<?php

class Tests extends CI_Controller {

	function Tests()
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
				$data['firstname']=$this->session->userdata('firstname');
				$data['guest']=$guest;
				$data['error']="У вас недостаточно прав";
				$this->load->view('index_view',$data);	
			}
			else
			{
				$this->load->model('tests_model');
				$this->load->model('plans_model');
				$this->load->model('groups_model');
				$this->$method();
			}
		}
	}

	function index()
	{
		$data['error']="Необходима авторизация";
		$this->load->view('main_view',$data);
	}

	//Функция отображения кодов для тестов
	function kods($error="")
	{
		$text=$this->tests_model->getKods();
		$data['kods'] = $text;
		$data['error'] = $error; 
		$this->load->view('tests/tests_kods_view',$data);
	}

	function kod_edit()
	{
		$this->form_validation->set_rules('q_value', 'Значение', 'trim|xss_clean|required');
		$this->form_validation->set_rules('q_param', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить код не удалось";
		}
		else
		{
			$this->tests_model->editTest();
			$name = $this->tests_model->getRazdel($this->input->post('q_id'));
			$disc_name = $this->tests_model->getDiscNameOverTestID($this->input->post('q_id'));
			$this->_add_to_log("Изменён ключ для теста \"".$name[0]['name_razd']."\" дисциплины \"$disc_name\"");
			$error = "";
		}
		$this->kods($error);
	}


	function dest_view()
	{
		switch ($this->uri->segment(3))
		{
			case 'fspo': $dest=1; break;
			case 'segrys': $dest=2;	break;
			case 'psih': $dest=3; break;
			default: $dest=1; break;
		}
		$data['disciplines'] = $this->plans_model->getDisciplines($dest);
		$data['error'] = "";
		$data['dest'] = $this->uri->segment(3);
		$this->load->view('tests/tests_disc_view',$data);
	}

	function target_tests()
	{
		switch ($this->uri->segment(3))
		{
			case 'fspo': $dest=1; $data['groups'] = $this->groups_model->getFSPO(); break;
			case 'segrys': $dest=2; $text=$this->groups_model->getSegrys();	$data['groups']=$text[0];	break;
			case 'psih': $dest=3; $data['groups']=$this->groups_model->getAllGroups(); break;
			default: $dest=1; break;
		}
		$data['error'] = "";
		$data['tests'] = "";
		$this->load->view('tests/tests_target_view',$data);
	}

	function disc_view($error="")
	{
		$data['error']="";
		$data['disciplin'] = $this->plans_model->getDisciplin($this->uri->segment(4));
		$data['razdels'] = $this->plans_model->getRazdels($this->uri->segment(4));
    	$data['id_disc'] = $this->uri->segment(4);
    	$data['dest'] = $this->uri->segment(3);
		$this->load->view('tests/tests_disc_tests_view',$data);
	}

	function test_edit()
	{
		$this->form_validation->set_rules('q_value', 'Значение', 'trim|xss_clean|required');
		$this->form_validation->set_rules('q_param', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры теста не удалось";
		}
		else
		{
			$this->tests_model->editTest();
			$name = $this->tests_model->getRazdel($this->input->post('q_id'));
			$disc_name = $this->tests_model->getDiscNameOverTestID($this->input->post('q_id'));
			$this->_add_to_log("Изменены параметры теста \"".$name[0]['name_razd']."\" дисциплины \"$disc_name\"");
			$error = "";
		}
		$this->disc_view($error);
	}

	//Удаление теста
	function del_test()
	{
		$this->tests_model->delTest();
		$name = $this->tests_model->getRazdel($this->input->post('r_id'));
		$disc_name = $this->tests_model->getDiscNameOverTestID($this->input->post('r_id'));
		$this->_add_to_log("Из дисциплины \"$disc_name\" удалён тест \"".$name[0]['name_razd']."\"");
		$error = "Тест удалён";
		$this->disc_view($error);
	}

	//Создание теста
	function create_test()
	{
		$this->form_validation->set_rules('test_name', 'Название', 'trim|xss_clean|required');
		$this->form_validation->set_rules('comment', 'Комментарий', 'trim|xss_clean');
		$this->form_validation->set_rules('test_time', 'Время на тест', 'trim|xss_clean|numeric|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать тест не удалось. Имеются ошибки в полях";
		}
		else
		{
			$this->tests_model->createTest($this->uri->segment(4));
			$disc_name = $this->tests_model->getDiscNameOverID($this->uri->segment(4));
			$this->_add_to_log("Создан тест \"".$this->input->post('test_name')."\" для дисциплины \"$disc_name\"");
			$error = "";
		}
		$this->disc_view($error);
	}

	//Приватная функция запуска вьювера tests_nabor_view
	function _test_nabor_run($error="")
	{
		$data['error']=$error;
		$data['disciplin']=$this->plans_model->getDisciplin($this->uri->segment(4));
		$data['razdel']=$this->tests_model->getRazdel($this->uri->segment(5));
		$data['questions']=$this->tests_model->getQuests($this->uri->segment(5));
		//Получить варианты
		$data['vars']=$this->tests_model->getVariants($this->uri->segment(5));
		foreach ($data['vars'] as $key)
		{
			//Получить количество вопросов одного варианта
			$all = $this->tests_model->getCountQuestVar($this->uri->segment(5),$key['variant']);
			//Получить по каждому варианту распределение сложности
			for ($i=0;$i<5;$i++)
			{
				$data['vars_array'][$key['variant']]['abs'][$i] = $this->tests_model->getCountLevelVar($this->uri->segment(5),$key['variant'],$i);
				$data['vars_array'][$key['variant']]['otn'][$i] = round(($data['vars_array'][$key['variant']]['abs'][$i]/$all)*100,2);
			}
		}
		//Получение всех вопросов в дисциплине
		$data['all_quests']=$this->tests_model->getAllQuests($this->uri->segment(4),$this->uri->segment(5));
		$data['themes']=$this->plans_model->getThemes($this->uri->segment(4));
    	$data['id_disc']=$this->uri->segment(4);
    	$data['id_test']=$this->uri->segment(5);
		$data['dest']=$this->uri->segment(3);
		$this->load->view('tests/tests_disc_tests_quests_view',$data);
	}

	//Просмотр вопросов теста
	function test_view()
	{
		$error = "";
		$this->_test_nabor_run($error);
	}

	function quest_del()
	{
		$this->tests_model->delQuest();
		$error="Вопрос удалён";
		$this->_test_nabor_run($error);
	}

	function quest_edit()
	{
		$this->form_validation->set_rules('q_value', 'Уровень', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить вопрос не удалось";
		}
		else
		{
			$this->tests_model->editQuest();
			$error = "";
		}
		$this->_test_nabor_run($error);
	}

	function test_full_view()
	{
		$data['error'] = "";
		$data['disciplin'] = $this->plans_model->getDisciplin($this->uri->segment(4));
		$data['razdel'] = $this->tests_model->getRazdel($this->uri->segment(5));
		$data['questions'] = $this->tests_model->getQuests($this->uri->segment(5));
		foreach ($data['questions'] as $key) {
			$data['answers'][$key['id']] = $this->tests_model->getAnswers($key['id']);
		}
		$data['themes'] = $this->plans_model->getThemes($this->uri->segment(4));
    	$data['id_disc'] = $this->uri->segment(4);
    	$data['id_test'] = $this->uri->segment(5);
		$data['dest'] = $this->uri->segment(3);
		$this->load->view('tests/tests_full_view',$data);
	}

	function answers_view($error = "")
	{
		$data['error'] = $error;
		$data['quest']=$this->tests_model->getQuest($this->uri->segment(6));
		$data['answers'] = $this->tests_model->getAnswers($this->uri->segment(6));
		$data['id_disc']=$this->uri->segment(4);
    	$data['id_test']=$this->uri->segment(5);
    	$data['id_quest']=$this->uri->segment(6);
		$data['dest']=$this->uri->segment(3);
		$this->load->view('tests/tests_answers_view',$data);
	}

	function answer_edit()
	{
		$this->form_validation->set_rules('a_value', 'Уровень', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error="Изменить ответ не удалось";
		}
		else
		{
			$this->tests_model->editAnswer();
			$error = "Ответ обновлён";
		}
		$this->answers_view($error);
	}

	function create_quest()
	{
		$data['id_disc']=$this->uri->segment(4);
	    $data['id_test']=$this->uri->segment(5);
		$data['dest']=$this->uri->segment(3);
		$config['upload_path'] = './images/'; // путь к папке куда будем сохранять изображение
		$config['allowed_types'] = 'gif|jpg|png'; // разрешенные форматы файлов
		$config['max_size']	= 2000; // максимальный вес файла
        $config['encrypt_name'] = TRUE; // переименование файла в уникальное название
		$config['remove_spaces'] = TRUE; // убирает пробелы из названия файлов
 		
        $this->load->library('upload', $config); // загружаем библиотеку
       	$this->upload->do_upload(); // вызываем функцию загрузки файла
        $upload_data = $this->upload->data(); // получаем информацию о загруженном файле        
      	$file_name = $upload_data['file_name']; // сохраняем имя файла
       
		$this->form_validation->set_rules('q_text', 'Текст', 'trim|xss_clean|required');
		$this->form_validation->set_rules('q_type', 'Тип', 'trim|xss_clean|required|less_than[7]');
		$this->form_validation->set_rules('q_theme', 'Тема', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('q_var', 'Вариант', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('q_kol_a', 'Ответы', 'trim|xss_clean|required|numeric');

		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать вопрос не удалось, проверьте правильность ввода, кроме того, размер файла не должен превышать 2 МБ";
			$this->_test_nabor_run($error);	
		}
		else
		{
       		$data['error']="Вопрос создан, добавьте ответы";
       		//Узнать последний номер в тесте и увеличить на единицу
       		$max_number = $this->tests_model->getMaxTestNumber($this->uri->segment(5));
       		if ($max_number>=1)
       		{
       			$max_number++;
       		}
       		else
       		{
       			$max_number = 1;
       		}
       		//Текст вопрос
       		$q_text = $this->input->post('q_text');
       		//Тип вопроса
			$q_type = $this->input->post('q_type');
			//Тема вопроса
			$q_theme = $this->input->post('q_theme');
			//Вариант вопроса
			$q_var = $this->input->post('q_var');
			//Создание вопроса и получение его ID
       		$quest_id = $this->tests_model->createQuestOne($file_name,$this->uri->segment(5),$max_number,$q_text,$q_type,$q_theme,$q_var);
       		/*-------------Создание ответов--------------*/
       		//Массив с ответами
       		$ans = $this->input->post('ans');
			$quest_t = $this->input->post('quest_t');
			$true_a = $this->input->post('true_a');
			//Количество ответов
			$q_kol_a = $this->input->post('q_kol_a');
			$this->tests_model->createQuestTwo($this->uri->segment(5),$quest_id,$ans,$quest_t,$true_a,$q_type,$q_kol_a);
			$this->_test_nabor_run("Вопрос создан");
		}
	}

	function duplicate_quest()
	{
		$post_array = $this->input->post('dubl_q');
		$dubl_count = 0;
		foreach ($post_array as $key=>$value)
		{
			//Получить ID вопроса и скопировать сам вопрос и ответы для него
			//Проверить, есть ли уже такой скопированный вопрос в данном тесте
			$check = $this->tests_model->checkDublQuest($key,$this->uri->segment(5));
			if (count($check) == 0)
			{
				//1: Дублировать запись с конкретным ID
				$this->tests_model->dublQuest($key,$this->uri->segment(5));
				$dubl_count++;
				//Новый ID вопроса
				$new_id = $this->tests_model->checkDublQuest($key,$this->uri->segment(5));
				//Узнать ID ответов
				$ans_id = $this->tests_model->getAnswers($key);
				foreach ($ans_id as $key2)
				{
					//Дублировать ответы
					$this->tests_model->dublAnswer($key2['id'],$new_id[0]['id']);
				}
			}
			else
			{
				echo "Вопрос $key уже дублирован в текущий тест";	
			}
		}
		$error = "Скопировано ".$dubl_count." вопросов";
		$this->_test_nabor_run($error);
	}

	//Просмотр заблокированных тем
	function themes_block($error = "")
	{
		$data['error'] = $error;
		$data['disciplin']=$this->plans_model->getDisciplin($this->uri->segment(4));
		$data['razdel']=$this->tests_model->getRazdel($this->uri->segment(5));
		switch ($this->uri->segment(3))
		{
			case 'fspo': $data['groups'] = $this->groups_model->getFSPO(); break;
			case 'segrys': $text=$this->groups_model->getSegrys();	$data['groups']=$text[0];	break;
			case 'psih': $data['groups']=$this->groups_model->getAllGroups(); break;
			default: $data['groups']=$this->groups_model->getAllGroups(); break;
		}
		$data['block']=$this->groups_model->getBlock($this->uri->segment(5));
		$data['themes']=$this->plans_model->getThemes($this->uri->segment(4));
    	$data['id_disc']=$this->uri->segment(4);
    	$data['id_test']=$this->uri->segment(5);
		$data['dest']=$this->uri->segment(3);
		$this->load->view('tests/tests_block_view',$data);
	}

	function block_del()
	{
		$this->tests_model->delBlock();
		$error = "Блокировка удалена";
		$this->$themes_block($error);
	}

	function create_block()
	{
		$this->tests_model->addBlock($this->uri->segment(5));
		$error = "Блокировка добавлена";
		$this->$themes_block($error);
	}

	function _add_to_log($msg = "")
	{
		$this->load->model('main_model');
		$this->main_model->createLogRecord($msg,3);
	}

}

?>