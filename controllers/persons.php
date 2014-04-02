<?php

class Persons extends CI_Controller {

	function Persons()
	{
		parent::__construct();
		
	}

	//Проверка сессии
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
				redirect('/main/auth/', 'refresh');
			}
			else
			{
				$this->load->model('persons_model');
				$this->$method();
			}
		}
	}

	function index()
	{
		redirect('/main/auth/', 'refresh');
	}

	//Запуск вьювера с персонала
	function personal($error = "")
	{
		$data['persons'] = $this->persons_model->getPersonal();
		$data['error'] = $error;
		$this->load->view('persons/persons_personal_view',$data);
	}

	//Обработка запроса по изменению информации о пользователе
	function personal_edit()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Обновить информацию пользователя не удалось";
		}
		else
		{
			$this->persons_model->editPersonal();
			$error = "Информация о пользователе обновлена";
		}
		$this->personal($error);
	}

	function person_del()
	{
		$user_id = $this->input->post('id_p');
		$this->persons_model->delPerson($user_id);
		$this->personal("Сотрудник заблокирован");
	}

	//Запуск вьювера со студентами ФСПО
	function students_fspo($error = "")
	{
		$data['all_groups']=$this->persons_model->getAllFSPOGroups();
		$data['groups']=$this->persons_model->getFspoGroups();
		foreach ($data['groups'] as $key)
		{
			$temp=$this->persons_model->getFSPO($key['id']);
			foreach($temp as $key2)
			{
				$data['persons'][$key['id']][$key2['id']]['lastname']=$key2['lastname'];
				$data['persons'][$key['id']][$key2['id']]['firstname']=$key2['firstname'];
				$data['persons'][$key['id']][$key2['id']]['id']=$key2['id'];
				$data['persons'][$key['id']][$key2['id']]['mail']=$key2['mail'];
			}
		}
		$data['error'] = $error;
		$this->load->view('persons/persons_fspo_view',$data);	
	}

	function students_fspo_edit()
	{
		$this->form_validation->set_rules('lname', 'Имя', 'trim|required|xss_clean');
		$this->form_validation->set_rules('fname', 'Фамилия', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Обновить информацию о студенте не удалось";
		}
		else
		{
			$this->persons_model->editFSPO();
			$error = "Информация о студенте обновлена";
		}
		$this->students_fspo($error);
	}

	function students_fspo_del()
	{
		$id_p=$this->input->post('id_p');
		$this->persons_model->delPerson($id_p);
		$this->students_fspo("Студент заблокирован");
	}

	function students_fspo_leto()
	{
		$old_id = $this->input->post('old_id');
		$new_id = $this->input->post('new_id');
		$this->persons_model->updateFSPOLeto($old_id,$new_id);
		$this->students_fspo("Информация о студентах обновлена");
	}

	//Запуск вьювера со студентами сегриса
	function students_segrys($error = "")
	{
		$data['plosh']=$this->persons_model->getSegrysPlosh();
		$data['groups']=$this->persons_model->getSegrysGroups();
		foreach($data['groups'] as $key)
		{
			$temp=$this->persons_model->getSegrys($key['id']);
			foreach($temp as $key2)
			{
				$data['plosh_name'][$key['id']]['plosh']=$key2['name_plosh'];
				$data['persons'][$key['id']][$key2['id']]['lastname']=$key2['lastname'];
				$data['persons'][$key['id']][$key2['id']]['firstname']=$key2['firstname'];
				$data['persons'][$key['id']][$key2['id']]['mail']=$key2['mail'];
				$data['persons'][$key['id']][$key2['id']]['id']=$key2['id'];
			}
		}
		$data['error'] = $error;
		$this->load->view('persons/persons_segrys_view',$data);	
	}

	function students_segrys_edit()
	{
		$this->form_validation->set_rules('lname', 'Имя', 'trim|required|xss_clean');
		$this->form_validation->set_rules('fname', 'Фамилия', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Обновить информацию о студенте не удалось";
		}
		else
		{
			$this->persons_model->editSegrys();
			$error = "Информация о студенте обновлена";
		}
		$this->students_segrys($error);
	}

	function students_segrys_del()
	{
		$id_p=$this->input->post('id_p');
		$this->persons_model->delPerson($id_p);
		$this->students_segrys("Информация о студенте обновлена");
	}

	function guest($error = "")
	{
		$data['persons']=$this->persons_model->getGuest();
		$data['fspo_groups']=$this->persons_model->getFspoGroups();
		$data['segrys_groups']=$this->persons_model->getSegrysGroups();
		$data['error'] = $error;
		$this->load->view('persons/persons_guest_view',$data);
	}

	function guest_edit()
	{
		$this->form_validation->set_rules('lname', 'Имя', 'trim|required|xss_clean');
		$this->form_validation->set_rules('fname', 'Фамилия', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Обновить информацию о госте не удалось";
		}
		else
		{
			$this->persons_model->editGuest();
			$error = "Информация о госте обновлена";
		}
		$this->guest($error);
	}

	function perevod($error = "")
	{
		$data['persons']=$this->persons_model->getSegrys();
		$data['fspo_groups']=$this->persons_model->getFspoGroups();
		$data['error'] = $error;
		$this->load->view('persons/persons_perevod_view',$data);	
	}

	function perevod_edit()
	{
		$this->persons_model->editPerevod();
		$this->perevod("Информация о студенте обновлена");	
	}

	function accounts($error = "")
	{
		$persons=$this->persons_model->getAll();
		foreach ($persons as $key) 
		{
			$persons_dubl[$key['id']]=$this->persons_model->getAll($key['id'],$key['lastname'],$key['firstname']);
			if (count($persons_dubl[$key['id']])>0)
			{
				$filter_pers[$key['id']]['id']=$key['id'];
				$filter_pers[$key['id']]['login']=$key['login'];
				$filter_pers[$key['id']]['data_r']=$key['data_r'];
				$filter_pers[$key['id']]['firstname']=$key['firstname'];
				$filter_pers[$key['id']]['lastname']=$key['lastname'];
				$filter_pers[$key['id']]['test_cnt']=$this->persons_model->getStudTestsCount($key['id']);
				foreach ($persons_dubl[$key['id']] as $key2)
				{
					$filter_pers[$key['id']]['dubl'][$key2['id']]['id']=$key2['id'];
					$filter_pers[$key['id']]['dubl'][$key2['id']]['lastname']=$key2['lastname'];
					$filter_pers[$key['id']]['dubl'][$key2['id']]['firstname']=$key2['firstname'];
					$filter_pers[$key['id']]['dubl'][$key2['id']]['login']=$key2['login'];
					$filter_pers[$key['id']]['dubl'][$key2['id']]['data_r']=$key2['data_r'];
					$filter_pers[$key['id']]['dubl'][$key2['id']]['test_cnt']=$this->persons_model->getStudTestsCount($key2['id']);
				}
			}
		}
		$data['counts']=count($filter_pers);
		$data['persons']=$filter_pers;
		$data['error']=$error;
		$this->load->view('persons/persons_accounts_view',$data);	
	}

	function accounts_edit()
	{
		$id_orig = $this->input->post('id_orig');
		$id_dubl = $this->input->post('id_dubl');
		$error = "";
		//Перевести результаты на один аккаунт, при этом проследить, чтобы не было повторной сдачи теста
		//Оригинал должен остаться, а дубликат заблокироваться, при этом то, что сдава дубликат перевести на оригинал
		//Поставить блок аккаунту (пока просто статус, потом предусмотреть полную блокировку)
		$orig_tests = $this->persons_model->getStudTests($id_orig);
		$dubl_tests = $this->persons_model->getStudTests($id_dubl);
		//Массив с результами, которые надо удалить
		$del_array=array();
		//Массив с результами, которые надо редактировать
		$edit_array=array();
		//Если есть тесты у оригинала или дубликата - обрабатываем, если нет, то просто блокируем дубликат
		if ((count($orig_tests)>0) || (count($dubl_tests)>0))
		{
			//Здесь возможно несколько вариантов
			//Самый простой, если у дубликата не было сдано тестов
			//В таком случае, просто блокируется дубликат
			if ((count($orig_tests)>0) && (count($dubl_tests)==0))
			{
				$error="Сданных тестов у дубликата не было, но он заблокирован. ";
			}
			//Второй случай посложнее - у оригинала не было сдано тестов, а дубликата были сданы
			if ((count($orig_tests)==0) && (count($dubl_tests)>0))
			{
				$error="Сданных тестов у оригинала не было, результаты дубликата переписаны на оригинал. ";
				$this->persons_model->updateStudResult($id_orig,$id_dubl);
			}
			//Третий случай, самый сложный. И оригинал и дубликат сдавали тесты, и, возможно, одни и те же
			if ((count($orig_tests)>0) && (count($dubl_tests)>0))
			{
				//Сравнить ID разделов, если есть совпадения - удалить тот результат, у которого меньший процент
				//Те, что не совпали, переписать на оригинала
				foreach($orig_tests as $key)
				{
					foreach ($dubl_tests as $key2)
					{
						//Разделы совпали
						if ($key['razd_id']==$key2['razd_id'])
						{
							//удаляем тот результат, который хуже
							if ($key['proz_corr']<$key2['proz_corr'])
							{
								$del_array[$key2['id']]=1;
							}
							else
							{
								$del_array[$key['id']]=1;
							}
						}
						else
						{
							$edit_array[$key2['id']]=1;
						}
					}
				}
			}
		}
		else
		{
			$error="Сданных тестов у пользователя не было, но дубликат заблокирован. ";
		}
		//Перезапись результатов
		$this->persons_model->updateStudResult($id_orig,$id_dubl);
		//Удаление результатов
		foreach ($del_array as $key=>$value)
		{
			if ($value==1) 
			{
				$this->persons_model->deleteStudResult($key);
			}
		}
		if (count($del_array)>0)
		{
			$error="Оригинал и дубликат сдавали одни и те же тесты. Худший результат был удалён. ";
		}
		//Заблокировать дубликат, чтобы не было возможности повторной сдачи теста
		$this->persons_model->updateStudBlock($id_dubl);
		//Формирование страницы с дубликатами
		$this->accounts($error);
	}

	function resume()
	{
		$this->load->model('private_model');
		//Посчитать количество навыков в группе (всего навыки сгруппированы в 4 группы)
		for ($i=1;$i<5;$i++)
		{
			$count[$i] = $this->private_model->getCountSkills($i);
		}
		//Получение всех студентов, которые составили резюме
		$data['students'] = $this->private_model->getResumeStudents();
		foreach($data['students'] as $key)
		{
			//Получить средний балл по группам навыков
			for ($i=1;$i<5;$i++)
			{
				//Посчитать сумму баллов студента по навыку одной группы
				$summ = $this->private_model->getSumSkills($key['id'],$i);
				$data['skill_groups'][$key['id']][$i] = round((($summ/$count[$i])/5)*100,2);
			}
			//Количество указанных проектов
			$data['portf_count'][$key['id']] = $this->private_model->getCountPortfolios($key['id']);
			//Средний балл компетентностного портрета
			$data['comps_avg'][$key['id']] = round($this->private_model->getCompsAvg($key['id']),2);
		}
		$data['error'] = "";
		$this->load->view('persons_resumes_view',$data);
	}

	function student_resume()
	{
		$user_id = $this->uri->segment(3);
		$this->load->model('private_model');
		$this->load->model('comps_model');
		$data['user_info'] = $this->private_model->getUserInfo($user_id);
		//Информация о пользовательских навыках
		$data['portfolios'] = $this->private_model->getAllUserPortfolios($user_id);
		$data['comps'] = $this->comps_model->getAllUserBalls($user_id);
		foreach ($data['comps'] as $key)
		{
			$data['comp_name'][$key['id']] = $this->comps_model->getCompTiDe($key['compet_id']);
			$data['comp_ball'][$key['id']] = round($key['balls'],2);
		}
		$data['skills'] = $this->private_model->getAllUserSkills($user_id);
		foreach($data['skills'] as $key) 
		{
			//Получение названия навыка
			$data['skill_name'][$key['id']] = $this->private_model->getSkillName($key['skill_id']);
			//Получение информации об уровне навыков
			$data['skill_description'][$key['id']] = $this->private_model->getSkillBallDescription($key['skill_id'],$key['balls']);
		}
		$data['user_id'] = $user_id;
		$data['error']="";
		$this->load->view('persons_studresume_view',$data);
	}

}

?>