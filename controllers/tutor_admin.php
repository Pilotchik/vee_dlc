<?php

class Tutor_admin extends CI_Controller {

	function Tutor_admin()
	{
		parent::__construct();
		
	}

	//Функция первичной проверки прав просмотра и перенаправления запросов в вызываемый метод
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
			$this->load->model('tutor_model');
			$this->$method();
		}
	}

	//Функция отображения главной страницы модерирования вопросов пользователей
	function index($error = "")
	{
		$this->load->model('main_model');
		
		$data['messages'] = $this->tutor_model->getAllMessagesWithoutAnswers();
		foreach ($data['messages'] as $key)
		{
			$data['users'][$key['id']] = $this->main_model->getUserOverId($key['user_id']);	
		}
		$data['old_dialogs'] = $this->tutor_model->getAllActiveMessagesWithAnswers();
		foreach($data['old_dialogs'] as $key)
		{
			//Получить ответы на вопрос
			$data['answers'][$key['id']] = $this->tutor_model->getAnswerMessagesOverQuestId($key['id']);
		}
		$data['title'] = "ВОС.Модерирование вопросов пользователей";
		$data['error'] = "";
		$this->load->view('tutor/tutor_admin_index_view',$data);
	}

	function all_history()
	{
		$range=$this->input->get('range');
		if ($range!='')
		{
			$time1 = strtotime(substr($range,0,10));
			$time2 = strtotime(substr($range,13,23));
		}
		else
		{
			$time1=strtotime("-1 month");
			$time2=time();
		}
		$data['messages'] = $this->tutor_model->getMessages($time1,$time2);
		$this->load->model('main_model');
		foreach ($data['messages'] as $key)
		{
			$data['users'][$key['id']] = $this->main_model->getUserOverId($key['user_id']);	
		}
		$data['title'] = "ВОС.Архив вопросов";
		$data['error'] = "";
		$this->load->view('tutor/tutor_admin_history_view',$data);	
	}

	//Функция журналирования событий, связанных с администрированием опросов
	function _add_to_log($msg = "")
	{
		$this->load->model('main_model');
		$this->main_model->createLogRecord($msg,3);
	}

}

?>