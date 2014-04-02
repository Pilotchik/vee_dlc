<?php

class Results extends CI_Controller {

	function Results()
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
				$this->load->model('private_model');
				$this->$method();
			}
		}
	}


	//Функция отображения страницы результатов
	function index($error = "")
	{
		$data['fspo']=$this->results_model->getDisciplines('1');
		$data['last_result']=array();
		foreach ($data['fspo'] as $key) 
		{
			$last=$this->results_model->getLastTest($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['segrys']=$this->results_model->getDisciplines('2');
		foreach ($data['segrys'] as $key) 
		{
			$last=$this->results_model->getLastTest($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['univers']=$this->results_model->getDisciplines('3');
		foreach ($data['univers'] as $key) 
		{
			$last=$this->results_model->getLastTest($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['error'] = $error;
		$this->load->view('results/results_disc_view',$data);
	}

	function view_tests()
	{
		$data['tests'] = $this->results_model->getDisciplin($this->uri->segment(3));
		$data['last_result']=array();
		$data['corr_info']=array();
		foreach ($data['tests'] as $key) 
		{
			//Вычисление последнего теста
			$last=$this->results_model->getLastResult($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(3));

		$data['disc_id']=$this->uri->segment(3);
		$data['error']="";
		$this->load->view('results/results_tests_view',$data);
	}

	function view_test_results()
	{
		$range=$this->input->post('range');
		if ($range!='')
		{
			$time1=substr($range,0,10);
			$time2=substr($range,13,23);
			$time1=strtotime($time1);
			$time2=strtotime($time2);
		}
		else
		{
			$time1=strtotime("-7 day");
			$time2=time();
		}
		$group_id=$this->input->post('group_id');
		//Все группы
		$data['filter_group']=$this->results_model->getGroupWithResults($this->uri->segment(3));
		//Выборка результатов по времени и группе
		$data['results']=$this->results_model->getResults($this->uri->segment(3),$time1,$time2,$group_id);
		//Получение шкалы
		$temp=$this->results_model->getSkala($this->uri->segment(3));
		$skala=$temp[0];
		//Получение корректного результата
		$res_correct=array();
		//Получение оценки
		$ozenka=array();
		$proz_corr_avg=0;
		$time_avg=0;
		//Формирование массива результатов
		foreach($data['results'] as $key)
		{
			if ($key['proz']<$skala['three'])
			{
				$ozenka[$key['id']]['norm']=2;	
			}
			else
			{
				if($key['proz']<$skala['four'])
				{
					$ozenka[$key['id']]['norm']=3;
				}
				else
				{
					if($key['proz']<$skala['five'])
					{
						$ozenka[$key['id']]['norm']=4;
					}	
					else
					{
						$ozenka[$key['id']]['norm']=5;
					}
				}
			}
			//Выборка из БД ответов на вопросы, которые не были убраны в процессе статистического анализа
			$corr_answers=$this->results_model->getCorrectResult($key['id']);
			$quest_str=$this->results_model->getTestScen($key['id']);
			//Результат студента
			$summ_corr=0;
			$summ_balls=0;
			$summ_balls_scen=0;
			//Если был сформирован сценарий (формируется с 15.03.2013), то смотреть некорректные по сценарию
			if (isset($quest_str))
			{
				$all_quest=$this->results_model->getAllInScen($quest_str);	
				foreach ($all_quest as $key2)
				{
					$summ_balls_scen+=$key2['level'];
				}
			}
			foreach ($corr_answers as $key2)
			{
				$summ_corr+=$key2['true']*$key2['level'];
				$summ_balls+=$key2['level'];
			}
			if (isset($quest_str))
			{
				$temp2=($summ_corr/$summ_balls_scen)*100;	
			}
			else
			{
				$temp2=($summ_corr/$summ_balls)*100;	
			}
			if ($temp2>100) {$temp2=100;}
			$res_correct[$key['id']]=round($temp2,3);
			$proz_corr_avg+=$res_correct[$key['id']];
			$time_avg+=$key['timeend']-$key['timebeg'];
			//Сохранение скорректированного результата в БД для рейтинга
			$this->results_model->updateCorrectProz($key['id'],$res_correct[$key['id']]);
			if ($res_correct[$key['id']]<$skala['three'])
			{
				$ozenka[$key['id']]['corr']=2;	
			}
			else
			{
				if($res_correct[$key['id']]<$skala['four'])
				{
					$ozenka[$key['id']]['corr']=3;
				}
				else
				{
					if($res_correct[$key['id']]<$skala['five'])
					{
						$ozenka[$key['id']]['corr']=4;
					}	
					else
					{
						$ozenka[$key['id']]['corr']=5;
					}
				}
			}
		}
		$reyt=array();
		foreach($data['results'] as $key)
		{
			$reyt[$key['id']]=$res_correct[$key['id']];
		}
		arsort($reyt);
		//Для шкалы определяем проценты
		$ects=count($data['results'])/100;
		$i=0;
		foreach($reyt as $key=>$value)
		{
			if ($i<=$ects*100)
			{
				$reyt[$key]="E";	
			}
			if ($i<=$ects*90)
			{
				$reyt[$key]="D";
			}
			if ($i<=$ects*65)
			{
				$reyt[$key]="C";
			}
			if ($i<=$ects*35)
			{
				$reyt[$key]="B";
			}
			if ($i<=$ects*10)
			{
				$reyt[$key]="A";
			}
			$i++;
		}
		$data['reyt']=$reyt;
		$data['skala']=$skala;
		$data['ozenka']=$ozenka;
		$data['res_correct']=$res_correct;
		$data['test_name'] = $this->results_model->getTestNameOverId($this->uri->segment(3));
		$data['disc_id']=$this->uri->segment(4);
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(4));
		$data['test_id']=$this->uri->segment(3);
		$data['error'] = "";
		$this->load->view('results/results_onetest_view',$data);
	}

	function downloadExcel()
	{
		$test_name = $this->results_model->getTestNameOverId($this->uri->segment(3));
		$disc_name = $this->de_model->getDiscNameOverID($this->uri->segment(4));
		@$results = $this->results_model->getResults($this->uri->segment(3));
		//Получение шкалы
		$temp=$this->results_model->getSkala($this->uri->segment(3));
		$skala=$temp[0];
		//Получение корректного результата
		$res_correct=array();
		//Получение оценки
		$ozenka=array();
		$proz_corr_avg=0;
		$time_avg=0;
		//Формирование массива результатов
		foreach($results as $key)
		{
			if ($key['proz']<$skala['three'])
			{
				$ozenka[$key['id']]['norm']=2;	
			}
			else
			{
				if($key['proz']<$skala['four'])
				{
					$ozenka[$key['id']]['norm']=3;
				}
				else
				{
					if($key['proz']<$skala['five'])
					{
						$ozenka[$key['id']]['norm']=4;
					}	
					else
					{
						$ozenka[$key['id']]['norm']=5;
					}
				}
			}
			//Выборка из БД ответов на вопросы, которые не были убраны в процессе статистического анализа
			$corr_answers=$this->results_model->getCorrectResult($key['id']);
			@$quest_str=$this->results_model->getTestScen($key['id']);
			//Результат студента
			$summ_corr=0;
			$summ_balls=0;
			$summ_balls_scen=0;
			//Если был сформирован сценарий (формируется с 15.03.2013), то смотреть некорректные по сценарию
			if (isset($quest_str))
			{
				$all_quest=$this->results_model->getAllInScen($quest_str);	
				foreach ($all_quest as $key2)
				{
					$summ_balls_scen+=$key2['level'];
				}
			}
			foreach ($corr_answers as $key2)
			{
				$summ_corr+=$key2['true']*$key2['level'];
				$summ_balls+=$key2['level'];
			}
			if (isset($quest_str))
			{
				$temp2=($summ_corr/$summ_balls_scen)*100;	
			}
			else
			{
				$temp2=($summ_corr/$summ_balls)*100;	
			}
			if ($temp2>100) {$temp2=100;}
			$res_correct[$key['id']]=round($temp2,3);
			$proz_corr_avg+=$res_correct[$key['id']];
			$time_avg+=$key['timeend']-$key['timebeg'];
			//Сохранение скорректированного результата в БД для рейтинга
			$this->results_model->updateCorrectProz($key['id'],$res_correct[$key['id']]);
			if ($res_correct[$key['id']]<$skala['three'])
			{
				$ozenka[$key['id']]['corr']=2;	
			}
			else
			{
				if($res_correct[$key['id']]<$skala['four'])
				{
					$ozenka[$key['id']]['corr']=3;
				}
				else
				{
					if($res_correct[$key['id']]<$skala['five'])
					{
						$ozenka[$key['id']]['corr']=4;
					}	
					else
					{
						$ozenka[$key['id']]['corr']=5;
					}
				}
			}
		}
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Результаты теста');
		$this->excel->getActiveSheet()->setCellValue('A1', "$disc_name. $test_name");
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:H1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue("A2", "Фамилия Имя");
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue("B2", "Группа");
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue("C2", "Дата");
		$this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue("D2", "Время");
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue("E2", "Результат");
		$this->excel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('E2:F2');
		$this->excel->getActiveSheet()->setCellValue("G2", "Результат скорректированный");
		$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('G2:H2');
		$i = 3;
		foreach ($results as $key)
		{
			$res_id=$key['id'];
			$this->excel->getActiveSheet()->setCellValue("A$i", $key['lastname']." ".$key['firstname']);
			if ($key['guest'] == '0')
			{
				$this->excel->getActiveSheet()->setCellValue("B$i", 'Гость');
			}
			else
			{
				$this->excel->getActiveSheet()->setCellValue("B$i", $key['name_numb']);
			}
			$this->excel->getActiveSheet()->setCellValue("C$i", $key['data']);
			$time=ceil(($key['timeend']-$key['timebeg'])/60);
			$this->excel->getActiveSheet()->setCellValue("D$i", "$time");
			$this->excel->getActiveSheet()->setCellValue("E$i", $key['proz']);
			$this->excel->getActiveSheet()->setCellValue("F$i", $ozenka[$key['id']]['norm']);
			$this->excel->getActiveSheet()->setCellValue("G$i", $res_correct[$key['id']]);
			$this->excel->getActiveSheet()->setCellValue("H$i", $ozenka[$key['id']]['corr']);
			$i++;
		}
		
		$filename = $disc_name." ".$test_name.".xls"; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	function view_stud_result()
	{
		$data['results']=$this->results_model->getStudResult($this->uri->segment(3));
		for ($i = 0; $i <=4; $i++)
		{
			$data['raspr']['sdano'][$i] = 0;
			$data['raspr']['vsego'][$i] = 0;
		}
		foreach ($data['results'] as $key)
		{
			$data['raspr']['sdano'][$key['level']] += $key['true'];
			$data['raspr']['vsego'][$key['level']]++;
		}
		$data['test_name'] = $this->results_model->getTestNameOverId($this->uri->segment(4));
		$data['stud_name'] = $this->results_model->getStudNameOverRes($this->uri->segment(3));
		$data['disc_id']=$this->uri->segment(5);
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(4));
		$data['test_id'] = $this->uri->segment(4);
		$data['res_id']=$this->uri->segment(3);
		$data['error']="";
		$this->load->view('results/results_stud_view',$data);
	}

	function annul_test_result()
	{
		$result=$this->results_model->getStudResult($this->uri->segment(3));
		$proz_array=$this->results_model->getProzResult($this->uri->segment(3));
		if (!isset($proz_array[0]['proz']))
		{
			$proz_array[0]['proz']=0;
		}
		@$this->results_model->delResult($this->uri->segment(3),$result[0]['user'],$proz_array[0]['proz'],$this->uri->segment(4));
		$error = "Результат аннулирован";
		$this->index($error);
	}

	function view_last()
	{
		$count=$this->input->get('count');
		if (($count=='')|| ($count>60))
		{
			$count=15;
		}
		$data['results']=$this->results_model->getLast($count);
		//Оценка
		$ozenka=array();
		//Оценка скорректированная
		$ozenka_corr=array();
		//Название теста
		$test_name=array();
		//Название дисциплины
		$disc_name=array();
		//хранение скорректированного результата
		$res_correct=array();
		//Пользователь
		$pers_info=array();
		//Формирование массива результатов
		foreach($data['results'] as $key)
		{
			//Если идёт тестирование (timeend=0), то узнать сколько уже сделано и сколько правильно
			if ($key['timeend'] == 0)
			{
				$data['endless_res'][$key['id']]['cmpl'] = $this->results_model->getCmplQuest($key['id']);
				$data['endless_res'][$key['id']]['summ'] = $this->results_model->getNowTrue($key['id']);
				$data['endless_res'][$key['id']]['all'] = $key['true_all'];
			}
			//Расчёт скорректированного результата
			//Выборка из БД ответов на вопросы, которые не были убраны в процессе статистического анализа
			$corr_answers=$this->results_model->getCorrectResult($key['id']);
			$quest_str=$this->results_model->getTestScen($key['id']);
			//Результат студента
			$summ_corr=0;
			$summ_balls=0;
			$summ_balls_scen=0;
			//Если был сформирован сценарий (формируется с 18.03.2013), то смотреть некорректные по сценарию
			if (isset($quest_str))
			{
				$all_quest=$this->results_model->getAllInScen($quest_str);	
				foreach ($all_quest as $key2)
				{
					$summ_balls_scen+=$key2['level'];
				}
			}
			foreach ($corr_answers as $key2)
			{
				$summ_corr+=$key2['true']*$key2['level'];
				$summ_balls+=$key2['level'];
			}
			if (isset($quest_str))
			{
				$temp2=($summ_corr/$summ_balls_scen)*100;
			}
			else
			{
				$temp2=($summ_corr/$summ_balls)*100;	
			}
			if ($temp2>100) {$temp2=100;}
			$res_correct[$key['id']]=round($temp2,3);
			//Сохранение скорректированного результата в БД для рейтинга
			$this->results_model->updateCorrectProz($key['id'],$res_correct[$key['id']]);
			//Конец расчёта скорректированного результата

			//Получение информации о конкретном тесте
			$test_info=$this->results_model->getTestInfo($key['razd_id']);
			$test_name[$key['id']]=$test_info['name_razd'];
			//Дата проведения статистического анализа
			$test_corr[$key['id']]=$test_info['stat_date'];
			$disc_name[$key['id']]['name']=$this->results_model->getDiscInfo($test_info['test_id']);
			//getPersInfo возвращает new_persons.id,new_persons.lastname,new_persons.firstname,new_numbers.name_numb
			$temp=$this->results_model->getPersInfo($key['user']);
			$pers_info[$key['id']]['user_id']=$temp['id'];
			$pers_info[$key['id']]['name']=$temp['lastname']." ".$temp['firstname'];
			$pers_info[$key['id']]['group']=$temp['name_numb'];
			if ($key['proz']<$test_info['three'])
			{
				$ozenka[$key['id']]=2;	
			}
			else
			{
				if($key['proz']<$test_info['four'])
				{
					$ozenka[$key['id']]=3;
				}
				else
				{
					if($key['proz']<$test_info['five'])
					{
						$ozenka[$key['id']]=4;
					}	
					else
					{
						$ozenka[$key['id']]=5;
					}
				}
			}
			if ($res_correct[$key['id']]<$test_info['three'])
			{
				$ozenka_corr[$key['id']]=2;	
			}
			else
			{
				if($res_correct[$key['id']]<$test_info['four'])
				{
					$ozenka_corr[$key['id']]=3;
				}
				else
				{
					if($res_correct[$key['id']]<$test_info['five'])
					{
						$ozenka_corr[$key['id']]=4;
					}	
					else
					{
						$ozenka_corr[$key['id']]=5;
					}
				}
			}
		}
		$data['test_name']=$test_name;
		$data['res_correct']=$res_correct;
		$data['test_corr']=$test_corr;
		$data['pers_info']=$pers_info;
		$data['disc_name']=$disc_name;
		$data['ozenka']=$ozenka;
		$data['ozenka_corr']=$ozenka_corr;
		$data['error']="";
		$this->load->view('results/results_last_view',$data);
	}

	function view_groups($error = "")
	{
		//Массив с указанием последнего результата в группе
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
		$this->load->view('results/results_groups_view',$data);
	}

	function view_one_group()
	{
		//ID группы
		$data['group_id'] = $this->uri->segment(3);
		//Образовательное учреждение (тип регистрации): 0 - гость, 1 - ФСПО, 2 - Сегрис
		$data['type_r'] = $this->results_model->getGroupTypeROverId($data['group_id']);
		$data['gr_name'] = $this->results_model->getGroupNameOverId($data['group_id']);
		$data['stud_results']=array();
		//Получение всех студентов в группе
		$data['students']=$this->results_model->getGroupStudents($this->uri->segment(3));
		//Получение всех тестов, в которых учавствовали участники группы
		$data['tests']=$this->results_model->getGroupTests($this->uri->segment(3),$data['type_r']);
		foreach ($data['students'] as $key) 
		{
			$data['stud_results'][$key['id']]['avg']=0;
			$data['stud_results'][$key['id']]['count']=0;
			//Получение данных о для каждого студента по тем тестам, в которых учавствовал хоть кто-нибудь из группы
			foreach ($data['tests'] as $key2)
			{
				$temp=$this->results_model->getOneStudResults($key['id'],$key2['id']);
				if (isset($temp['proz_corr']))
				{
					$proz_corr=$temp['proz_corr'];
					$proz=$temp['proz'];
					//type 1, если строится по скорректированному результату,2 - если без коррекции
					$type=1;
					if (($proz_corr==0 && $proz>0) || ($proz_corr==$proz))
					{
						$proz_corr=$proz;
						$type=2;
					}
					if ($proz_corr>0)
					{
						$data['stud_results'][$key['id']]['tests'][$key2['id']]['value']=round($proz_corr,2);
						$data['stud_results'][$key['id']]['tests'][$key2['id']]['type']=$type;
						$data['stud_results'][$key['id']]['count']++;
						$data['stud_results'][$key['id']]['avg']+=$proz_corr;
					}
					else
					{
						$data['stud_results'][$key['id']]['tests'][$key2['id']]['value']="";
						$data['stud_results'][$key['id']]['tests'][$key2['id']]['type']=$type;
					}
				}
				else
				{
					$data['stud_results'][$key['id']]['tests'][$key2['id']]['value']="";
					$data['stud_results'][$key['id']]['tests'][$key2['id']]['type']=0;
				}
			}
			if ($data['stud_results'][$key['id']]['count']>0)
			{
				$data['stud_results'][$key['id']]['avg']=round($data['stud_results'][$key['id']]['avg']/$data['stud_results'][$key['id']]['count'],2);
			}
			else
			{
				$data['stud_results'][$key['id']]['avg']=0;	
			}
		}
		$data['error'] = "";
		$this->load->view('results/results_groups_onegroup_view',$data);
	}

	function view_one_stud()
	{
		$data['stud_id'] = $this->uri->segment(3);
		//ID группы
		$data['group_id'] = $this->results_model->getGroupIDOverUserID($data['stud_id']);
		$data['gr_name'] = $this->results_model->getGroupNameOverId($data['group_id']);
		$data['stud_name'] = $this->results_model->getUserNameOverUserID($data['stud_id']);
		
		$data['results']=$this->results_model->getAllStudTests($this->uri->segment(3));
		//Оценка
		$ozenka=array();
		//Название теста
		$test_name=array();
		//Название дисциплины
		$disc_name=array();
		//Пользователь
		$pers_info=array();
		//Формирование массива результатов
		foreach($data['results'] as $key)
		{
			//Получение информации о конкретном тесте
			$test_info=$this->results_model->getTestInfo($key['razd_id']);
			$test_name[$key['id']]['name']=$test_info['name_razd'];
			$test_name[$key['id']]['id']=$key['razd_id'];
			$disc_name[$key['id']]['name']=$this->results_model->getDiscInfo($test_info['test_id']);
			$disc_name[$key['id']]['id']=$test_info['test_id'];
			if ($key['proz']<$test_info['three'])
			{
				$ozenka[$key['id']]=2;	
			}
			else
			{
				if($key['proz']<$test_info['four'])
				{
					$ozenka[$key['id']]=3;
				}
				else
				{
					if($key['proz']<$test_info['five'])
					{
						$ozenka[$key['id']]=4;
					}	
					else
					{
						$ozenka[$key['id']]=5;
					}
				}
			}
		}
		$data['test_name'] = $test_name;
		$data['disc_name'] = $disc_name;
		$data['ozenka'] = $ozenka;
		$data['error'] = "";
		$this->load->view('results/results_groups_onestud_view',$data);		
	}

	function view_stud_group_result()
	{
		$data['stud_id']=$this->input->post('stud_id');
		$data['type_r']=$this->input->post('type_r');
		$data['test_id']=$this->input->post('test_id');
		$data['disc_id']=$this->input->post('disc_id');
		$data['group_id']=$this->input->post('group_id');
		$data['gr_name'] = $this->results_model->getGroupNameOverId($data['group_id']);
		$data['results'] = $this->results_model->getStudResult($this->uri->segment(3));
		$data['test_name']=$this->input->post('test_name');
		$data['stud_name'] = $this->results_model->getUserNameOverUserID($data['stud_id']);
		$data['res_id'] = $this->uri->segment(3);
		$data['error'] = "";
		$this->load->view('results/results_groups_onestud_onetest_view',$data);	
	}

	function annul_group_test_result()
	{
		$result=$this->results_model->getStudResult($this->uri->segment(3));
		$proz_array=$this->results_model->getProzResult($this->uri->segment(3));
		if (!isset($proz_array[0]['proz']))
		{
			$proz_array[0]['proz']=0;
		}
		@$this->results_model->delResult($this->uri->segment(3),$result[0]['user'],$proz_array[0]['proz'],$this->uri->segment(4));
		$this->view_groups("Результат аннулирован");
	}

	function view_popup_stud()
	{
		$user_id=$this->input->post('user_id');
		//Получение информации о студенте
		//`id`,`numbgr`,`reyt_type`,`reyting`,`type_r`,имя, фамилия, фото
		$user_info=$this->private_model->getStudReyt($user_id);
		//Вычисление общего количества студентов, учавствующих в рейтинге
		$all_users=$this->private_model->getAllReyt($user_info['type_r']);
		//Результаты студента
		$results=$this->private_model->getStudResults($user_id);
		if (strlen($user_info['photo'])>5)
		{
			echo "<table class=\"sortable\" border=\"1\" id=\"groups\" width=\"100%\">
				<tr>
					<td align=center width=10%><img src=\"".$user_info['photo']."\"></td>
					<td align=center><h3>".$user_info['lastname']."<br />".$user_info['firstname']."</h3></td>
				</tr>
			</table><br />";	
		}
		else
		{
			echo "<h3>".$user_info['lastname']." ".$user_info['firstname']."</h3>";	
		}
		if($user_info['reyt_type']>0)
		{
			print '<p>Студент занимает '.$user_info['reyt_type'].' место из '.$all_users.'.</p>';
		}
		echo "<table class=\"sortable\" border=\"1\" id=\"groups\" width=\"100%\">
				<tr>
					<td align=\"center\"><b>Дисциплина</b></td>
					<td align=\"center\"><b>Тест</b></td>
					<td align=\"center\"><b>Дата</b></td>
					<td align=\"center\"><b>Результат</b></td>
					<td align=\"center\"><b>Оценка</b></td>
				</tr>";
		foreach ($results as $key)
		{
			echo "<tr>";
			echo "<td>".$key['name_test']."</td>";
			echo "<td>".$key['name_razd']."</td>";
			echo "<td>".$key['data']."</td>";
			echo "<td>".$key['proz_corr']."</td>";
			if ($key['proz_corr']<$key['three'])
			{
				$ozenka=2;	
			}
			else
			{
				if($key['proz_corr']<$key['four'])
				{
					$ozenka=3;
				}
				else
				{
					if($key['proz_corr']<$key['five'])
					{
						$ozenka=4;
					}	
					else
					{
						$ozenka=5;
					}
				}
			}
			echo "<td>".$ozenka."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	function view_quests()
	{
		$data['fspo']=$this->results_model->getDisciplines('1');
		$data['last_result']=array();
		foreach ($data['fspo'] as $key) 
		{
			$last=$this->results_model->getLastTest($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['segrys']=$this->results_model->getDisciplines('2');
		foreach ($data['segrys'] as $key) 
		{
			$last=$this->results_model->getLastTest($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['univers']=$this->results_model->getDisciplines('3');
		foreach ($data['univers'] as $key) 
		{
			$last=$this->results_model->getLastTest($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['error']="";
		$this->load->view('results/results_quests_disc_view',$data);
	}

	function view_quests_disc()
	{
		$data['tests'] = $this->results_model->getDisciplin($this->uri->segment(3));
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(3));
		$data['last_result']=array();
		$data['corr_info']=array();
		foreach ($data['tests'] as $key) 
		{
			//Вычисление последнего теста
			$last=$this->results_model->getLastResult($key['id']);
			$data['last_result'][$key['id']]=$last[0]['max(data)'];
		}
		$data['error']="";
		$this->load->view('results/results_quests_tests_view',$data);
	}

	function view_test_quests_results()
	{
		$data['results'] = $this->results_model->getResults($this->uri->segment(3));
		$data['quests'] = $this->results_model->getQuests($this->uri->segment(3));

		$data['test_name'] = $this->results_model->getTestNameOverId($this->uri->segment(3));
		$data['disc_id'] = $this->results_model->getDiscIDOverTestID($this->uri->segment(3));
		$data['disc_name'] = $this->de_model->getDiscNameOverID($data['disc_id']);

		$avg=array();
		foreach($data['quests'] as $key2)
		{
			//среднее значение
			$avg[$key2['id']]=0;
			//число ответов
			$cnt_a[$key2['id']]=0;
		}
		foreach ($data['results'] as $key)
		{
			foreach($data['quests'] as $key2)
			{
				$answers[$key['id']][$key2['id']]=$this->results_model->getQuestResult($key['id'],$key2['id']);
				if (is_numeric($answers[$key['id']][$key2['id']]) && ($key['timeend']!=0))
				{
					$avg[$key2['id']]+=$answers[$key['id']][$key2['id']];
				}
				$cnt_a[$key2['id']]++;
			}
		}
		foreach($data['quests'] as $key2)
		{
			if ($cnt_a[$key2['id']]>0)
			{
				$avg[$key2['id']]=round(($avg[$key2['id']]/$cnt_a[$key2['id']])*100,2);
			}
			else
			{
				$avg[$key2['id']]=0;	
			}
		}
		$data['answers'] = $answers;
		$data['quest_avg'] = $avg;
		$data['test_id'] = $this->uri->segment(3);
		$data['error'] = "";
		$this->load->view('results/results_quests_onetest_view',$data);
	}

	function autocheck()
	{
		$this->form_validation->set_rules('id_res', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('true_all', 'ID', 'trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE)
		{
			$res_id = $this->input->post('id_res');
			$true_all = $this->input->post('true_all');
			$cmpl = round(($this->results_model->getCmplQuest($res_id)/$true_all)*100,1);
			$summ = round(($this->results_model->getNowTrue($res_id)/$true_all)*100,1);
			$otn = round(($this->results_model->getNowTrue($res_id)/$this->results_model->getCmplQuest($res_id))*100,1);
			$razn = $cmpl - $summ;
			echo json_encode(array('answer'=>1,'summ'=>$summ,'cmpl'=>$cmpl,'razn'=>$razn,'otn'=>$otn));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

	function de()
	{
		$data['fspo'] = $this->de_model->getDisciplines('1');
		$data['segrys'] = $this->de_model->getDisciplines('2');
		$data['univers'] = $this->de_model->getDisciplines('3');
		$data['error']="";
		$this->load->view('results/results_de_disc_view',$data);
	}

	function de_view_courses()
	{
		//Выборка всех курсов, для которых есть результаты
		$data['courses'] = $this->de_model->getCoursesWithResults($this->uri->segment(3));
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(3));
		$data['disc_id'] = $this->uri->segment(3);
		$data['error'] = "";
		$this->load->view('results/results_de_courses_view',$data);
	}

	function de_course_results()
	{
		$range = '';
		$range = $this->input->get('range');
		if ($range != '')
		{
			$time1 = strtotime(substr($range,0,10));
			$time2 = strtotime(substr($range,13,23));
		}
		else
		{
			$time1 = strtotime("-1 month");
			$time2 = time();
		}
		//Выборка результатов по курсу и времени
		$data['results']=$this->de_model->getResults($this->uri->segment(3),$time1,$time2);
		$data['disc_name'] = $this->de_model->getDiscNameOverID($this->uri->segment(4));
		$data['course_name'] = $this->de_model->getNameCourse($this->uri->segment(3));
		$data['disc_id'] = $this->uri->segment(4);
		$data['course_id'] = $this->uri->segment(3);
		$data['error'] = "";
		$this->load->view('results/results_de_onecourse_view',$data);
	}

	//de_view_stud_result/$res_id/$course_id/$disc_id
	function de_view_stud_result()
	{
		$data['disc_id'] = $this->uri->segment(5);
		$data['disc_name'] = $this->de_model->getDiscNameOverID($data['disc_id']);
		$data['course_id'] = $this->uri->segment(4);
		$student = $this->de_model->getStudNameOverCrsRes($this->uri->segment(3));
		$data['stud_name'] = $student['firstname']." ".$student['lastname'];
		$data['results'] = $this->de_model->getStudLectionResult($this->uri->segment(4),$student['id']);
		foreach ($data['results'] as $key)
		{
			$data['lection_names'][$key['id']] = $this->de_model->getLectionName($key['lection_id']);
			if ($key['test_res_id'] != 0)
			{
				$data['test_results'][$key['id']] = $this->de_model->getTestResult($key['test_res_id']);
			}
		}
		$data['course_name'] = $this->de_model->getNameCourse($this->uri->segment(4));
		$data['error']="";
		$this->load->view('results/results_de_stud_view',$data);
	}

	function all_user_results()
	{
		$this->form_validation->set_rules('user_id', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$data['stud_id'] = $this->input->post('user_id');
			//ID группы
			$data['group_id'] = $this->results_model->getGroupIDOverUserID($data['stud_id']);
			$data['group_name'] = $this->results_model->getGroupNameOverId($data['group_id']);
			$data['stud_name'] = $this->results_model->getUserNameOverUserID($data['stud_id']);
			$data['type_r'] = $this->results_model->getUserTypeROverUserID($data['stud_id']);
			$data['results']=$this->results_model->getAllStudTests($data['stud_id']);
			//Оценка
			$ozenka=array();
			//Название теста
			$test_name=array();
			//Название дисциплины
			$disc_name=array();
			//Пользователь
			$pers_info=array();
			//Формирование массива результатов
			foreach($data['results'] as $key)
			{
				//Получение информации о конкретном тесте
				$test_info=$this->results_model->getTestInfo($key['razd_id']);
				$test_name[$key['id']]['name']=$test_info['name_razd'];
				$test_name[$key['id']]['id']=$key['razd_id'];
				$disc_name[$key['id']]['name']=$this->results_model->getDiscInfo($test_info['test_id']);
				$disc_name[$key['id']]['id']=$test_info['test_id'];
				if ($key['proz']<$test_info['three'])
				{
					$ozenka[$key['id']]=2;	
				}
				else
				{
					if($key['proz']<$test_info['four'])
					{
						$ozenka[$key['id']]=3;
					}
					else
					{
						if($key['proz']<$test_info['five'])
						{
							$ozenka[$key['id']]=4;
						}	
						else
						{
							$ozenka[$key['id']]=5;
						}
					}
				}
			}
			$data['test_name'] = $test_name;
			$data['disc_name'] = $disc_name;
			$data['ozenka'] = $ozenka;
			//Результаты пройденных дистанционных курсов
			$data['course_results'] = $this->de_model->getNotMyStudCourses($data['stud_id']);
			foreach($data['course_results'] as $key)
			{
				$data['disc_names'][$key['id']] = $this->de_model->getDiscName($key['course_id']);
				$data['course_names'][$key['id']] = $this->de_model->getNameCourse($key['course_id']);
			}
			//Результаты опросов
			$this->load->model('forms_model');
			$data['form_results'] = $this->forms_model->getAllUserForms($data['stud_id']);

			$data['error'] = "";
			//Вычисление индекса сложности решённых задач
			$isrz = 0;
			//Найти все вопросы, на которые отвечал пользователь
			for($i = 1;$i < 5;$i++)
			{
				$diff[$i] = $this->results_model->getUserAnswersOverDifficult($data['stud_id'],$i);
				$summ = 0;
				foreach($diff[$i] as $key)
				{
					$summ += $key['true'];
				}
				$data['diff'][$i] = 0;
				if (count($diff[$i]) > 0)
				{
					$data['diff'][$i] = round(($summ/count($diff[$i]))*100,3);
					$isrz += ($summ/count($diff[$i]))*$i;	
				}
			}
			if (count($data['results'])>4)
			{
				$data['isrz'] = round($isrz,3);
			}
			else
			{
				$data['isrz'] = 0;
			}
			if (($data['stud_id'] == 1) || ($data['stud_id'] == 1060))
			{
				//Не обновлять
			}
			else
			{
				//Обновить индекс в БД
				$this->results_model->updateUserIndexOfDifficult($data['stud_id'],$data['isrz']);
			}
			//Узнать, сколько студентов набрали больший индекс
			$high_isrz = $this->results_model->getCountIndexOfDifficult($data['isrz'],1,$data['type_r']);
			$low_isrz = $this->results_model->getCountIndexOfDifficult($data['isrz'],2,$data['type_r']);
			$data['high_isrz'] = ceil(($high_isrz/($high_isrz+$low_isrz))*100);
			$data['low_isrz'] = 100 - $data['high_isrz'];
			$this->load->view('results/results_all_user_results_view',$data);	
		}
		else
		{
			redirect('/main/auth', 'refresh');
		}
	}
}

?>