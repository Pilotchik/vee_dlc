<?php

class Moder_model extends CI_Model{
	
	//Выбрать дисциплины, в тестах которых есть задачи для проверки 
	function getDisciplines($type_r="")
	{
		$sql="SELECT * FROM `new_tests` where `type_r`='$type_r' and `del`='0' and id in (SELECT `test_id` FROM `new_razd` WHERE `del`='0' and `id` in (SELECT `razd_id` FROM `new_vopros` WHERE `type`='5'))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Узнать количество непроверенных задач
	function getCountOfAnswers($disc_id="")
	{
		$sql="SELECT `id` FROM `new_stud_ans` where `check`='0' AND `quest_id` in (SELECT `id` FROM `new_vopros` WHERE `type`='5' AND `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$disc_id'))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Выбрать все ответы для дисциплины
	function getStudAnswers($id_disc="")
	{
		$sql="SELECT * FROM `new_stud_ans` where `check`='0' AND `quest_id` in (SELECT `id` FROM `new_vopros` WHERE `type`='5' AND `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$id_disc'))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Узнать название теста и дисциплины
	function getTestName($quest_id="")
	{
		$sql="SELECT `name_razd`,`test_id` FROM `new_razd` where `id` in (SELECT `razd_id` FROM `new_vopros` WHERE `id`='$quest_id')";
		$query = $this->db->query($sql);
		$data1=$query->result_array();
		$disc_id = $data1[0]['test_id'];
		$sql="SELECT `name_test` FROM `new_tests` where `id`='$disc_id'";
		$query = $this->db->query($sql);
		$data2=$query->result_array();
		return $data2[0]['name_test'].": ".$data1[0]['name_razd'];
	}

	//Текст вопроса
	function getQuestText($quest_id="")
	{
		$sql="SELECT `text` FROM `new_vopros` where `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['text'];
	}

	//Название группы
	function getUserGroup($user="")
	{
		$sql="SELECT `name_numb` FROM `new_numbers` where `id` in (SELECT `numbgr` FROM `new_persons` WHERE `id`='$user')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_numb'];	
	}

	//Дата сдачи теста
	function getDateAnswer($result_id="")
	{
		$sql="SELECT `data` FROM `new_results` where `id`='$result_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['data'];		
	}

	//Параметры ответа
	function getStudOneAnswer($id_answer="")
	{
		$sql="SELECT * FROM `new_stud_ans` WHERE `id`='$id_answer'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Текущий результат студента
	function getUserResult($result_id="")
	{
		$sql="SELECT `proz` FROM `new_results` where `id`='$result_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['proz'];		
	}

	//Узнать текущее количество правильных заданий и количество заданий всего
	function getUserTrue($id_answer="")
	{
		$sql="SELECT `true`,`true_all`,`id`,`proz` FROM `new_results` where `id` in (SELECT `results` FROM `new_stud_ans` WHERE `id`='$id_answer')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	//Обновить информацию об ответе студента
	function updateUserAnswer($id_answer="",$balls="")
	{
		$sql = "UPDATE `new_stud_ans` SET `true` = '$balls',`check`='1' WHERE `id`='$id_answer'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Записать отчёт о проверке
	function addCheckLog($id_answer="",$balls="",$proz_before="",$new_result="",$comm="")
	{
		$prepod_id=$this->session->userdata('user_id');
		$sql = "INSERT INTO `new_moder_answers` (`answer_id`,`prepod_id`,`comment`,`balls`,`date`,`proz_before`,`proz_after`) VALUES ('$id_answer','$prepod_id','$comm','$balls',NOW(),'$proz_before','$new_result')";
		$data = $this->db->query($sql);
		return $data;
	}

	function updateUserResult($result_id="",$new_result="",$new_true="")
	{
		$sql = "UPDATE `new_results` SET `true` = '$new_true',`proz`='$new_result' WHERE `id`='$result_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getOneStudAnswers($user_id="")
	{
		$sql="SELECT * FROM `new_stud_ans` WHERE `user`='$user_id' and `quest_id` in (SELECT `id` FROM `new_vopros` WHERE `type`='5')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getCheckLog($answer_id="")
	{
		$sql="SELECT * FROM `new_moder_answers` WHERE `answer_id`='$answer_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function updateReadStatus($answer_id="")
	{
		$sql = "UPDATE `new_moder_answers` SET `student_read` = '1' WHERE `answer_id`='$answer_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getPrepodCheckAnswers()
	{
		//$user=$this->session->userdata('user_id');
		$sql="SELECT * FROM `new_moder_answers` WHERE `answer_id` in (SELECT `id` FROM `new_stud_ans` WHERE `check`='1') ORDER BY `date` DESC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getAnswerOverCheck($answer_id="")
	{
		$sql="SELECT * FROM `new_stud_ans` WHERE `id`='$answer_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

}

?>