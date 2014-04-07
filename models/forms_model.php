<?php

class Forms_model extends CI_Model{
	
	function getAllTypeReg()
	{
		$sql="SELECT `id`,`name` FROM `new_type_reg`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getTypeReg($type_r = 1)
	{
		$sql="SELECT `name` FROM `new_type_reg` where `id`='$type_r'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];
	}

	function getUserName($author_id="")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` where `id`='$author_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

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

	function createForm($title = "",$type_r = 1,$desc = "",$access = 1,$user_id = 1)
	{
		$sql = "INSERT INTO `new_forms` (`title`,`type_r`,`author_id`,`date`,`description`,`active`,`access`) VALUES ('$title','$type_r','$user_id',NOW(),'$desc','1','$access')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getFormIDOverTitleAndDesc($title = "",$desc = "")
	{
		$sql="SELECT `id` FROM `new_forms` WHERE `title`='$title' AND `description`='$desc' AND `active`='1' AND `del`='0' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['id'];
	}

	function createMainSite($form_id = 1,$title = "Главная страница",$numb = 0)
	{
		$sql = "INSERT INTO `new_form_quests` (`title`,`type`,`form_id`,`numb`) VALUES ('$title','0','$form_id','$numb')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение максимального номера страницы опроса
	function getMaxSiteNumbOverFormID($form_id = 1)
	{
		$sql="SELECT MAX(`numb`) as `i` FROM `new_form_quests` WHERE `form_id`='$form_id' AND `type`='0' AND `del`='0'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['i'];
	}

	//Функция для нахождения всех страниц опроса
	function getAllSitesOverFormID($form_id = 1)
	{
		$sql="SELECT `id`,`numb`,`title` FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `type`='0' ORDER BY `numb`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Функция для выборки всех вопросов на указанной странице
	function getAllQuestsOverSiteID($form_id = 1,$site_id = 1)
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `site`='$site_id' ORDER BY `numb`";
		$query = $this->db->query($sql);
		return $query->result_array();	
	}

	function getAllQuests($form_id = 1)
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' ORDER BY `site`,`numb`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getAllActiveQuests($form_id="")
	{
		$sql="SELECT * FROM `new_form_quests` where `form_id`='$form_id' AND `del`='0' AND `type`!=0 AND `type`!=6 AND `active`='1'";
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

	function editQuest($id_c = 1,$value = "",$param = "title")
	{
		$sql = "UPDATE `new_form_quests` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
	}

	function delQuest($quest_id = 1)
	{
		$sql = "UPDATE `new_form_quests` SET `del` = '1' where `id`='$quest_id'";
		$data = $this->db->query($sql);
	}

	function getMainSiteIdOverFormId($form_id = 1)
	{
		$sql = "SELECT `id` FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `numb`='0' AND `type`='0' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['id'];
	}

	function updateQuestSite($quest_id = 1,$main_site_id = 1)
	{
		$sql = "UPDATE `new_form_quests` SET `site` = '$main_site_id' WHERE `site`='$quest_id'";
		$data = $this->db->query($sql);
	}

	function createQuest($form_id = 1, $title = "",$subtitle = "",$type = 1,$option1 = "",$option2 = "",$option3 = "",$req = 1,$site = 1,$numb = 1)
	{
		if ($type == 6)
		{
			$numb = 10;
		}
		if ($req == 'on')	{$req=1;}	else	{$req=0;}
		$sql = "INSERT INTO `new_form_quests` (`title`,`subtitle`,`type`,`required`,`option1`,`option2`,`option3`,`active`,`del`,`form_id`,`site`,`numb`) VALUES ('$title','$subtitle','$type','$req','$option1','$option2','$option3','1','0','$form_id','$site','$numb')";
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
		return $query->result_array();
	}

	function getFormSiteQuests($form_id="",$user_id="",$site_id = 1)
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `active`='1' AND `site`='$site_id' AND `id` NOT IN (SELECT `quest_id` FROM `new_form_answers` WHERE `res_id` IN (SELECT `id` FROM `new_form_results` WHERE `person_id` = '$user_id'))";
		$query = $this->db->query($sql);
		return $query->result_array();
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