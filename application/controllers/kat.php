<?php

class Kat extends CI_Controller {

	function Kat()
	{
		parent::__construct();
		
	}

	//Функция первичной проверки прав просмотра и перенаправления запросов в вызываемый метод
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
			foreach ( $data['materials'][$key['id']] as $key2)
			{
				$data['materials_themes'][$key2['id']] = $this->kat_model->getThemesOverMaterialID($key2['id']);
			}
		}

		$data['all_themes'] = $this->kat_model->getAllThemesWithMaterials();
		foreach($data['all_themes'] as $key)
		{
			$data['all_themes_count'][$key['id_theme']] = $this->kat_model->getCountThemesOverThemeId($key['id_theme']);
		}
		
		$data['error'] = $error;

		//Рекомендации
		$user_id = $this->session->userdata('user_id');; // мой айди
		$names = array();
		$data['contents'] = array();
		//Выбрать вопросы, на которые давал ответ пользователь
		$user_themes = $this->kat_model->getUserThemes($user_id);
		//Для каждой темы выбрать результат пользователя
		$result = array();
		$bad_themes = array();
		foreach ($user_themes as $key) {
			$balls = $this->kat_model->getUserThemeResult($user_id,$key['theme_id']);
			if ($balls < 50)
			{
				if (!(in_array($key['theme_id'],$bad_themes)))
				{
					array_push($bad_themes,$key['theme_id']);
				}
				$result[$key['theme_id']]['name'] = $key['name_th'];
			}
		}
		
		$data['result'] = $result;
		
		foreach ($result as $key) {
			$mats = $this->kat_model->getNeedMaterials($key['name']);
			if (count($mats)>0)
			{
				$data['contents'][$key['name']]['materials'] =  $mats;	
				$data['contents'][$key['name']]['name'] =  $key['name'];	
			}
		}

		$this->load->view('kat/kat_menu_view',$data);
	}

	//Функция формирования интерфейса с содержимым материала
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

	function view_theme()
	{
		$theme_id = (int) $this->uri->segment(3);
		$data['error'] = "";
		$data['materials'] = $this->kat_model->getMaterialsOverThemeId($theme_id);
		$data['theme_name'] = $this->kat_model->getThemeNameOverThemeId($theme_id);
		foreach ($data['materials'] as $key)
		{
			$data['materials_themes'][$key['id']] = $this->kat_model->getThemesOverMaterialID($key['id']);
		}
		$this->load->view('kat/kat_theme_view',$data);
	}

}

?>