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
			$data['users'][$key['id']] = $this->main_model->getUserOverId($key['user_id']);
			//Получить ответы на вопрос
			$data['answers'][$key['id']] = $this->tutor_model->getAnswerMessagesOverQuestId($key['id']);
		}
		$data['title'] = "ВОС.Модерирование вопросов пользователей";
		$data['error'] = "";
		$this->load->view('tutor/tutor_admin_index_view',$data);
	}

	function help_del()
	{
		$this->form_validation->set_rules('help_id', '', 'trim|xss_clean|required|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$help_id = $this->input->post('help_id');
			$this->tutor_model->archiveMessage($help_id);
			$user_id = $this->session->userdata('user_id');
			$user_name = $this->session->userdata('lastname')." ".$this->session->userdata('firstname');
			$this->_add_to_log($user_name." заблокировал сообщение");
			$error = "Сообщение архивировано";
		}
		else
		{
			$error = "Необходимые поля заполнены неверно";
		}
		$this->index($error);
	}

	//
	function help_answer()
	{
		$this->form_validation->set_rules('help_id', '', 'trim|xss_clean|required|is_natural_no_zero');
		$this->form_validation->set_rules('helper_id', '', 'trim|xss_clean|required|is_natural_no_zero');
		$this->form_validation->set_rules('help_answer', '', 'trim|xss_clean|required');
		if ($this->form_validation->run() == TRUE)
		{
			$help_id = $this->input->post('help_id');
			$helper_id = $this->input->post('helper_id');
			$help_answer = $this->input->post('help_answer');
			$user_id = $this->session->userdata('user_id');
			$this->tutor_model->addAnswerMessage($help_id,$help_answer,$user_id);

			$user_name = $this->session->userdata('lastname')." ".$this->session->userdata('firstname');
			
			$this->_add_to_log($user_name." ответил на сообщение пользователя");
			$mail_status = $this->_send_answer_mail($helper_id, $user_name);
			
			$error = "Ответ был записан. ".$mail_status;
		}
		else
		{
			$error = "Необходимые поля заполнены неверно";
		}
		$this->index($error);
	}

	function all_history()
	{
		$this->load->model('main_model');

		$range = $this->input->get('range');
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
		$data['old_dialogs'] = $this->tutor_model->getAllUnActiveMessagesWithAnswers($time1,$time2);
		foreach($data['old_dialogs'] as $key)
		{
			$data['users'][$key['id']] = $this->main_model->getUserOverId($key['user_id']);
			//Получить ответы на вопрос
			$data['answers'][$key['id']] = $this->tutor_model->getAnswerMessagesOverQuestId($key['id']);
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

	//функция отправки письма пользователю, на вопрос которого получен ответ
	function _send_answer_mail($user_id = 1, $admin_name = "")
	{
		//Получить адрес пользователя и если он корректный, то отправить письмо
		$this->load->model('main_model');
		$email = $this->main_model->getUserMail($user_id);

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			$this->load->library('email');
			$config['protocol'] = 'mail';
				
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$this->email-> initialize($config);
			$this->email->from('ves_ifmo@mail.ru', 'Администратор ВОС');
			
			$this->email->to($email); 
			$this->email->cc('pilotchik@gmail.com');
			$this->email->subject('Ответ на Ваш вопрос');
			
			$text = "<H2>Администратор $admin_name дал ответ на ваш вопрос!</H2>
				<br>Зайдите в систему и узнайте, что он Вам ответил.<br>
				<a href='http://exam.segrys.ru'>exam.segrys.ru</b><br><br>
				<i>Виртуальная образовательная среда</i>";	
			$this->email->message($text);
			$this->email->send();
			$error = "Сообщение отправлено на почту пользователя";
		}
		else
		{
			$error = "Неправильный адрес электронной почты пользователя, сообщение отправить не удалось";
		}
		return $error;
	}

}

?>