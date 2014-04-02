<?php

class Kat extends CI_Controller {

	function Kat()
	{
		parent::__construct();
		
	}

	function _remap($method)
	{
		$guest = $this->session->userdata('guest');
		if ($guest=='')
		{
			$data['error']="Время сессии истекло. Необходима авторизация";
			$this->load->view('main_view',$data);
		}
		else
		{
			$this->load->model('kat_model');
			$this->load->library('session');
			$this->$method();
		}
	}


	//Функция отображения главной страницы администратора
	function index($error = "")
	{
		$type_r = $this->session->userdata('type_r');
		if ($type_r == 0) {$type_r = "1,2";}
		$data['disciplines'] = $this->kat_model->getDisciplines($type_r);
		foreach ($data['disciplines'] as $key)
		{
			//Все материалы дисциплины
			$data['materials'][$key['id']] = $this->kat_model->getMaterials($key['id']);
		}
		$data['error'] = $error;
		$this->load->view('kat/kat_menu_view',$data);
	}

	function view_content()
	{
		$mat_id = $this->uri->segment(3);
		$data['material'] = $this->kat_model->getOneMaterialOverId($mat_id);
		$data['disc_name'] = $this->kat_model->getNameOfDisc($data['material']['disc_id']);
		//Увеличить количество просмотров
		$views = $data['material']['views'] + 1;
		$this->kat_model->updateMaterialViewsOverId($mat_id,$views);
		$data['error'] = "";
		$this->load->view('kat/kat_material_view',$data);
	}

}

?>