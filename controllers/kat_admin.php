<?php

class Kat_admin extends CI_Controller {

	function Kat_admin()
	{
		parent::__construct();
	}

	function _remap($method)
	{
		//Проверка существования сессии
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
				redirect('/main/auth/', 'refresh');
			}	
			else
			{
				//Загрузка общих моделей всего контроллера
				$this->load->model('kat_model');
				$this->$method();
			}
		}
	}

	function index()
	{
		redirect('/main/auth/', 'refresh');
	}

	//Просмотр всех дисциплин
	function dest_view($error = "")
	{
		switch ($this->uri->segment(3))
		{
			case 'fspo': $dest=1; break;
			case 'segrys': $dest=2;	break;
			case 'psih': $dest=3; break;
			default: $dest=1; break;
		}
		$data['disciplines'] = $this->kat_model->getAllDisciplines($dest);
		foreach ($data['disciplines'] as $key)
		{
			//Все материалы дисциплины
			$data['materials'][$key['id']] = $this->kat_model->getMaterials($key['id']);
		}
		$data['error'] = $error;
		$data['dest']=$this->uri->segment(3);
		$this->load->view('kat/kat_admin_disc_view',$data);
	}

	//Добавление лекций
	function mat_create()
	{
		$config['upload_path'] = './images/'; // путь к папке куда будем сохранять изображение
		$config['allowed_types'] = 'gif|jpg|png|doc|ppt|xls|pdf|txt|rtf|xlsx|docx|pptx|zip|rar|vsd|py'; // разрешенные форматы файлов
		$config['max_size']	= 50000; // максимальный вес файла
        $config['encrypt_name'] = FALSE; // переименование файла в уникальное название
		$config['remove_spaces'] = TRUE; // убирает пробелы из названия файлов
 		
        $this->load->library('upload', $config); // загружаем библиотеку
       	$this->upload->do_upload(); // вызываем функцию загрузки файла
        $upload_data = $this->upload->data(); // получаем информацию о загруженном файле
        print_r($upload_data);
        $file_name = $upload_data['file_name'];

		$this->form_validation->set_rules('mat_name', 'Название', 'trim|xss_clean|required');
		$this->form_validation->set_rules('disc_id', 'Название', 'trim|xss_clean|required|is_natural');
		$this->form_validation->set_rules('area', 'Контент', '');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Добавить материал не удалось";
			$this->dest_view($error);	
		}
		else
		{
			$name = $this->input->post('mat_name');
			$disc_id = $this->input->post('disc_id');
			$this->kat_model->createMat($file_name,$name,$disc_id);
			$c_name = $this->kat_model->getNameOfDisc($disc_id);
			$error = "В дисциплину \"".$c_name."\". добавлен справочный метериал \"$name\".";
			$this->_add_to_log($error);
			$this->dest_view($error);
		}
	}

	function mat_edit()
	{
		$this->form_validation->set_rules('mat_id', 'Значение', 'required|is_natural');
		$this->form_validation->set_rules('mat_value', 'Значение', 'required');
		$this->form_validation->set_rules('mat_param', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры учебного материала не удалось";
		}
		else
		{
			$this->kat_model->editMat();
			$error = "";
		}
		$this->dest_view($error);
	}

	function mat_del()
	{
		$this->de_model->delLection();
		$this->view_course("Лекция удалена");
	}

	function _add_to_log($msg = "")
	{
		$this->load->model('main_model');
		$this->main_model->createLogRecord($msg,3);
	}
	
}