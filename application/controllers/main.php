<?php

class Main extends CI_Controller {

	//Функция отображения главной страницы
	function index($error = "")
	{
		$data['error'] = $error;
		$this->load->model('registr_model');
		$data['fspo']=$this->registr_model->getFSPO();
		$data['segrys']=$this->registr_model->getSegrys();
		$this->load->view('main_view',$data);
	}

	//Форма аутентификации
	function auth()
	{
		$this->load->model('persons_model');
		if ($this->session->userdata('lastname') == '')
		{
			$this->form_validation->set_rules('username', 'Логин', 'trim|required|xss_clean|max_length[20]|min_length[3]');
			$this->form_validation->set_rules('password', 'Пароль', 'trim|required|xss_clean|max_length[20]|min_length[2]');
			if ($this->form_validation->run() == FALSE)
			{
				$this->index();
			}
			else
			{
				//Проверка и запись сессии
				$this->load->model('auth_model');
				$text = $this->auth_model->getData();
				$c=count($text[0]);
				$d=count($text[1]);
				$e=0;
				if ($c=='0')
				{
					$error = "Неправильный логин";
					$e++;
				}
				if (($c>'0')&&($d=='0'))
				{
					$error = "Неправильный пароль";
					$e++;
				}
				if (($c>'0')&&($d>'0'))
				{
					$f=$text[0][0]['lastname'];
					$f1=$text[0][0]['firstname'];
					$f2=$text[0][0]['login'];
					$f3=$text[0][0]['guest'];
					$f4=$text[0][0]['id'];
					$f5=$text[0][0]['type_r'];
					$f6=$text[0][0]['block'];
					$f7=$this->auth_model->getGroup($f4);
					$name=$f." ".$f1;
					$type="Форма аутентификации";
					$this->auth_model->addLog($name,$type,1);
					$this->load->library('session'); // загружаем класс
					$newdata = array(
                	   	'lastname'  => $f,
                	   	'firstname'	=> $f1,
						'login'    	=> $f2,
						'guest'     => $f3,
						'user_id'	=> $f4,
						'type_r'	=> $f5,
						'block'	=> $f6,
						'group'	=> $f7,
						'logged_in' => TRUE
               		); // определяем массив с параметрами для сессии
 					$this->session->set_userdata($newdata); // записываем массив в сессию
				}
				if ($e>0)
				{
					$this->index($error);
				}
				else
				{
					$this->main_page();
				}
			}
		}
		else
		{
			$this->main_page();	
		}
	}

