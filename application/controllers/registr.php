<?php

class Registr extends CI_Controller {

	function Registr()
	{
		parent::__construct();
		
	}

	//Функция отображения главной страницы
	function index($error = "")
	{
		$data['error'] = $error;
		$this->load->model('registr_model');
		$data['fspo']=$this->registr_model->getFSPO();
		$data['segrys']=$this->registr_model->getSegrys();
		$this->load->view('registr_view',$data);
	}

	function check_mail()
	{
		$login = $this->input->post('login');
		$this->load->model('registr_model');
		$this->form_validation->set_rules('login', 'Логин', 'trim|required|xss_clean|valid_email');
		if ($this->form_validation->run() == TRUE) 
		{
			@$check = $this->registr_model->checkLogin($login);
			if (isset($check))
			{
				$auth = false;
			}
			else
			{
				$auth = true;
			}
			echo json_encode(array('auth'=>$auth));
		}
		else
		{
			echo json_encode(array('auth'=>'error'));
		}
	}

	function create_person()
	{
		$this->load->model('registr_model');
		$this->load->model('auth_model');
		$this->form_validation->set_rules('lastname', 'Фамилия', 'trim|required|xss_clean');
		$this->form_validation->set_rules('firstname', 'Имя', 'trim|required|xss_clean');
		$this->form_validation->set_rules('login', 'Логин', 'trim|required|xss_clean|valid_email|max_length[30]|min_length[4]');
		$this->form_validation->set_rules('pass', 'Пароль', 'trim|required|xss_clean|max_length[30]|min_length[2]');
		$this->form_validation->set_rules('type', '', 'trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('guest', 'Пароль', 'trim|xss_clean|is_natural');
		$this->form_validation->set_rules('fspo_group', 'Пароль', 'trim|xss_clean|is_natural');
		$this->form_validation->set_rules('segrys_group', 'Пароль', 'trim|xss_clean|is_natural');
		$lastname=$this->input->post('lastname');
		$firstname=$this->input->post('firstname');
		$patern = "|^[-а-я]+$|i";
		$last_c=preg_match("/^[".chr(0x7F)."-".chr(0xff)."_-]+$/", $lastname);
		$first_c=preg_match("/^[".chr(0x7F)."-".chr(0xff)."_-]+$/", $firstname);
		if ($this->form_validation->run() == TRUE && $last_c && $first_c) 
		{
			//Проверить, нет ли учётной записи с таким логином
			$status = $this->registr_model->checkLogin($this->input->post('login'));
			if (!isset($status))
			{
				$this->registr_model->createUser();
				$data['error'] = "Поздравляем, учётная запись создана! Попробуйте войти в систему.";
			}
			else
			{
				$data['error'] = "Попытка создания учётной записи с существующим логином.";
				$this->auth_model->addLog($this->input->post('lastname')." ".$this->input->post('firstname'),$data['error'],1);
			}
			$this->load->model('registr_model');
			$data['fspo']=$this->registr_model->getFSPO();
			$data['segrys']=$this->registr_model->getSegrys();
			$this->load->view('main_view',$data);
		}
		else
		{
			$data['error'] = "Проверьте правильность введённых данных. Учтите, что имя и фамилия должны быть записаны кириллицей";
			$this->load->model('registr_model');
			$data['fspo']=$this->registr_model->getFSPO();
			$data['segrys']=$this->registr_model->getSegrys();
			$this->load->view('main_view',$data);
		}
	}

	function authOpenAPIMember() 
	{ 
		$session = array(); 
		$member = FALSE; 
		$valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig'); 
		$app_cookie = $_COOKIE['vk_app_'.'2849330'];
		if ($app_cookie) 
		{ 
			$session_data = explode ('&', $app_cookie, 10); 
			foreach ($session_data as $pair) 
			{ 
				list($key, $value) = explode('=', $pair, 2);
				if (empty($key) || empty($value) || !in_array($key, $valid_keys)) 
				{
					continue; 
	  			} 
	  			$session[$key] = $value; 
			}
			foreach ($valid_keys as $key) 
			{
				if (!isset($session[$key])) return $member; 
			}
			ksort($session); 

			$sign = '';
			foreach ($session as $key => $value) 
			{ 
	  			if ($key != 'sig') 
	  			{ 
					$sign .= ($key.'='.$value); 
	  			}
			}
			$sign .= 'LXGYFTULRHhxoYQ5vExI'; 
			$sign = md5($sign);
			if ($session['sig'] == $sign && $session['expire'] > time()) 
			{ 
	  			$member = array( 
				'id' => intval($session['mid']), 
				'secret' => $session['secret'], 
				'sid' => $session['sid'],
				'user' => $session['user']
	  			); 
			}
  		} 
  		return $member; 
	}

	function vk()
	{
		$member = $this->authOpenAPIMember();
		if($member !== FALSE) 
		{ 
  			/* Пользователь авторизован в Open API */ 
  			$firstname = $this->input->get('firstname','TRUE');
			$lastname = $this->input->get('lastname','TRUE');
			$this->vk_session($member['id'],$firstname,$lastname);
		}
		else
		{ 
  			/* Пользователь не авторизован в Open API */ 
  			echo "FUCK";
		}
		/*
		$this->load->model('registr_model');
		$this->load->model('persons_model');
		$uid = $this->input->get('uid','TRUE');
		$firstname = $this->input->get('first_name','TRUE');
		$lastname = $this->input->get('last_name','TRUE');
		$photo = $this->input->get('photo','TRUE');
		$hash = $this->input->get('hash','TRUE');
		$this->vk_session($uid, $firstname, $lastname, $photo, $hash);
		*/

	}

	function vk_session($uid = "", $firstname = "", $lastname = "")
	{
		$this->load->model('registr_model');
		$this->load->model('persons_model');
		$this->load->model('auth_model');

		$login = "vk_".$uid;
		$user = $this->registr_model->getUser($login);
		

		if (isset($user[0]))
		{
			//Пользователь существует, авторизуем его
			$f=$user[0]['lastname'];
			$f1=$user[0]['firstname'];
			$f2=$user[0]['login'];
			$f3=$user[0]['guest'];
			$f4=$user[0]['id'];
			$f5=$user[0]['type_r'];
			$f6=$user[0]['block'];
			$f7=$this->auth_model->getGroup($f4);
			$name=$f." ".$f1;
			$type="ВКонтакте";
			//Если не Кудрявцев Александр, то записать в лог
			if ($f4!=1060)
			{
				$this->auth_model->addLog($name,$type,1);
			}
			$this->load->library('session'); // загружаем класс
			$newdata = array(
					'lastname'  => $f,
					'firstname'	=> $f1,
					'login'    	=> $f2,
					'guest'     => $f3,
					'user_id'	=> $f4,
					'type_r'	=> $f5,
					'block'		=> $f6,
					'group'		=> $f7,
					'logged_in' => TRUE
					); // определяем массив с параметрами для сессии
			$this->session->set_userdata($newdata); // записываем массив в сессию
			redirect('/main/auth/', 'refresh');
		}
		else
		{
			//Пользователя не существует, региструем его
			$data['error'] = "При первой авторизации необходимо заполнить регистрационную форму";
			$this->load->model('registr_model');
			$data['uid'] = $uid;
			$data['lastname'] = $lastname;
			$data['firstname'] = $firstname;
			$data['fspo'] = $this->registr_model->getFSPO();
			$data['segrys'] = $this->registr_model->getSegrys();
			$data['hash'] = md5("vk_".$uid);
			$this->load->view('registr_vk_view',$data);
		}
	}

	function vk_registr()
	{
		$this->load->model('registr_model');
		$this->form_validation->set_rules('lastname', 'Фамилия', 'trim|required|xss_clean');
		$this->form_validation->set_rules('firstname', 'Имя', 'trim|required|xss_clean');
		$this->form_validation->set_rules('uid', 'Имя', 'trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('guest', 'Имя', 'trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('type', 'Имя', 'trim|required|xss_clean|is_natural');
		$this->form_validation->set_rules('hash', 'Имя', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$data['error'] = "Попробуйте зарегистрироваться ещё раз. Если повторная попытка будет безуспешной, зарегистрируйтесь, пожалуйста, стандартным способом";
			$this->load->model('registr_model');
			$data['fspo']=$this->registr_model->getFSPO();
			$data['segrys']=$this->registr_model->getSegrys();
			$this->load->view('main_view',$data);
		}
		else
		{
			$this->registr_model->createVkUser();
			$lastname = $this->input->post('lastname');
			$firstname = $this->input->post('firstname');
			$uid = $this->input->post('uid');
			$photo = "";
			$hash = $this->input->post('hash');
			$this->vk_session($uid, $firstname, $lastname);
		}		
	}

	
}