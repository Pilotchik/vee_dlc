<?php

class De_admin extends CI_Controller {

	function De_admin()
	{
		parent::__construct();
	}

	function _remap($method)
	{
		//Проверка существования сессии
		$guest=$this->session->userdata('guest');
		if ($guest=='')
		{
			$data['error']="Время сессии истекло. Необходима авторизация";
			$this->load->view('main_view',$data);
		}
		else
		{
			if ($guest<2)
			{
				redirect('/main/auth/', 'refresh');
			}	
			else
			{
				//Загрузка общих моделей всего контроллера
				$this->load->model('de_model');
				$this->load->model('plans_model');
				$this->$method();
			}
		}
	}

	function index()
	{
		redirect(base_url());
	}

	//Просмотр всех дисциплин
	function disc_view()
	{
		switch ($this->uri->segment(3))
		{
			case 'fspo': $dest=1; break;
			case 'segrys': $dest=2;	break;
			case 'psih': $dest=3; break;
			default: $dest=1; break;
		}
		$data['disciplines']=$this->plans_model->getDisciplines($dest);
		$data['error'] = "";
		$data['dest']=$this->uri->segment(3);
		$this->load->view('de/de_admin_disc_view',$data);
	}

	//Просмотр и добавление дистанционных курсов
	function courses_view($error="")
	{
		$data['error']=$error;
		$data['disciplin']=$this->plans_model->getDisciplin($this->uri->segment(4));
		$data['courses']=$this->de_model->getCourses($this->uri->segment(4));
    	$data['id_disc']=$this->uri->segment(4);
    	$data['dest']=$this->uri->segment(3);
		$this->load->view('de/de_admin_courses_view',$data);
	}

	//Удаление курса
	function del_course()
	{
		$this->de_model->delCourse();
		$c_name = $this->de_model->getCourse($this->input->post('r_id'));
		$this->_add_to_log("Удалён дистанционный курс \"".$c_name."\". ");
		$error = "Курс удалён";
		$this->courses_view($error);
	}

	function edit_course()
	{
		$this->form_validation->set_rules('q_value', 'Значение', 'trim|xss_clean|required');
		$this->form_validation->set_rules('q_param', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры курса не удалось";
		}
		else
		{
			$this->de_model->editCourse();
			$c_name = $this->de_model->getCourse($this->input->post('q_id'));
			$this->_add_to_log("Изменён дистанционный курс \"".$c_name."\". ");
			$error = "";
		}
		$this->courses_view($error);
	}

	function create_course()
	{
		$this->form_validation->set_rules('course_name', 'Название', 'trim|xss_clean|required');
		$this->form_validation->set_rules('comment', 'Комментарий', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать учебный курс не удалось. Имеются ошибки в полях";
		}
		else
		{
			$this->de_model->createCourse($this->uri->segment(4));
			$this->_add_to_log("Создан дистанционный курс \"".$this->input->post('course_name')."\". ");
			$error = "";
		}
		$this->courses_view($error);
	}

	//Просмотр лекций курса
	function view_course($error = "")
	{
		$data['error'] = $error;
		$data['disciplin'] = $this->plans_model->getDisciplin($this->uri->segment(4));
		//Название курса
		$data['course'] = $this->de_model->getCourse($this->uri->segment(5));
		//Лекции курса с контентом
		$data['lections'] = $this->de_model->getLections($this->uri->segment(5));
		foreach ($data['lections'] as $key)
		{
			if ($key['test_id'] != 0)
			{
				$data['test_name'][$key['id']] = $this->de_model->getTestName($key['test_id']);
			}
		}
		$data['tests'] = $this->de_model->getDiscTests($this->uri->segment(4));
		$data['id_disc'] = $this->uri->segment(4);
    	$data['id_test'] = $this->uri->segment(5);
		$data['dest'] = $this->uri->segment(3);
		$this->load->view('de/de_admin_nabor_view',$data);
	}

	//Добавление лекций
	function lection_create()
	{
		$id_course = $this->uri->segment(5);
		$this->form_validation->set_rules('lection_name', 'Название', 'trim|xss_clean|required');
		$this->form_validation->set_rules('comment', 'Комментарий', 'trim|xss_clean');
		$this->form_validation->set_rules('area', 'Контент', '');
		$this->form_validation->set_rules('type', 'Контент', 'required|xss_clean');
		$this->form_validation->set_rules('tags', 'Теги', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать лекцию не удалось";
			$this->view_course($error);	
		}
		else
		{
			//Узнать максимальный номер лекции в курсе
			$max = $this->de_model->getMaxNumberOfLectInCourse($id_course);
			$numb = $max + 1;
       		$this->de_model->createLection($id_course,$numb);
       		$c_name = $this->de_model->getCourse($id_course);
			$this->_add_to_log("В дистанционный курс \"".$c_name."\". добавлена лекция");
			$this->view_course();
		}
	}

	function lection_edit()
	{
		$this->form_validation->set_rules('q_value', 'Значение', 'required');
		$this->form_validation->set_rules('q_param', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры лекции не удалось";
		}
		else
		{
			$this->de_model->editLection();
			$error = "";
		}
		$this->view_course($error);
	}

	function lection_del()
	{
		$this->de_model->delLection();
		$this->view_course("Лекция удалена");
	}

	function _add_to_log($msg = "")
	{
		$this->load->model('main_model');
		$this->main_model->createLogRecord($msg,3);
	}

	function simple($error="")
	{
		$data['error'] = "";
		$this->load->view('de/de_simple_view',$data);
	}


	
}