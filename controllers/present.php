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

	//Функция формирования интерфейса для просмотра слайдов
	function play()
	{
		$this->load->model('present_model');
		$present_id = (int) $this->uri->segment(3);
		//обнулить индексы
		$this->present_model->updatePresentIndexes($present_id);
		//Получение названия презентации
		$data['present_name'] = $this->present_model->getPresentName($present_id);
		//Получение слайдов презентации
		$data['present_slides'] = $this->present_model->getAllSlides($present_id);
		//Получение подслайдов
		$data['subslides'] = array();
		foreach ($data['present_slides'] as $key) 
		{
			$data['subslides'][$key['id']] = $this->present_model->getAllSubSlides($key['id']);
		}
		$data['present_id'] = $present_id;
		$data['error'] = "";
		$this->load->view('present/present_play_view',$data);
	}

	//функция асинхронной проверки индексов
	function get_indexes()
	{
		$this->load->model('present_model');
		$this->form_validation->set_rules('present_id', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$present_id = $this->input->post('present_id');
			$current = $this->present_model->getCurrentIndexes($present_id);
			echo json_encode(array('answer' => 1,'index_h' => $current['index_h'],'index_v' => $current['index_v'] ));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

}