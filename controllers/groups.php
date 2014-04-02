<?php

class Groups extends CI_Controller {

	function Groups()
	{
		parent::__construct();
		
	}

	//Проверка сессии и загрузка модели
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
				$this->load->model('groups_model');
				$this->$method();
			}
		}
	}

	//Запуск вьювера с группами ФСПО
	function fspo($error = "")
	{
		$data['groups'] = $this->groups_model->getFSPO();
		$data['error'] = $error;
		$this->load->view('groups_fspo_view',$data);
	}

	//Обработка запроса по изменению групп
	function fspo_edit()
	{
		$this->form_validation->set_rules('old_name', 'Старое название группы', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Обновить информацию о группе не удалось";
		}
		else
		{
			$this->groups_model->editFSPO();
			$error = "Информация о группе обновлена";
		}
		$this->fspo($error);
	}

	//Удаление группы ФСПО НИУ ИТМО
	function fspo_del()
	{
		$this->groups_model->delGroup();
		$this->fspo("Группа удалена");
	}

	//Добавление группы ФСПО НИУ ИТМО
	function fspo_create()
	{
		$this->form_validation->set_rules('old_name', 'Название группы', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать группу не удалось";
		}
		else
		{
			$this->groups_model->createFSPO();
			$error = "Группа успешно создана";
		}
		$this->fspo($error);
	}

	//Запуск вьювера с группами ФСПО
	function segrys($error = "")
	{
		$text = $this->groups_model->getSegrys();
		$data['groups'] = $text[0];
		$data['plosh'] = $text[1];
		$data['prepods'] = $text[2];
		$data['error'] = $error;
		$this->load->view('groups_segrys_view',$data);
	}

	//Изменение информации о группе НОУ "Сегрис-ИИТ"
	function segrys_edit()
	{
		$this->form_validation->set_rules('old_name', 'Старое название группы', 'trim|required|xss_clean');
		$this->form_validation->set_rules('date_end', 'Дата окончания', 'trim|required|xss_clean|is_natural');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Обновить информацию о группе не удалось";
		}
		else
		{
			$this->groups_model->editSegrys();
			$error = "Информация о группе обновлена";
		
		}
		$this->segrys($error);
	}

	//Удаление группы НОУ "Сегрис-ИИТ"
	function segrys_del()
	{
		$this->groups_model->delGroup();
		$this->segrys("Группа заархивирована");
	}

	//Добавление группы НОУ "Сегрис-ИИТ"
	function segrys_create()
	{
		$this->form_validation->set_rules('old_name', 'Название группы', 'trim|required|xss_clean');
		$this->form_validation->set_rules('date_end', 'Дата окончания', 'trim|required|xss_clean|is_natural');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать группу не удалось";
		}
		else
		{
			$this->groups_model->createSegrys();
			$error = "Группа успешно создана";
		}
		$this->segrys($error);
	}
}

?>