<?php

class Private_site extends CI_Controller {

	function Private_site()
	{
		parent::__construct();
		
	}

	function _remap($method)
	{
		if ($this->session->userdata('guest') == '')
		{
			$data['error']="Время сессии истекло. Необходима авторизация";
			$this->load->model('registr_model');
			$data['fspo']=$this->registr_model->getFSPO();
			$data['segrys']=$this->registr_model->getSegrys();
			$this->load->view('main_view',$data);
		}
		else
		{
			$this->load->model('private_model');
			$this->load->model('reyting_model');
			$this->load->model('moder_model');
			$this->load->model('comps_model');
			$this->load->model('de_model');
			$this->$method();
		}
	}

	//Функция отображения страницы результатов
	function index()
	{
		$data['title'] = "ВОС.Мои результаты";
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('type_r');
		/*
		//Получение информации о студенте
		$data['user_info']=$this->private_model->getStudReyt($user_id);
		
		//Вычисление общего количества студентов, учавствующих в рейтинге
		$data['all_users']['type']=$this->private_model->getAllReyt($user_type);
		
		//Дата обновления рейтинга
		$data['reyt_date']=$this->private_model->getDateReyt($user_type);
		
		//Получение информации о рейтинге всех участников группы
		if($data['user_info']['reyt_type']>0)
		{
			$data['user_info']['numbgr'];
			$group=$this->private_model->getGroupReyt($data['user_info']['numbgr']);
			//print_r($group);
			$data['all_group']=count($group);
			//Транспонирование матрицы
			foreach($group as $key=>$value) 
			{
				$sort_proz[$key] = $value['reyt_type'];
			}
			//Сортировка массива по убыванию среднего результата
			array_multisort($sort_proz, SORT_NUMERIC, SORT_ASC, $group);
			//echo "<br />";
			//print_r($group);
			$data['group']=$group;
			$pos=0;
			foreach ($group as $key)
			{
				$pos++;
				if ($key['id']==$data['user_info']['id'])
				{
					$data['user_info']['group_pos']=$pos;	
				}
			}
			//echo $data['user_info']['group_pos'];
		}
		*/

		//Протокол проверенных заданий
		$data['stud_answers'] = $this->moder_model->getOneStudAnswers($user_id);
		
		$this->load->model('forms_model');
		
		foreach($data['stud_answers'] as $key)
		{
			$data['test_name'][$key['id']] = $this->moder_model->getTestName($key['quest_id']);
			$data['quest_text'][$key['id']] = $this->moder_model->getQuestText($key['quest_id']);
			$data['test_date'][$key['id']] = $this->moder_model->getDateAnswer($key['results']);
			if ($key['check']==1)
			{
				$checking = $this->moder_model->getCheckLog($key['id']);
				$data['prepod_name'][$key['id']] = $this->forms_model->getUser($checking['prepod_id']);
				$data['prepod_comm'][$key['id']] = $checking['comment'];
				$data['prepod_date'][$key['id']] = $checking['date'];
				$data['proz_before'][$key['id']] = $checking['proz_before'];
				$data['proz_after'][$key['id']] = $checking['proz_after'];
				$data['balls'][$key['id']] = $checking['balls'];
				//Обновить статус прочтения студентом результата
				$this->moder_model->updateReadStatus($key['id']);
			}
		}
		//Результаты студента
		$data['user_id'] = $user_id;

		//Найти все дисциплины, в которых учавствовал пользователь
		$data['results'] = array();
		$data['disciplines'] = $this->private_model->getStudDisciplines($user_id);
		foreach($data['disciplines'] as $key)
		{
			$data['results'][$key['id']] = $this->private_model->getStudResultsOverDiscAndUserID($user_id,$key['id']);
		}
		//$data['results'] = $this->private_model->getStudResults($user_id);
		//Результаты пройденных дистанционных курсов
		$data['courses'] = $this->de_model->getStudCourses();
		foreach($data['courses'] as $key)
		{
			$data['disc_names'][$key['id']] = $this->de_model->getDiscName($key['course_id']);
			$data['course_names'][$key['id']] = $this->de_model->getNameCourse($key['course_id']);
		}
		$data['error'] = "";
		$this->load->view('private_site_view',$data);
	}

	function view_stud_result()
	{
		$user_id = $this->session->userdata('user_id');
		$data['test_name'] = $this->input->post('test_name');
		$data['results'] = $this->private_model->getStudResult($this->uri->segment(3),$user_id);
		$data['error'] = "";
		$this->load->view('private_stud_view',$data);
	}

	function view_history()
	{
		$user_id=$this->session->userdata('user_id');
		$data['history']=$this->reyting_model->getHistory($user_id);
		$i=0;
		$hist_array=array();
		foreach($data['history'] as $key)
		{
			$hist_array[$i]['reyt']=$key['reyt'];
			$hist_array[$i]['id']=$key['id'];
			if ($i>0)
			{
				if ($hist_array[$i]['reyt']==$hist_array[$i-1]['reyt'])
				{
					$this->reyting_model->delHistory($hist_array[$i-1]['id']);
				}
			}
			$i++;
		}
		$data['history']=$this->reyting_model->getHistory($user_id);
		$data['user']=$this->reyting_model->getStudInfo($user_id);
		$data['error']="";
		$this->load->view('private_reyting_history_view',$data);			
	}

	function reyt_desc()
	{
		$user_id=$this->session->userdata('user_id');
		$results=$this->private_model->getStudResults($user_id);
		$data['result']=$results[0];
		$data['error']="";
		$this->load->view('private_reyt_desc_view',$data);	
	}

