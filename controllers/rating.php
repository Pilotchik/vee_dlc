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
		$this->load->view('rating/rating_main_view',$data);
	}

	
	
}

?>