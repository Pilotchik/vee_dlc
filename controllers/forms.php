<?php

class Forms extends CI_Controller {

	function Forms()
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
			$this->load->model('forms_model');
			$this->$method();
		}
	}

	//Функция отображения главной страницы
	function index()
	{
		$data['error'] = "";
		$data['title'] = "ВОС.Анкетирование";
		$type_r = $this->session->userdata('type_r');
		$data['open_forms']=$this->forms_model->getTypeRForms($type_r);
		foreach ($data['open_forms'] as $key)
		{
			$data['count_resp'][$key['id']] = $this->forms_model->getCountForms($key['id']);
			$data['resp_status'][$key['id']] = $this->forms_model->getRespStatus($key['id'],$this->session->userdata('user_id'));
		}
		$data['archive_forms'] = $this->forms_model->getArchiveForms($type_r);
		foreach ($data['archive_forms'] as $key)
		{
			$data['count_resp'][$key['id']] = $this->forms_model->getCountForms($key['id']);
			@$data['resp_status'][$key['id']] = $this->forms_model->getRespStatus($key['id'],$this->session->userdata('user_id'));
		}
		$this->load->view('forms/forms_view',$data);
	}

	function play_form()
	{
		$form_id = (int) $this->uri->segment(3);
		$data['error'] = "";
		//Проверить, есть ли вообще такой опрос
		if ($this->forms_model->checkFormId($form_id)>0)
		{
			//Проверка, был ли уже начат этот опрос, если нет - то создать запись в таблице результатов форм
			$check = $this->forms_model->checkFormResult($form_id);
			if ($check==0)
			{
				//Создание записи о начале прохождения тестирования
				$now_time=time();
				$this->forms_model->createFormResult($form_id,$now_time);	
			}
			//Получение названия опроса
			$data['form_name']=$this->forms_model->getFormName($form_id);
			//Получение всех страниц опроса
			$data['sites'] = $this->forms_model->getAllSitesOverFormID($form_id);
			//Для каждой страницы получить её вопросы
			foreach ($data['sites'] as $key) 
			{
				$data['quests'][$key['id']]  = $this->forms_model->getFormSiteQuests($form_id,$this->session->userdata('user_id'),$key['id']);
			}
			$data['form_id'] = $form_id;
			$this->load->view('forms/forms_play_view',$data);
		}
		else
		{
			$this->index();
		}
	}

	//Функция автосохранения
	function autosave()
	{
		//Проверка введённых данных
		$this->form_validation->set_rules('id_q', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('val', 'Значение1', 'trim|required|xss_clean');
		$this->form_validation->set_rules('val2', 'Значение2', 'trim|xss_clean');
		$this->form_validation->set_rules('val3', 'Значение2', 'trim|xss_clean|is_natural');
		$this->form_validation->set_rules('form_id', 'Опрос', 'trim|required|xss_clean|is_natural_no_zero');
		//Получение идентификатора пользователя
		$user_id = $this->session->userdata('user_id');
		//Если введённые данные верны, то их обработка
		if ($this->form_validation->run() == TRUE)
		{
			$id_q = $this->input->post('id_q');
			$value = $this->input->post('val');
			$value2 = $this->input->post('val2');
			$value3 = $this->input->post('val3');
			$form_id = $this->input->post('form_id');
			$res_id = $this->forms_model->getResId($form_id,$user_id);
			$type_q = $this->forms_model->getTypeQuest($id_q);
			$temp = "";
			if ($type_q == 1 || $type_q == 3 || $type_q == 4)
			{
				//Проверка существования записи
				$check = $this->forms_model->getCheckAnswer($id_q,$res_id);
				if ($check == 0)
				{
					$this->forms_model->insertAnswer($id_q,$res_id,$value,$value2);
					$k="ins";
				}
				else
				{
					$this->forms_model->updateAnswer($id_q,$res_id,$value,$value2);
					$k="upd";
				}
			}
			if ($type_q == 2)
			{
				$this->forms_model->insertAnswer($id_q,$res_id,$value,$value2);
				$k="ins";
			}
			if ($type_q == 5)
			{
				//Проверка существования записи со строкой
				$check = $this->forms_model->getCheckAnswerSetka($id_q,$res_id,$value);
				if ($check == 0)
				{
					$this->forms_model->insertAnswer($id_q,$res_id,$value,$value2);
					$k="ins";
				}
				else
				{
					$this->forms_model->updateAnswer($id_q,$res_id,$value,$value2);
					$k="upd";
				}
			}
			$temp = $id_q;
			if ($type_q == 7)
			{
				
				//Проверка существования записи со строкой и столбцом
				$check = $this->forms_model->getCheckAnswerSetkaSelect($id_q,$res_id,$value,$value2);
				if ($check == 0)
				{
					$this->forms_model->insertAnswerSetkaSelect($id_q,$res_id,$value,$value2,$value3);
					$k="ins";
				}
				else
				{
					$this->forms_model->updateAnswerSetkaSelect($id_q,$res_id,$value,$value2,$value3);
					$k="upd";
				}
			}
			echo json_encode(array('answer'=>1,'type'=>$k,'q_type'=>$type_q,'option'=>$temp));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

	function autosave2()
	{
		//Проверка введённых данных
		$this->form_validation->set_rules('id_q', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('val', 'Значение1', 'trim|required|xss_clean');
		$this->form_validation->set_rules('form_id', 'Опрос', 'trim|required|xss_clean|is_natural_no_zero');
		//Получение идентификатора пользователя
		$user_id = $this->session->userdata('user_id');
		//Если введённые данные верны, то их обработка
		if ($this->form_validation->run() == TRUE)
		{
			$id_q = $this->input->post('id_q');
			$value = $this->input->post('val');
			$form_id = $this->input->post('form_id');
			$res_id = $this->forms_model->getResId($form_id,$user_id);
			//удалить элемент из базы
			$this->forms_model->delUserAnswer($id_q,$res_id,$value);
			echo json_encode(array('answer'=>1, 'option'=>"del"));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

	function form_itog()
	{
		$form_id = $this->uri->segment(3);
		$data['error'] = "";
		//Запись в лог
		$form_name=$this->forms_model->getFormName($form_id);
		$this->forms_model->createLogRecord($form_name);
		//Проверка, завершался ли уже опрос раньше. Если нет - записать время окончания опроса
		$check = $this->forms_model->checkEndFormResult($form_id);
		if ($check == 0)
		{
			//запись времени об окончании анкетирования
			$now_time = time();
			$user_id=$this->session->userdata('user_id');
			$this->forms_model->updateFormResult($user_id,$form_id,$now_time);
		}
		$data['right'] = $this->forms_model->getRightResults($form_id);
		$data['form_id'] = $form_id;
		$this->load->view('forms/forms_itog_view',$data);
	}

	function view_one_result()
	{
		$form_id = $this->uri->segment(3);
		$data['title'] = "ВОС.Результаты анкетирования";
		$data['form_name']=$this->forms_model->getFormName($form_id);
		//Получить ID образовательное учреждение
		$data['form_ou']=$this->forms_model->getFormOU($form_id);
		$data['form_access']=$this->forms_model->getFormAccess($form_id);
		$data['form_id'] = $form_id;
		$data['form_quests'] = $this->forms_model->getAllActiveQuests($form_id);
		$data['error']="";
		$this->load->view('forms/forms_one_result_view',$data);
	}

	function loadgraph()
	{
		$this->form_validation->set_rules('q_id', '', 'trim|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$quest_id = $this->input->post('q_id');
			$q_type = $this->forms_model->getTypeQuestOverID($quest_id);
			$q_own = $this->forms_model->getOwnQuestOverID($quest_id);
			$option1 = $this->forms_model->getOption1QuestOverID($quest_id);
			$option2 = $this->forms_model->getOption2QuestOverID($quest_id);
			$option3 = $this->forms_model->getOption3QuestOverID($quest_id);
			$punkts = array();
			$columns = array();
			$proz = array();
			$proz_kurs = array();
			for($j = 1;$j < 5;$j++) {$proz_kurs[$j] = array();}
			$other_version = array();
			//Выбор одного пункта
			if ($q_type == 1)
			{
				//Получение списка пунктов для ответа
				$punkts = explode(", ",$option1);
				//Общая сумма
				$summ = 0;
				//Сумма по курсам
				for($j = 1;$j < 5;$j++)	{$summ_kurs[$j] = 0;}
				for($i = 0;$i < count($punkts);$i++)
				{
					//Получение количества ответов на элемент вопроса
					$answers[$i] = $this->forms_model->getCountOptionResult($quest_id,$i);
					//Увеличить количество голосов по пункту
					$summ += $answers[$i];
					//Получение количества для каждого курса
					for($j = 1;$j < 5;$j++)
					{
						$answers_kurs[$j][$i] = $this->forms_model->getCountOptionKursResult($quest_id,$i,$j);
						$summ_kurs[$j] += $answers_kurs[$j][$i];
					}
				}

				for($i = 0;$i < count($punkts);$i++)
				{
					$proz[$i] = ($summ > 0 ? round(($answers[$i]/$summ)*100,2) : 0);
					for ($j = 1;$j < 5;$j++)
					{
						$proz_kurs[$j][$i] = ($summ_kurs[$j] > 0 ? round(($answers_kurs[$j][$i]/$summ_kurs[$j])*100,2) : 0);
					}
				}
				$other_version = $this->forms_model->getOtherTestResult($quest_id);
			}
			
			//Выбор нескольких
			if ($q_type == 2)
			{
				//punkts
				//proz
				//proz_kurs
				//Массив значений
				$punkts = explode(", ",$option1);
				$summ = $this->forms_model->getCountUniqOptionResult($quest_id);
				
				$count_punkts = (int) $option3;
				
				//Сумма по курсам
				for($j = 1;$j < 5;$j++)	{$summ_kurs[$j] = 0;}

				//Получить мощность ответа каждого пользователя, если у вопроса было ограничение на количество отмечаемых пунктов
				/*
				if ($count_punkts > 0)
				{
					$user_answer_balls = array();
					//получить все res_id, которые участвовали в ответе на вопрос
					$all_quest_res = $this->forms_model->getAllResIdOptionResult($key['id']);
					//Для каждого res_id определить количество ответов 
					foreach ($all_quest_res as $key2) 
					{
						$count_answers = $this->forms_model->getCountUserAnswers($quest_id,$key2['res_id']);
						$user_answer_balls[$key2['res_id']] = round($count_punkts/$count_answers,2);
					}
				}
				*/

				for($i = 0;$i < count($punkts);$i++)
				{
					$answers[$i] = $this->forms_model->getCountOptionResult($quest_id,$i);

					//Получение количества для каждого курса
					for($j = 1;$j < 5;$j++)
					{
						$answers_kurs[$j][$i] = $this->forms_model->getCountOptionKursResult($quest_id,$i,$j);
						$summ_kurs[$j] += $answers_kurs[$j][$i];
					}
					
					/*
					if ($count_punkts > 0)
					{
						$data['quest_options1'][$key['id']]['ball_answers'][$i] = 0;
						//Найти все res_id, на этот вопрос и отмечал этот пункт
						$all_punkt_res = $this->forms_model->getPunktResIdOptionResult($key['id'],$i);
						//Увеличить количество баллов на цену ответа каждого пользователя
						foreach ($all_punkt_res as $key2) 
						{
							//количество ответов пользователя в вопросе	
							$data['quest_options1'][$key['id']]['ball_answers'][$i] += $user_answer_balls[$key2['res_id']];
						}
					}
					*/
				}

				for($i = 0;$i < count($punkts);$i++)
				{
					$proz[$i] = round(($answers[$i]/$summ)*100,2);
					for ($j = 1;$j < 5;$j++)
					{
						$proz_kurs[$j][$i] = ($summ_kurs[$j] > 0 ? round(($answers_kurs[$j][$i]/$summ_kurs[$j])*100,2) : 0);
					}
				}
				$other_version = $this->forms_model->getOtherTestResult($quest_id);
			}

			//Текст
			if ($q_type == 3)
			{
				$other_version = $this->forms_model->getAllQuestResults($quest_id);
			}

			//Шкала
			if ($q_type == 4)
			{
				$summ = 0;
				
				//Сумма по курсам
				for($j = 1;$j < 5;$j++)	{$summ_kurs[$j] = 0;}

				for($i = 1;$i <= $option3;$i++)
				{
					array_push($punkts,$i);
					$answers[$i] = $this->forms_model->getCountOptionResult($quest_id,$i);
					$summ += $answers[$i];
					for($j = 1;$j < 5;$j++)
					{
						$answers_kurs[$j][$i] = $this->forms_model->getCountOptionKursResult($quest_id,$i,$j);
						$summ_kurs[$j] += $answers_kurs[$j][$i];
					}
				}

				for($i = 1;$i <= $option3;$i++)
				{
					$proz[$i] = ($summ > 0 ? round(($answers[$i]/$summ)*100,2) : 0);
					for ($j=1;$j<5;$j++)
					{
						$proz_kurs[$j][$i] = ($summ_kurs[$j] > 0 ? round(($answers_kurs[$j][$i]/$summ_kurs[$j])*100,2) : 0);
					}
				}
			}
			//Сетка с радио
			if ($q_type == 5)
			{
				$punkts = explode(", ",$option1);
				$columns = explode(", ",$option2);
				
				//Определяем количество ответов для всей строки
				for($i = 0;$i < count($punkts);$i++)
				{
					$summ_str[$i] = 0;
				
					//Определяем количество ответов по каждому столбцу
					for($j = 0;$j < count($columns);$j++)
					{
						$summ_stlb[$i][$j] = $this->forms_model->getCountOptionResultSetka($quest_id,$i,$j);
						$summ_str[$i] += $summ_stlb[$i][$j];
					}
				}

				for($i = 0;$i < count($punkts);$i++)
				{
					for($j = 0;$j < count($columns);$j++)
					{
						$proz[$i][$j] = ($summ_str[$i] > 0 ? round(($summ_stlb[$i][$j]/$summ_str[$i])*100,2) : 0);
					}
				}
			}
			//Сетка с селекторами
			if ($q_type == 7)
			{
				//получение массива строк
				$punkts = explode(", ",$option1);
				//получение массива столбцов
				$columns = explode(", ",$option2);

				for($i = 0;$i < count($punkts);$i++)
				{
					//Определяем среднее значение для всей строки (все курсы)
					$row_summ[$i] = 0;
					for($k = 1;$k < 5;$k++)
					{
						$proz_kurs[$k][$i] = 0;
						$users_count[$i][$k] = 0;
					}

					for($j=0; $j < count($columns); $j++)
					{
						//Определяем средний балл по каждой строке и столбцу 
						$proz[$i][$j] = round($this->forms_model->getAVGOptionResultSetkaSelector($quest_id,$i,$j),3);
						//увеличить сумму всей строки на найденное среднее значение для строки и столбца
						$row_summ[$i] += $proz[$i][$j];
						//Пересчёт средних значений для каждого курса
						for($k = 1;$k < 5;$k++)
						{
							//Увеличить сумму ряда на среднее значение
							$proz_kurs[$k][$i] += round($this->forms_model->getAVGOptionResultSetkaSelectorKurs($quest_id,$i,$j,$k),3);
						}
					}
				}
				//Средние значения для каждой строки
				for($i=0;$i < count($punkts);$i++)
				{
					for($k = 1;$k < 5;$k++)
					{
						$proz_kurs[$k][$i] = round($proz_kurs[$k][$i]/count($columns),3);
					}
					//Найти среднее значение строки: поделить накопленное значение на количество столбцов
					//В массивы proz в заданной строке добавить среднее значение
					array_push($proz[$i],round($row_summ[$i]/count($columns),3));
				}
			}
			echo json_encode(array('answer'=>1,'quest'=>$q_type,'punkts'=>$punkts,'proz'=>$proz,'kurs1'=>$proz_kurs[1],'kurs2'=>$proz_kurs[2],'kurs3'=>$proz_kurs[3],'kurs4'=>$proz_kurs[4],'other'=>$other_version,'columns'=>$columns));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}

	}
}