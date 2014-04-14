<?php

class Forms_admin extends CI_Controller {

	function Forms_admin()
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
				redirect('/main/auth/', 'refresh');
			}	
			else
			{
				$this->load->model('forms_model');
				$this->$method();
			}
		}
	}


	//Функция отображения главной страницы администрирования опросов
	function index($error = "")
	{
		$data['all_type_reg']=$this->forms_model->getAllTypeReg();
		$data['all_forms']=$this->forms_model->getAllForms(1);
		foreach ($data['all_forms'] as $key)
		{
			$data['type_r'][$key['id']]=$this->forms_model->getTypeReg($key['type_r']);
			$data['author'][$key['id']]=$this->forms_model->getUserName($key['author_id']);
		}
		$data['error'] = $error;
		$this->load->view('forms/forms_admin_view',$data);
	}

	function form_edit()
	{
		$this->form_validation->set_rules('c_value', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры опроса не удалось";
		}
		else
		{
			$this->forms_model->editForm();
			$form_name = $this->forms_model->getFormName($this->input->post('c_id'));
			$this->_add_to_log("Изменены параметры опроса \"$form_name\"");
			$error = "Опрос обновлён";
		}
		$this->index($error);
	}

	function form_del()
	{
		$this->forms_model->delForm();
		$form_name = $this->forms_model->getFormName($this->input->post('c_id'));
		$this->_add_to_log("Опроса \"$form_name\" удалён");
		$error = "Опрос удалён";
		$this->index($error);
	}

	function form_create()
	{
		$this->form_validation->set_rules('f_title', 'Текст', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_description', 'Описание', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_access', 'Доступ', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_type_r', 'ОУ', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать опрос не удалось";
		}
		else
		{
			//Получение данных из формы
			$title = $this->input->post('f_title');
			$type_r = $this->input->post('f_type_r');
			$desc = $this->input->post('f_description');
			$access = $this->input->post('f_access');
			$user_id = $this->session->userdata('user_id');
			//Обращение к методу создания формы
			$this->forms_model->createForm($title,$type_r,$desc,$access,$user_id);
			//Найти идентификатор созданного опроса
			$form_id = $this->forms_model->getFormIDOverTitleAndDesc($title,$desc);
			//Создать в опросе страницу с номером 0 и типом 0
			$this->forms_model->createMainSite($form_id,"Главная страница",0);
			$this->_add_to_log("Создан опрос \"".$this->input->post('f_title')."\"");
			$error = "Опрос создан";
		}
		$this->index($error);
	}

	function quest_view($error = "")
	{
		//Получение идентификатора опроса из URI
		$form_id = $this->uri->segment(3);
		//Получение названия опроса
		$data['form_name'] = $this->forms_model->getFormName($form_id);
		$data['form_id'] = $form_id;
		//Получение всех страниц опроса
		$data['sites'] = $this->forms_model->getAllSitesOverFormID($form_id);
		foreach ($data['sites'] as $key) 
		{
			$data['quests'][$key['id']] = $this->forms_model->getAllQuestsOverSiteID($form_id,$key['id']);
		}
		$data['error'] = $error;
		$this->load->view('forms/forms_admin_quest_view',$data);
	}

	function quest_edit()
	{
		$this->form_validation->set_rules('c_value', 'Значение', 'trim|xss_clean|required');
		$this->form_validation->set_rules('c_param', 'Параметр', 'trim|xss_clean|required');
		$this->form_validation->set_rules('c_id', 'Параметр', 'trim|xss_clean|required|is_natural_no_zero');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры вопроса не удалось";
		}
		else
		{
			$id_c=$this->input->post('c_id');
			$value=$this->input->post('c_value');
			$param=$this->input->post('c_param');
			$this->forms_model->editQuest($id_c,$value,$param);
			$error = "";
		}
		$this->quest_view($error);
	}

	function quest_del()
	{
		$this->form_validation->set_rules('c_id', 'Параметр3', 'trim|xss_clean|is_natural');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Удалить вопрос не удалось";
		}
		else
		{
			//Получение ID страницы
			$quest_id = $this->input->post('c_id');
			//Удалить вопрос

			$this->forms_model->delQuest($quest_id);
			$error = "Вопрос удалён";
		}
		$this->quest_view($error);
	}

	function quest_site_del()
	{
		$this->form_validation->set_rules('c_id', 'Параметр3', 'trim|xss_clean|is_natural');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Удалить вопрос не удалось";
		}
		else
		{
			//Получение ID страницы
			$quest_id = $this->input->post('c_id');
			//Удалить вопрос
			$this->forms_model->delQuest($quest_id);
			//Все вопросы, у которых в параметре "site" значился вопрос c указанным ID изменить
			//Выяснить главную страницу формы (та, у которой numb = 0)
			$form_id = $this->uri->segment(3);
			$main_site_id = $this->forms_model->getMainSiteIdOverFormId($form_id);
			//Поменять те вопросы, у которых в "site" значился вопрос c ID удалённой страницы
			$this->forms_model->updateQuestSite($quest_id,$main_site_id);
			$error = "Вопрос удалён";
		}
		$this->quest_view($error);
	}

	//Создание вопроса
	function quest_create()
	{
		$form_id=$this->uri->segment(3);
		$this->form_validation->set_rules('f_title', 'Текст', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_subtitle', 'Описание', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_type', 'Тип', 'trim|xss_clean|required');
		$this->form_validation->set_rules('f_site', 'Тип', 'trim|xss_clean|required|is_natural');
		$this->form_validation->set_rules('f_option1', 'Параметр1', 'trim|xss_clean');
		$this->form_validation->set_rules('f_option2', 'Параметр2', 'trim|xss_clean');
		$this->form_validation->set_rules('f_option3', 'Параметр3', 'trim|xss_clean|is_natural');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать вопрос не удалось";
		}
		else
		{
			$title=$this->input->post('f_title');
			$subtitle=$this->input->post('f_subtitle');
			$type=$this->input->post('f_type');
			$option1=$this->input->post('f_option1');
			$option2=$this->input->post('f_option2');
			$option3=$this->input->post('f_option3');
			$req=$this->input->post('f_req');
			$site = $this->input->post('f_site');
			$this->forms_model->createQuest($form_id,$title,$subtitle,$type,$option1,$option2,$option3,$req,$site);
			$error = "Вопрос создан";
		}
		$this->quest_view($error);
	}

	//Создание страницы опроса
	function site_create()
	{
		$form_id=$this->uri->segment(3);
		$this->form_validation->set_rules('f_title', 'Текст', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать вопрос не удалось";
		}
		else
		{
			//узнать максимальный номер страницы, которая есть в опросе и увеличить её на 1
			$max_numb = $this->forms_model->getMaxSiteNumbOverFormID($form_id);
			$max_numb++;
			$title = $this->input->post('f_title');
			$this->forms_model->createMainSite($form_id,$title,$max_numb);
			$error = "Страница создана";
		}
		$this->quest_view($error);
	}

	function view_results($error="")
	{
		$data['error'] = $error;
		$data['open_forms']=$this->forms_model->getAllForms(1);
		foreach ($data['open_forms'] as $key)
		{
			$data['count_resp'][$key['id']] = $this->forms_model->getCountForms($key['id']);
		}
		$this->load->view('forms/forms_results_view',$data);
	}

	function public_result()
	{
		$form_id = $this->uri->segment(3);
		if ($this->uri->segment(4) == 1)
		{
			$this->forms_model->updatePublicForm($form_id,1);
		}
		else
		{
			$this->forms_model->updatePublicForm($form_id,0);
		}
		$this->view_results("Статус опроса обновлён");
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
			//Выбор нескольких
			if ($key['type'] == 2)
			{
				//Массив значений
				$data['quest_options1'][$key['id']]['quest'] = explode(", ",$key['option1']);
				$data['quest_options1'][$key['id']]['summ'] = $this->forms_model->getCountUniqOptionResult($key['id']);
				
				$count_punkts = (int) $key['option3'];
				
				//Сумма по курсам
				for($j=1;$j<5;$j++)
				{
					$data['quest_options1'][$key['id']]['summ_kurs'][$j] = 0;
				}

				//Получить мощность ответа каждого пользователя, если у вопроса было ограничение на количество отмечаемых пунктов
				if ($count_punkts > 0)
				{
					$user_answer_balls = array();
					//получить все res_id, которые участвовали в ответе на вопрос
					$all_quest_res = $this->forms_model->getAllResIdOptionResult($key['id']);
					//Для каждого res_id определить количество ответов 
					foreach ($all_quest_res as $key2) 
					{
						$count_answers = $this->forms_model->getCountUserAnswers($key['id'],$key2['res_id']);
						$user_answer_balls[$key2['res_id']] = round($count_punkts/$count_answers,2);
					}
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
					if ($data['quest_options1'][$key['id']]['summ'] != 0)
					{
						$data['quest_options1'][$key['id']]['proz'][$i]=round(($data['quest_options1'][$key['id']]['answers'][$i]/$data['quest_options1'][$key['id']]['summ'])*100,2);
					}
					else
					{
						$data['quest_options1'][$key['id']]['proz'][$i] = 0;
					}
					for ($j=1;$j<5;$j++)
					{
						if ($data['quest_options1'][$key['id']]['summ_kurs'][$j] != 0)
						{
							$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j] = round(($data['quest_options1'][$key['id']]['answers_kurs'][$j][$i]/$data['quest_options1'][$key['id']]['summ_kurs'][$j])*100,2);	
						}
						else
						{
							$data['quest_options1'][$key['id']]['proz_kurs'][$i][$j] = 0;
						}
						
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

	function _add_to_log($msg = "")
	{
		$this->load->model('main_model');
		$this->main_model->createLogRecord($msg,3);
	}
}

?>