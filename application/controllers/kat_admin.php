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

	public function view_materials($error = "")
	{
		//Загрузить из БД все материалы
		$data['error'] = $error;
		$data['materials'] = $this->kat_model->getAllMaterials();
		$this->load->view('kat/kat_view_materials_view',$data);
	}


	public function edit_material()
	{
		$this->form_validation->set_rules('edit_id', '', 'required|numeric|is_natural');
		$this->form_validation->set_rules('edit_name', '', 'xss_clean|required');
		$this->form_validation->set_rules('edit_content', '', 'xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->view_materials("Поля были заполнены некорректно");
		}
		else
		{
			$content = $this->input->post('edit_content');
			$name = $this->input->post('edit_name');
			$id = $this->input->post('edit_id');
			$this->kat_model->updateMaterial($id,$name,$content);
			$this->view_materials("Материал \"$name\" изменён");	
		}	
	}

		public function edit_accordance()
	{
		/*$this->form_validation->set_rules('id_mat', '', 'required|numeric');
		$this->form_validation->set_rules('accordance_percents', '', 'required|numeric|is_natural');
		$this->form_validation->set_rules('sel_theme', '', 'required|numeric');
		if ($this->form_validation->run() == FALSE)
		{
			$this->view_materials("Поля были заполнены некорректно");
		}
		else
		{ */
			$id_mat = $this->input->post('id_mat');
			$id_th = $this->input->post('sel_theme');
			$accordance = $this->input->post('accordance_percents');
			$this->kat_model->setAccordance($id_mat,$id_th,$accordance);
			$this->view_materials("Добавлено новое соответствие");	
		//}	
	}
	public function edit_according($error = "")
	{
		
		$id_mat = $this->uri->segment(3);
		$data['error'] = $error;
		$data['currentmat'] = $this->kat_model->getCurrentMat($id_mat);
		$data['accordances'] = $this->kat_model->getAllAccordance($id_mat);
		$data['themeslist'] = $this->kat_model->getAllThemes();
		$data['id_mat'] = $id_mat;
		$this->load->view('kat/kat_view_edit_according',$data);
		
	}

	public function delete_accordance()
	{
		$id = $this->input->post('delete_id');
		$this->kat_model->deleteAccordance($id);
		$this->edit_according("Соответствие удалено");	
	}

	public function delete_material()
	{			
				$this->form_validation->set_rules('delete_id', '', 'required|numeric|is_natural');
					if ($this->form_validation->run() == FALSE)
				{
					$this->view_materials("Поля были заполнены некорректно");
				}
					else
				{
					$id = $this->input->post('delete_id');
					$this->kat_model->deleteMaterial($id);
					$this->view_materials("Материал удален");
				}

	}
	
}