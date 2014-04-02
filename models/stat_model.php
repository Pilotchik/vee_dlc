<?php

class Stat_model extends CI_Model{
	
	function getTestCount($disc_id="")
	{
		$sql="SELECT COUNT(*) FROM `new_results` where `timeend`!='0' AND `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$disc_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getTestResult($disc_id="")
	{
		$sql="SELECT `proz`,`proz_corr`,`timeend`,`timebeg` FROM `new_results` where `timeend`!='0' AND `razd_id`='$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getQuests($disc_id="")
	{
		$sql="SELECT `id`,`text` FROM `new_vopros` where `razd_id`='$disc_id' AND id in (SELECT `quest_id` FROM `new_stud_ans`)";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getQuestResults($quest_id="")
	{
		$sql="SELECT `true` FROM `new_stud_ans` where `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getThemes($disc_id="")
	{
		$sql="SELECT `id_theme`, `name_th` FROM `new_themes` where id_theme in (SELECT `theme_id` FROM `new_vopros` where `razd_id`='$disc_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getThemeResults($theme_id="")
	{
		$sql="SELECT `true` FROM `new_stud_ans` where `quest_id` in (SELECT `id` FROM `new_vopros` WHERE `theme_id`='$theme_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	//Получение списка пользователей, которые учавствовали в тестах по дисциплинам
	function getUsers($disc_id="",$type_r="")
	{
		$sql="SELECT DISTINCT `user`,`proz_corr` FROM `new_results` where `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$disc_id') AND `user` in (SELECT `id` FROM `new_persons` WHERE `type_r` in $type_r AND `block`=0)";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getGroups($nabor="")
	{
		$sql="SELECT DISTINCT `name_numb`,`id`,`prepod_id` FROM `new_numbers` where `id` in (SELECT `numbgr` FROM `new_persons` WHERE `id` in $nabor) AND `active`=1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	function getPrepods($nabor="")
	{
		$sql="SELECT DISTINCT `name`,`id` FROM `new_prepods` where `id` in (SELECT `prepod_id` FROM `new_numbers` WHERE `id` in $nabor)";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	function getGroupId($user_id="")
	{
		$sql="SELECT `numbgr` FROM `new_persons` WHERE `id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;			
	}

	//Получение списка пользователей, которые учавствовали в тесте
	function getUsersTest($test_id="")
	{
		$sql="SELECT DISTINCT `user`,`proz_corr` FROM `new_results` where `razd_id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	function getQuestsTest($test_id="")
	{
		$sql="SELECT `id` FROM `new_vopros` WHERE `razd_id`='$test_id' AND `del`=0 ORDER BY `id` ";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;			
	}

	function getQuestsTestReport($test_id="")
	{
		$sql="SELECT `id`,`success`,`level`,`theme_id`,`text` FROM `new_vopros` WHERE `razd_id`='$test_id' AND `del`=0 ORDER BY `id` ";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;			
	}

	//Получение вопросов, на которые есть ответы
	function getQuestInfo($result_id="")
	{
		$sql="SELECT `true`,`quest_id` FROM `new_stud_ans` where `results`='$result_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	//Получение информации об ответах студентов
	function getAnswersInfo($test_id="")
	{
		$sql="SELECT `user`,`id` FROM `new_results` WHERE `timeend`!=0 AND `razd_id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	function getQuestText($quest_id="")
	{
		$sql="SELECT `text` FROM `new_vopros` WHERE `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	function editQuestStatus($quest_id="",$status=0)
	{
		$sql = "UPDATE `new_vopros` SET `incorrect` = '$status' where `id`='$quest_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function editQuestSuccess($quest_id="",$status=0)
	{
		$sql = "UPDATE `new_vopros` SET `success` = '$status' where `id`='$quest_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function editQuestDiff($quest_id="",$diff=1)
	{
		$sql = "UPDATE `new_vopros` SET `level` = '$diff' where `id`='$quest_id'";
		$data = $this->db->query($sql);
		return $data;
	}
		
	//Запись даты последнего сбора статистики
	function editStatDate($test_id="")
	{
		$date_t=date("Y.m.d H:i");
		$sql="UPDATE `new_razd` SET `stat_date`='$date_t' WHERE `id`='$test_id'";
		$data = $this->db->query($sql);
		return $data;	
	}

	function updateTestMultiplicity($razd_id="",$abs="",$time_avg="")
	{
		$sql="UPDATE `new_razd` SET `multiplicity`='$abs',`time_avg`='$time_avg' WHERE `id`='$razd_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getTypeDisc($disc_id="")
	{
		$sql="SELECT `type_r` FROM `new_tests` WHERE `id`='$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['type_r'];
	}

	function getQuestsAnswers($quest_id="")
	{
		$sql="SELECT `text`,`true` FROM `new_answers` WHERE `vopros_id`='$quest_id' and `del`=0";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getQuestIncorrStud($quest_id="")
	{
		$sql="SELECT `user_id` FROM `new_vopros_feedback` WHERE `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function getAvgTime($quest_id="")
	{
		$sql="SELECT AVG(time) FROM `new_stud_ans` WHERE `quest_id`='$quest_id' AND `time`>0 AND `true`>0.5";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['AVG(time)'];
	}

	function editQuestTimeStatus($quest_id = "" ,$avg_time = "")
	{
		$sql = "UPDATE `new_vopros` SET `avg_time` = '$avg_time' WHERE `id`='$quest_id'";
		$data = $this->db->query($sql);
		return $data;
	}

}

?>