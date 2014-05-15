<?php

class Comps_admin extends CI_Controller {

	function Comps_admin()
	{
		parent::__construct();
		
	}

	function _remap($method)
	{
		$guest=$this->session->userdata('guest');
		if (($guest == '') || ($guest < 2))
		{
			redirect('/', 'refresh');
		}	
		else
		{
			$this->load->model('comps_model');
			$this->load->model('attest_model');
			$this->load->model('forms_model');
			$this->$method();
		}
	}

	function index()
	{
		redirect('/', 'refresh');
	}


	function comps_menage($error = "")
	{
		$data['all_comps'] = $this->comps_model->getAllComps();
		$data['error'] = $error;
		$data['title'] = "ВОС.Управление компетенциями";
		$this->load->view('comps/comps_menage_view',$data);	
	}

	function comps_create()
	{
		$this->form_validation->set_rules('c_title', ' ', 'trim|xss_clean|required');
		$this->form_validation->set_rules('c_desc', ' ', 'trim|xss_clean|required');
		$this->form_validation->set_rules('c_prof', ' ', 'trim|xss_clean');
		$this->form_validation->set_rules('c_type', ' ', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать компетенцию не удалось";
		}
		else
		{
			$this->comps_model->createComp();
			$error = "Компетенция создана";
		}
		$this->comps_menage($error);
	}

	function comps_del()
	{
		$this->comps_model->delComp();
		$error = "Компетенция удалена";
		$data['all_comps'] = $this->comps_model->getAllComps();
		$this->comps_menage($error);
	}

	function comps_edit()
	{
		$this->form_validation->set_rules('c_value', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error ="Изменить параметры компетенции не удалось";
		}
		else
		{
			$this->comps_model->editComp();
			$error = "Компетенция обновлена";
		}
		$this->comps_menage($error);
	}

	function vklad_admin($error = "")
	{
		$data['all_comps'] = $this->comps_model->getAllComps();
		$data['all_disciplines'] = $this->attest_model->getDisciplines(1);
		$data['all_contributions'] = $this->comps_model->getAllContributions();
		foreach ($data['all_contributions'] as $key)
		{
			$data['proz'][$key['id']] = $key['contribution'];
			$summ = 0;
			$compet_record = $this->comps_model->getCompVklad($key['compet_id']);
			foreach($compet_record as $key2)
			{
				$summ += $key2['contribution'];
			}
			$data['proz'][$key['id']] = round(($data['proz'][$key['id']]/$summ)*100,2);
			$this->comps_model->updateContrProz($key['id'],$data['proz'][$key['id']]);
			$data['expert'][$key['id']] = $this->forms_model->getUser($key['expert_id']);
			$data['comp'][$key['id']] = $this->comps_model->getComp($key['compet_id']);
			$data['disc'][$key['id']] = $this->comps_model->getDiscParams($key['discipline_id']);
		}
		$data['error'] = $error;
		$data['title'] = "ВОС.Связь дисциплин и компетенций";
		$this->load->view('comps/comps_contribution_view',$data);
	}

	function vklad_create()
	{
		$this->form_validation->set_rules('c_disc', 'Дисциплина', 'trim|xss_clean|is_natural|required');
		$this->form_validation->set_rules('c_comp', 'Компетенция', 'trim|xss_clean|required|is_natural');
		$this->form_validation->set_rules('c_vklad', 'Вклад', 'trim|xss_clean|required|is_natural');
		$this->form_validation->set_rules('c_comm', 'Комментарий', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Создать связь не удалось";
		}
		else
		{
			$this->comps_model->createVklad();
			$error = "Связь создана";
		}
		$this->vklad_admin($error);
	}

	function vklad_del()
	{
		$this->comps_model->delVklad();
		$error = "Связь удалена";
		$this->vklad_admin($error);
	}

	function vklad_edit()
	{
		$this->form_validation->set_rules('c_value', 'Параметр', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE)
		{
			$error = "Изменить параметры не удалось";
		}
		else
		{
			$this->comps_model->editVklad();
			$error = "Связь обновлена";
		}
		$this->vklad_admin($error);
	}

