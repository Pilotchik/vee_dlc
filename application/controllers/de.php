<?php

class De extends CI_Controller {

	function De()
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
			$this->load->model('de_model');
			$this->$method();
		}
	}

	//Функция отображения главной страницы
	function index()
	{
		$data['disciplines'] = $this->de_model->getAllDiscCourses();
		$data['error'] = "";
		$this->load->view('de/de_disc_courses_view',$data);
	}

	function view_courses($error = "")
	{
		$user_id = $this->session->userdata('user_id');
		//ID дисциплины
		$data['disc_id'] = $this->uri->segment(3);
		//Узнать информацию по курсам дисциплины
		$this->load->model('plans_model');
		$data['disc_name'] = $this->plans_model->getDisciplin($this->uri->segment(3));
		$data['courses_uncompleted'] = $this->de_model->getUserCourse($this->uri->segment(3),$user_id,0);
		$data['courses_completed'] = $this->de_model->getUserCourse($this->uri->segment(3),$user_id,1);
		$data['error'] = $error;
		$this->load->view('de/de_courses_view',$data);
	}

	function play_course()
	{
		$this->form_validation->set_rules('course_id', 'ID курса', 'trim|xss_clean|required|is_natural_no_zero');
		$this->form_validation->set_rules('course_key', 'Ключ', 'trim|xss_clean|required');
		if ($this->form_validation->run() == TRUE)
		{
			$course_id = $this->input->post('course_id');
			$course_key = $this->input->post('course_key');
			//Получить настоящий код курса
			$true_code = $this->de_model->getCourseCode($course_id);
			if ($course_key != $true_code)
			{
				$error = "Неверный ключ";
				$this->view_courses($error);
			}
			else
			{
				//Проверить, создана ли запись о начале курса
				if (count($this->de_model->getUserCourseStatus($course_id)) == 0)
				{
					//Создать отметку о начале курса в таблице new_crs_results
					$this->de_model->addUserCourse($course_id);	
				}
				//Показать лекции и их статус (редирект на функцию продолжения курса)
				$this->continue_course($course_id);
			}
		}
		else
		{
			$error = "Введённые параметры некорректны, беда";
			$this->view_courses($error);
		}
	}

	function continue_course($course_id = "")
	{
		if ($course_id == "")
		{
			$this->form_validation->set_rules('course_id', 'ID курса', 'trim|xss_clean|required|is_natural_no_zero');
			if ($this->form_validation->run() == TRUE)
			{	
				$course_id = $this->input->post('course_id');
			}
			else
			{
				$error = "Введённые параметры некорректны, беда";
				$this->view_courses($error);
			}	
		}
		//Название курса
		$data['course_name'] = $this->de_model->getCourse($course_id);
		$data['disc_id'] = $this->de_model->getDiscIDOverCourseID($course_id);
		$data['disc_name'] =  $this->de_model->getDiscNameOverID($data['disc_id']);
		//выбрать все доступные лекции и узнать их статус
		$data['lections'] = $this->de_model->getUserCourseLect($course_id);
		//Получение информации о прохождении лекции конкретным пользователем
		$i = 0;
		$status[0] = 0;
		$data['block'][0] = 0;
		foreach ($data['lections'] as $key)
		{
			//Если статус предыдущей лекции = 1 (Закончена), то разблокировать текущую
			if ($i>0)
			{
				if ($status[$i-1] == 1)
				{
					//Блокировка отключена
					$data['block'][$i] = 0;
				}
				else
				{
					$data['block'][$i] = 1;	
				}
			}
			$data['lect_info'][$key['id']] = $this->de_model->getLectStatus($key['id']);
			if (count($data['lect_info'][$key['id']]) > 0)
			{
				if ($data['lect_info'][$key['id']]['timeend'] != 0)
				{
					//Статус оконченности
					$status[$i] = 1;
				}
				else
				{
					$data['block'][$i] = 0;
				}
			}
			else
			{
				$status[$i] = 0;
			}
			$i++;
		}
		$data['id_course'] = $course_id;
		$data['error'] = "";
		//Запуск вьювера со списком лекций и их статусом
		$this->load->view('de/de_course_lection_view',$data);
	}

	function view_lection()
	{
		$error = "";
		//Узнать ID пользователя
		$user_id = $this->session->userdata('user_id');
		//Узнать ID лекции
		$data['lection_id'] = $this->uri->segment(3);
		//Узнать ID курса
		$this->form_validation->set_rules('course_id', 'ID курса', 'trim|xss_clean|required|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{	
			$course_id = $this->input->post('course_id');
		}
		else
		{
			$error = "Параметры некорректны, беда";
		}
		//Проверить, есть ли такая лекция в курсе
		if (count($this->de_model->checkLectInCourse($course_id,$data['lection_id'])) == 0)
		{
			$error = "Нет такой лекции в этом курсе";
		}
		//Проверить, создана ли запись о начале курса
		if (count($this->de_model->getUserCourseStatus($course_id)) == 0)
		{
			$error = "У Вас нет доступа к этой лекции";
		}
		if ($error != "")
		{
			//Если имеется ошибка
			$this->view_courses($error);
		}
		else
		{
			//Запись информации о начале чтения лекции, если такой информации ещё нет
			if (count($this->de_model->checkUserLectInCourse($data['lection_id'])) == 0)
			{
				$this->de_model->addUserLectInCourse($data['lection_id']);
			}
			$data['lect_info'] = $this->de_model->getLectionContent($data['lection_id']);
			$data['lect_status'] = $this->de_model->getLectStatus($data['lection_id']);
			//Статус сдачи теста
			$data['test_sdan'] = 0;
			//ID дисциплины, в которой проходится обучение
			$data['disc_id'] = 0;
			//Если предусмотрен тест, то проверить был ли он пройдён заранее
			if ($data['lect_info']['test_id'] != 0)
			{
				//Узнать id дисциплины, в которой сдаётся тест
				$data['disc_id'] = $this->de_model->getDiscId($data['lection_id']);
				//Передать test_key и id лекции в качестве токена на завершение прохождения
				$data['test_key'] = $this->de_model->getTestKey($data['lect_info']['test_id']);
				$test_result = $this->de_model->searchTestResult($data['lect_info']['test_id']);
				if (count($test_result) > 0)
				{
					//Если был пройден тест, то записать результат в new_lect_results
					$this->de_model->addTestResultInLect($test_result[0]['id'],$data['lection_id']);
					$data['test_sdan'] = 1;
				}
			}
			$data['course_id'] = $course_id;
			$this->load->view('de/de_one_lection_view',$data);		
		}
	}

	function end_lection()
	{
		$error = "";
		$this->form_validation->set_rules('course_id', 'ID курса', 'trim|xss_clean|required|is_natural_no_zero');
		if ($this->form_validation->run() == TRUE)
		{	
			$course_id = $this->input->post('course_id');
			$lection_id = $this->input->post('lection_id');
			//Проверить, есть ли такая лекция в курсе
			if (count($this->de_model->checkLectInCourse($course_id,$lection_id)) == 0)
			{
				$error = "Нет такой лекции в этом курсе";
			}
			//Проверить, создана ли запись о начале курса
			if (count($this->de_model->getUserCourseStatus($course_id)) == 0)
			{
				$error = "У Вас нет доступа к этой лекции";
			}
		}
		else
		{
			$error = "Параметры некорректны, беда";
		}
		if ($error != "")
		{
			//Если имеется ошибка
			$this->view_courses($error);
		}
		//Записать новый статус лекции new_lect_results
		$this->de_model->updateUserLectInCourse($lection_id);
		/*
					Обновить таблицу с результатами курса: new_crs_results
		*/
		$course_id = $this->de_model->getCourseWhereLection($lection_id);
		//1. Узнать количество лекций в курсе
		$lection_count = $this->de_model->getLectionCount($course_id);
		//2. Узнать количество завершённых лекций
		$lection_count_close = $this->de_model->getLectionCountClose($course_id);
		//3. Узнать количество набранных процентов в тестах и вычислить среднее
		$balls_course = $this->de_model->getAVGTestResults($course_id);
		//Обновить количество процентов и если 100, то обновить статус
		$proz_course = round(($lection_count_close/$lection_count)*100,2);
		if ($proz_course > 99)
		{
			//Обучение завершено
			$this->de_model->updateCourseResult($course_id,$proz_course,$balls_course,1);
			$this->load->model('main_model');
			$msg = "Пройден дистанционный курс \"".$this->de_model->getNameCourse($course_id)."\"";
			$this->main_model->createLogRecord($msg,2);
		}
		else
		{
			$this->de_model->updateCourseResult($course_id,$proz_course,$balls_course,0);
		}

		//Показать курс с лекциями
		$this->continue_course($course_id);
	}

}