<?php

class Resume extends CI_Controller {

	function Resume()
	{
		parent::__construct();
	}

	function _remap($method)
	{
		$this->index();
	}

	//Функция отображения главной страницы
	function index()
	{
		
		$user_id = $this->uri->segment(2);
		$this->load->model('private_model');
		//Проверка, публиковал ли пользователь своё резюме
		$check = $this->private_model->getPublicStatus($user_id);
		if ($check == 1)
		{
			$this->load->model('comps_model');
			$data['user_info'] = $this->private_model->getUserInfo($user_id);
			//Информация о пользовательских навыках
			$data['portfolios'] = $this->private_model->getAllUserPortfolios($user_id);
			$data['comps'] = $this->comps_model->getAllUserBalls($user_id);
			foreach ($data['comps'] as $key)
			{
				$data['comp_name'][$key['id']] = $this->comps_model->getCompTiDe($key['compet_id']);
				$data['comp_ball'][$key['id']] = round($key['balls'],2);
			}
			$data['skills'] = $this->private_model->getAllUserSkills($user_id);
			foreach($data['skills'] as $key) 
			{
				//Получение названия навыка
				$data['skill_name'][$key['id']] = $this->private_model->getSkillName($key['skill_id']);
				//Получение информации об уровне навыков
				$data['skill_description'][$key['id']] = $this->private_model->getSkillBallDescription($key['skill_id'],$key['balls']);
			}
			$data['user_id'] = $user_id;
			$data['error']="";
			$this->load->view('resume_public_view',$data);
		}
		else
		{
			$data['error']="Такого пользователя не существует, либо он предпочёл скрыть своё резюме, либо он его просто не составил";
			$this->load->view('main_view',$data);
		}
	}

}