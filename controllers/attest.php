<?php

class Attest extends CI_Controller {

	function Attest()
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
			$this->load->model('attest_model');
			$this->load->library('session');
			$this->$method();
		}
	}


	//Функция отображения главной страницы
	function index($error = "")
	{
		$data['title'] = "ВОС.Тестирование";
		$type_r=$this->session->userdata('type_r');
		if ($type_r > 0)
		{
			$data['disciplines'] = $this->attest_model->getDisciplines($type_r);
		}
		else
		{
			$data['disciplines'] = $this->attest_model->getAllDisciplines();		
		}
		$user_id=$this->session->userdata('user_id');
		foreach ($data['disciplines'] as $key)
		{
			$data['disc'][$key['id']]['tests_uncompleted'] = $this->attest_model->getTests_uncompl($key['id'],$user_id);
			$data['disc'][$key['id']]['tests_completed'] = $this->attest_model->getTests_compl($key['id'],$user_id);
		}
		$data['error'] = $error;
		$this->load->view('attest/attest_menu_view',$data);
	}

	function play_test()
	{
		$this->form_validation->set_rules('test_id', 'Ключ', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('test_key', 'Ключ', 'trim|required|xss_clean|max_length[10]|min_length[1]');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Попытка взлома";
			$this->index($error);
		}
		else
		{
			$test_id = $this->input->post('test_id');
			$test = $this->attest_model->getTest($test_id);
		}
		$user_id = $this->session->userdata('user_id');
		$code_input = $this->input->post('test_key');
		//если ID лекции != нулю, то студент на тест попал из ДО
		if ($this->input->post('lection_id') != "")	{$lection_id = $this->input->post('lection_id');}	else {$lection_id = 0;}
		if ($code_input != $test[0]['kod'] || $this->form_validation->run() == FALSE)
		{
			$s_id = $this->session->userdata('session_id');
			$ddos = $this->attest_model->getDdos($s_id);
			$ddos++;
			$this->attest_model->updateDdos($s_id,$ddos);
			$error = "Неверный код";
			if ($ddos>3)
			{
				$this->load->model('auth_model');
				$f1=$this->session->userdata('firstname');
				$f=$this->session->userdata('lastname');
				$name=$f." ".$f1;
				$type="Попытка подбора ключа к тесту";
				$this->auth_model->addLog($name,$type,2);
			}
			redirect('/main/auth', 'refresh');
		}
		else
		{
			$now_time = time();
			$data['name_test'] = $test[0]['name_razd'];
			$data['time_long'] = $test[0]['time_long'];
			$data['user_id'] = $this->session->userdata('user_id');
			$result=$this->attest_model->getResult($test_id,$this->session->userdata('user_id'));
			if (isset($result[0]))
			{
				//Если тест уже был начат
				$data['time_save']=$result[0]['timesave'];
				$data['begin_t']=$result[0]['timebeg'];
				$all_quests=$this->attest_model->getScenariy($result[0]['id']);
				$data['quests']=$this->attest_model->getSpecQuests($test_id,$this->session->userdata('user_id'),$all_quests);
			}
			else
			{
				//Получить список номеров заданий в тесте (каждый номер может содержать несколько вариантов)
				$numbers=$this->attest_model->getNumberOfTest($test_id,$test[0]['rnd_status']);
				//Для каждого номера задания выбрать вариант
				$quest_id_str="(";
				foreach ($numbers as $key)
				{
					//Получить список ID вопросов с одним номером и выбрать из них один вариант
					$variant=$this->attest_model->getVariants($test_id,$key['number']);
					$rnd_var=rand(0,count($variant)-1);
					$quest_id_str=$quest_id_str.$variant[$rnd_var]['id'].",";
				}
				$quest_id_str=substr($quest_id_str, 0, -1);
				$quest_id_str=$quest_id_str.")";
				//Массив с вопросами
				$data['quests']=$this->attest_model->getQuests($test_id,$quest_id_str);
				$true_all=count($data['quests']);
				//Создание записи о результате
				$res_record=$this->attest_model->createResRecord($test_id,$this->session->userdata('user_id'),$now_time,$rnd_var,$true_all);
				//Получение ID результат для создания сценария
				$last_res_array=$this->attest_model->getResult($test_id,$this->session->userdata('user_id'));
				$res_id=$last_res_array[0]['id'];
				//Создание сценария c ID результата и строкой вопросов
				$this->attest_model->createScenariy($res_id,$quest_id_str);
				$data['begin_t']=$now_time;
				$data['time_save']=0;
			}
			$data['answers']=array();
			foreach ($data['quests'] as $key) 
			{
				$data['answers'][$key['id']]=$this->attest_model->getAnswers($key['id']);
			}
			$data['tim']=$now_time;
			$data['chislo_vopr'] = count($data['quests']);
			$data['time_long'] = $test[0]['time_long'];
			$data['id_test'] = $test_id;
			$data['lection_id'] = $lection_id;
			$data['error'] = "";
			$this->load->view('attest/attest_play_view',$data);	
		}
	}

	function autosave()
	{
		$this->form_validation->set_rules('id_q', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('ans_id', 'ID', 'trim|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('time_s', 'Время', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('idrazd', 'Раздел', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('true_q', 'Ответ', 'trim|xss_clean|max_length[30]');
		$this->form_validation->set_rules('check', 'Проверка', 'trim|xss_clean|max_length[30]');
		if ($this->form_validation->run() == TRUE)
		{
			$id_q=$this->input->post('id_q');
			$true_q=$this->input->post('true_q');
			$time_s=$this->input->post('time_s');
			$idrazd=$this->input->post('idrazd');
			$ans_id=$this->input->post('ans_id');
			$check=$this->input->post('check');
			//Получение ID результатной записи
			$status_array=$this->attest_model->getResRecord($this->session->userdata('user_id'),$idrazd);
			$result_id=$status_array[0]['id'];
			//Записать время выполнения вопроса
			//Узнать время выполнения предыдущего задания
			$prev_quest_time = $this->attest_model->getPrevQuest($result_id, $id_q);
			$now_time=time();
			if ($prev_quest_time != 0)
			{
				//Если в предыдущем вопросе есть время
				$quest_time = $now_time - $prev_quest_time;
			}
			else
			{
				//Получить время начала теста
				$test_begin = $this->attest_model->getTestBegin($result_id);
				$quest_time = $now_time - $test_begin;
			}
		
			//Все ответы на вопрос
			$answers=$this->attest_model->getAnswers($id_q);
			//Все правильные ответы
			$true_answers=$this->attest_model->getTrueAnswers($id_q);
			//Получение типа вопроса
			$quest=$this->attest_model->getQuest($id_q);
			//Тип вопроса
			$type_q=$quest[0]['type'];
			$n=1;
			//Количество ответов
			$s2=count($answers);
			//Найти количество правильных ответов в закрытых вопросах с несколькими правильными
			$s=count($true_answers);
			$true=0;
			foreach($answers as $key)
			{
				$questtrue=$key['true'];
				$ans_text=$key['text'];
				if ($type_q==2)
				{				
					if (($true_q=="$n") and ($questtrue=='1') and ($check=='1'))
					{
						$true=1/$s;
					}
					if (($true_q=="$n") and ($questtrue=='1') and ($check!='1'))
					{
						$true=(-1)*(1/($s2-$s));
					}
					if (($true_q=="$n") and ($questtrue!='1') and ($check=='1'))
					{
						$true=(-1)*(1/($s2-$s));
					}
					if (($true_q=="$n") and ($questtrue!='1') and ($check!='1'))
					{
						$true=1/$s;
					}
				}
				if ($type_q==3)
				{
					if (((strlen($true_q)/2)==strlen($ans_text)) or ($true_q==$ans_text))
					{
						$true = 1;
					}
					else
					{
						$true = 0;
					}
				}
				//Числовой диапазон
				if ($type_q == 6)
				{
					$true_q = str_replace(",",".",$true_q);
					if (($true_q > $key['option_1']) && ($true_q < $key['option_2']) || ($true_q == $key['option_1']) || ($true_q == $key['option_2']))
					{
						$true = 1;
					}
					else
					{
						$true = 0;
					}
				}
				$n++;
			}
			//Выяснить правильный ответ для конкретного ID ответа
			$true_of_answer = $this->attest_model->getAnswer($ans_id);
			if ($type_q==1)
			{
				$true = ($true_of_answer['true']=='1' ? 1 : 0);
			}
			if ($type_q==4)
			{
				if ($true_of_answer['true']==$true_q)
				{
					$true=1/$s2;
				}
				else
				{
					$true=-0.05;
				}
			}
			//Ответ студента
			$pers_answer=$this->attest_model->getPersonalAnswer($id_q,$this->session->userdata('user_id'));
			if (isset($pers_answer[0]))
			{
				//Уже есть запись ответа
				$ans_id=$pers_answer[0]['id'];
				$answer=$pers_answer[0]['true'];
				if (($type_q==2) or ($type_q==4)) 
				{
					$true=$true+$answer;
					if ($true<0) {$true=0;}
					if ($true>1) {$true=1;}
				}
				$update_answer=$this->attest_model->updatePersonalAnswer($ans_id,$true_q,$true);
			}
			else
			{
				//Ответ даётся в первый раз
				if ($true<0) {$true=0;}
				$update_answer = $this->attest_model->addPersonalAnswer($this->session->userdata('user_id'),$id_q,$true_q,$result_id,$true,$quest_time);	
			}
			//Изменить время автосохранения
			$editTime=$this->attest_model->updateResTimeRecord($result_id,$time_s);	
			echo json_encode(array('answer'=>1));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

	function corr_quest()
	{
		$this->form_validation->set_rules('id_q', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('type', 'type', 'trim|required|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$id_q=$this->input->post('id_q');
			$type=$this->input->post('type');
			//Получение ID результатной записи
			$this->attest_model->addIncorrQuest($this->session->userdata('user_id'),$id_q,$type);	
			echo json_encode(array('answer'=>1));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

	//Автоматическая запись времени
	function timesave()
	{
		$time_s=$this->input->post('time_s');
		$idrazd=$this->input->post('idrazd');
		$this->form_validation->set_rules('time_s', 'Время', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('idrazd', 'Раздел', 'trim|required|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$status_array=$this->attest_model->getResRecord($this->session->userdata('user_id'),$idrazd);
			$result_id=$status_array[0]['id'];
			$editTime=$this->attest_model->updateResTimeRecord($result_id,$time_s);
		}
	}

	function test_itog()
	{
		$test_id=$this->uri->segment(3);
		$user_id=$this->session->userdata('user_id');
		$now_time=time();
		$status_array=$this->attest_model->getResRecord($user_id,$test_id);
		$result_id=$status_array[0]['id'];
		if ($status_array[0]['proz']>0)
		{
			redirect(base_url());
		}
		else
		{
			$data['true_all']=round($status_array[0]['true_all'],3);
			$stud_answers=$this->attest_model->getStudAnswers($result_id);
			$true_cnt=0;
			$data['dano']=count($stud_answers);
			foreach ($stud_answers as $key)
			{
				$true_cnt=$key['true']+$true_cnt;
			}
			$abs=round(($true_cnt/$data['true_all'])*100,3);
			if ($abs>100) {$abs=100;}
			$data['true_cnt']=$true_cnt;
			$data['abs']=$abs;
			$result=$this->attest_model->updateResRecord($result_id,$true_cnt,$abs,$now_time);
			$data['result_id'] = $result_id;
			$this->load->model('main_model');
			$lection_id = $this->input->post('lection_id');
			if ($lection_id != 0)
			{
				//Подгрузка модели дистанционного обучения
				$this->load->model('de_model');
				//Записать новый статус лекции new_lect_results
				$this->de_model->updateUserLectInCourse($lection_id,$result_id);
				/*
					Обновить таблицу с результатами курса: new_crs_results
				*/
				$course_id = $this->de_model->getCourseWhereLection($lection_id);
				//1. Узнать количество лекций в курсе
				$lection_count = $this->de_model->getLectionCount($course_id);
				//2. Узнать количество завершённых лекций
				$lection_count_close = $this->de_model->getLectionCountClose($course_id);
				//3. Узнать количество набранных процентов в тестах и вычислить среднее
				$balls_course = $this->de_model->getAVGTestResults($course_id);
				//Обновить количество процентов и если 100, то обновить статус
				$proz_course = round(($lection_count_close/$lection_count)*100,2);
				if ($proz_course > 99)
				{
					//Обучение завершено
					$this->de_model->updateCourseResult($course_id,$proz_course,$balls_course,1);
					$msg = "Пройден дистанционный курс \"".$this->de_model->getNameCourse($course_id)."\"";
					$this->main_model->createLogRecord($msg,2);
				}
				else
				{
					$this->de_model->updateCourseResult($course_id,$proz_course,$balls_course,0);
				}
			}
			$this->load->model('tests_model');
			$msg = "Пройден тест \"".$this->tests_model->getDiscNameOverTestID($test_id).". ".$this->attest_model->getNameTest($test_id)."\"";
			$this->main_model->createLogRecord($msg,1);
			$data['error']="";
			$this->load->view('attest/attest_itog_view',$data);
		}
	}

	//Выражение мнения по поводу оценки
	function result_opinion()
	{
		$this->form_validation->set_rules('resultid', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('opinion', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$res_id=$this->input->post('resultid');
			$opinion=$this->input->post('opinion');
			//Изменение результатной записи
			$this->attest_model->updateResOpinion($res_id,$opinion);
			echo json_encode(array('answer'=>1));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

}

?>