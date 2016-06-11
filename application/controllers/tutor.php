<?php

class Tutor extends CI_Controller {

	function Tutor()
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
			$this->load->model('tutor_model');
			$this->$method();
		}
	}

	//Функция отображения главной страницы
	function index($error = "")
	{
		$data['title'] = "ВОС.Помощь";
		$data['error'] = "";
		//Вопросы пользователя
		$user_id = $this->session->userdata('user_id');
		$data['messages'] = $this->tutor_model->getUserMainMessages($user_id);
		//Узнать об ответах на сообщения
		foreach($data['messages'] as $key)
		{
			$data['answers'][$key['id']] = $this->tutor_model->getAnswerMessagesOverQuestId($key['id']);
		}
		$this->load->view('tutor/tutor_index_view',$data);
	}

	function add_message()
	{
		$this->form_validation->set_rules('help_type', '', 'trim|xss_clean|required|is_natural_no_zero');
		$this->form_validation->set_rules('help_title', '', 'trim|xss_clean|required');
		$this->form_validation->set_rules('help_text', '', 'trim|xss_clean|required');
		if ($this->form_validation->run() != FALSE)
		{
			$help_text = addslashes($this->input->post('help_text'));
			$help_title = $this->input->post('help_title');
			$help_type = $this->input->post('help_type');
			$user_id = $this->session->userdata('user_id');
			
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$this->email->initialize($config);
			$this->email->from('ves_ifmo@mail.ru', 'Администратор ВОС');
			
			$this->email->to('pilotchik@gmail.com'); 
			$this->email->subject('Новый вопрос в ВОС');
			
			$text = "<H2>Новый вопрос в Виртуальной Образовательной Среде!</H2>
				<br>Зайдите в систему и узнайте, что Вам написали.<br>
				<a href='http://exam.segrys.ru'>exam.segrys.ru</b><br><br>
				<i>Виртуальная образовательная среда</i>";	
			$this->email->message($text);
			$this->email->send();
			$error = "Сообщение отправлено на почту пользователя";

			$this->tutor_model->addMessage($user_id,$help_type,$help_title,$help_text);
			echo json_encode(array('msg'=>$help_type));
		}
	}

	function add_grade()
	{
		$this->form_validation->set_rules('help_id', '', 'trim|xss_clean|required|is_natural_no_zero');
		$this->form_validation->set_rules('help_grade', '', 'trim|xss_clean|required|is_natural_no_zero|less_than[3]');
		if ($this->form_validation->run() != FALSE)
		{
			$help_id = $this->input->post('help_id');
			$help_grade = $this->input->post('help_grade');
			$this->tutor_model->updateMessageGrade($help_id,$help_grade);
			echo json_encode(array('msg'=>$help_grade));
		}
	}

	function add_answer()
	{
		$this->form_validation->set_rules('help_id', '', 'trim|xss_clean|required|is_natural_no_zero');
		$this->form_validation->set_rules('help_answer', '', 'trim|xss_clean|required');
		if ($this->form_validation->run() != FALSE)
		{
			$help_answer = addslashes($this->input->post('help_answer'));
			$help_id = $this->input->post('help_id');
			
			$user_id = $this->session->userdata('user_id');
			
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$this->email->initialize($config);
			$this->email->from('ves_ifmo@mail.ru', 'Администратор ВОС');
			
			$this->email->to('pilotchik@gmail.com'); 
			$this->email->subject('Новый вопрос в ВОС');
			
			$text = "<H2>Новый вопрос в Виртуальной Образовательной Среде!</H2>
				<br>Зайдите в систему и узнайте, что Вам написали.<br>
				<a href='http://exam.segrys.ru'>exam.segrys.ru</b><br><br>
				<i>Виртуальная образовательная среда</i>";	
			$this->email->message($text);
			$this->email->send();
			$error = "Сообщение отправлено на почту";

			$this->tutor_model->addAnswerMessage($help_id,$help_answer,$user_id);
			echo json_encode(array('msg'=>$error));
		}
	}

	function close_quest()
	{
		$this->form_validation->set_rules('help_id', '', 'trim|xss_clean|required|is_natural_no_zero');
		if ($this->form_validation->run() != FALSE)
		{
			$help_id = $this->input->post('help_id');
			$user_id = $this->session->userdata('user_id');

			$this->tutor_model->archiveMessageOverIdAndUserId($help_id,$user_id);
			echo json_encode(array('msg'=>'ok'));
		}
	}

	//функция формирования интерфейса со справкой о корректировке результатов аналитическим модулем
	function faq_corr_desc()
	{
		$user_id = $this->session->userdata('user_id');
		$data['test'] = $this->tutor_model->getCorrResult($user_id);

		$this->load->model('private_model');
		$data['results'] = $this->private_model->getStudResult($data['test']['id'],$user_id);
		
		$data['title'] = "ВОС. Корректировка результатов";
		$data['error'] = "";
		$this->load->view('tutor/tutor_faq_corr_view',$data);	
	}

}