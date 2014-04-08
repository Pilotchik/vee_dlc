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
			$now_time=time();
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
		$data['form_name']=$this->forms_model->getFormName($form_id);
		//Получить ID образовательное учреждение
		$data['form_ou']=$this->forms_model->getFormOU($form_id);
		$data['form_access']=$this->forms_model->getFormAccess($form_id);
		$data['form_id'] = $form_id;
		$data['form_quests'] = $this->forms_model->getAllActiveQuests($form_id);
		foreach($data['form_quests'] as $key)
		{
			$data['quest_options1'][$key['id']]['type'] = $key['type'];
			//Выбор одного
			if ($key['type'] == 1)
			{
				$data['quest_options1'][$key['id']]['quest']=explode(", ",$key['option1']);
				//Общая сумма
				$data['quest_options1'][$key['id']]['summ'] = 0;
				//Сумма по курсам
				for($j=1;$j<5;$j++)
				{
					$data['quest_options1'][$key['id']]['summ_kurs'][$j] = 0;
				}
				for($i=0;$i<count($data['quest_options1'][$key['id']]['quest']);$i++)
				{
					//Получение количества ответов на элемент вопроса
					$data['quest_options1'][$key['id']]['answers'][$i]=$this->forms_model->getCountOptionResult($key['id'],$i);
					$data['quest_options1'][$key['id']]['summ']+=$data['quest_options1'][$key['id']]['answers'][$i];
					//Получение количества для каждого курса
					for($j=1;$j<5;$j++)
					{
						$data['quest_options1'][$key['id']]['answers_kurs'][$j][$i] = $this->forms_model->getCountOptionKursResult($key['id'],$i,$j);
						$data['quest_options1'][$key['id']]['summ_kurs'][$j] += $data['quest_options1'][$key['id']]['answers_kurs'][$j][$i];
					}
					if ($data['form_access'] == 1)
					{
						$users_array=$this->forms_model->getAllUsersOptionResult($key['id'],$i);
						$user_string = "";
						foreach ($users_array as $key2)
						{
							//echo $user_string."<br>";
							$user_string=$user_string.$this->forms_model->getUser($key2['person_id']).", ";
						}
						$data['quest_options1'][$key['id']]['users'][$i]=substr($user_string, 0, -2);
					}
				}
				for($i=0;$i<count($data['quest_options1'][$key['id']]['quest']);$i++)
				{
					if ($data['quest_options1'][$key['id']]['summ'] > 0)
					{
						$data['quest_options1'][$key['id']]['proz'][$i] = round(($data['quest_options1'][$key['id']]['answers'][$i]/$data['quest_options1'][$key['id']]['summ'])*100,2);
					}
					else
					{
						$data['quest_options1'][$key['id']]['proz'][$i] = 0;
					}
					for ($j=1;$j<5;$j++)
					{
						if ($data['quest_options1'][$key['id']]['summ_kurs'][$j]>0)
						{
							$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j]=round(($data['quest_options1'][$key['id']]['answers_kurs'][$j][$i]/$data['quest_options1'][$key['id']]['summ_kurs'][$j])*100,2);
						}
						else
						{
							$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j] = 0;
						}
						//echo $data['quest_options1'][$key['id']]['proz_kurs'][$i][$j]."<br>";
					}
				}
				$other=$this->forms_model->getOtherTestResult($key['id']);
				$i=0;
				foreach ($other as $key2)
				{
					$data['quest_options1'][$key['id']]['other_answers'][$i]=$key2['answer'];
					if ($data['form_access'] == 1)
					{
						$user=$this->forms_model->getUsersOptionResult($key['id'],$key2['answer']);
						$user_name=$this->forms_model->getUser($user);
						$data['quest_options1'][$key['id']]['other_user'][$i]=$user_name;
					}
					$i++;
				}
			}
			if ($key['type'] == 2)
			{
				$data['quest_options1'][$key['id']]['quest']=explode(", ",$key['option1']);
				$data['quest_options1'][$key['id']]['summ'] = 0;
				$data['quest_options1'][$key['id']]['summ'] = $this->forms_model->getCountUniqOptionResult($key['id']);
				//Сумма по курсам
				for($j=1;$j<5;$j++)
				{
					$data['quest_options1'][$key['id']]['summ_kurs'][$j] = 0;
				}
				for($i=0;$i<count($data['quest_options1'][$key['id']]['quest']);$i++)
				{
					$data['quest_options1'][$key['id']]['answers'][$i]=$this->forms_model->getCountOptionResult($key['id'],$i);
					//Получение количества для каждого курса
					for($j=1;$j<5;$j++)
					{
						$data['quest_options1'][$key['id']]['answers_kurs'][$j][$i] = $this->forms_model->getCountOptionKursResult($key['id'],$i,$j);
						$data['quest_options1'][$key['id']]['summ_kurs'][$j] += $data['quest_options1'][$key['id']]['answers_kurs'][$j][$i];
					}
					if ($data['form_access'] == 1)
					{
						$users_array=$this->forms_model->getAllUsersOptionResult($key['id'],$i);
						$user_string = "";
						foreach ($users_array as $key2)
						{
							$user_string=$user_string.$this->forms_model->getUser($key2['person_id']).", ";
						}
						$data['quest_options1'][$key['id']]['users'][$i]=substr($user_string, 0, -2);
					}
				}
				for($i=0;$i<count($data['quest_options1'][$key['id']]['quest']);$i++)
				{
					$data['quest_options1'][$key['id']]['proz'][$i]=round(($data['quest_options1'][$key['id']]['answers'][$i]/$data['quest_options1'][$key['id']]['summ'])*100,2);
					for ($j=1;$j<5;$j++)
					{
						if ($data['quest_options1'][$key['id']]['summ_kurs'][$j] > 0)
						{
							$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j]=round(($data['quest_options1'][$key['id']]['answers_kurs'][$j][$i]/$data['quest_options1'][$key['id']]['summ_kurs'][$j])*100,2);
						}
						else
						{
							$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j] = 0;
						}
						//echo $key['id']." -> ".$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j]."<br>";
					}
				}
				$other=$this->forms_model->getOtherTestResult($key['id']);
				$i=0;
				foreach ($other as $key2)
				{
					$data['quest_options1'][$key['id']]['other_answers'][$i]=$key2['answer'];
					if ($data['form_access'] == 1)
					{
						$user=$this->forms_model->getUsersOptionResult($key['id'],$key2['answer']);
						$user_name=$this->forms_model->getUser($user);
						$data['quest_options1'][$key['id']]['other_user'][$i]=$user_name;
					}
					$i++;
				}
			}
			//Шкала
			if ($key['type'] == 4)
			{
				$data['quest_options1'][$key['id']]['summ'] = 0;
				//Сумма по курсам
				for($j=1;$j<5;$j++)
				{
					$data['quest_options1'][$key['id']]['summ_kurs'][$j] = 0;
				}
				for($i=1;$i<=$key['option3'];$i++)
				{
					$data['quest_options1'][$key['id']]['quest'][$i]=$i;	
					$data['quest_options1'][$key['id']]['answers'][$i]=$this->forms_model->getCountOptionResult($key['id'],$i);
					$data['quest_options1'][$key['id']]['summ'] += $data['quest_options1'][$key['id']]['answers'][$i];
					for($j=1;$j<5;$j++)
					{
						$data['quest_options1'][$key['id']]['answers_kurs'][$j][$i] = $this->forms_model->getCountOptionKursResult($key['id'],$i,$j);
						$data['quest_options1'][$key['id']]['summ_kurs'][$j] += $data['quest_options1'][$key['id']]['answers_kurs'][$j][$i];
					}
					if ($data['form_access'] == 1)
					{
						$users_array=$this->forms_model->getAllUsersOptionResult($key['id'],$i);
						$user_string = "";
						foreach ($users_array as $key2)
						{
							$user_string=$user_string.$this->forms_model->getUser($key2['person_id']).", ";
						}
						$data['quest_options1'][$key['id']]['users'][$i]=substr($user_string, 0, -2);
					}
				}
				for($i=1;$i<=$key['option3'];$i++)
				{
					$data['quest_options1'][$key['id']]['proz'][$i]=round(($data['quest_options1'][$key['id']]['answers'][$i]/$data['quest_options1'][$key['id']]['summ'])*100,2);
					for ($j=1;$j<5;$j++)
					{
						$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j]=round(($data['quest_options1'][$key['id']]['answers_kurs'][$j][$i]/$data['quest_options1'][$key['id']]['summ_kurs'][$j])*100,2);
					}
				}
			}
			//Текст
			if ($key['type'] == 3)
			{
				$text_answer_array=$this->forms_model->getAllQuestResults($key['id']);
				$i=0;
				foreach($text_answer_array as $key2)
				{
					$data['quest_options1'][$key['id']]['answers'][$i]=$key2['answer'];
					if ($data['form_access'] == 1)
					{
						$person_id=$this->forms_model->getUserByResId($key2['res_id']);
						$data['quest_options1'][$key['id']]['users'][$i]=$this->forms_model->getUser($person_id);
					}
					$i++;
				}
			}
			//Шкала
			if ($key['type'] == 5)
			{
				$data['quest_options1'][$key['id']]['stroka']=explode(", ",$key['option1']);
				$data['quest_options1'][$key['id']]['stolb']=explode(", ",$key['option2']);
				for($i=0;$i<count($data['quest_options1'][$key['id']]['stroka']);$i++)
				{
					//Определяем количество ответов для всей строки
					$data['quest_options1'][$key['id']]['summ_str'][$i] = 0;
					for($j=0;$j<count($data['quest_options1'][$key['id']]['stolb']);$j++)
					{
						//Определяем количество ответов по каждому столбцу
						$data['quest_options1'][$key['id']]['summ_stlb'][$i][$j] = $this->forms_model->getCountOptionResultSetka($key['id'],$i,$j);
						$data['quest_options1'][$key['id']]['summ_str'][$i] += $data['quest_options1'][$key['id']]['summ_stlb'][$i][$j];
						if ($data['form_access'] == 1)
						{
							$users_array=$this->forms_model->getUsersOptionResultSetka($key['id'],$i,$j);
							$user_string = "";
							foreach ($users_array as $key2)
							{
								$user_string=$user_string.$this->forms_model->getUser($key2['person_id']).", ";
							}
							$data['quest_options1'][$key['id']]['users_setka'][$i][$j]=substr($user_string, 0, -2);
						}
					}
				}
				for($i=0;$i<count($data['quest_options1'][$key['id']]['stroka']);$i++)
				{
					for($j=0;$j<count($data['quest_options1'][$key['id']]['stolb']);$j++)
					{
						if ($data['quest_options1'][$key['id']]['summ_str'][$i] > 0)
						{
							$data['quest_options1'][$key['id']]['proz_stlb'][$i][$j]=round(($data['quest_options1'][$key['id']]['summ_stlb'][$i][$j]/$data['quest_options1'][$key['id']]['summ_str'][$i])*100,2);	
						}
						else
						{
							$data['quest_options1'][$key['id']]['proz_stlb'][$i][$j] = 0;
						}		
					}
				}
			}
			//Сетка с селекторами
			if ($key['type'] == 7)
			{
				//получение массива строк
				$data['quest_options1'][$key['id']]['stroka']=explode(", ",$key['option1']);
				//получение массива столбцов
				$data['quest_options1'][$key['id']]['stolb']=explode(", ",$key['option2']);
				for($i = 0;$i < count($data['quest_options1'][$key['id']]['stroka']);$i++)
				{
					//Определяем среднее значение для всей строки (все курсы)
					$data['quest_options1'][$key['id']]['row_summ'][$i] = 0;
					for($k = 1;$k < 5;$k++)
					{
						$data['quest_options1'][$key['id']]['row_summ_kurs'][$i][$k] = 0;
						$data['quest_options1'][$key['id']]['users_count'][$i][$k] = 0;
					}
					for($j=0; $j < count($data['quest_options1'][$key['id']]['stolb']); $j++)
					{
						//Определяем средний балл по каждой строке и столбцу 
						$data['quest_options1'][$key['id']]['cell_avg'][$i][$j] = round($this->forms_model->getAVGOptionResultSetkaSelector($key['id'],$i,$j),3);
						//увеличить сумму всей строки на найденное среднее значение для строки и столбца
						$data['quest_options1'][$key['id']]['row_summ'][$i] += $data['quest_options1'][$key['id']]['cell_avg'][$i][$j];
						//Пересчёт средних значений для каждого курса
						for($k = 1;$k < 5;$k++)
						{
							//Увеличить сумму ряда на среднее значение
							$data['quest_options1'][$key['id']]['row_summ_kurs'][$i][$k] += round($this->forms_model->getAVGOptionResultSetkaSelectorKurs($key['id'],$i,$j,$k),3);
						}
					}
				}
				//Средние значения для каждой строки
				for($i=0;$i < count($data['quest_options1'][$key['id']]['stroka']);$i++)
				{
					for($k = 1;$k < 5;$k++)
					{
						$data['quest_options1'][$key['id']]['row_avg_kurs'][$i][$k] = round($data['quest_options1'][$key['id']]['row_summ_kurs'][$i][$k]/count($data['quest_options1'][$key['id']]['stolb']),3);
					}
					//Найти среднее значение строки: поделить накопленное значение на количество столбцов
					$data['quest_options1'][$key['id']]['avg_str'][$i] = round($data['quest_options1'][$key['id']]['row_summ'][$i]/count($data['quest_options1'][$key['id']]['stolb']),3);
				}
			}
		}
		$data['error']="";
		$this->load->view('forms/forms_one_result_view',$data);
	}
}