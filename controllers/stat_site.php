<?php

class Stat_site extends CI_Controller {

	function Stat_site()
	{
		parent::__construct();
		
	}

	function _remap($method)
	{
		$guest=$this->session->userdata('guest');
		if ($guest=='')
		{
			redirect('/main/auth/', 'refresh');
		}
		else
		{
			if ($guest<2)
			{
				redirect('/main/auth/', 'refresh');
			}	
			else
			{
				$this->load->model('stat_site_model');
				$this->$method();
			}
		}
	}

	//Функция отображения страницы c выбором диапазона статистики
	function index()
	{
		$range=$this->input->get('range');
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
		//Проверить, есть ли запись пользователя в new_log_status
		if ($this->stat_site_model->getUserLogString() == 0)
		{
			//Если записи не было - создать запись о пользователе
			$this->stat_site_model->createUserLogString();
		}
		for ($i = 0; $i < 4; $i++)
		{
			//Получить количество записей, указанных в new_log
			$log_cnt[$i] = $this->stat_site_model->getLogCount($i);
			//Получить количество записей, указанных в new_log_status
			$log_user_cnt[$i] = $this->stat_site_model->getUserLogCount($i);
			$data['log_user_cnt'][$i] = $log_cnt[$i] - $log_user_cnt[$i];
			//Обновить значение count в new_log_status
			$this->stat_site_model->updateUserLogCount($i,$log_cnt[$i]);
		}

		//Посещения
		$data['log_0'] = $this->stat_site_model->getLogs($time1,$time2,0);
		//Тестирование
		$data['log_1']=$this->stat_site_model->getLogs($time1,$time2,1);
		//Дистанционные курсы
		$data['log_2']=$this->stat_site_model->getLogs($time1,$time2,2);
		//Администрирование
		$data['log_3']=$this->stat_site_model->getLogs($time1,$time2,3);
		//Получение количества скорректированных результатов
		$data['proz_corr']=$this->stat_site_model->getCountCorr();
		$temp=$this->stat_site_model->getCountCorrPlus();
		$temp=ceil(($temp/$data['proz_corr'])*100);
		$data['proz_corr_plus']=$temp;
		//Количество активных пользователей, начинающиеся с vk_
		$data['vk_users']=$this->stat_site_model->getVkUsers();
		//Количество активных пользователей, которые зарегистрировались не через ВКонтакте
		$data['nvk_users']=$this->stat_site_model->getNotVkUsers();
		//Получение количества тестов в указанном диапазоне дат
		$data['tests']=$this->stat_site_model->getCountTests($time1,$time2);
		//Количество некорректных заданий (как считают студенты)
			//Количество заданий, которые якобы не проходили
			$data['incorr_stud_1']=$this->stat_site_model->getCountIncorrStud(1);
			//Количество некорректно заданных заданий
			$data['incorr_stud_2']=$this->stat_site_model->getCountIncorrStud(2);
			//Количество заданий, которыми недовольны пользователи
			$data['incorr_stud_3']=$this->stat_site_model->getCountIncorrStud(3);
		//Количество некорректных заданий (как считает статистический модуль)
		$data['incorr_stat']=$this->stat_site_model->getCountIncorrStat();
		//Количество активных заданий
		$data['incorr']=$this->stat_site_model->getCountQuest();
		//Количество студентов, давших НЕГАТИВНУЮ оценку своему результату
		$data['negative']=$this->stat_site_model->getCountOpinion(1);
		//Количество студентов, давших ПОЗИТИВНУЮ оценку своему результату
		$data['positive']=$this->stat_site_model->getCountOpinion(2);
		$data['error']="";
		$this->load->view('stat_site_view',$data);
	}

	function read_messages()
	{
		$this->load->model('main_model');
		$range=$this->input->get('range');
		if ($range!='')
		{
			$time1=substr($range,0,10);
			$time2=substr($range,13,23);
			$time1=strtotime($time1);
			$time2=strtotime($time2);
		}
		else
		{
			$time1=strtotime("-1 month");
			$time2=time();
		}
		$data['messages'] = $this->main_model->getMessages($time1,$time2);
		foreach ($data['messages'] as $key)
		{
			if ($key['user_id'] == 0)
			{
				$data['users'][$key['id']] = "Анонимный Аноним";
			}
			else
			{
				$data['users'][$key['id']] = $this->main_model->getUserOverId($key['user_id']);	
			}
			if ($key['to'] == 0)
			{
				$data['to'][$key['id']] = "Всем";	
			}
			else
			{
				$data['to'][$key['id']] = $this->main_model->getUserOverId($key['to']);	
			}
			
		}
		$data['error'] = "";
		$this->load->view('stat_site_messages_view',$data);
	}
	
}

?>