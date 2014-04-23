<?php

class Attest_model extends CI_Model
{
	function getDdos($s_id="")
	{
		$sql="SELECT ddos FROM `new_sessions` where `session_id`='$s_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['ddos'];
	}

	function updateDdos($s_id="",$ddos="")
	{
		$sql="UPDATE `new_sessions` SET `ddos` ='$ddos' where session_id='$s_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getDisciplines($type_r="")
	{
		$sql="SELECT id,name_test FROM `new_tests` where `type_r` in ($type_r,3) and `del`='0' and `active`='1' and id in (SELECT test_id from `new_razd` where `view`='1' and `active`='1' and `del`='0') ORDER BY `name_test` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}	
	
	function getAllDisciplines()
	{
		$sql="SELECT id,name_test FROM `new_tests` where `del`='0' and `active`='1'  and id in (SELECT test_id from `new_razd` where `view`='1' and `active`='1' and `del`='0') ORDER BY `name_test` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}	

	function getDiscipline($disc_id="")
	{
		$sql="SELECT name_test FROM `new_tests` where `id`='$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getTests_uncompl($disc_id="",$user_id="")
	{
		$sql="SELECT id,name_razd,kod,active FROM `new_razd` where `test_id`='$disc_id' and `del`='0' and `view`='1' and `active`='1' and id not in (select razd_id from `new_results` where `user`='$user_id' and `timeend`!='0')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение всех пройденных тестов
	function getTests_compl($disc_id = 1,$user_id = 1)
	{
		$sql="SELECT `new_razd`.`stud_view`,`new_razd`.`id`,`new_razd`.`name_razd`,`new_results`.`id` as `res_id` FROM `new_razd`,`new_results` WHERE `new_razd`.`test_id` = '$disc_id' AND `new_results`.`razd_id` = `new_razd`.`id` AND `new_results`.`user` = '$user_id' AND `new_results`.`timeend` != '0'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	function getTest($test_id="")
	{
		$sql="SELECT * FROM `new_razd` where `id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getNameTest($test_id="")
	{
		$sql="SELECT `name_razd` FROM `new_razd` where `id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_razd'];	
	}

	function getResult($test_id="",$user_id="")
	{
		$sql="SELECT * FROM `new_results` WHERE `razd_id`='$test_id' and `user`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	//Получение номер вопросов (каждый номер может содержать несколько вариантов)
	function getNumberOfTest($test_id="",$rnd_status = 0)
	{
		if ($rnd_status == 0)
		{
			$sql="SELECT DISTINCT `number` FROM `new_vopros` where `razd_id`='$test_id' and `active`='1' and `del`='0' ORDER BY RAND()";
		}
		else
		{
			$sql="SELECT DISTINCT `number` FROM `new_vopros` WHERE `razd_id`='$test_id' AND `active`='1' AND `del`='0' ORDER BY `number` ASC";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getVariants($test_id="",$number="")
	{
		$sql="SELECT id FROM `new_vopros` where `razd_id`='$test_id' and `number`='$number' and `active`='1' and `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getQuests($test_id="",$quest_id_str="")
	{
		$sql="SELECT `id`,`type`,`text`,`image` FROM `new_vopros` where `razd_id`='$test_id' and `active`='1' and `id` in $quest_id_str and `del`='0' ORDER BY RAND()";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getSpecQuests($test_id="",$user_id="",$all_quests = "")
	{
		$sql="SELECT `id`,`type`,`text`,`image` FROM `new_vopros` WHERE `razd_id`='$test_id' AND `active`='1' and `del`='0' AND `id` NOT IN (SELECT `quest_id` FROM `new_stud_ans` WHERE `user`='$user_id') AND `id` IN $all_quests ORDER BY RAND()";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}	

	//Данные об ответе
	function getAnswer($ans_id="")
	{
		$sql="SELECT `true` FROM `new_answers` WHERE `id`='$ans_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	//Много ответов для одного вопроса
	function getAnswers($vopros_id="")
	{
		$sql="SELECT `text`,`image`,`id`,`true`,`quest_t`,`option_1`,`option_2` FROM `new_answers` where `vopros_id`='$vopros_id' and `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getTrueAnswers($vopros_id="")
	{
		$sql="SELECT `text`,`image`,`id`,`true`,`quest_t`,`option_1`,`option_2` FROM `new_answers` WHERE `true`='1' AND `vopros_id`='$vopros_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getResRecord($user_id="",$test_id="")
	{
		$sql="SELECT `id`,`true_all`,`proz` FROM `new_results` where `user`='$user_id' and `razd_id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function createResRecord($test_id="",$user_id="",$now_time="",$var="",$true_all="")
	{
		$date_t=date("Y.m.d H:i");
		$year=date("Y");
		if ($test_id!=0)
		{
			$sql = "INSERT INTO `new_results` (`razd_id`,`user`,`timebeg`,`data`,`year`,`variant`,`true_all`) VALUES ('$test_id','$user_id','$now_time','$date_t','$year','$var','$true_all')";
		}		
		$data = $this->db->query($sql);
		return $data;
	}

	//Создание сценария
	function createScenariy($res_id="",$str="")
	{
		$sql = "INSERT INTO `new_scenaries` (`res_id`,`quests`) VALUES ('$res_id','$str')";		
		$data = $this->db->query($sql);
		return $data;		
	}

	//Получение строки сценария
	function getScenariy($res_id="")
	{
		$sql="SELECT `quests` FROM `new_scenaries` where `res_id`='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['quests'];
	}

	function getQuest($quest_id="")
	{
		$sql="SELECT `type` FROM `new_vopros` where `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getPersonalAnswer($quest_id="",$user_id="")
	{
		$sql="SELECT * FROM `new_stud_ans` WHERE `quest_id`='$quest_id' AND `user`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function updatePersonalAnswer($ans_id="",$true_q="",$true="")
	{
		$sql="UPDATE `new_stud_ans` SET `answer` ='$true_q',`true`='$true' where id='$ans_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function addPersonalAnswer($user_id="",$id_q="",$true_q="",$result_id="",$true="",$quest_time = "0")
	{
		$now_time = time();
		$sql = "INSERT INTO `new_stud_ans` (`user` ,`quest_id` ,`answer` ,`results`,`true`,`unix_time`,`time`) VALUES ('$user_id','$id_q','$true_q','$result_id','$true','$now_time','$quest_time')";
		$data = $this->db->query($sql);
		return $data;	
	}

	function updateResTimeRecord($result_id="",$time_s="")
	{
		$sql="UPDATE `new_results` SET `timesave` ='$time_s' WHERE id='$result_id'";
		$data = $this->db->query($sql);
		return $data;	
	}

	function getStudAnswers($result_id="")
	{
		$sql="SELECT `true` FROM `new_stud_ans` WHERE `results`='$result_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function updateResRecord($result_id="",$true_cnt="",$abs="",$now_time="")
	{
		$sql="UPDATE `new_results` SET `timeend` ='$now_time',`true`='$true_cnt',`proz`='$abs',`proz_corr`='$abs' WHERE id='$result_id'";
		$data = $this->db->query($sql);
		return $data;	
	}

	//Добавление записи о некорректном вопросе
	function addIncorrQuest($user_id="",$id_q="",$type="")
	{
		$sql = "INSERT INTO `new_vopros_feedback` (`user_id` ,`quest_id`,`type`) VALUES ('$user_id','$id_q','$type')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Обновление записи результата мнением
	function updateResOpinion($res_id="",$opinion="")
	{
		$sql="UPDATE `new_results` SET `opinion` ='$opinion' WHERE id='$res_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Узнать начало сдачи теста
	function getTestBegin($res_id = "")
	{
		$sql="SELECT `timebeg` FROM `new_results` where `id`='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['timebeg'];
	}

	//Время выполнения предыдущего вопроса
	function getPrevQuest($result_id = "",$quest_id = "")
	{
		$sql="SELECT `unix_time` FROM `new_stud_ans` WHERE `results` = '$result_id' AND `quest_id` != '$quest_id' ORDER BY  `id` DESC LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		if (isset($data[0]['unix_time']))
		{
			return $data[0]['unix_time'];
		}
		else
		{
			return 0;
		}
	}

}

?>