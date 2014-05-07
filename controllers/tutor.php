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
	function index()
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
			if ($this->session->userdata('lastname') == "")	{$user_id = 0;}
			
			$this->tutor_model->addMessage($user_id,$help_type,$help_title,$help_text);
			echo json_encode(array('msg'=>$help_type));
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