	function main_page($error = "")
	{
		$this->load->model('main_model');
		$this->load->model('persons_model');
		$this->load->model('results_model');		
		//Имя пользователя
		$data['title'] = "ВОС.Главная";
		$data2['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname');
		$user_id = $this->session->userdata('user_id');
		$data2['guest'] = $this->session->userdata('guest');
		$data2['type_r'] = $this->session->userdata('type_r');
		$data2['block'] = $this->main_model->getBlockOverUserId();
		$data2['group'] = $this->main_model->getGroupOverUserId();
		$data2['all_groups'] = $this->persons_model->getAllGroups();
		//Проверка почты
		$data2['mail'] = $this->main_model->getUserMail($user_id);
		$data2['mail_status'] = 0;
		if (filter_var($data2['mail'], FILTER_VALIDATE_EMAIL)) 
		{
			$data2['mail_status'] = 1;
		}
		else
		{
			if (filter_var($this->session->userdata('login'), FILTER_VALIDATE_EMAIL)) 
			{
				$data2['mail_status'] = 1;
				$this->main_model->updateUserMail($this->session->userdata('login'));
			}
		}
		//$data2['photo'] = $this->main_model->getPhotoOverUserId();
		//Получение информации о результатах студента
		$data2['sdano_t'] = $this->main_model->getTestCount();
		$data2['sdano_de'] = $this->main_model->getDeCount();
		//Статистика по тестам
		$this->load->model('private_model');
		$data2['avg'] = 0;
		$user_tests = $this->private_model->getUserDiscRes($user_id);
		for($i = 1;$i < 5;$i++)
		{
			$data2['diff'][$i] = 0;
		}
		foreach ($user_tests as $key)
		{
			$data2['tests'][$key['id']]['proz'] = $key['proz_corr'];
			$data2['avg'] += $key['proz_corr'];
			$data2['tests'][$key['id']]['name'] = $this->private_model->getDiscName($key['razd_id']).". ".$this->private_model->getTestName($key['razd_id']);
			$data2['tests'][$key['id']]['avg'] = $this->private_model->getTestAVG($key['razd_id']);
		}
		if (count($user_tests) > 0)
		{
			$data2['avg'] = round($data2['avg']/count($user_tests),1);
		}
		else
		{
			$data2['avg'] = 0;
		}
		//Вычисление индекса сложности решённых задач
		$isrz = 0;
		$this->load->model('reyting_model');
		if (count($user_tests)>4)
		{
			//Найти все вопросы, на которые отвечал пользователь
			for($i = 1;$i < 5;$i++)
			{
				$diff[$i] = $this->results_model->getUserAnswersOverDifficult($user_id,$i);
				$summ = 0;
				foreach($diff[$i] as $key)
				{
					$summ += $key['true'];
				}
				$data2['diff'][$i] = 0;
				if (count($diff[$i])>0) 
				{
					$data2['diff'][$i] = round(($summ/count($diff[$i]))*100,3);
					$isrz += ($summ/count($diff[$i]))*$i;
				}
			}
		
			$data2['isrz'] = round($isrz,3);
		}
		else
		{
			$data2['isrz'] = 0;
		}
		//Обновить индекс в БД
		if (($user_id == 1) || ($user_id == 1060))
		{
			//Не обновлять
		}
		else
		{
			$this->reyting_model->updateUserIndexOfDifficult($user_id,$data2['isrz']);
		}
		//Узнать, сколько студентов набрали больший индекс
		$high_isrz = $this->reyting_model->getCountIndexOfDifficult($data2['isrz'],1,$data2['type_r']);
		$low_isrz = $this->reyting_model->getCountIndexOfDifficult($data2['isrz'],2,$data2['type_r']);
		$data2['high_isrz'] = ceil(($high_isrz/($high_isrz+$low_isrz))*100);
		$data2['low_isrz'] = 100 - $data2['high_isrz'];
		$data2['high_isrz_abs'] = $high_isrz;
		$data2['low_isrz_abs'] = $low_isrz;
		//Сформировать топ
		if($data2['guest'] > 1)
		{
			$data2['top_index_f'] = $this->reyting_model->getTopOfIndex(1);
			$data2['top_index_s'] = $this->reyting_model->getTopOfIndex(2);
		}
		else
		{
			$data2['top_index'] = $this->reyting_model->getTopOfIndex($data2['type_r']);
		}
		/******Рейтинг*******/
		
		//Выбрать последнюю запись рейтинга пользователя
		//Если такой нет, то создать запись
		//Если запись есть и при этом рейтинг не совпадает, то смотреть на дату
		//Если дата совпадает с сегодняшней, то перезаписать рейтинг
		//Если дата не совпадает с сегодняшней, то создать запись

		$rank = $high_isrz + 1;
		$isrz = $data2['isrz'];

		$last_result = $this->reyting_model->getLastReytingRecordOverUserId($user_id);
		
		$data2['progress'] = "";
		
		if (isset($last_result))
		{
			$date = date("Y, n-1, d");
			if ($last_result['reyt'] != $rank)
			{
				$delta = $last_result['reyt'] - $rank;
				$forecast = 0.1 * $last_result['forecast'] + 0.9 * $isrz;
				$data2['progress'] = ($forecast < $last_result['forecast'] ? "Вам надо постараться" : "Вы прогрессируете, так держать!");
				if ($last_result['date'] == $date)
				{
					//Перезаписать рейтинг
					$this->reyting_model->updateStudReyt($last_result['id'],$rank,$isrz,$forecast);
					$data2['status'] = "Рейтинг уже был составлен сегодня, но Вы изменили позицию в рейтинге на ".$delta." позиций. Теперь Вы занимаете ".$rank." место\n";
				}
				else
				{
					$this->reyting_model->addStudReyt($user_id,$rank,$isrz,$forecast);
					$data2['status'] = "Вы изменили позицию в рейтинге на ".$delta." позиций. Теперь Вы занимаете ".$rank." место\n";
				}
			}
			else
			{
				$data2['status'] = "Ваша позиция в рейтинге не изменилась. Вы занимаете ".$rank." место\n";
			}
		}
		else
		{
			$this->reyting_model->addStudReyt($user_id,$rank,$isrz,$isrz);
			$data2['status'] = "Поздравляем! Вы впервые попали в рейтинг. Вы занимаете ".$rank." место\n";
		}

		//3. Получить все записи рейтинга по возрастанию ID
		$data2['reyting'] = $this->reyting_model->getFullReytingOverUserId($user_id);
		$data2['type_r_name'] = $this->reyting_model->getTypeRegNameOverTypeRegId($data2['type_r']);
		$data2['error'] = $error;
		
		$this->load->view('index_view',$data2);
	}

