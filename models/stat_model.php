<?php

class Stat_model extends CI_Model{
	
	//Получение количества результатов тестов по идентификатору дисциплины
	function getTestCount($disc_id = 1)
	{
		$sql="SELECT COUNT(*) FROM `new_results` where `timeend`!='0' AND `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$disc_id')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации о всех результатах теста по его идентификатору
	function getTestResult($test_id = 1)
	{
		$sql = "SELECT `proz`,`proz_corr`,`timeend`,`timebeg` FROM `new_results` WHERE `timeend` != '0' AND `razd_id`='$test_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации о вопросах теста по его идентификатору
	function getQuests($test_id = 1)
	{
		$sql = "SELECT `id`,`text` FROM `new_vopros` where `razd_id` = '$test_id' AND `id` IN (SELECT `quest_id` FROM `new_stud_ans`)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение статуса успешности выполнения вопроса по его идентификатору
	function getQuestResults($quest_id = 1)
	{
		$sql = "SELECT `true` FROM `new_stud_ans` WHERE `quest_id` = '$quest_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение списка тем по идентификатору дисциплины
	function getThemes($disc_id = 1)
	{
		$sql="SELECT `id_theme`, `name_th` FROM `new_themes` where id_theme in (SELECT `theme_id` FROM `new_vopros` where `razd_id`='$disc_id')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение статуса успешности выполнения вопроса по идентификатору темы
	function getThemeResults($theme_id="")
	{
		$sql="SELECT `true` FROM `new_stud_ans` where `quest_id` in (SELECT `id` FROM `new_vopros` WHERE `theme_id`='$theme_id')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение списка пользователей, которые учавствовали в тестах по дисциплинам
	function getUsers($disc_id = 1, $type_r = 1)
	{
		$sql="SELECT DISTINCT `user`,`proz_corr` FROM `new_results` where `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$disc_id') AND `user` in (SELECT `id` FROM `new_persons` WHERE `type_r` in $type_r AND `block`=0)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации о группах и идентификаторах преподавателей по идентикаторам пользователей
	function getGroups($nabor="")
	{
		$sql="SELECT DISTINCT `name_numb`,`id`,`prepod_id` FROM `new_numbers` WHERE `id` in (SELECT `numbgr` FROM `new_persons` WHERE `id` in $nabor) AND `active` = '1'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации о преподавателях по идентикаторам групп
	function getPrepods($nabor="")
	{
		$sql="SELECT DISTINCT `name`,`id` FROM `new_prepods` where `id` in (SELECT `prepod_id` FROM `new_numbers` WHERE `id` in $nabor)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение идентификатора группы по идентификатору пользователя
	function getGroupId($user_id = 1)
	{
		$sql="SELECT `numbgr` FROM `new_persons` WHERE `id` = '$user_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение списка пользователей, которые учавствовали в тесте
	function getUsersTest($test_id="")
	{
		$sql="SELECT DISTINCT `user`,`proz_corr` FROM `new_results` where `razd_id`='$test_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение списка идентификаторов вопросов теста по его идентификатору
	function getQuestsTest($test_id = 1)
	{
		$sql = "SELECT `id` FROM `new_vopros` WHERE `razd_id` = '$test_id' AND `del` = '0' ORDER BY `id` ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации о вопросах по идентификатору теста
	function getQuestsTestReport($test_id = 1)
	{
		$sql="SELECT `id`,`success`,`level`,`theme_id`,`text` FROM `new_vopros` WHERE `razd_id`='$test_id' AND `del`=0 ORDER BY `id` ";
		$query = $this->db->query($sql);
		return $query->result_array();	
	}

	//Получение вопросов, на которые есть ответы по идентификатору результата тестирования
	function getQuestInfo($result_id = 1)
	{
		$sql="SELECT `true`,`quest_id` FROM `new_stud_ans` where `results`='$result_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации об ответах студентов по идентификатору теста
	function getAnswersInfo($test_id = 1)
	{
		$sql = "SELECT `user`,`id` FROM `new_results` WHERE `timeend`!=0 AND `razd_id`='$test_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации о тексте вопроса по его идентификатору
	function getQuestText($quest_id = 1)
	{
		$sql = "SELECT `text` FROM `new_vopros` WHERE `id`='$quest_id' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Изменить статус корректности вопроса по его идентификатору
	function editQuestStatus($quest_id = 1, $status = 0)
	{
		$sql = "UPDATE `new_vopros` SET `incorrect` = '$status' WHERE `id`='$quest_id'";
		$this->db->query($sql);
	}

	//Изменить статус успешности вопроса по его идентификатору
	function editQuestSuccess($quest_id = 1, $status = 0)
	{
		$sql = "UPDATE `new_vopros` SET `success` = '$status' WHERE `id`='$quest_id'";
		$this->db->query($sql);
	}

	//Изменить статус уровня сложности вопроса по его идентификатору
	function editQuestDiff($quest_id = 1, $diff = 1)
	{
		$sql = "UPDATE `new_vopros` SET `level` = '$diff' WHERE `id`='$quest_id'";
		$this->db->query($sql);
	}
		
	//Запись даты последнего сбора статистики
	function editStatParams($test_id = 1, $qual_status = 0, $equability = 0)
	{
		$date_t=date("Y.m.d H:i");
		$sql="UPDATE `new_razd` SET `stat_date`='$date_t',`qual_status`='$qual_status',`equability`='$equability' WHERE `id`='$test_id'";
		$this->db->query($sql);
	}

	//Обновление статуса успешности прохождения теста и среднего затраченного времени по его идентификатору
	function updateTestMultiplicity($test_id = 1,$abs = 0,$time_avg = 0)
	{
		$sql="UPDATE `new_razd` SET `multiplicity`='$abs',`time_avg`='$time_avg' WHERE `id`='$test_id'";
		$this->db->query($sql);
	}

	//Получение идентификатора образовательно учреждения по идентификатору дисциплины
	function getTypeDisc($disc_id = 1)
	{
		$sql = "SELECT `type_r` FROM `new_tests` WHERE `id`='$disc_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['type_r'];
	}

	//Получение статуса успешности выполнения вопроса по его идентификатору
	function getQuestsAnswers($quest_id = 1)
	{
		$sql="SELECT `text`,`true` FROM `new_answers` WHERE `vopros_id`='$quest_id' and `del`=0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение количества студентов, оставивших отзыв о вопросе по его идентификатору
	function getQuestIncorrStud($quest_id = 1)
	{
		$sql="SELECT `user_id` FROM `new_vopros_feedback` WHERE `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return count($data);
	}

	//Получение среднего времи успешного ответа пользователя на вопрос по его идентификатору
	function getAvgTime($quest_id = 1)
	{
		$sql = "SELECT AVG(time) FROM `new_stud_ans` WHERE `quest_id`='$quest_id' AND `time`>0 AND `true`>0.5";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['AVG(time)'];
	}

	//Обновление среднего времени ответа на вопрос по его идентификатору
	function editQuestTimeStatus($quest_id = 1, $avg_time = 0)
	{
		$sql = "UPDATE `new_vopros` SET `avg_time` = '$avg_time' WHERE `id`='$quest_id'";
		$this->db->query($sql);
	}

}

?>