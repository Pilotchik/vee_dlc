<?php

class Tutor_model extends CI_Model{
	
	function addMessage($user_id = 1, $help_type = 1, $help_title = "", $help_text = "")
	{
		$now_time=time();
		$date_t=date("H:i d.m.Y");
		$sql = "INSERT INTO `new_feedback` (`user_id`,`help_text`,`help_title`,`help_type`,`data`,`time`) VALUES ('$user_id','$help_text','$help_title','$help_type','$date_t','$now_time')";
		echo $sql;
		$data = $this->db->query($sql);
		return $data;
	}

	function getAllMessagesWithoutAnswers()
	{
		$sql = "SELECT * FROM `new_feedback` WHERE `to` = '0' AND `id` NOT IN (SELECT `to` FROM `new_feedback`) ORDER BY `time` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();	
	}

	function getAllActiveMessagesWithAnswers()
	{
		$sql = "SELECT * FROM `new_feedback` WHERE `to` = '0' AND `id` IN (SELECT `to` FROM `new_feedback`) AND `archive` = '0' ORDER BY `time` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();		
	}

	function getMessages($time1,$time2)
	{
		$sql = "SELECT * FROM `new_feedback` WHERE time>'$time1' AND time<'$time2' ORDER BY `time` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение всех главных (первых) сообщений пользователя по его идентификатору
	function getUserMainMessages($user_id = 1)
	{
		$sql = "SELECT * FROM `new_feedback` WHERE `user_id` = '$user_id' AND `to`='0' ORDER BY `time` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение всех ответов на пользовательский вопрос по его идентификатору
	function getAnswerMessagesOverQuestId($quest_id = 1)
	{
		$sql = "SELECT * FROM `new_feedback` WHERE `to` = '$quest_id' ORDER BY `time` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	//Получение информации о любом случайном результате пользователя
	function getCorrResult($user_id = 1)
	{
		$sql = "SELECT `new_results`.`id`,`new_results`.`data`,`new_razd`.`name_razd` FROM `new_results`,`new_razd` WHERE `new_results`.`user`='$user_id' AND `new_results`.`proz`!=`new_results`.`proz_corr` AND `new_results`.`proz_corr`>0 AND `new_results`.`razd_id`=`new_razd`.`id` LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0];
	}
	
}

?>