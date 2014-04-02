<?php

class Plans extends CI_Controller {

	function Plans()
	{
		parent::__construct();
		
	}

	//Проверка сессии и инициализация модели с учебными планами
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
				$this->load->model('plans_model');
				$this->$method();
			}
		}
	}

	//Запуск вьювера с планами ФСПО
	function view($error = "")
	{
		
		$data['disciplines'] = $this->plans_model->getDisciplines($this->uri->segment(3));
		switch ($this->uri->segment(3))
		{
			case '1': $data['dest_name'] = "Дисциплины НИУ ИТМО ФСПО"; break;
			case '2': $data['dest_name'] = "Дисциплины НОУ СЕГРИС-ИИТ"; break;
			case '3': $data['dest_name'] = "Универсальные дисциплины"; break;
			default: $data['dest_name'] = "Дисциплины НИУ ИТМО ФСПО"; break;
		}
		$data['dest'] = $this->uri->segment(3);
		$data['error'] = $error;
		$this->load->view('plans/plans_disc_view',$data);
	}

	function create_disc()
	{
		$type_r = $this->uri->segment(3);
		$this->form_validation->set_rules('disc_name', 'Название дисциплины', 'trim|required|xss_clean');
		$this->form_validation->set_rules('comment', 'Комментарий к дисциплине', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать дисциплину не удалось";
		}
		else
		{
			$this->plans_model->create_disc($type_r);
			$error = "Дисциплина успешно создана";
		}
		$this->view($error);
	}

	function edit($error = "")
	{
		$data['error'] = $error;
		$data['disciplin'] = $this->plans_model->getDisciplin($this->uri->segment(4));
		switch ($this->uri->segment(3))
		{
			case '1': $data['dest_name'] = "Дисциплины НИУ ИТМО ФСПО"; break;
			case '2': $data['dest_name'] = "Дисциплины НОУ СЕГРИС-ИИТ"; break;
			case '3': $data['dest_name'] = "Универсальные дисциплины"; break;
			default: $data['dest_name'] = "Дисциплины НИУ ИТМО ФСПО"; break;
		}
		$data['dest'] = $this->uri->segment(3);
    	$data['id_disc'] = $this->uri->segment(4);
		$this->load->view('plans/plans_disc_edit_view',$data);
	}

	function disc_del()
	{
		$this->plans_model->delDisc();
		$this->view("Дисциплина успешно удалена");
	}

	//Обработка запроса по изменению информации о дисциплине
	function disc_edit()
	{	
		$this->form_validation->set_rules('disc_name', 'Название дисциплины', 'trim|required|xss_clean');
		$this->form_validation->set_rules('comment', 'Комментарий к дисциплине', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Обновить информацию о дисциплине не удалось";
		}
		else
		{
			$this->plans_model->edit_disc();
			$error = "Информация о дисциплине обновлена";
		}
		$this->view($error);
	}

	function disc_view($error = "")
	{
		$data['error'] = $error;
		$data['disciplin']=$this->plans_model->getDisciplin($this->uri->segment(4));
		$data['themes']=$this->plans_model->getThemes($this->uri->segment(4));
    	$data['id_disc']=$this->uri->segment(4);
		switch ($this->uri->segment(3))
		{
			case '1': $data['dest_name'] = "Дисциплины НИУ ИТМО ФСПО"; break;
			case '2': $data['dest_name'] = "Дисциплины НОУ СЕГРИС-ИИТ"; break;
			case '3': $data['dest_name'] = "Универсальные дисциплины"; break;
			default: $data['dest_name'] = "Дисциплины НИУ ИТМО ФСПО"; break;
		}
		$data['dest'] = $this->uri->segment(3);
		$this->load->view('plans/plans_disc_themes_view',$data);
	}

	function theme_del()
	{
		$this->plans_model->delTheme($this->uri->segment(5));
		$this->disc_view("Тему успешно удалена из дисциплины");
	}

	function theme_edit()
	{
		$this->form_validation->set_rules('th_name', 'Название дисциплины', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить тему не удалось";
		}
		else
		{
			$this->plans_model->editTheme();
			$error = "Информация о теме обновлена";
		}
		$this->disc_view($error);
	}

	function create_theme()
	{
		$this->form_validation->set_rules('th_name', 'Название темы', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать тему не удалось";
		}
		else
		{
			$this->plans_model->createTheme();
			$error = "Тема успешно создана";
		}
		$this->disc_view($error);
	}
}

?>