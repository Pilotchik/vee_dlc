<?php

class Present_admin extends CI_Controller {

	function Present_admin()
	{
		parent::__construct();
		
	}

	function _remap($method)
	{
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
				$this->load->model('captcha_model');
				$this->load->model('forms_model');
				$this->load->model('present_model');
				$this->$method();
			}
		}
	}


	//Функция отображения главной страницы администрирования опросов
	function index($error="")
	{
		$data['presents']=$this->present_model->getAllPresents();
		foreach ($data['presents'] as $key)
		{
			$data['author'][$key['id']]=$this->captcha_model->getUserName($key['user_id']);
		}
		$data['error'] = $error;
		$this->load->view('present/present_admin_view',$data);
	}

	function present_del()
	{
		$this->present_model->delPresent();
		$error="Презентация удалена";
		$this->index($error);
	}

	function present_edit()
	{
		$this->form_validation->set_rules('c_value', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры презентации не удалось";
		}
		else
		{
			$this->present_model->editPresent();
			$error = "Информация о презентации обновлена";
		}
		$this->index($error);
	}

	function present_create()
	{
		$this->form_validation->set_rules('f_title', 'Текст', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать презентацию не удалось";
		}
		else
		{
			$this->present_model->createPresent();
			$error = "Презентация создана";
		}
		$this->index($error);
	}

	function slides_view($present_id = "", $error = "")
	{
		if ($present_id == "") {$present_id = $this->uri->segment(3);}
		$data['present_name'] = $this->present_model->getPresentName($present_id);
		$data['present_slides'] = $this->present_model->getAllSlides($present_id);
		$data['present_id'] = $present_id;
		$data['error'] = $error;
		$this->load->view('present/present_admin_slides_view',$data);
	}

	function slide_del()
	{
		$this->present_model->delSlide();
		$error = "Вопрос удалён";
		$present_id = $this->uri->segment(3);
		$this->slides_view($present_id,$error);
	}

	function slide_create()
	{
		$present_id = $this->uri->segment(3);
		$this->form_validation->set_rules('f_title', 'Текст', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_file', 'Описание', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать слайд не удалось";
		}
		else
		{
			//Узнать последний номер слайда
			$last = $this->present_model->getMaxSlide($present_id);
			$last++;
			$this->present_model->createSlide($present_id,$last);
			$error = "";
		}
		$this->slides_view($present_id,$error);
	}

	function slide_edit()
	{
		$this->form_validation->set_rules('q_value', 'Значение', 'trim|xss_clean|required');
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

	function present_menage($error="")
	{
		$data['presents']=$this->present_model->getAllPresents();
		foreach ($data['presents'] as $key)
		{
			$data['author'][$key['id']]=$this->captcha_model->getUserName($key['user_id']);
		}
		$data['error']=$error;
		$this->load->view('present/present_menage_view',$data);
	}

	function present_view()
	{
		$present_id = $this->uri->segment(3);
		//Сделать первый (минимальный для презентации) слайд активным
		//1. Найти первый (минимальный)
		$first = $this->present_model->getMinSlide($present_id);
		//2. Сделать первый слайд активным
		$this->present_model->setActiveSlide($present_id,$first);
		$data['present_name'] = $this->present_model->getPresentName($present_id);
		$data['present_slides'] = $this->present_model->getAllSlides($present_id);
		$data['present_id'] = $present_id;
		$data['error'] = "";
		$this->load->view('present/present_slides_menage_view',$data);
	}

	function setactive_slide()
	{
		$present_id=$this->input->post('present_id');
		$slide=$this->input->post('slide');
		$this->present_model->setActiveSlide($present_id,$slide);
		echo json_encode(array('answer'=>1));
	}

}

?>