	function deauth()
	{
		//!Сделать напоминание о том, что надо выйти из ВКонтакте
		$this->session->sess_destroy();
		$this->index();
	}

	function renew_info()
	{
		$error = "";
		$this->load->model('persons_model');
		$this->load->model('auth_model');
		$new_gr = $this->input->post('new_group');
		$user_id = $this->session->userdata('user_id');
		$this->form_validation->set_rules('new_group', 'Номер группы', 'trim|required|xss_clean|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{
			$type_r=$this->persons_model->getTypeGroup($new_gr);
			$this->persons_model->updateGroup($user_id,$new_gr,$type_r);
			$error = "Информация о группе обновлена. Спасибо";
			$f1 = $this->session->userdata('firstname');
			$f = $this->session->userdata('lastname');
			$name = $f." ".$f1;
			$type = "Изменение группы";
			$this->auth_model->addLog($name,$type,1);
			
		}
		$this->main_page($error);
	}

	function unblock()
	{
		$this->load->model('main_model');
		$this->load->model('auth_model');	
		$this->main_model->unblockPerson();
		$error = "Учётная запись разблокирована. Спасибо";
		$f1 = $this->session->userdata('firstname');
		$f = $this->session->userdata('lastname');
		$name = $f." ".$f1;
		$type = "Разблокировка учётной записи";
		$this->auth_model->addLog($name,$type,1);
		$this->main_page($error);
	}

	function mail_update()
	{
		$this->form_validation->set_rules('user_mail', ' ', 'trim|required|xss_clean|valid_email');
		if ($this->form_validation->run() == TRUE)
		{
			$mail = $this->input->post('user_mail');
			$this->load->model('main_model');
			$this->main_model->updateUserMail($mail);
			$error = "Адрес обновлён! Спасибо!";
			$this->load->model('auth_model');
			$f1 = $this->session->userdata('firstname');
			$f = $this->session->userdata('lastname');
			$name = $f." ".$f1;
			$type = "Указан почтовый адрес: ".$mail;
			$this->auth_model->addLog($name,$type,1);
		}
		else
		{
			$error = "Обновить адрес не удалось";
		}
		$this->main_page($error);
	}

	function finduser()
	{
		$this->form_validation->set_rules('name', 'a', 'trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE)
		{
			$name = $this->input->post('name');
			$this->load->model('main_model');
			echo json_encode($this->main_model->getAllPersonsLikeName($name));
		}
	}

	function editors()
	{
		echo "Разработчики все будут описаны здесь";
	}

}