	//Генерация портретов
	function comps_images()
	{
		//Количество сформированных портретов
		$rec = 0;
		//Количество обвновлённых портретов
		$upd = 0;
		//Выбрать компетенции, для которых определён вклад
		$comps = $this->comps_model->getUniqComps();
		foreach ($comps as $key)
		{
			//Берём дисциплины, которые есть в каждой компетенции
			$disciplines = $this->comps_model->getDiscContr($key['compet_id']);
			foreach ($disciplines as $key2)
			{
				//Берём всех студентов ФСПО, прошедших тесты по этим дисциплинам
				$students = $this->comps_model->getDiscUniqStudents($key2['discipline_id']);
				foreach ($students as $key3)
				{
					$summ_avg = 0;
					//Для каждого считаем средний балл для дисциплины по тестам
					$user_results = $this->comps_model->getUserResults($key2['discipline_id'],$key3['user']);
					foreach ($user_results as $key4)
					{
						$summ_avg+=$key4['proz_corr'];
					}
					$summ_avg = round($summ_avg/count($user_results),2);
					//Умножаем средний балл на коэффициент вклада дисциплины в компетенцию
					if (!isset($balls[$key['compet_id']][$key3['user']]['proz'])) 
					{
						$balls[$key['compet_id']][$key3['user']]['proz'] = 0;
					}
					if (!isset($balls[$key['compet_id']][$key3['user']]['disc_count'])) 
					{
						$balls[$key['compet_id']][$key3['user']]['disc_count'] = 0;
					}
					$balls[$key['compet_id']][$key3['user']]['proz'] += $summ_avg * ($key2['contr_proz']/100);
					$balls[$key['compet_id']][$key3['user']]['disc_count']++;
					/*
					Если количество дисциплин, сданных студентов совпадает с количеством дисциплин, 
					вкладывающихся в компетенцию, то этот результат следует записать
					*/
					if ($balls[$key['compet_id']][$key3['user']]['disc_count'] == count($disciplines))
					{
						//Проверка, имелся ли уже результат
						$check = $this->comps_model->getResultCompUser($key['compet_id'],$key3['user']);
						if (count($check) == 0)
						{
							//Запись результата
							$this->comps_model->addResultCompUser($key['compet_id'],$key3['user'],$balls[$key['compet_id']][$key3['user']]['proz']);
							$rec++;
						}
						else
						{
							//Обновление результата
							$this->comps_model->updateResultCompUser($key['compet_id'],$key3['user'],$balls[$key['compet_id']][$key3['user']]['proz']);
							$upd++;
						}
					}
				}
			}
		}
		//список студентов, для которых есть что-то для портрета
		$data['students'] =  $this->comps_model->getUniqStudents();
		foreach($data['students'] as $key)
		{
			$data['name'][$key['user_id']] = $this->forms_model->getUser($key['user_id']);
			//Получить все коэффициенты по компетенциям
			$comps = $this->comps_model->getAllUserBalls($key['user_id']);
			foreach ($comps as $key2)
			{
				$data['comps'][$key['user_id']][$key2['compet_id']]['name'] = $this->comps_model->getCompTiDe($key2['compet_id']);
				$data['comps'][$key['user_id']][$key2['compet_id']]['balls'] = $key2['balls'];
			}
		}
		$data['error'] = "$rec портретов составлено, $upd портретов обновлено";
		$data['title'] = "ВОС.Компетентностные портреты пользователей";
		$this->load->view('comps/comps_images_view',$data);
	}

	//Формирование диаграммы с компетентностным портретом
	function view_popup_stud()
	{
		$user_id = $this->input->post('user_id');
		//Получение информации о студенте
		$this->load->model('private_model');
		$user_info = $this->private_model->getStudReyt($user_id);
		?>
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url()?>js/jquery.jqplot.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.dateAxisRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.canvasTextRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.categoryAxisRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.barRenderer.min.js"></script>
		<?php
		echo "<h1>".$user_info['lastname']." ".$user_info['firstname']."</h1><br />";	
		
		//Получение информации о компетенциях
		$comps = $this->comps_model->getAllUserBalls($user_id);
		?>
		<script>
		$(document).ready(function(){
  			var line1 = 
  			[
  				<?php
  				$i = 1;
				foreach ($comps as $key2)
				{
					$abs=ceil($key2['balls']);
					echo "['Компетенция $i', $abs],";
					$i++;
				}
				?>
  			];

  		var plot1 = $.jqplot('chart1', [line1], 
 			{
 				title: 'Компетентностный портрет',
    			series:[{renderer:$.jqplot.BarRenderer,color:'gray'}],
   				axesDefaults: 
   				{
    			    tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
    			    tickOptions: 
    			    {
          				angle: -30,
          				fontSize: '10pt'
			        }
    			},
			    axes: 
			    {
      				xaxis: 
      				{
        				renderer: $.jqplot.CategoryAxisRenderer
      				}
    			}
  			});
			});
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.jqplot.min.css" />
		<?php
		echo "<table class=\"sortable\" border=\"1\" id=\"groups\" width=\"100%\" style=\"font-size:10px;\">
				<tr>
					<td align=\"center\"><b>#</b></td>
					<td align=\"center\" width=90%><b>Компетенция</b></td>
					<td align=\"center\"><b>Баллы</b></td>
				</tr>";
		$i = 1;
		foreach ($comps as $key2)
		{
			echo "<tr><td align=center>$i</td><td align=center>";
			$name = $this->comps_model->getCompTiDe($key2['compet_id']);
			echo $name."</td><td align=center>".round($key2['balls'],2)."</td></tr>";
			$i++;
		}
		echo "</table>";
		?>
			<div id="chart1" style="width:600;height:400;margin:20px 0 0 0;"></div>
		<?php
		
	}

	
}

?>