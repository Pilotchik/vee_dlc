<?php

class Rating extends CI_Controller {

	function Rating()
	{
		parent::__construct();

	}

	function _remap($method)
	{
		$guest = $this->session->userdata('guest');
		if ($guest=='')
		{
			$data['error']="Время сессии истекло. Необходима авторизация";
			$this->load->model('registr_model');
			$data['fspo']=$this->registr_model->getFSPO();
			$data['segrys']=$this->registr_model->getSegrys();
			$this->load->view('main_view',$data);
		}
		else
		{
			$this->load->model('reyting_model');
			$this->$method();
		}
	}

	//Функция отображения страницы c выбором диапазона статистики
	function index()
	{
		$data['error'] = "";
		$type_r = $this->input->get('type');
		$data['type_r'] = $type_r;
		$data['title'] = "ВОС.Рейтинг";
		//Получить дату последней пересортировки рейтинга
		$data['rate_resort'] = $this->reyting_model->getDateRateResort();
		//Получить название ОУ
		$data['type_r_name'] = $this->reyting_model->getTypeRegNameOverTypeRegId($type_r);
		//Сформировать топ
		$data['top_index'] = $this->reyting_model->getFullTopOfIndex($type_r);
		foreach ($data['top_index'] as $key) 
		{
			$data['top_users'][$key['id']] = $this->reyting_model->getFullReytingOverUserId($key['id']);
		}
		for ($i = 1; $i <5; $i++)
		{
			$data['groups'][$i] = $this->reyting_model->getGroupsOverKurs($i);
		}
		$this->load->view('rating/rating_main_view',$data);
	}

	function courses()
	{
		$course = (int) $this->uri->segment(3);
		$data['type_r'] = 1;
		$data['error'] = "";
		$data['type_r_name'] = "ФСПО НИУ ИТМО";
		$data['filter_type'] = $course." курсу";
		$data['title'] = "ВОС.Рейтинг по ".$data['filter_type'];
		$groups = "(";
		$groups_array = $this->reyting_model->getGroupsOverKurs($course);
		foreach ($groups_array as $key) 
		{
			$groups .= $key['id'].",";
		}
		$groups = substr($groups, 0, -1);
		$groups .= ")";
		//Сформировать топ
		$data['top_index'] = $this->reyting_model->getFullTopOfIndexOverCourse($groups);
		foreach ($data['top_index'] as $key) 
		{
			$data['top_users'][$key['id']] = $this->reyting_model->getFullReytingOverUserId($key['id']);
		}
		for ($i = 1; $i <5; $i++)
		{
			$data['groups'][$i] = $this->reyting_model->getGroupsOverKurs($i);
		}
		$this->load->view('rating/rating_filter_view',$data);
	}

	function groups()
	{
		$group = (int) $this->uri->segment(3);
		$group_name = (int) $this->uri->segment(4);
		$data['type_r'] = 1;
		$data['error'] = "";
		$data['type_r_name'] = "ФСПО НИУ ИТМО";
		$data['filter_type'] = "группе ".$group_name;
		$data['title'] = "ВОС.Рейтинг по ".$data['filter_type'];
		$groups = "(".$group.")";
		//Сформировать топ
		$data['top_index'] = $this->reyting_model->getFullTopOfIndexOverCourse($groups);
		foreach ($data['top_index'] as $key) 
		{
			$data['top_users'][$key['id']] = $this->reyting_model->getFullReytingOverUserId($key['id']);
		}
		for ($i = 1; $i <5; $i++)
		{
			$data['groups'][$i] = $this->reyting_model->getGroupsOverKurs($i);
		}
		$this->load->view('rating/rating_filter_view',$data);
	}

	
	
}

?>