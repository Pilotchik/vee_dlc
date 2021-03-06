<?php
/**
 * User: Andrey Slabkiy
 * Date: 06.03.14
 * Time: 13:13
 */
class Api extends CI_Controller
{
   
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mapi');
		header('Access-Control-Allow-Origin: *');
	}

	function index()
	{
		echo "API ВОС";
	}
	
	function getTestData()
	{

		$data = array(
			"DiscName" => $this->mapi->getDiscNames(),
			"DiscTest" => $this->mapi->getDiscTests()
		);

		echo json_encode($data);
	}
	
	function testStart()
	{
		//Создание записи о результате
		$test_id = $this->input->post('test_id');
		$user_id = $this->input->post('user_id');
		$true_all = $this->input->post('true_all');
		$now_time = time();
		$result =  $this->mapi->createResRecord($test_id,$user_id,$now_time,0,$true_all);
		if($result = '0'){
			echo '0';
		}
	}
	
	function autosave()
	{
		$this->form_validation->set_rules('id_q', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('ans_id', 'ID', 'trim|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('time_s', 'Время', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('idrazd', 'Раздел', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('true_q', 'Ответ', 'trim|xss_clean|max_length[30]');
		$this->form_validation->set_rules('check', 'Проверка', 'trim|xss_clean|max_length[30]');
		if ($this->form_validation->run() == TRUE)
		{
			$id_q=$this->input->post('id_q');
			$true_q=$this->input->post('true_q');
			$time_s=$this->input->post('time_s');
			$idrazd=$this->input->post('idrazd');
			$ans_id=$this->input->post('ans_id');
			$check=$this->input->post('check');
			$user_id = $this->input->post('user_id');
			//Получение ID результатной записи
			$status_array=$this->mapi->getResRecord($user_id,$idrazd);
			$result_id=$status_array[0]['id'];
			//Записать время выполнения вопроса
			//Узнать время выполнения предыдущего задания
			$prev_quest_time = $this->mapi->getPrevQuest($result_id, $id_q);
			$now_time=time();
			if ($prev_quest_time != 0)
			{
				//Если в предыдущем вопросе есть время
				$quest_time = $now_time - $prev_quest_time;
			}
			else
			{
				//Получить время начала теста
				$test_begin = $this->mapi->getTestBegin($result_id);
				$quest_time = $now_time - $test_begin;
			}

			//Все ответы на вопрос
			$answers=$this->mapi->getAnswers($id_q);
			//Все правильные ответы
			$true_answers=$this->mapi->getTrueAnswers($id_q);
			//Получение типа вопроса
			$quest=$this->mapi->getQuest($id_q);
			//Тип вопроса
			$type_q=$quest[0]['type'];
			$n=1;
			//Количество ответов
			$s2=count($answers);
			//Найти количество правильных ответов в закрытых вопросах с несколькими правильными
			$s=count($true_answers);
			$true=0;
			foreach($answers as $key)
			{
				$questtrue=$key['true'];
				$ans_text=$key['text'];
				if ($type_q==2)
				{
					if (($true_q=="$n") and ($questtrue=='1') and ($check=='1'))
					{
						$true=1/$s;
					}
					if (($true_q=="$n") and ($questtrue=='1') and ($check!='1'))
					{
						$true=(-1)*(1/($s2-$s));
					}
					if (($true_q=="$n") and ($questtrue!='1') and ($check=='1'))
					{
						$true=(-1)*(1/($s2-$s));
					}
					if (($true_q=="$n") and ($questtrue!='1') and ($check!='1'))
					{
						$true=1/$s;
					}
				}
				if ($type_q==3)
				{
					if (((strlen($true_q)/2)==strlen($ans_text)) or ($true_q==$ans_text))
					{
						$true = 1;
					}
					else
					{
						$true = 0;
					}
				}
				//Числовой диапазон
				if ($type_q == 6)
				{
					$true_q = str_replace(",",".",$true_q);
					if (($true_q > $key['option_1']) && ($true_q < $key['option_2']) || ($true_q == $key['option_1']) || ($true_q == $key['option_2']))
					{
						$true = 1;
					}
					else
					{
						$true = 0;
					}
				}
				$n++;
			}
			//Выяснить правильный ответ для конкретного ID ответа
			$true_of_answer = $this->mapi->getAnswer($ans_id);
			if ($type_q==1)
			{
				$true = ($true_of_answer['true']=='1' ? 1 : 0);
			}
			if ($type_q==4)
			{
				if ($true_of_answer['true']==$true_q)
				{
					$true=1/$s2;
				}
				else
				{
					$true=-0.05;
				}
			}
			//Ответ студента
			$pers_answer=$this->mapi->getPersonalAnswer($id_q,$user_id);
			if (isset($pers_answer[0]))
			{
				//Уже есть запись ответа
				$ans_id=$pers_answer[0]['id'];
				$answer=$pers_answer[0]['true'];
				if (($type_q==2) or ($type_q==4))
				{
					$true=$true+$answer;
					if ($true<0) {$true=0;}
					if ($true>1) {$true=1;}
				}
				$update_answer=$this->mapi->updatePersonalAnswer($ans_id,$true_q,$true);
			}
			else
			{
				//Ответ даётся в первый раз
				if ($true<0) {$true=0;}
				$update_answer = $this->mapi->addPersonalAnswer($user_id,$id_q,$true_q,$result_id,$true,$quest_time);
			}
			//Изменить время автосохранения
			$editTime=$this->mapi->updateResTimeRecord($result_id,$time_s);
			echo json_encode(array('answer'=>1));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

	function test_itog()
	{
		$test_id=$this->input->post('id');
		$user_id=$this->input->post('user_id');
		$now_time=time();
		$status_array=$this->mapi->getResRecord($user_id,$test_id);
		$result_id=$status_array[0]['id'];
		if ($status_array[0]['proz']>0)
		{
			redirect('auth');
		}
		else
		{
		$data['true_all']=round($status_array[0]['true_all'],3);
		$stud_answers=$this->mapi->getStudAnswers($result_id);
		$true_cnt=0;
		$data['dano']=count($stud_answers);
		foreach ($stud_answers as $key)
		{
		$true_cnt=$key['true']+$true_cnt;
		}
		$abs=round(($true_cnt/$data['true_all'])*100,3);
		if ($abs>100) {$abs=100;}
		$data['true_cnt']=$true_cnt;
		$data['abs']=$abs;
		$result=$this->mapi->updateResRecord($result_id,$true_cnt,$abs,$now_time);
		$data['result_id'] = $result_id;
		// $this->load->model('main_model');//журналирование
		// $this->load->model('tests_model');//название теста
		$data['text'] = "Пройден тест \"".$this->mapi->getDiscNameOverTestID($test_id).". ".$this->mapi->getNameTest($test_id)."\"";
		// $this->main_model->createLogRecord($msg,1);

		$data['error']="";
		echo json_encode($data);
		}
	}

	function auth(){
		$this->form_validation->set_rules('username', 'Логин', 'trim|required|xss_clean|max_length[20]|min_length[3]');
		$this->form_validation->set_rules('password', 'Пароль', 'trim|required|xss_clean|max_length[20]|min_length[2]');
		if ($this->form_validation->run() == FALSE)
		{
		   // $this->index();
		   // echo "form error";
		}
		else{
			$this->load->model('auth_model');
			$text = $this->mapi->getPersonData();
			$c=count($text[0]);
			$d=count($text[1]);
			$e=0;
			if ($c=='0')
			{
				$error = "Неправильный логин(login)";
			   // echo $error;
				$e++;
			}
			if (($c>'0')&&($d=='0'))
			{
				$error = "Неправильный пароль(pass)";
			   // echo $error;
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
				$f7=$this->mapi->getGroup($f4);
				$name=$f." ".$f1;
				$type="Удалённый ресурс";
				$this->mapi->addLog($name,$type,1);
				$secret_key = "1m.2be25or96not45to032be";
				$status = array(
					'lastname'  => $f,
					'firstname'	=> $f1,
					'login'    	=> crypt($f2, $secret_key),
					'guest'     => $f3,
					'user_id'	=> $f4,
					'type_r'	=> $f5,
					'block'	=> $f6,
					'group'	=> $f7,
					'logged_in' => TRUE
				);
				echo json_encode($status);
			}
		}
	}

	function auth_vk(){
		$this->form_validation->set_rules('username', 'Логин', 'trim|required|xss_clean|max_length[20]|min_length[3]');
		if ($this->form_validation->run() == FALSE)
		{
		   // $this->index();
		   // echo "form error";
		}
		else
		{
			$uname=$this->input->post('username');
			$user = $this->mapi->getPersonDataToVK($uname);
			if (count($user) > 0)
			{
				$group=$this->mapi->getGroup($user['id']);
				$name=$user['lastname']." ".$user['firstname'];
				$type="Удалённый ресурс через ВКонтакте";
				$this->mapi->addLog($name,$type,1);
				$secret_key = "1m.2be25or96not45to032be";
				$status = array(
					'lastname'  => $user['lastname'],
					'firstname' => $user['firstname'],
					'login'     => crypt($user['login'], $secret_key),
					'guest'     => $user['guest'],
					'user_id'   => $user['id'],
					'type_r'    => $user['type_r'],
					'block' => $user['block'],
					'group' => $group,
					'logged_in' => TRUE
				);
				echo json_encode($status);
			}
		}
	}

	function show_event()
	{
		header('Content-type: text/html; charset=utf-8');
		$this->form_validation->set_rules('test_id', 'Ключ', 'required|is_natural_no_zero');
		if($this->form_validation->run() == FALSE)
		{
			$error = 0;
			echo json_encode($error);
		}
		else
		{
			$test_id = $this->input->post('test_id');
			$quests = $this->mapi->getQuests($test_id);
			$CountQuests = $this->mapi->getCountQuests($test_id);
			foreach ($quests as $key)
			{
				$questsAnswers[$key->id] = $this->mapi->getQuestsAnswers($key->id);
			}
			$data_array = array($quests,$questsAnswers,array('count' => $CountQuests));
			echo json_encode($data_array);
		}
	}

	function getTestIdOverKey()
	{
		$this->form_validation->set_rules('key', 'Ключ', 'required');
		if($this->form_validation->run() == FALSE)
		{
			$error = 0;
			echo json_encode($error);
		}
		else
		{
			$key = $this->input->post('key');
			$test_id = $this->mapi->getTestIdOverKey($key);
			foreach($test_id as $value):
				echo $value->id;
			endforeach;
		}
	}

	function getMaxUserId()
	{
		echo $this->mapi->getMaxUserId();
	}

	//Функция получения индекса пользователя
	function getUserISRZ()
	{
		$this->form_validation->set_rules('user_id', 'Ключ', 'required');
		if($this->form_validation->run() == FALSE)
		{
			echo "error";
		}
		else
		{
			$user_id = $this->input->post('user_id');
			//Проверить, существует ли этот пользователь и не заблокирован ли он
			$account = $this->mapi->checkUserAccount($user_id);
			if (isset($account[0]))
			{
				echo $user_id."> ".$account[0]['lastname']." ".$account[0]['firstname']."\n";
				
				//Найти все вопросы, на которые отвечал пользователь
				$this->load->model('results_model');
				
				//Получить количество пройденных пользователем тестов
				$results = $this->results_model->getAllStudTests($user_id);
				
				//определить тип образовательного учреждения, в котором учится пользователь
				$type_r = $this->results_model->getUserTypeROverUserID($user_id);

				//Инициализация индекса сложности решённых задач
				$isrz = 0;
				//Если количество тесто больше 4, то считать рейтинг
				if (count($results) > 4)
				{
					for($i = 1;$i < 5;$i++)
					{
						$diff[$i] = $this->results_model->getUserAnswersOverDifficult($user_id,$i);
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
					//Округлить полученный коэффициент до 3 знаков после запятой
					$isrz = round($isrz,3);
					$this->load->model('reyting_model');
					
					//Если учётная запись принадлежит суперадминистратору, то не обновлять рейтинг
					if (!(($user_id == 1) || ($user_id == 1060)))
					{
						//Обновить индекс в базе данных
						$this->reyting_model->updateUserIndexOfDifficult($user_id,$isrz);
						echo "Индекс пользователя обновлён: ".$isrz."\n";
					}
					else
					{
						echo "Учётная запись администратора\n";
					}
				}
				else
				{
					echo "Тестов меньше 5, рейтинг рассчитываться не будет\n";
				}
			}
			else
			{
				echo $user_id."> Пользователя нет или он заблокирован\n";
			}
		}
	}

	function updateRateResortDate()
	{
		$this->load->model('reyting_model');
		$this->reyting_model->updateRateResortDate();
		echo "Дата пересортировки рейтинга обновлена";
	}

	//Функция получения места пользователя в рейтинге
	function getUserReyt()
	{
		$this->form_validation->set_rules('user_id', 'Ключ', 'required');
		if($this->form_validation->run() == FALSE)
		{
			echo "error";
		}
		else
		{
			$user_id = $this->input->post('user_id');
			//Проверить, существует ли этот пользователь и не заблокирован ли он
			$account = $this->mapi->checkUserAccount($user_id);
			if (isset($account[0]))
			{
				echo $user_id."> ".$account[0]['lastname']." ".$account[0]['firstname']."\n";

				$isrz = $account[0]['isrz'];

				//Если индекс больше нуля, то просчитать места
				if ($isrz > 0)
				{
					//Найти все вопросы, на которые отвечал пользователь
					$this->load->model('results_model');
					$this->load->model('reyting_model');

					//определить тип образовательного учреждения, в котором учится пользователь
					$type_r = $this->results_model->getUserTypeROverUserID($user_id);

					//Узнать, сколько студентов набрали больший индекс
					$high_isrz = $this->reyting_model->getCountIndexOfDifficult($isrz,1,$type_r);
					
					//Выбрать последнюю запись рейтинга пользователя
						//Если такой нет, то создать запись
						//Если запись есть и при этом рейтинг не совпадает, то смотреть на дату
						//Если дата совпадает с сегодняшней, то перезаписать рейтинг
						//Если дата не совпадает с сегодняшней, то создать запись

					$rank = $high_isrz + 1;

					$last_result = $this->reyting_model->getLastReytingRecordOverUserId($user_id);
					
					if (isset($last_result))
					{
						$date = date("Y, n-1, d");
						if ($last_result['reyt'] != $rank)
						{
							$delta = $last_result['reyt'] - $rank;
							$forecast = 0.1 * $last_result['forecast'] + 0.9 * $isrz;
							if ($last_result['date'] == $date)
							{
								//Перезаписать рейтинг
								$this->reyting_model->updateStudReyt($last_result['id'],$rank,$isrz,$forecast);
								echo "Рейтинг уже был составлен сегодня, но пользователь изменил позицию в рейтинге на ".$delta." позиций. Теперь он занимает ".$rank." место\n";
							}
							else
							{
								$this->reyting_model->addStudReyt($user_id,$rank,$isrz,$forecast);
								echo "Пользователь изменил позицию в рейтинге на ".$delta." позиций. Теперь он занимает ".$rank." место\n";
							}
						}
						else
						{
							echo "Позиция пользователя в рейтинге не изменилась. Он занимает ".$rank." место\n";
						}
					}
					else
					{
						$this->reyting_model->addStudReyt($user_id,$rank,$isrz,$isrz);
						echo "Пользователь впервые участвует в рейтинге. Теперь он занимает ".$rank." место\n";
					}
				}
				else
				{
					echo "Индекс для пользователя не вычислялся";
				}
			}
			else
			{
				echo $user_id."> Пользователя нет или он заблокирован\n";
			}
		}
	}

	function vk_send_notification()
	{
		$this->form_validation->set_rules('user_id', 'Ключ', 'required');
		if($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('answer'=>0));
		}
		else
		{
			$user_id = $this->input->post('user_id');
			$msg = $this->input->post('msg');

			$api_id = 2849330; // id приложения 
    		$secret_key = 'LXGYFTULRHhxoYQ5vExI'; // защищенный ключ
    		
    		require_once(APPPATH.'libraries/vkapi.php');

    		$VK = new vkapi($api_id, $secret_key);
    		
    		$data = time();
    		$rnd = rand();

    		//$msg = urlencode($msg);
    		$msg = "hello";

    		$resp = $VK->api('secure.sendNotification', array('message'=>$msg,'timestamp'=>$data,'uids'=>$user_id),$api_id,$secret_key);
    		//$data = strtotime($data);
    		//md5("api_id=".$api_id."message=".$message."method=".$method."random=".$random."timestamp=".$timestamp."uids=".$uids."v=".$version.$secret);
    		//{"access_token":"0b224e2c0b224e2c0b0c5d903e0b09341e00b220b224e2c5845074a25150960496599ea","expires_in":0}
    		echo json_encode(array('answer'=>$resp,'date'=>$data,'msg'=>$msg));	
		}
	}

	function php_stat()
	{
		$url = 'http://flapps.ru/';  
		$ch = curl_init();
		echo $ch;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$page = curl_exec ($ch);
		curl_close($ch);  
		echo $page; 
	}

}