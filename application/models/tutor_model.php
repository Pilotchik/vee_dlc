<?php

class Tutor_model extends CI_Model{
	
	//Функция добавления в БД информации о вопросе пользователя
	function addMessage($user_id = 1, $help_type = 1, $help_title = "", $help_text = "")
	{
		$now_time=time();
		$date_t=date("H:i d.m.Y");
		$sql = "INSERT INTO `new_feedback` (`user_id`,`help_text`,`help_title`,`help_type`,`data`,`time`) VALUES ('$user_id','$help_text','$help_title','$help_type','$date_t','$now_time')";
		$this->db->query($sql);
	}

	//Функция добавления в БД информации об ответе на пользовательский запрос
	function addAnswerMessage($help_id = 1,$help_answer = "",$user_id = 1)
	{
		$now_time=time();
		$date_t=date("H:i d.m.Y");
		$sql = "INSERT INTO `new_feedback` (`user_id`,`help_text`,`help_title`,`to`,`data`,`time`) VALUES ('$user_id','$help_answer','Ответ','$help_id','$date_t','$now_time')";
		$this->db->query($sql);
	}

	//Функция выборки сообщений, на которые ещё не были даны ответы
	function getAllMessagesWithoutAnswers()
	{
		$sql = "SELECT * FROM `new_feedback` WHERE `to` = '0' AND `id` NOT IN (SELECT `to` FROM `new_feedback`) AND `archive` = '0' ORDER BY `time` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();	
	}

	//Получение всех открытых вопросов, для которых уже были ответы
	function getAllActiveMessagesWithAnswers()
	{
		$sql = "SELECT * FROM `new_feedback` WHERE `to` = '0' AND `id` IN (SELECT `to` FROM `new_feedback`) AND `archive` = '0' ORDER BY `time` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();		
	}

	//Получение всех закрытых вопросов
	function getAllUnActiveMessagesWithAnswers($time1 = 0,$time2 = 0)
	{
		$sql = "SELECT * FROM `new_feedback` WHERE `to` = '0' AND `id` IN (SELECT `to` FROM `new_feedback`) AND `archive` = '1' AND `time` > '$time1' AND `time` < '$time2' ORDER BY `time` DESC";
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

	//Функция изменения статуса архивации сообщения по его идентификатору
	function archiveMessage($help_id = 1)
	{
		$sql = "UPDATE `new_feedback` SET `archive` = '1' WHERE `id` = '$help_id'";
		$this->db->query($sql);
	}
	
	//Функция изменения оценки ответа на вопрос администратором
	function updateMessageGrade($help_id = 1,$help_grade = 0)
	{
		$sql = "UPDATE `new_feedback` SET `grade` = '$help_grade' WHERE `id` = '$help_id'";
		$this->db->query($sql);
	}

	//Функция изменения статуса архивации вопроса
	function archiveMessageOverIdAndUserId($help_id = 1,$user_id = 1)
	{
		$sql = "UPDATE `new_feedback` SET `archive` = '1' WHERE `id` = '$help_id' AND `user_id` = '$user_id'";
		$this->db->query($sql);
	}

	//Получение текста всех вопросов пользователей
	function getAllQuestText()
	{
		$sql = "SELECT `help_text` FROM `new_feedback` WHERE `to` = '0'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}

?>