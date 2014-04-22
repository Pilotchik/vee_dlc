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

	function view_history()
	{
		$type=$this->input->post('type_r');
		$progr=$this->input->post('progr');
		$data['history']=$this->reyting_model->getHistory($this->uri->segment(3));
		$i=0;
		$hist_array=array();
		foreach($data['history'] as $key)
		{
			$hist_array[$i]['reyt']=$key['reyt'];
			$hist_array[$i]['id']=$key['id'];
			if ($i>0)
			{
				if ($hist_array[$i]['reyt']==$hist_array[$i-1]['reyt'])
				{
					$this->reyting_model->delHistory($hist_array[$i-1]['id']);
				}
			}
			$i++;
		}
		$data['history']=$this->reyting_model->getHistory($this->uri->segment(3));
		$data['user']=$this->reyting_model->getStudInfo($this->uri->segment(3));
		$data['type_r']=$type;
		$data['progr']=$progr;
		$data['error']="";
		$this->load->view('reyting/reyting_history_view',$data);			
	}

	function prepods()
	{
		$prepods=$this->reyting_model->getPrepods();
		$data['prepods']=array();
		//print_r($prepods);
		foreach ($prepods as $key)
		{
			$groups[$key['id']]=$this->reyting_model->getPrepodStudents($key['id']);
			if (count($groups[$key['id']])>2)
			{
				$reyt=0;
				foreach($groups[$key['id']] as $key2)
				{
					$reyt+=$key2['reyting'];
				}
				$data['prepods'][$key['id']]['avg']=round($reyt/count($groups[$key['id']]),3);
				$data['prepods'][$key['id']]['count']=count($groups[$key['id']]);
				$data['prepods'][$key['id']]['name']=$key['name'];
			}
		}
		$data['error']="";
		$this->load->view('reyting/reyting_prepods_view',$data);
	}
	
}

?>