	function corr_desc()
	{
		$user_id=$this->session->userdata('user_id');
		$res=$this->private_model->getCorrResult($user_id);
		$data['test']=$res;
		$data['results']=$this->private_model->getStudResult($res['id'],$user_id);
		$data['error']="";
		$this->load->view('private_corr_desc_view',$data);	
	}

	//Формирование диаграммы с компетентностным портретом
	function view_popup_stud()
	{
		$user_id=$this->session->userdata('user_id');
		//Получение информации о студенте
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
		if (strlen($user_info['photo'])>5)
		{
			echo "<table class=\"sortable\" border=\"1\" id=\"groups\" width=\"100%\">
				<tr>
					<td align=center width=10%><img src=\"".$user_info['photo']."\"></td>
					<td align=center><h1>".$user_info['lastname']."<br />".$user_info['firstname']."</h1></td>
				</tr>
			</table><br />";	
		}
		else
		{
			echo "<h1>".$user_info['lastname']." ".$user_info['firstname']."</h1><br />";	
		}
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

	function resume()
	{
		$restart_status = $this->uri->segment(3);
		if ($restart_status == 966)
		{
			//Обновить статус готовности резюме
			$this->private_model->updateCmplStatus();
		}
		//Главная информация о пользователе
		$data['user_info'] = $this->private_model->getUserInfo();
		//Информация о пользовательских навыках
		$data['portfolios'] = $this->private_model->getAllUserPortfolios();
		$user_id=$this->session->userdata('user_id');
		$data['comps'] = $this->comps_model->getAllUserBalls($user_id);
		foreach ($data['comps'] as $key)
		{
			$data['comp_name'][$key['id']] = $this->comps_model->getCompTiDe($key['compet_id']);
			$data['comp_ball'][$key['id']] = round($key['balls'],2);
		}
		//Проверить, сформировано ли было резюме ранее. Если нет - запустить мастер создания
		$cmpl = $this->private_model->checkResumeCmpl();
		if ($cmpl == 0)
		{
			$data['skills'] = $this->private_model->getAllSkills();
			foreach($data['skills'] as $key) 
			{
				//Получение балла пользователя по навыку
				$data['user_skill'][$key['id']] = $this->private_model->getUserSkill($key['id']);
				//Получение информации об уровнях навыков
				$data['skill_description'][$key['id']] = $this->private_model->getSkillDescriptions($key['id']);
			}
			$data['error'] = "";
			$this->load->view('private_resume_create_view',$data);
		}
		else
		{
			$data['public_status'] = $this->private_model->getPublicStatus($user_id);
			$data['skills'] = $this->private_model->getAllUserSkills();
			$data['user_id'] = $user_id;
			foreach($data['skills'] as $key) 
			{
				//Получение названия навыка
				$data['skill_name'][$key['id']] = $this->private_model->getSkillName($key['skill_id']);
				//Получение информации об уровне навыков
				$data['skill_description'][$key['id']] = $this->private_model->getSkillBallDescription($key['skill_id'],$key['balls']);
			}
			$data['error']="";
			$this->load->view('private_resume_view',$data);
		}
	}

	function resume_create()
	{
		$step=$this->input->post('step');
		$param_1=$this->input->post('param_1');
		$param_2=$this->input->post('param_2');
		$param_3=$this->input->post('param_3');
		$param_4=$this->input->post('param_4');
		$param_5=$this->input->post('param_5');
		$this->form_validation->set_rules('step', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$this->form_validation->set_rules('param_1', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('param_2', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('param_3', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('param_4', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('param_5', 'ID', 'trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE)
		{
			if ($step == 1)
			{
				if ($this->private_model->updateUserInfo($param_1,$param_2,$param_3,$param_4,$param_5))
				{
					echo json_encode(array('answer'=>1));
				}
				else
				{
					echo json_encode(array('answer'=>0));
				}
			}
			if ($step == 2)
			{
				$sdal = $this->private_model->getUserSkill($param_1);
				if (!isset($sdal))
				{
					//Создать запись об ответе
					$this->private_model->addUserSkill($param_1,$param_2);
				}
				else
				{
					//Обновить запись о навыке
					$this->private_model->updateUserSkill($param_1,$param_2);
				}
				echo json_encode(array('answer'=>1));
			}
			if ($step == 3)
			{
				//Сохранить портфолио
				if ($this->private_model->addUserPortfolio($param_1,$param_2,$param_3,$param_4,$param_5))
				{
					echo json_encode(array('answer'=>1));
				}
				else
				{
					echo json_encode(array('answer'=>0));
				}
			}
			if ($step == 4)
			{
				//Изменить статус прикрепления компетентностного портрета
				if ($this->private_model->updateCompStatus($param_1))
				{
					echo json_encode(array('answer'=>1));
				}
				else
				{
					echo json_encode(array('answer'=>0));
				}
			}
			if ($step == 5)
			{
				//Обновить статус законченности резюме
				if ($this->private_model->updateResumeStatus())
				{
					echo json_encode(array('answer'=>1));
				}
				else
				{
					echo json_encode(array('answer'=>0));
				}
			}
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
		
	}

	function portfolio_del()
	{
		$this->form_validation->set_rules('id', 'ID', 'trim|required|xss_clean');
		$port_id=$this->input->post('id');
		if ($this->private_model->delUserPortfolio($port_id))
		{
			echo json_encode(array('answer'=>1));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}

	function publicstatus_change()
	{
		$this->form_validation->set_rules('status_pole', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
		$status=$this->input->post('status_pole');
		if ($this->private_model->changePublicStatus($status))
		{
			echo json_encode(array('answer'=>1));
		}
		else
		{
			echo json_encode(array('answer'=>0));
		}
	}


}

?>