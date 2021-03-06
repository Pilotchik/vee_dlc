<?php

class Present_admin extends CI_Controller {

	function Present_admin()
	{
		parent::__construct();
		
	}

	//Функция первичной проверки прав просмотра и перенаправления запросов в вызываемый метод
	function _remap($method)
	{
		$guest = $this->session->userdata('guest');
		if ($guest == '')
		{
			$data['error'] = "Время сессии истекло. Необходима авторизация";
			$this->load->model('registr_model');
			$data['fspo'] = $this->registr_model->getFSPO();
			$data['segrys'] = $this->registr_model->getSegrys();
			$this->load->view('main_view',$data);
		}
		else
		{
			/*
			if ($guest < 2)
			{
				redirect('/', 'refresh');
			}	
			else
			{
				$this->load->model('present_model');
				$this->$method();
			}
			*/
			$this->load->model('present_model');
			$this->$method();
		}
	}

	//Функция отображения главной страницы администрирования опросов
	function index($error = "")
	{
		redirect('/present', 'refresh');
	}

	//Функция изменения статуса архивации в БД
	function present_del()
	{
		$this->present_model->delPresent();
		$error="Презентация удалена";
		$this->index($error);
	}

	//Функция изменения параметров презентации в БД
	function present_edit()
	{
		$this->form_validation->set_rules('f_title', 'Текст', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_description', '', 'trim|xss_clean');
		$this->form_validation->set_rules('f_theme', '', 'trim|xss_clean');
		$this->form_validation->set_rules('f_transition', '', 'trim|xss_clean');
		$this->form_validation->set_rules('f_id', '', 'trim|xss_clean|is_natural_no_zero|required');
		$this->form_validation->set_rules('f_status', '', 'trim|xss_clean|is_natural|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры презентации не удалось";
		}
		else
		{
			$present_id = $this->input->post('f_id');
			$title = $this->input->post('f_title');
			$status = $this->input->post('f_status');
			$desc = $this->input->post('f_description');
			$theme = $this->input->post('f_theme');
			$transition = $this->input->post('f_transition');
			$this->present_model->editPresent($title,$desc,$theme,$transition,$status,$present_id);
			$error = "Информация о презентации обновлена";
		}
		$this->index($error);
	}

	//Функция добавления в БД данных о презентации
	function present_create()
	{
		$this->form_validation->set_rules('f_title', 'Текст', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_description', '', 'trim|xss_clean');
		$this->form_validation->set_rules('f_theme', '', 'trim|xss_clean');
		$this->form_validation->set_rules('f_transition', '', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать презентацию не удалось";
		}
		else
		{
			$user_id = $this->session->userdata('user_id');
			$title = $this->input->post('f_title');
			$desc = $this->input->post('f_description');
			$theme = $this->input->post('f_theme');
			$transition = $this->input->post('f_transition');
			$this->present_model->createPresent($title,$desc,$theme,$transition,$user_id);
			$error = "Презентация создана";
			$author_name = $this->present_model->getUserName($user_id);
			$this->_add_to_log($author_name." создал презентацию \"".$title."\"");
		}
		$this->index($error);
	}

	//Функция формирования интерфейса для управления презентацией
	function slides_view($present_id = "", $error = "")
	{
		if ($present_id == "") {$present_id = $this->uri->segment(3);}
		$data['title'] = "ВОС.Управление презентацией";
		$data['present_name'] = $this->present_model->getPresentName($present_id);
		$data['present_theme'] = $this->present_model->getPresentTheme($present_id);
		//Получение главных слайдов
		$data['present_slides'] = $this->present_model->getAllSlides($present_id);
		//Получение подслайдов
		$data['subslides'] = array();
		foreach ($data['present_slides'] as $key) 
		{
			$data['subslides'][$key['id']] = $this->present_model->getAllSubSlides($key['id']);
		}
		$data['present_id'] = $present_id;
		$data['error'] = $error;

		$this->load->view('present/present_admin_slides_view',$data);
	}

	//Функция изменения статуса архивации слайда
	function slide_del()
	{
		$this->present_model->delSlide();
		$error = "Вопрос удалён";
		$present_id = $this->uri->segment(3);
		$this->slides_view($present_id,$error);
	}

	//Функция обработки и добавления данных о слайде презентации в БД
	function slide_create()
	{
		$present_id = $this->uri->segment(3);
		$this->form_validation->set_rules('f_text', 'Текст', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_main_slide', 'Текст', 'trim|xss_clean|is_natural|required');
		$this->form_validation->set_rules('f_content', 'Описание', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать слайд не удалось";
		}
		else
		{
			//Узнать последний номер слайда
			$last = $this->present_model->getMaxSlide($present_id);
			$last++;
			$content = $this->input->post('f_content');
			$text = $this->input->post('f_text');
			$main_slide = $this->input->post('f_main_slide');
			$this->present_model->createSlide($present_id,$last,$content,$text,$main_slide);
			$error = "";
		}
		$this->slides_view($present_id,$error);
	}

	//Функция обработки и изменения данных слайда в БД
	function slide_edit()
	{
		$this->form_validation->set_rules('q_value', 'Значение', 'trim|required');
		$this->form_validation->set_rules('q_param', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры слайда не удалось";
		}
		else
		{
			$this->present_model->editSlide();
			$error = "";
		}
		$this->slides_view($this->uri->segment(3),$error);
	}

	//Функция формирования интерфейса для управления презентацией
	function present_view()
	{
		$present_id = $this->uri->segment(3);
		$data['title'] = "ВОС.Управление презентацией";
		$data['present_name'] = $this->present_model->getPresentName($present_id);
		$data['present_slides'] = $this->present_model->getAllSlides($present_id);
		$data['present_id'] = $present_id;
		$data['error'] = "";
		$this->load->view('present/present_slides_menage_view',$data);
	}

	//Функция асинхронной смены текущих индексов
	function change_slide()
	{
		$this->form_validation->set_rules('index_h', 'Описание', 'trim|xss_clean|required|is_natural');
		$this->form_validation->set_rules('index_v', 'Описание', 'trim|xss_clean|required|is_natural');
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('answer' => 0));	
		}
		else
		{
			$index_h = $this->input->post('index_h');
			$index_v = $this->input->post('index_v');
			$present_id = $this->input->post('present_id');
			$this->present_model->changeIndex($present_id,$index_h,$index_v);
			echo json_encode(array('answer'=>1));
		}
	}

	//Функция журналирования событий, связанных с администрированием опросов
	function _add_to_log($msg = "")
	{
		$this->load->model('main_model');
		$this->main_model->createLogRecord($msg,3);
	}

}

?>