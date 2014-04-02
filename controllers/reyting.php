<?php

class Reyting extends CI_Controller {

	function Reyting()
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
			if ($guest<3)
			{
				$data['firstname']=$this->session->userdata('firstname');;
				$data['guest']=$guest;
				$data['error']="У вас недостаточно прав";
				$this->load->view('index_view',$data);	
			}	
			else
			{
				$this->load->model('reyting_model');
				$this->$method();
			}
		}
	}

	//Функция отображения страницы c выбором диапазона статистики
	function index()
	{
		$type = $this->uri->segment(3);
		$progr = $this->uri->segment(4);
		//Обновление даты обновления рейтинга
		$this->reyting_model->updateTypeReyt($type);
		//Общее обнуление рейтинга у всех студентов данного типа
		$this->reyting_model->updateAllReyt($type, $progr);
		if ($type==2)
		{
			$data['name']="Рейтинг студентов НОУ \"СЕГРИС-ИИТ\"";
			if ($progr=="bk")
			{
				$data['name_2']="Базовый курс";
			}
			else
			{
				$data['name_2']="Специализация";
			}
			//Массив со студентами Сегриса
			$data['students']=$this->reyting_model->getStudType($progr);
		}
		else
		{
			$data['name']="Рейтинг студентов ФСПО НИУ ИТМО";
			$data['name_2']="";
			//Массив со студентами ФСПО
			$data['students']=$this->reyting_model->getStudFSPO();
		}
		foreach($data['students'] as $key)
		{
			//Массив с результатами
			$results=$this->reyting_model->getStudResult($key['id']);
			//Количество тестов для расчёта рейтинга
			if (count($results)>4)
			{
				$i=0;
				//Общая сообразительность
				$reyting[$key['id']]['soobraz']=0;
				$reyting[$key['id']]['avg']=0;
				//Средняя сложность
				$avg_multiplicity=0;
				foreach($results as $key2)
				{
					//Скорректированный процент студента
					$proz=$key2['proz_corr'];
					//время студента
					$time_st=$key2['timeend']-$key2['timebeg'];
					//Получить сложность теста, рассчитанную статистически, и среднее время
					//выполнения теста  `multiplicity`,`time_avg`
					$temp=$this->reyting_model->getTestPars($key2['razd_id']);
					//Сложность теста
					$multiplicity=$temp['multiplicity'];
					//Среднее время теста
					$time_avg=$temp['time_avg'];
					//Скорость выполнения
					$temp_t=$time_avg/$time_st;
					if($temp_t>5) {$temp_t=5;}
					if($temp_t<0.2) {$temp_t=0.2;}
					//Превосходство над средним
					$temp_r = $proz/$multiplicity;
					$soobr = $temp_t*$temp_r/100;
					//Увеличить рейтинг на:
					$reyting[$key['id']]['avg']+=$temp_r+$soobr;
					$reyting[$key['id']]['soobraz']+=$soobr*100;
					$avg_multiplicity+=$multiplicity;
					$i++;
				}
				$reyting[$key['id']]['avg']=round($reyting[$key['id']]['avg']/$i,3);
				$reyting[$key['id']]['count']=round($avg_multiplicity/$i,3);
				$reyting[$key['id']]['soobraz']=round($reyting[$key['id']]['soobraz']/$i,3);
				$reyting[$key['id']]['kolvo']=$i;
				$reyting[$key['id']]['id']=$key['id'];
				$reyting[$key['id']]['name']=$key['lastname']." ".$key['firstname'];
				$stud_info[$key['id']]=$this->reyting_model->getStudGroup($key['id']);
			}
		}
		//Транспонирование матрицы
		foreach($reyting as $key=>$value) 
		{
			$sort_proz[$key] = $reyting[$value['id']]['avg'];
			$sort_count[$key]= $reyting[$value['id']]['count'];
		}
		//Сортировка массива по убыванию среднего результата
		array_multisort($sort_proz, SORT_NUMERIC, SORT_DESC, $sort_count, SORT_NUMERIC, SORT_DESC, $reyting);
		foreach ($reyting as $key=>$value)
		{
			//Обновляем позицию и рейтинг студента
			$this->reyting_model->updateStudReyt($value['id'],$key+1,$value['avg']);
			//Проверяем, записывался ли сегодня рейтинг в БД для этого пользователя
			$date_reyt=$this->reyting_model->getDateStud($value['id']);
			if ($date_reyt['reyt']=="hell")
			{
				$this->reyting_model->addDateStudReyt($value['id'],$key+1,$value['avg']);
			}
			else
			{
				if (($date_reyt['reyt']!=$key+1) && ($date_reyt['date']==date("Y.m.d")))
				{
					$this->reyting_model->updateDateStudReyt($value['id'],$key+1,$value['avg']);
				}
				if (($date_reyt['reyt']!=$key+1) && ($date_reyt['date']!=date("Y.m.d")))
				{
					$this->reyting_model->addDateStudReyt($value['id'],$key+1,$value['avg']);		
				}
			}
			//Обратное транспонирование матрицы
			$stud_reyt[$value['id']]['pos']=$key+1;
			$stud_reyt[$value['id']]['avg']=$value['avg'];
			$stud_reyt[$value['id']]['soobraz']=$value['soobraz'];
			$stud_reyt[$value['id']]['count']=$value['count'];
			$stud_reyt[$value['id']]['kolvo']=$value['kolvo'];
			$stud_reyt[$value['id']]['name']=$value['name'];
			$stud_reyt[$value['id']]['id']=$value['id'];
		}
		$data['stud_reyt']=$stud_reyt;
		$data['stud_info']=$stud_info;
		$data['progr']=$progr;
		$data['type_r']=$type;
		$data['error'] = "";
		$this->load->view('reyting/reyting_view',$data);
	}

	function view_history()
	{
		$type=$this->input->post('type_r');
		$progr=$this->input->post('progr');
		$data['history']=$this->reyting_model->getHistory($this->uri->segment(3));
		$i=0;
		$hist_array=array();
		foreach($data['history'] as $key)
		{
			$hist_array[$i]['reyt']=$key['reyt'];
			$hist_array[$i]['id']=$key['id'];
			if ($i>0)
			{
				if ($hist_array[$i]['reyt']==$hist_array[$i-1]['reyt'])
				{
					$this->reyting_model->delHistory($hist_array[$i-1]['id']);
				}
			}
			$i++;
		}
		$data['history']=$this->reyting_model->getHistory($this->uri->segment(3));
		$data['user']=$this->reyting_model->getStudInfo($this->uri->segment(3));
		$data['type_r']=$type;
		$data['progr']=$progr;
		$data['error']="";
		$this->load->view('reyting/reyting_history_view',$data);			
	}

	function prepods()
	{
		$prepods=$this->reyting_model->getPrepods();
		$data['prepods']=array();
		//print_r($prepods);
		foreach ($prepods as $key)
		{
			$groups[$key['id']]=$this->reyting_model->getPrepodStudents($key['id']);
			if (count($groups[$key['id']])>2)
			{
				$reyt=0;
				foreach($groups[$key['id']] as $key2)
				{
					$reyt+=$key2['reyting'];
				}
				$data['prepods'][$key['id']]['avg']=round($reyt/count($groups[$key['id']]),3);
				$data['prepods'][$key['id']]['count']=count($groups[$key['id']]);
				$data['prepods'][$key['id']]['name']=$key['name'];
			}
		}
		$data['error']="";
		$this->load->view('reyting/reyting_prepods_view',$data);
	}
	
}

?>