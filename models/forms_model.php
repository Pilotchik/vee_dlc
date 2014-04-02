<?php

class Forms_model extends CI_Model{
	
	function getAllForms($active="0")
	{
		if ($active==0)
		{
			$sql="SELECT * FROM `new_forms` where `active`='1' and `del`='0' ORDER BY `date` ASC";	
		}
		else
		{
			$sql="SELECT * FROM `new_forms` where `del`='0' ORDER BY `date` ASC";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getTypeRForms($type_r="1")
	{
		if (($type_r<1) || ($type_r>2))
		{
			$sql="SELECT * FROM `new_forms` where `active`='1' AND `del`='0' ORDER BY `date` ASC";	
		}
		else
		{
			$sql="SELECT * FROM `new_forms` where `active`='1' AND `type_r`='$type_r' and `del`='0' ORDER BY `date` ASC";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getArchiveForms($type_r="1")
	{
		if (($type_r<1) || ($type_r>2))
		{
			$sql="SELECT * FROM `new_forms` where `active`='0' AND `del`='0' ORDER BY `date` ASC";	
		}
		else
		{
			$sql="SELECT * FROM `new_forms` where `active`='0' AND `type_r`='$type_r' and `del`='0' ORDER BY `date` ASC";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getCountForms($form_id="")
	{
		$sql="SELECT * FROM `new_form_results` WHERE `form_id`='$form_id' AND `end`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function editForm()
	{
		$id_c=$this->input->post('c_id');
		$value=$this->input->post('c_value');
		$param=$this->input->post('c_param');
		$sql = "UPDATE `new_forms` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function delForm()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_forms` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createForm()
	{
		$title=$this->input->post('f_title');
		$type_r=$this->input->post('f_type_r');
		$desc=$this->input->post('f_description');
		$access=$this->input->post('f_access');
		$user=$this->session->userdata('user_id');
		$sql = "INSERT INTO `new_forms` (`title`,`type_r`,`author_id`,`date`,`description`,`active`,`access`) VALUES ('$title','$type_r','$user',NOW(),'$desc','1','$access')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getAllQuests($form_id="")
	{
		$sql="SELECT * FROM `new_form_quests` where `form_id`='$form_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getAllActiveQuests($form_id="")
	{
		$sql="SELECT * FROM `new_form_quests` where `form_id`='$form_id' AND `del`='0' AND `active`='1'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getFormName($form_id="")
	{
		$sql="SELECT `title` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['title'];	
	}

	function getFormAccess($form_id="")
	{
		$sql="SELECT `access` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['access'];	
	}

	function getFormOU($form_id="")
	{
		$sql="SELECT `type_r` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['type_r'];	
	}	

	function editQuest()
	{
		$id_c=$this->input->post('c_id');
		$value=$this->input->post('c_value');
		$param=$this->input->post('c_param');
		$sql = "UPDATE `new_form_quests` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function delQuest()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_form_quests` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createQuest($form_id="")
	{
		$title=$this->input->post('f_title');
		$subtitle=$this->input->post('f_subtitle');
		$type=$this->input->post('f_type');
		$option1=$this->input->post('f_option1');
		$option2=$this->input->post('f_option2');
		$option3=$this->input->post('f_option3');
		$req=$this->input->post('f_req');
		if ($req == 'on')	{$req=1;}	else	{$req=0;}
		$sql = "INSERT INTO `new_form_quests` (`title`,`subtitle`,`type`,`required`,`option1`,`option2`,`option3`,`active`,`del`,`form_id`) VALUES ('$title','$subtitle','$type','$req','$option1','$option2','$option3','1','0','$form_id')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getRespStatus($form_id="",$user_id="")
	{
		$sql="SELECT `end` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['end'];
	}

	function getFormQuests($form_id="",$user_id="")
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `id` NOT IN (SELECT `quest_id` FROM `new_form_answers` WHERE `res_id` IN (SELECT `id` FROM `new_form_results` WHERE `person_id` = '$user_id'))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Проверка наличия записи о результате
	function checkFormResult($form_id="")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function createFormResult($form_id="",$now_time="")
	{
		$user_id = $this->session->userdata('user_id');
		$sql = "INSERT INTO `new_form_results` (`form_id`,`person_id`,`begin`) VALUES ('$form_id','$user_id','$now_time')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение идентификатора записи результата
	function getResId($form_id="",$user_id="")
	{
		$sql="SELECT `id` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['id'];
	}

	//Получение типа вопроса
	function getTypeQuest($id_q="")
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `id`='$id_q'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['type'];	
	}

	//Проверка, сдавался ли вопрос
	function getCheckAnswer($id_q="",$res_id="")
	{
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$id_q' AND `res_id`='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Создание записи об ответе
	function insertAnswer($id_q="",$res_id="",$value="",$value2="")
	{
		$sql = "INSERT INTO `new_form_answers` (`quest_id`,`res_id`,`answer`,`option`) VALUES ('$id_q','$res_id','$value','$value2')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Обновление записи об ответе
	function updateAnswer($id_q="",$res_id="",$value="",$value2="")
	{
		$sql="UPDATE `new_form_answers` SET `answer` ='$value',`option`='$value2' WHERE `quest_id`='$id_q' AND `res_id`='$res_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Проверка, сдавался ли вопрос
	function getCheckAnswerSetka($id_q="",$res_id="",$value="")
	{
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$id_q' AND `res_id`='$res_id' AND `answer`='$value'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Проверка окончания анкетирования
	function checkEndFormResult($form_id="")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id' AND `end`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Обновление записи о результате при завершении анкетирования
	function updateFormResult($user_id="",$form_id="",$now_time="")
	{
		$sql="UPDATE `new_form_results` SET `end` ='$now_time' WHERE `person_id`='$user_id' AND `form_id`='$form_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Изменение статуса опубликования результатов
	function updatePublicForm($form_id="",$status="")
	{
		$sql="UPDATE `new_forms` SET `public_res` ='$status' WHERE `id`='$form_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getAllQuestResults($quest_id="")
	{
		$sql="SELECT `answer`,`res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Посчитать, сколько человек ответило
	function getCountOptionResult($quest_id="",$answer="")
	{
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Посчитать, сколько человек ответило для каждого курса
	function getCountOptionKursResult($quest_id="",$answer="",$kurs="")
	{
		$kurs = $kurs."__";
		$sql="SELECT `id` FROM `new_numbers` WHERE `type_r`='1' AND `name_numb` LIKE '$kurs' ORDER BY `name_numb` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		$numbers="(";
		foreach ($data as $key)
		{
			$numbers=$numbers.$key['id'].",";
		}
		$numbers=substr($numbers, 0, -1);
		$numbers = $numbers.")";
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `res_id` IN (SELECT `id` FROM `new_form_results` WHERE `person_id` IN (SELECT `id` FROM `new_persons` WHERE `numbgr` in $numbers))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Посчитать, сколько человек ответило
	function getCountUniqOptionResult($quest_id="")
	{
		$sql="SELECT DISTINCT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Получение ID пользователей, которые отвечали на вопросы
	function getUsersOptionResult($quest_id="",$answer="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` IN (SELECT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['person_id'];	
	}

	function getAllUsersOptionResult($quest_id="",$answer="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` IN (SELECT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getUserByResId($res_id="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` ='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['person_id'];	
	}

	function getUser($user_id="")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` WHERE `id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

	function getCountOptionResultSetka($quest_id="",$answer="",$option="")
	{
		$sql="SELECT DISTINCT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `option`='$option'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Получение ID пользователей, ответивших на сетку
	function getUsersOptionResultSetka($quest_id="",$answer="",$option="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` IN (SELECT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `option`='$option')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	//Выборка пользовательских ответов
	function getOtherTestResult($quest_id="")
	{
		$sql="SELECT `res_id`,`answer` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer` REGEXP '[[:alpha:]]+'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function createLogRecord($form_name="")
	{
		$lname=$this->session->userdata('lastname');
		$fname=$this->session->userdata('firstname');
		$name=$lname." ".$fname;
		$now_time=time();
		$type="Пройден опрос \"".$form_name."\"";
		$date_t=date("Y.m.d H:i");
		$sql = "INSERT INTO `new_log` (`user`,`date`,`type`,`time`) VALUES ('$name','$date_t','$type','$now_time')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getRightResults($form_id="")
	{
		$sql="SELECT `public_res` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['public_res'];
	}

	function getAllUserForms($user_id = "")
	{
		$sql="SELECT `new_form_results`.`end`,`new_forms`.`title`,`new_forms`.`description` FROM `new_forms`,`new_form_results` WHERE `new_form_results`.`person_id`='$user_id' AND `new_form_results`.`form_id` = `new_forms`.`id` AND `new_forms`.`del`='0'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	function checkFormId($form_id="")
	{
		$sql="SELECT `id` FROM `new_forms` WHERE `id` = '$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

}

?>