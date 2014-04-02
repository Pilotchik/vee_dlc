<?php

class Stat extends CI_Controller {

	function Stat()
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
				$this->load->model('results_model');
				$this->load->model('stat_model');
				$this->load->model('de_model');
				$this->$method();
			}
		}
	}


	//Функция отображения страницы результатов
	function index()
	{
		$data['fspo']=$this->results_model->getDisciplines('1');
		$data['count_results']=array();
		foreach ($data['fspo'] as $key) 
		{
			$count=$this->stat_model->getTestCount($key['id']);
			$data['count_results'][$key['id']]=$count[0]['COUNT(*)'];
		}
		$data['segrys']=$this->results_model->getDisciplines('2');
		foreach ($data['segrys'] as $key) 
		{
			$count=$this->stat_model->getTestCount($key['id']);
			$data['count_results'][$key['id']]=$count[0]['COUNT(*)'];
		}
		$data['univers']=$this->results_model->getDisciplines('3');
		foreach ($data['univers'] as $key) 
		{
			$count=$this->stat_model->getTestCount($key['id']);
			$data['count_results'][$key['id']]=$count[0]['COUNT(*)'];
		}
		$data['error']="";
		$this->load->view('stat/stat_disc_view',$data);
	}

	function view_tests($error = "")
	{
		$data['tests']=$this->results_model->getDisciplin($this->uri->segment(3));
		$data['tests_results']=array();
		foreach ($data['tests'] as $key) 
		{
			$results=$this->stat_model->getTestResult($key['id']);
			$summ=0;
			$summ_t=0;
			$summ_corr=0;
			foreach ($results as $key2)
			{
				$summ+=$key2['proz'];
				$summ_corr+=$key2['proz_corr'];
				$summ_t+=$key2['timeend']-$key2['timebeg'];
			}
			$data['tests_results'][$key['id']]['count']=count($results);
			$data['tests_results'][$key['id']]['abs']=round($summ/count($results),2);
			$data['tests_results'][$key['id']]['abs_corr']=round($summ_corr/count($results),2);
			//Расчёт среднего времени выполнения теста
			$data['tests_results'][$key['id']]['time_avg']=ceil($summ_t/count($results));
			//Обновление сложности теста и времени выполнения
			$this->stat_model->updateTestMultiplicity($key['id'],$data['tests_results'][$key['id']]['abs_corr'],$data['tests_results'][$key['id']]['time_avg']);
			$data['tests_results'][$key['id']]['time_avg']=ceil($data['tests_results'][$key['id']]['time_avg']/60);
		}
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(3));
		$data['disc_id']=$this->uri->segment(3);
		$data['error'] = $error;
		$this->load->view('stat/stat_tests_view',$data);
	}

	function view_disc_groups()
	{
		//Определить образовательное учреждение для дисцпилины
		$type_disc=$this->stat_model->getTypeDisc($this->uri->segment(3));
		if ($type_disc==3)
		{
			$type_disc="(1,2)";
		}
		else
		{
			$type_disc="(".$type_disc.")";
		}
		//Получение списка пользователей, которые учавствовали в тестах по дисциплине
		$users=$this->stat_model->getUsers($this->uri->segment(3),$type_disc);
		$str="(";
		$user_results=array();	
		foreach ($users as $key) 
		{
			$str=$str.$key['user'].",";
			$user_results[$key['user']]['proz']=$key['proz_corr'];
			//Получение id группы пользователя
			$group_id=$this->stat_model->getGroupId($key['user']);
			$user_results[$key['user']]['group']=$group_id[0]['numbgr'];
		}
		$str=substr($str, 0, -1);
		$str=$str.")";
		//Получение списка групп, которые учавствовали в тестировании по дисциплине
		$groups=$this->stat_model->getGroups($str);
		$data['groups_results']=array();
		foreach ($groups as $key) 
		{
			$data['groups_results'][$key['id']]['name']=$key['name_numb'];
			//Сумма баллов
			$s=0;
			//Счётчик студентов
			$i=0;
			$data['groups_results'][$key['id']]['min']=100;
			$data['groups_results'][$key['id']]['max']=0;
			foreach ($user_results as $key2)
			{
				if ($key2['group']==$key['id'])
				{
					if ($key2['proz']>$data['groups_results'][$key['id']]['max'])
					{
						$data['groups_results'][$key['id']]['max']=$key2['proz'];	
					}
					if ($key2['proz']<$data['groups_results'][$key['id']]['min'])
					{
						$data['groups_results'][$key['id']]['min']=$key2['proz'];	
					}
					$s+=$key2['proz'];
					$i++;
				}
			}
			//Средний результат
			$avg=round($s/$i,2);
			$disp=0;
			foreach ($user_results as $key2)
			{
				if ($key2['group']==$key['id'])
				{
					$disp+=($key2['proz']-$avg)*($key2['proz']-$avg);
				}
			}
			$data['groups_results'][$key['id']]['otkl']=round(sqrt($disp/$i),1);
			$data['groups_results'][$key['id']]['avg']=$avg;
			$data['groups_results'][$key['id']]['count']=$i;
		}
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(3));
		$data['disc_id']=$this->uri->segment(3);
		$data['error']="";
		$this->load->view('stat/stat_disc_groups_view',$data);
	}

	function view_test_groups()
	{
		//Получение списка пользователей, которые учавствовали в тесте
		$users=$this->stat_model->getUsersTest($this->uri->segment(3));
		$str="(";
		$user_results=array();	
		foreach ($users as $key) 
		{
			$str=$str.$key['user'].",";
			$user_results[$key['user']]['proz']=$key['proz_corr'];
			//Получение id группы пользователя
			$group_id=$this->stat_model->getGroupId($key['user']);
			$user_results[$key['user']]['group']=$group_id[0]['numbgr'];
		}
		$str=substr($str, 0, -1);
		$str=$str.")";
		//Получение списка групп, которые учавствовали в тестировании по дисциплине
		$groups=$this->stat_model->getGroups($str);
		$data['groups_results']=array();
		//Массив с результатами по преподавателям
		$data['prepods_results']=array();
		if (count($groups)>0)
		{
			$str="(";
			foreach ($groups as $key) 
			{
				$str=$str.$key['id'].",";
				$data['groups_results'][$key['id']]['name']=$key['name_numb'];
				//Сумма баллов
				$s=0;
				//Счётчик студентов
				$i=0;
				$data['groups_results'][$key['id']]['min']=1000;
				$data['groups_results'][$key['id']]['max']=0;
				foreach ($user_results as $key2)
				{
					if ($key2['group']==$key['id'])
					{
						if ($key2['proz']>$data['groups_results'][$key['id']]['max'])
						{
							$data['groups_results'][$key['id']]['max']=$key2['proz'];	
						}
						if ($key2['proz']<$data['groups_results'][$key['id']]['min'])
						{
							$data['groups_results'][$key['id']]['min']=$key2['proz'];	
						}
						$s+=$key2['proz'];
						$i++;
					}
				}
				//Средний результат
				$avg=round($s/$i,2);
				$disp=0;
				foreach ($user_results as $key2)
				{
					if ($key2['group']==$key['id'])
					{
						$disp+=($key2['proz']-$avg)*($key2['proz']-$avg);
					}
				}
				$data['groups_results'][$key['id']]['otkl']=round(sqrt($disp/$i),1);
				$data['groups_results'][$key['id']]['avg']=$avg;
				$data['groups_results'][$key['id']]['prepod_id']=$key['prepod_id'];
				$data['groups_results'][$key['id']]['count']=$i;
			}
			$str=substr($str, 0, -1);
			$str=$str.")";
			//Статистика по преподавателям
			$prepods=$this->stat_model->getPrepods($str);
			foreach ($prepods as $key)
			{
				$data['prepods_results'][$key['id']]['summ']=0;
				$data['prepods_results'][$key['id']]['count']=0;
				$data['prepods_results'][$key['id']]['name']=$key['name'];
				foreach ($data['groups_results'] as $key2=>$value) 
				{
					if ($key['id']==$value['prepod_id'])
					{
						$data['prepods_results'][$key['id']]['count']++;
						$data['prepods_results'][$key['id']]['summ']=$data['prepods_results'][$key['id']]['summ']+$value['avg'];
					}
				}
			}
			//Пересчёт среднего значения
			foreach ($data['prepods_results'] as $key => $value) 
			{
				$data['prepods_results'][$key]['avg']=round($value['summ']/$value['count'],2);
			}
		}
		$data['test_name']=$this->input->post('test_name');
		$data['disc_id']=$this->uri->segment(4);
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(4));
		$data['test_id']=$this->uri->segment(3);
		$data['error']="";
		$this->load->view('stat/stat_tests_groups_view',$data);	
	}

	function view_theme_results()
	{
		$data['results']=$this->stat_model->getThemes($this->uri->segment(3));
		$data['tests_results']=array();
		foreach ($data['results'] as $key) 
		{
			$results=$this->stat_model->getThemeResults($key['id_theme']);
			$summ=0;
			foreach ($results as $key2)
			{
				if ($key2['true']=='1')
				{
					$summ++;
				}
			}
			$data['tests_results'][$key['id_theme']]['count']=count($results);
			$abs=round(($summ/count($results))*100,2);
			$data['tests_results'][$key['id_theme']]['abs']=$abs;
		}
		$data['test_name']=$this->input->post('test_name');
		$data['disc_id'] = $this->uri->segment(4);
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(4));
		$data['test_id']=$this->uri->segment(3);
		$data['error']="";
		$this->load->view('stat/stat_tests_themes_view',$data);
	}

	function view_test_stat()
	{
		//ID вопросов теста
		//Информация о заданиях (x1,x2...xN)
		$quests=array();
		$quests=$this->stat_model->getQuestsTest($this->uri->segment(3));
		$data['quests']=$quests;
		//Получение информации о студентах, сдавших тест (y1, y2... yM)
		$students=array();
		$students=$this->stat_model->getAnswersInfo($this->uri->segment(3));
		//Количество заданий по уровням сложности
		$summ_diff = array();
		for ($i=0; $i<4; $i++)
		{
			$summ_diff[$i] = 0;	
		}
		if (count($students)>4)
		{
			$answers=array();
			$answers_id=array();
			//Матрица ответов
			$data['matrix']=array();
			//Массив суммарных баллов и индивидуальных баллов испытуемых
			$summ=array();
			//m - количество заданий
			$m=count($quests);
			//n - количество студентов
			$n=count($students);
			//Определение трети студентов
			$tret_1=ceil($n/3);
			//Определение последней трети студентов
			$tret_3=ceil(($n*2)/3);
			$kol=1;
			//Массив для хранения распределения результатов
			$raspr=array();
			for ($i=0;$i<20;$i++)
			{
				$raspr[$i] = 0;
			}
			//Массив для хранения статуса о изменение корректности вопроса
			$status=array();
			for ($i=0;$i<10;$i++)
			{
				$raspr[$i]=0;
			}
			//Массив баллов по заданиям
			$zadanie=array();
			foreach ($quests as $key)
			{
				$zadanie[$key['id']]['summ']=0;
				//Сумма первых двух третей ответов
				$zadanie[$key['id']]['tret_1']=0;
				//Сумма первых последней трети ответов
				$zadanie[$key['id']]['tret_3']=0;
			}
			foreach ($students as $key)
			{
				$answers=$this->stat_model->getQuestInfo($key['id']);
				$summ[$key['id']]['summ']=0;
				foreach ($quests as $key2)
				{
					foreach ($answers as $key3)
					{
						$answers_id[$key3['quest_id']]=$key3['true'];
					}
					if (isset($answers_id[$key2['id']]))
					{
						if ($answers_id[$key2['id']]>0.5)
						{
							$matrix[$key['id']][$key2['id']]=1;
						}
						else
						{
							$matrix[$key['id']][$key2['id']]=0;	
						}
						}
					else
					{
						$matrix[$key['id']][$key2['id']]=0;	
					}
					$zadanie[$key2['id']]['summ']=$zadanie[$key2['id']]['summ']+$matrix[$key['id']][$key2['id']];
					$summ[$key['id']]['summ']=$summ[$key['id']]['summ']+$matrix[$key['id']][$key2['id']];
					if ($kol<$tret_1+1)
					{
						$zadanie[$key2['id']]['tret_1']=$zadanie[$key2['id']]['tret_1']+$matrix[$key['id']][$key2['id']];
					}
					if ($kol>$tret_3)
					{
						$zadanie[$key2['id']]['tret_3']=$zadanie[$key2['id']]['tret_3']+$matrix[$key['id']][$key2['id']];	
					}
				}
				$kol++;
			}
			//avg_y - средний результат суммарных баллов
			$avg_y=0;
			foreach ($students as $key) 
			{
				//Относительный результат каждого
				$summ[$key['id']]['balls']=round($summ[$key['id']]['summ']/$m,2);
				//Заполнение распределения
				$temp=$summ[$key['id']]['balls']*100;
				//Формирование данных длая графика распределения
				
				for ($i=0;$i<10;$i++)
				{
					if ($temp>$i*10 && $temp <= ($i+1)*10)
					{
						$raspr[$i]++;
					}
				}
				//Средний результат суммарных баллов
				$avg_y=$avg_y+$summ[$key['id']]['summ'];
			}
			$avg_y=round($avg_y/$n,4);
			//Дисперсия суммарных баллов испытуемых
			$disp_stud=0;
			foreach ($summ as $key) 
			{
				$disp_stud=$disp_stud+(($key['summ']-$avg_y)*($key['summ']-$avg_y));
			}
			$disp_stud=$disp_stud/($n-1);
			//стандартное отклонение суммарных баллов
			$std_otkl_stud=sqrt($disp_stud);
			//Количество плохих заданий
			$bad_quests['discr']=0;
			$bad_quests['korel']=0;
			//Количество забракованных ответов
			$bad_quests['edit']=0;
			foreach ($quests as $key)
			{
				$status[$key['id']]=0;
				//Нахождение количества студентов, которые указали, что вопрос некорректен
				$zadanie[$key['id']]['incorr_stud']=$this->stat_model->getQuestIncorrStud($key['id']);
				//Нахождение среднего значения времени на вопрос
				$zadanie[$key['id']]['avg_time']=round($this->stat_model->getAvgTime($key['id']),2);
				//Обновить среднее время вопроса
				if ($zadanie[$key['id']]['avg_time'] > 0)
				{
					$this->stat_model->editQuestTimeStatus($key['id'],$zadanie[$key['id']]['avg_time']);
				}
				//Нахождение среднего результата испытуемых по каждому заданию
				$zadanie[$key['id']]['balls']=$zadanie[$key['id']]['summ']/$n;
				//Редактирование статуса вопроса в БД
				if (($zadanie[$key['id']]['balls']>0.9) || ($zadanie[$key['id']]['balls']<0.1))
				{
					//Изменение статуса корректности вопроса
					$statusEdit=$this->stat_model->editQuestStatus($key['id'],1);
					//Если изеняется корректность, то изменить статус, иначе вопрос снова будет считаться корректным
					$status[$key['id']]=1;
					$zadanie[$key['id']]['diff']=0;
					$diff=0;
					$bad_quests['edit']++;
				}
				else
				{
					//Возвращение статуса корректности вопроса
					$statusEdit=$this->stat_model->editQuestStatus($key['id'],0);
					//Определение веса
					if ($zadanie[$key['id']]['balls']<=0.9) {$diff=1;$summ_diff[0]++;}
					if ($zadanie[$key['id']]['balls']<=0.7) {$diff=2;$summ_diff[1]++;}
					if ($zadanie[$key['id']]['balls']<=0.5) {$diff=3;$summ_diff[2]++;}
					if ($zadanie[$key['id']]['balls']<=0.3) {$diff=4;$summ_diff[3]++;}
					$zadanie[$key['id']]['diff'] = $diff;
				}
				//Изменяем сложность в БД
				$statusEdit=$this->stat_model->editQuestDiff($key['id'],$diff);
				//Вычисление индекса дискриминативности
				$zadanie[$key['id']]['discr']=($zadanie[$key['id']]['tret_1']-$zadanie[$key['id']]['tret_3'])/$tret_1;
				if ($zadanie[$key['id']]['discr']<0.3)
				{
					$bad_quests['discr']++;
				}
			}
			//Дисперсия результатов по каждому заданию
			foreach ($students as $key)
			{
				foreach ($quests as $key2)
				{
					$zadanie[$key2['id']]['disp']=$zadanie[$key2['id']]['balls']*(1-$zadanie[$key2['id']]['balls']);
					//Стандартное отклонение по заданиям
						$zadanie[$key2['id']]['otkl']=sqrt($zadanie[$key2['id']]['disp']);
				}
			}
			//Корелляционная связь задания с суммой баллов за весь тест (по Пирсону)
			foreach ($quests as $key) 
			{
				$zadanie[$key['id']]['korel']=0;
				foreach ($students as $key2)
				{
					$zadanie[$key['id']]['korel']=$zadanie[$key['id']]['korel']+$matrix[$key2['id']][$key['id']]*$summ[$key2['id']]['summ'];
				}
				if ($zadanie[$key['id']]['otkl']*$std_otkl_stud!=0)
				{
					$zadanie[$key['id']]['korel']=((($zadanie[$key['id']]['korel']/$n)-$zadanie[$key['id']]['balls']*$avg_y)/($zadanie[$key['id']]['otkl']*$std_otkl_stud))*($n/($n-1));
				}
				else
				{
					$zadanie[$key['id']]['korel']=1;	
				}
				$this->stat_model->editQuestSuccess($key['id'],$zadanie[$key['id']]['balls']);
				if ($zadanie[$key['id']]['korel']<0.15)
				{
					$statusEdit=$this->stat_model->editQuestStatus($key['id'],1);
					$zadanie[$key['id']]['diff']=0;
					//Обнулить сложность
					$statusEdit=$this->stat_model->editQuestDiff($key['id'],0);
					if ($status[$key['id']]!=1)
					{	
						$bad_quests['edit']++;
					}
					$status[$key['id']]=1;
					$bad_quests['korel']++;
				}
				else
				{
					if ($status[$key['id']]!=1)
					{
						$statusEdit=$this->stat_model->editQuestStatus($key['id'],0);
					}
				}
				$text=$this->stat_model->getQuestText($key['id']);
				$zadanie[$key['id']]['text']=$text[0]['text'];
				$zadanie[$key['id']]['id']=$key['id'];
			}
			//Корреляционная связь заданий между собой
			$korel=array();
			foreach ($quests as $key) 
			{
				foreach ($quests as $key2) 
				{
					$temp=0;
					foreach ($students as $key3)
					{
						$temp=$temp+$matrix[$key3['id']][$key['id']]*$matrix[$key3['id']][$key2['id']];
					}
					if (($zadanie[$key['id']]['otkl']*$zadanie[$key2['id']]['otkl'])!=0)
					{
						$korel[$key['id']][$key2['id']]=((($temp/$n)-($zadanie[$key['id']]['balls']*$zadanie[$key2['id']]['balls']))/($zadanie[$key['id']]['otkl']*$zadanie[$key2['id']]['otkl']))*($n/($n-1));
					}
					else
					{
						$korel[$key['id']][$key2['id']]=0;	
					}
				}
			}
			/*------Вычисление коэффициента качества теста */
			//Отношение забракованных ко всем заданиям (с округлением до 2 знаков после запятой)
			$valid_coeff = round(($bad_quests['edit']/count($zadanie))*100,2);
			//коэффициент равномерности распределения заданий по уровню сложности
			//или, иначе, коэффициент вариаций по уровню сложности
			//1. Вычислить среднее количество заданий в каждом уровне
			$diff_avg = 0;
			for ($i = 0; $i < 4; $i++)
			{
				$diff_avg += $summ_diff[$i];
			}
			$diff_avg = round($diff_avg/4,2);
			//2. Вычислить дисперсию
			$diff_disp = 0;
			for ($i = 0; $i < 4; $i++)
			{
				$diff_disp += ($summ_diff[$i] - $diff_avg)*($summ_diff[$i] - $diff_avg);
			}
			$diff_disp = round($diff_disp/4,2);
			//3. Стандартное отклонение - корень из дисперсии
			$diff_otkl = round(sqrt($diff_disp),2);
			//4. Коэффициент вариации
			$diff_var = round(($diff_otkl/$diff_avg)*100,2);
			//Коэффициент качества теста
			$data['valid_coeff'] = $diff_var + $valid_coeff;

			/*------Конец вычисления коэффициента валидности */
			$this->stat_model->editStatDate($this->uri->segment(3));
			$data['raspr'] = $raspr;
			$data['bad_quests'] = $bad_quests;
			$data['korel'] = $korel;
			$data['quests'] = $quests;
			$data['zadanie'] = $zadanie;
			$data['test_name']=$this->input->post('test_name');
			$data['disc_id']=$this->uri->segment(4);
			$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(4));
			$data['test_id']=$this->uri->segment(3);
			$data['error']="";
			$this->load->view('stat/stat_tests_quests_view',$data);	
		}
		else
		{
			$this->view_tests("В тесте приняло участие менее 5 студентов. Статистика не может быть составлена");
		}
	}

	function view_groups($error = "")
	{
		$data['last_result']=array();
		$data['fspo']=$this->results_model->getGroups(1);
		foreach ($data['fspo'] as $key) 
		{
			//Вычисление последнего теста в группе
			$last=$this->results_model->getLastTestGroup($key['id'],$key['type_r']);
			$data['last_result'][$key['id']]=$last['max(data)'];
		}
		$data['segrys']=$this->results_model->getGroups(2);
		$data['prepods']=array();
		foreach ($data['segrys'] as $key) 
		{
			//Вычисление последнего теста в группе
			$last=$this->results_model->getLastTestGroup($key['id'],$key['type_r']);
			$data['last_result'][$key['id']]=$last['max(data)'];
			$data['prepods'][$key['id']]=$this->results_model->getPrepod($key['id']);
		}
		//Вычисление последнего теста гостей
		$last=$this->results_model->getLastTestGroup(78);
		$data['last_result'][78]=$last['max(data)'];
		$data['error'] = $error;
		$this->load->view('stat/stat_groups_view',$data);
	}

	function view_one_group()
	{
		//Получить список дисциплин, которые были сданы группой
		$data['type_r']=$this->input->post('type_r');
		$data['gr_name']=$this->input->post('gr_name');
		$data['tests_results']=array();
		//Получение всех студентов в группе
		$data['students']=$this->results_model->getGroupStudents($this->uri->segment(3));
		//Получение всех тестов, в которых учавствовали участники группы
		$data['tests']=$this->results_model->getGroupTests($this->uri->segment(3),$data['type_r']);
		foreach ($data['tests'] as $key)
		{
			$min=100;
			$max=0;
			$data['tests_results'][$key['id']]['name']=$key['name_test'].". ".$key['name_razd'];
			$data['tests_results'][$key['id']]['max']=0;
			$data['tests_results'][$key['id']]['min']=0;
			$data['tests_results'][$key['id']]['avg']=0;
			$data['tests_results'][$key['id']]['disp'] = 0;
			$data['tests_results'][$key['id']]['count']=0;
			foreach ($data['students'] as $key2) 
			{
				//getOneStudResults(ID студента,ID теста);
				$temp=$this->results_model->getOneStudResults($key2['id'],$key['id']);
				if (isset($temp['proz_corr']))
				{
					$proz_corr=$temp['proz_corr'];
					if ($proz_corr>0)
					{
						$data['tests_results'][$key['id']]['count']++;
						$data['tests_results'][$key['id']]['avg']+=$proz_corr;
						$data['tests_results'][$key['id']]['students'][$key2['id']]=$proz_corr;
						if ($proz_corr>$max)
						{
							$data['tests_results'][$key['id']]['max']=$proz_corr;
							$max=$proz_corr;
						}
						if ($proz_corr<$min)
						{
							$data['tests_results'][$key['id']]['min']=$proz_corr;
							$min=$proz_corr;
						}
					}
				}
			}
			if ($data['tests_results'][$key['id']]['count'] > 0)
			{
				$data['tests_results'][$key['id']]['avg']=round($data['tests_results'][$key['id']]['avg']/$data['tests_results'][$key['id']]['count'],2);
				foreach ($data['students'] as $key2) 
				{
					if (isset($data['tests_results'][$key['id']]['students'][$key2['id']]))
					{
						$data['tests_results'][$key['id']]['disp']+=pow($data['tests_results'][$key['id']]['students'][$key2['id']]-$data['tests_results'][$key['id']]['avg'],2);
					}
				}
				$data['tests_results'][$key['id']]['disp']=$data['tests_results'][$key['id']]['disp']/$data['tests_results'][$key['id']]['count'];	
				$data['tests_results'][$key['id']]['otkl']=sqrt($data['tests_results'][$key['id']]['disp']);
				//Коэффициент вариации
				if ($data['tests_results'][$key['id']]['avg']>0)
				{
					$data['tests_results'][$key['id']]['var']=round(($data['tests_results'][$key['id']]['otkl']/$data['tests_results'][$key['id']]['avg'])*100,2);	
				}
				else
				{
					$data['tests_results'][$key['id']]['var']=0;	
				}
			}
			else
			{
				$this->view_groups("Статистика не может быть получена");
			}
		}
		//Получение ID дисцпиплины
		$data['disc_id']=$this->uri->segment(3);
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(3));
		//Сообщение об ошибке
		$data['error'] = "";
		//Запуск вьювера
		$this->load->view('stat/stat_groups_one_view',$data);
	}

	function view_test_report()
	{
		$data['quests']=array();
		$data['quests']=$this->stat_model->getQuestsTestReport($this->uri->segment(3));
		if (count($data['quests'])>0)
		{
			foreach($data['quests'] as $key)
			{
				$data['answers'][$key['id']]['info']=$this->stat_model->getQuestsAnswers($key['id']);
			}
			$data['test_name']=$this->input->post('test_name');
			$data['disc_id']=$this->uri->segment(4);
			$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(4));
			$data['test_id']=$this->uri->segment(3);
			$data['error']="";
			$this->load->view('stat/stat_tests_report_view',$data);	
		}
		else
		{
			$this->view_tests("В тесте приняло участие менее 1 студента. Отчёт не может быть составлен");
		}
	}

}

?>