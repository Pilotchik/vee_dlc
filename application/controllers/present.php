<?php

class Present extends CI_Controller {

	function Present()
	{
		parent::__construct();
	}

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
			$this->load->model('present_model');
			$this->$method();
		}
	}

	//Функция отображения главной страницы
	function index()
	{
		$data['title'] = "ВОС.Список презентаций";
		$data['presents_nmy'] = $this->present_model->getAllPresents(0,$this->session->userdata('user_id'));
		foreach ($data['presents_nmy'] as $key)
		{
			$data['author'][$key['id']] = $this->present_model->getUserName($key['user_id']);
			$data['status'][$key['id']] = ($key['user_id'] == $this->session->userdata('user_id') ? 1 : 0);
		}
		$data['presents_my'] = $this->present_model->getAllPresents(1,$this->session->userdata('user_id'));
		$data['error'] = "";
		$this->load->view('present/present_list_view',$data);
	}

	//Функция формирования интерфейса для просмотра слайдов
	function play()
	{
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