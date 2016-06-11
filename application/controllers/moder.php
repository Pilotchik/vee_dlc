<?php

class Moder extends CI_Controller {

	function Moder()
	{
		parent::__construct();
		
	}

	function _remap($method)
	{
		$guest=$this->session->userdata('guest');
		if ($guest=='')
		{
			$data['error']="Время сессии истекло. Необходима авторизация";
			$this->load->view('main_view',$data);
		}
		else
		{
			if ($guest<2)
			{
				$data['firstname']=$this->session->userdata('firstname');;
				$data['guest']=$guest;
				$data['error']="У вас недостаточно прав";
				$this->load->view('index_view',$data);	
			}	
			else
			{
				$this->load->model('moder_model');
				$this->load->model('forms_model');
				$this->$method();
			}
		}
	}


	//Функция отображения главной страницы модерирования заданий
	function index()
	{
		//Все дисциплины, по которым есть непроверенные задачи
		$data['fspo']=$this->moder_model->getDisciplines('1');
		foreach ($data['fspo'] as $key) 
		{
			$data['count'][$key['id']]=$this->moder_model->getCountOfAnswers($key['id']);
		}
		$data['segrys']=$this->moder_model->getDisciplines('2');
		foreach ($data['segrys'] as $key) 
		{
			$data['count'][$key['id']]=$this->moder_model->getCountOfAnswers($key['id']);
		}
		$data['univers']=$this->moder_model->getDisciplines('3');
		foreach ($data['univers'] as $key) 
		{
			$data['count'][$key['id']]=$this->moder_model->getCountOfAnswers($key['id']);
		}
		$data['error']="";
		$this->load->view('moder_disc_view',$data);
	}

	//Просмотр всех проверяемых ответов
	function view_answers()
	{		
		//В этот же метод отправляются данные при проверке
		if ($this->uri->segment(4)!="")
		{
			$this->form_validation->set_rules('ans_comm', 'Комментарий', 'trim|xss_clean');
			$this->form_validation->set_rules('ans_true', 'Правильность', 'trim|xss_clean|required');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error']="Проверка не удалась";
			}
			else
			{
				$comm = $this->input->post('ans_comm');
				$ans_true = $this->input->post('ans_true');
				//Выбрать текущие результаты 
				$id_answer = $this->uri->segment(4);
				$user_result = $this->moder_model->getUserTrue($id_answer);
				$proz_before = $user_result['proz'];
				$balls = round($ans_true/5,2);
				//Записать в new_stud_ans новое значение ответа и изменить свойство check
				$this->moder_model->updateUserAnswer($id_answer,$balls);
				$new_true = $user_result['true']+$balls;
				$new_result = round(($new_true/$user_result['true_all'])*100,2);
				//Записать отчёт о проверке в new_moder_answers
				$this->moder_model->addCheckLog($id_answer,$balls,$proz_before,$new_result,$comm);
				//Обновить результат
				$this->moder_model->updateUserResult($user_result['id'],$new_result,$new_true);
				$data['error']="Проверка прошла успешно. Студент сможет узнать свой результат на личной странице";
			}
		}
		else
		{
			$data['error']="";
		}
		$id_disc = $this->uri->segment(3);
		//Вывести список ответов, которые надо проверить
		$data['stud_answers'] = $this->moder_model->getStudAnswers($id_disc);
		foreach($data['stud_answers'] as $key)
		{
			$data['user'][$key['id']] = $this->forms_model->getUser($key['user']);
			$data['group'][$key['id']] = $this->moder_model->getUserGroup($key['user']);
			$data['test_name'][$key['id']] = $this->moder_model->getTestName($key['quest_id']);
			$data['quest_text'][$key['id']] = $this->moder_model->getQuestText($key['quest_id']);
			$data['test_date'][$key['id']] = $this->moder_model->getDateAnswer($key['results']);
		}
		$data['id_disc'] = $id_disc;
		$this->load->view('moder_answers_view',$data);
	}

	//Интерфейс проверки задания, запись комментария, который увидит студент на личной странице
	function check_answer()
	{
		$id_disc = $this->uri->segment(3);
		$id_answer = $this->uri->segment(4);
		$data['stud_answer'] = $this->moder_model->getStudOneAnswer($id_answer);
		foreach($data['stud_answer'] as $key)
		{
			$data['user'][$key['id']] = $this->forms_model->getUser($key['user']);
			//Текущий результат студента
			$data['user_result'][$key['id']] = $this->moder_model->getUserResult($key['results']);
			$data['group'][$key['id']] = $this->moder_model->getUserGroup($key['user']);
			$data['test_name'][$key['id']] = $this->moder_model->getTestName($key['quest_id']);
			$data['quest_text'][$key['id']] = $this->moder_model->getQuestText($key['quest_id']);
			$data['test_date'][$key['id']] = $this->moder_model->getDateAnswer($key['results']);
		}
		$data['error'] = "";
		$data['id_answer'] = $id_answer;
		$data['id_disc'] = $id_disc;
		$this->load->view('moder_check_view',$data);
	}

	function my_cmpl()
	{
		$data['stud_answers'] = $this->moder_model->getPrepodCheckAnswers();
		foreach($data['stud_answers'] as $key)
		{
			$data['prepod_comm'][$key['id']] = $key['comment'];
			$data['prepod_date'][$key['id']] = $key['date'];
			$data['proz_before'][$key['id']] = $key['proz_before'];
			$data['proz_after'][$key['id']] = $key['proz_after'];
			$data['read_status'][$key['id']] = $key['student_read'];
			$data['prepod_name'][$key['id']] = $this->forms_model->getUser($key['prepod_id']);
			$data['balls'][$key['id']] = $key['balls'];
			//Получение информации об ответе
			$answer = $this->moder_model->getAnswerOverCheck($key['answer_id']);
			$data['test_name'][$key['id']] = $this->moder_model->getTestName($answer['quest_id']);
			$data['stud_answer'][$key['id']] = $answer['answer'];
			$data['student_name'][$key['id']] = $this->forms_model->getUser($answer['user']);
			$data['quest_text'][$key['id']] = $this->moder_model->getQuestText($answer['quest_id']);
			$data['test_date'][$key['id']] = $this->moder_model->getDateAnswer($answer['results']);
		}
		$data['error'] = "";
		$this->load->view('moder_cmpl_view',$data);
	}
	
}

?>