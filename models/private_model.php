<?php

class Private_model extends CI_Model{
	
	function getStudResults($user_id="")
	{
		$sql="SELECT `new_results`.*, `new_tests`.`name_test`,`new_razd`.`multiplicity`,`new_razd`.`time_avg`, `new_razd`.`name_razd`,`new_razd`.`stud_view`,`new_razd`.`three`, `new_razd`.`four`,`new_razd`.`five` FROM `new_results`,`new_tests`,`new_razd` WHERE new_results.razd_id=new_razd.id AND new_razd.test_id = new_tests.id and new_results.user='$user_id'  ORDER BY `new_results`.`data` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение всех дисциплин, в которых принимал участие студент
	function getStudDisciplines($user_id = 1)
	{
		$sql="SELECT DISTINCT `new_tests`.`name_test`,`new_tests`.`id` FROM `new_tests`,`new_razd`,`new_results` WHERE `new_tests`.`id` = `new_razd`.`test_id` AND `new_results`.`razd_id` = `new_razd`.`id` AND `new_results`.`user` = '$user_id'  ORDER BY `new_tests`.`name_test` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение всех результатов по ID пользователя и дисциплины
	function getStudResultsOverDiscAndUserID($user_id = 1,$disc_id = 1)
	{
		$sql="SELECT `new_results`.*,`new_results`.`id` as `res_id`, `new_razd`.* FROM `new_results`,`new_razd` WHERE `new_results`.`razd_id` = `new_razd`.`id` AND `new_razd`.`test_id` = '$disc_id' AND `new_results`.`user` = '$user_id'  ORDER BY `new_results`.`data` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getStudReyt($user_id="")
	{
		$sql="SELECT `id`,`numbgr`,`reyt_type`,`reyting`,`type_r`,`lastname`,`firstname`,`photo` FROM `new_persons` WHERE `id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function getGroupReyt($group_id="")
	{
		$sql="SELECT `id`,`reyt_type`,`reyting`,`lastname`,`firstname` FROM `new_persons` WHERE `numbgr`='$group_id' and `reyt_type`>0";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getStudResult($res_id="",$user_id="")
	{
		$sql="SELECT new_stud_ans.*,new_vopros.text,new_vopros.level,new_vopros.incorrect,new_themes.name_th FROM `new_stud_ans`,`new_vopros`,`new_themes` WHERE new_stud_ans.results='$res_id' AND new_vopros.id = new_stud_ans.quest_id and new_themes.id_theme=new_vopros.theme_id AND new_stud_ans.user='$user_id'  ORDER BY `new_themes`.`name_th` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getStudRandomResult($user_id="")
	{
		$sql="SELECT new_stud_ans.*,new_vopros.text,new_vopros.level,new_vopros.incorrect,new_themes.name_th FROM `new_stud_ans`,`new_vopros`,`new_themes` WHERE new_stud_ans.results in (SELECT `id` FROM `new_results` WHERE `user`='$user_id' and `timeend`!=0) AND new_vopros.id = new_stud_ans.quest_id and new_themes.id_theme=new_vopros.theme_id AND new_stud_ans.user='$user_id'  ORDER BY `new_themes`.`name_th` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getDateReyt($user_type="")
	{
		if ($user_type<1)
		{
			$user_type=3;
		}
		$sql="SELECT `reyt_date` FROM `new_type_reg` WHERE id='$user_type'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['reyt_date'];		
	}

	function getAllReyt($user_type="")
	{
		if ($user_type=="")
		{
			$sql="SELECT id FROM `new_persons` WHERE reyt_type>0 and `block`=0";
		}
		else
		{
			$sql="SELECT `id` FROM `new_persons` WHERE `type_r`='$user_type' and `reyt_type`>0 AND `block`=0";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		$count=count($data);
		return $count;
	}

	function getUserDiscRes($user_id = "")
	{
		$sql="SELECT `id`,`razd_id`,`proz_corr` FROM `new_results` WHERE `user` = '$user_id' AND `timeend` != '0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getTestName($razd_id = "")
	{
		$sql="SELECT `name_razd` FROM `new_razd` WHERE `id` = '$razd_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_razd'];
	}

	function getTestAVG($razd_id = "")
	{
		$sql="SELECT `multiplicity` FROM `new_razd` WHERE `id` = '$razd_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['multiplicity'];	
	}

	function getDiscName($razd_id = "")
	{
		$sql="SELECT `name_test` FROM `new_tests` WHERE `id` IN (SELECT `test_id` FROM `new_razd` WHERE `id` = '$razd_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_test'];
	}

	function getCorrResult($user_id="")
	{
		$sql="SELECT `new_results`.`id`,`new_results`.`data`,`new_razd`.`name_razd` FROM `new_results`,`new_razd` WHERE `new_results`.`user`='$user_id' AND `new_results`.`proz`!=`new_results`.`proz_corr` AND `new_results`.`proz_corr`>0 AND `new_results`.`razd_id`=`new_razd`.`id` LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	/*
		###################
		Часть 2. Для резюме
		###################
	*/

	//Проверка сформированности резюме
	function checkResumeCmpl()
	{
		$user=$this->session->userdata('user_id');
		$sql="SELECT `resume_cmpl` FROM `new_persons` WHERE `id`='$user'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['resume_cmpl'];
	}

	//Получение необходимой информации о пользователе
	function getUserInfo($user_id="")
	{
		if ($user_id == "")	{$user_id=$this->session->userdata('user_id');}
		$sql="SELECT `firstname`,`lastname`,`middlename`,`state`,`birthday`,`mail`,`mail_adr`,`phone`,`comp_image`,`resume_date` FROM `new_persons` WHERE `id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function updateUserInfo($middlename="",$phone="",$mail="",$user_birth="",$state="")
	{
		$user=$this->session->userdata('user_id');
		$sql = "UPDATE `new_persons` SET `middlename` = '$middlename',`phone` = '$phone', `mail_adr` = '$mail',`birthday` = '$user_birth', `state` = '$state' where `id`='$user'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение информации о уровне навыка пользователя
	function getUserSkill($skill_id="")
	{
		$user=$this->session->userdata('user_id');
		$sql="SELECT `balls` FROM `new_user_skills` WHERE `user_id`='$user' AND `skill_id` = '$skill_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['balls'];
	}

	//Получение всех навыков
	function getAllSkills()
	{
		$sql="SELECT * FROM `new_skills` ORDER BY  `group` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение информации об уровнях навыков
	function getSkillDescriptions($skill_id="")
	{
		$sql="SELECT `description` FROM `new_skill_descriptions` WHERE `skill_id`='$skill_id' ORDER BY `ball` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	//Создание записи о навыке
	function addUserSkill($skill_id="",$ball="")
	{
		$user=$this->session->userdata('user_id');
		$sql = "INSERT INTO `new_user_skills` (`user_id`,`skill_id`,`balls`) VALUES ('$user','$skill_id','$ball')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Обновление записи о навыке
	function updateUserSkill($skill_id="",$ball="")
	{
		$user=$this->session->userdata('user_id');
		$sql = "UPDATE `new_user_skills` SET `balls` = '$ball' WHERE `user_id`='$user' AND `skill_id`='$skill_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение всех портфолио студента
	function getAllUserPortfolios($user="")
	{
		if ($user == "")	{$user = $this->session->userdata('user_id');}
		$sql="SELECT * FROM `new_portfolios` WHERE `user_id`='$user' ORDER BY `date_begin` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	//Добавление информации о портфолио
	//postAjax(3,port_name,port_desc,port_url,port_begin,port_end);	
	function addUserPortfolio($name="",$desc="",$url="",$begin="",$end="")
	{
		$user=$this->session->userdata('user_id');
		$sql = "INSERT INTO `new_portfolios` (`user_id`,`name`,`description`,`url`,`date_begin`,`date_end`) VALUES ('$user','$name','$desc','$url','$begin','$end')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Удаление портфолио
	function delUserPortfolio($port_id="")
	{
		$user=$this->session->userdata('user_id');
		$sql = "DELETE FROM `new_portfolios` WHERE `id`='$port_id' AND `user_id`='$user'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Обновление статуса прикрепления компетентностного портрета
	function updateCompStatus($status="")
	{
		$user=$this->session->userdata('user_id');
		$sql = "UPDATE `new_persons` SET `comp_image` = '$status' WHERE `id`='$user'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Составление резюме закончено
	function updateResumeStatus()
	{
		$user=$this->session->userdata('user_id');
		$sql = "UPDATE `new_persons` SET `resume_cmpl` = '1',`resume_date` = NOW() WHERE `id`='$user'";
		$data = $this->db->query($sql);
		$lname=$this->session->userdata('lastname');
		$fname=$this->session->userdata('firstname');
		$name=$lname." ".$fname;
		$now_time=time();
		$type="Составлено резюме";
		$date_t=date("Y.m.d H:i");
		$sql = "INSERT INTO `new_log` (`user`,`date`,`type`,`time`) VALUES ('$name','$date_t','$type','$now_time')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение информации о всех навыкаx пользователя
	function getAllUserSkills($user="")
	{
		if ($user == "")	{$user = $this->session->userdata('user_id');}
		$sql="SELECT `id`,`balls`,`skill_id` FROM `new_user_skills` WHERE `user_id`='$user' AND `balls`!='0' ORDER BY `skill_id` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение названия конкретного навыка
	function getSkillName($skill_id="")
	{
		$sql="SELECT `name` FROM `new_skills` WHERE `id`='$skill_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];
	}

	//Получение описания навыка по баллам пользователя
	function getSkillBallDescription($skill_id="",$balls="")
	{
		$sql="SELECT `description` FROM `new_skill_descriptions` WHERE `skill_id`='$skill_id' AND `ball`='$balls' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['description'];
	}

	//Сброс резюме
	function updateCmplStatus()
	{
		$user=$this->session->userdata('user_id');
		$sql = "UPDATE `new_persons` SET `resume_cmpl` = '0' WHERE `id`='$user'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Проверка публичности резюме
	function getPublicStatus($user_id="")
	{
		$sql="SELECT `public_status` FROM `new_persons` WHERE `id`='$user_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['public_status'];
	}

	//Изменение статуса публикации резюме
	function changePublicStatus($status="")
	{
		$user=$this->session->userdata('user_id');
		$sql = "UPDATE `new_persons` SET `public_status` = '$status' WHERE `id`='$user'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение всех пользователей, составивших резюме
	function getResumeStudents()
	{
		$sql="SELECT `id`,`firstname`,`lastname`,`type_r` FROM `new_persons` WHERE `resume_cmpl`='1' AND `block`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение количества навыков в группе
	function getCountSkills($group_id="")
	{
		$sql="SELECT `id` FROM `new_skills` WHERE `group`='$group_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Посчитать сумму навыков для одного пользователя по группе навыков
	function getSumSkills($user_id="",$group="")
	{
		$sql="SELECT SUM(balls) FROM `new_user_skills` WHERE `user_id`='$user_id' AND `skill_id` IN (SELECT `id` FROM `new_skills` WHERE `group`='$group')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['SUM(balls)'];
	}

	//Количество проектов
	function getCountPortfolios($user_id="")
	{
		$sql="SELECT `id` FROM `new_portfolios` WHERE `user_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function getCompsAvg($user_id="")
	{
		$sql="SELECT AVG(balls) FROM `new_comps_image` WHERE `user_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['AVG(balls)'];
	}

}

?>