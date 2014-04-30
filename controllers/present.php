<?php

class Present extends CI_Controller {

	function Present()
	{
		parent::__construct();
	}

	//Функция отображения главной страницы
	function index()
	{
		$this->load->model('present_model');
		$data['title'] = "ВОС.Список презентаций";
		$data['presents'] = $this->present_model->getAllPresents(1);
		foreach ($data['presents'] as $key)
		{
			$data['author'][$key['id']] = $this->present_model->getUserName($key['user_id']);
		}
		$data['error'] = "";
		$this->load->view('present/present_list_view',$data);
	}

	function play()
	{
		$this->load->model('present_model');
		$present_id = (int) $this->uri->segment(3);
		//Сделать первый (минимальный для презентации) слайд активным
		//1. Найти первый (минимальный)
		$first = $this->present_model->getMinSlide($present_id);
		//2. Сделать первый слайд активным
		$this->present_model->setActiveSlide($present_id,$first);
		$data['first'] = $first;
		$data['present_slides'] = $this->present_model->getAllSlides($present_id);
		$data['present_id'] = $present_id;
		$data['error'] = "";
		$this->load->view('present/present_play_view',$data);
	}

	function play2()
	{
		$this->load->model('present_model');
		$present_id = (int) $this->uri->segment(3);
		//Сделать первый (минимальный для презентации) слайд активным
		//1. Найти первый (минимальный)
		$first = $this->present_model->getMinSlide($present_id);
		//2. Сделать первый слайд активным
		$this->present_model->setActiveSlide($present_id,$first);
		$data['first'] = $first;
		$data['present_name'] = $this->present_model->getPresentName($present_id);
		$data['present_slides'] = $this->present_model->getAllSlides($present_id);
		//Получение подслайдов
		$data['subslides'] = array();
		foreach ($data['present_slides'] as $key) 
		{
			$data['subslides'][$key['id']] = $this->present_model->getAllSubSlides($key['id']);
		}
		$data['present_id'] = $present_id;
		$data['error'] = "";
		$this->load->view('present/present_play2_view',$data);
	}

	function check_slide()
	{
		$this->load->model('present_model');
		$this->form_validation->set_rules('present_id', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$present_id=$this->input->post('present_id');
			$current = $this->present_model->getCurrentSlide($present_id);
			echo json_encode(array('answer'=>1,'current_slide'=>$current));
		}
		else
		{
			$this->index();
		}
	}

}