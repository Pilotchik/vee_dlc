<?php

class Results_model extends CI_Model{
	
	function getDisciplines($type_r="")
	{
		$sql="SELECT * FROM `new_tests` where `type_r`='$type_r' and `del`='0' and id in (SELECT `test_id` FROM `new_razd` WHERE `del`='0' and `id` in (SELECT `razd_id` FROM `new_results`))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getLastTest($disc_id="")
	{
		$sql="SELECT max(data) FROM `new_results` where `timeend`!='0' AND `razd_id` in (SELECT `id` FROM `new_razd` where `test_id`='$disc_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getDisciplin($disc_id="")
	{
		$sql="SELECT * FROM `new_razd` where `test_id`='$disc_id' and `del`='0' and id in (SELECT razd_id FROM `new_results`)";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getLastResult($test_id="")
	{
		$sql="SELECT max(data) FROM `new_results` where timeend!='0' AND razd_id='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getResults($test_id="",$time1="0",$time2="9999999999999",$gr_id="")
	{
		if ($gr_id=="")
		{
			$sql="SELECT `new_results`.*,`new_numbers`.`name_numb`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`guest` FROM `new_results`,`new_numbers`,`new_persons` WHERE `new_results`.`razd_id`='$test_id' AND `new_numbers`.`id` = `new_persons`.`numbgr` and `new_persons`.`id`=`new_results`.`user` AND `new_persons`.`block`='0' AND `new_results`.`timeend`>'$time1' AND `new_results`.`timeend`<'$time2' ORDER BY `new_results`.`timeend` DESC";
		}
		else
		{
			$sql="SELECT `new_results`.*,`new_numbers`.`name_numb`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`guest` FROM `new_results`,`new_numbers`,`new_persons` WHERE `new_results`.`razd_id`='$test_id' AND `new_numbers`.`id` = `new_persons`.`numbgr` AND `new_numbers`.`id` = '$gr_id' AND `new_persons`.`id`=`new_results`.`user` AND `new_persons`.`block`='0' AND `new_results`.`timeend`>'$time1' AND `new_results`.`timeend`<'$time2' ORDER BY `new_results`.`timeend` DESC";
		}
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	function getGroupWithResults($test_id="")
	{
		$sql="SELECT `name_numb`,`id` FROM `new_numbers` WHERE `active`='1' ORDER BY `type_r`, `name_numb`";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}

	function getQuests($test_id="")
	{
		$sql="SELECT `text`,`id`,`incorrect` FROM `new_vopros` WHERE razd_id='$test_id' ORDER BY `incorrect` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getQuestResult($res_id="",$quest_id="")
	{
		$sql="SELECT `true` FROM `new_stud_ans` WHERE `results`='$res_id' AND `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		if (count($data)>0)
		{
			return $data[0]['true'];
		}
		else
		{
			return "";
		}
	}

	function getSkala($test_id="")
	{
		$sql="SELECT `three`,`four`,`five` FROM `new_razd` where `id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getStudResult($res_id="")
	{
		$sql="SELECT `new_stud_ans`.*,`new_vopros`.`text`,`new_vopros`.`level`,`new_themes`.`name_th`,`new_vopros`.`avg_time` FROM `new_stud_ans`,`new_vopros`,`new_themes` WHERE `new_stud_ans`.`results`='$res_id' AND `new_vopros`.`id` = `new_stud_ans`.`quest_id` and `new_themes`.`id_theme`=`new_vopros`.`theme_id`  ORDER BY `new_themes`.`name_th` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getStudNameOverRes($res_id = "")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` WHERE `id` IN (SELECT `user` FROM `new_results` where `id`='$res_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];	
	}

	function getTestNameOverId($test_id = "")
	{
		$sql="SELECT `name_razd` FROM `new_razd` where `id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_razd'];
	}

	function getProzResult($res_id="")
	{
		$sql="SELECT `proz` FROM `new_results` where `id`='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function delResult($res_id="",$user="",$proz="",$test_id="")
	{
		$date_t=date("Y.m.d H:i");
		$sql = "DELETE FROM `new_stud_ans` WHERE `results`='$res_id'";
		$query = $this->db->query($sql);
		$sql = "DELETE FROM `new_results` WHERE `id`='$res_id'";
		$query = $this->db->query($sql);
		$sql = "INSERT INTO `new_annul` (`person_id`,`data`,`result`,`razd_id`) VALUES ('$user', '$date_t', '$proz', '$test_id')";
		$query = $this->db->query($sql);
		return $query;		
	}

	function getCorrectResult($result_id="")
	{
		$sql="SELECT `new_stud_ans`.`true`,`new_vopros`.`level` FROM `new_stud_ans`,`new_vopros` where `new_stud_ans`.`results`='$result_id' and `new_stud_ans`.`quest_id`=`new_vopros`.`id` AND `new_vopros`.`incorrect`=0";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;			
	}

	function getTestScen($result_id="")
	{
		$sql="SELECT `quests` FROM `new_scenaries` where `res_id`='$result_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['quests'];
	}	

	function getAllInScen($quest_str="")
	{
		$sql="SELECT `level` FROM `new_vopros` where `id` in $quest_str AND `incorrect`=0";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;			
	}

	function getCountQuest($test_id="",$variant="")
	{
		$sql="SELECT COUNT(*) FROM `new_vopros` where `razd_id`='$test_id' and `del`=0 and `active`=1 and `variant`='$variant'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['COUNT(*)'];
	}


	function getLast($count="")
	{
		$sql="SELECT * FROM `new_results` WHERE `user` in (SELECT id FROM new_persons WHERE block=0) ORDER BY  `data` DESC LIMIT 0,$count";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getTestInfo($test_id="")
	{
		$sql="SELECT three,four,five,name_razd,test_id,stat_date FROM `new_razd` where `id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function getDiscInfo($disc_id="")
	{
		$sql="SELECT `name_test` FROM `new_tests` where `id`='$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_test'];
	}

	function getPersInfo($user_id="")
	{
		$sql="SELECT `new_persons`.`id`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_numbers`.`name_numb` FROM `new_persons`,`new_numbers` WHERE `new_persons`.`id`='$user_id' AND `new_persons`.`numbgr`=`new_numbers`.`id`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}	

	function getGroups($type_r="")
	{
		$sql="SELECT * FROM `new_numbers` WHERE `type_r`='$type_r' AND `active`=1 ORDER BY `name_numb`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	//id in (SELECT `numbgr` FROM `new_persons` WHERE id in (SELECT `user` FROM `new_results` WHERE `timeend`!=0))

	function getLastTestGroup($group_id="",$type_r="")
	{
		if ($type_r!="")
		{
			$sql="SELECT max(data) FROM `new_results` where timeend!='0' AND user in (SELECT id FROM `new_persons` where `numbgr`='$group_id' and `type_r`='$type_r' AND `block`=0)";
		}
		else
		{
			$sql="SELECT max(data) FROM `new_results` where timeend!='0' AND user in (SELECT id FROM `new_persons` where `guest`=0 AND `block`=0)";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];	
	}

	function getGroupStudents($group_id="")
	{
		$sql="SELECT * FROM `new_persons` WHERE `numbgr`='$group_id' AND id in (SELECT `user` FROM `new_results` WHERE `timeend`!=0 AND razd_id in (SELECT id FROM `new_razd` WHERE del=0)) AND `block`=0 ORDER BY `lastname`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	function getGroupTests($group_id="",$type_r="")
	{
		if ($type_r!=0)
		{
			$sql="SELECT `new_razd`.`id`,new_razd.name_razd,new_tests.name_test FROM `new_razd`,`new_tests` WHERE `new_razd`.`test_id`=new_tests.id AND new_razd.id in (SELECT DISTINCT `razd_id` FROM `new_results` WHERE user in (SELECT id FROM `new_persons` WHERE `numbgr`='$group_id' and `block`=0)) AND `new_razd`.`del`=0 AND new_tests.type_r in ('$type_r',3)";	
		}
		else
		{
			$sql="SELECT `new_razd`.`id`,`new_razd`.`name_razd`,new_tests.name_test FROM `new_razd`,`new_tests` WHERE `new_razd`.`test_id`=`new_tests`.`id` AND `new_razd`.`id` in (SELECT DISTINCT `razd_id` FROM `new_results` WHERE user in (SELECT id FROM `new_persons` WHERE `numbgr`='$group_id' and `block`=0)) AND `new_razd`.`del`=0";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

	function getOneStudResults($person_id="",$razd_id="")
	{
		$sql="SELECT `proz_corr`,`proz` FROM `new_results` WHERE timeend!=0 and `user`=$person_id and `razd_id`='$razd_id'";		
		$query = $this->db->query($sql);
		$data=$query->result_array();
		if (count($data)>0)
		{
			return $data[0];	
		}
		else
		{
			return "";
		}
		
	}

	function getAllStudTests($user_id="")
	{
		$sql="SELECT * FROM `new_results` WHERE timeend!=0 AND `user`='$user_id' ORDER BY  `data` DESC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getPrepod($group_id="")
	{
		$sql="SELECT `name` FROM `new_prepods` WHERE id in (SELECT `prepod_id` FROM `new_numbers` WHERE `id`='$group_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];		
	}

	//Сохранение скорректированного результата в БД для рейтинга
	function updateCorrectProz($result_id="",$proz_corr="")
	{
		$sql="UPDATE `new_results` SET `proz_corr`='$proz_corr' WHERE `id`='$result_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Количество выполненных студентом заданий
	function getCmplQuest($res_id="")
	{
		$sql="SELECT `id` FROM `new_stud_ans` WHERE `results`='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Сумма набранных баллов
	function getNowTrue($res_id="")
	{
		$sql="SELECT SUM(`true`) FROM `new_stud_ans` WHERE `results`='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['SUM(`true`)'];
	}

	function getGroupNameOverId($group_id = "")
	{
		$sql="SELECT `name_numb` FROM `new_numbers` WHERE `id`='$group_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_numb'];
	}

	function getGroupTypeROverId($group_id = "")
	{
		$sql="SELECT `type_r` FROM `new_numbers` WHERE `id`='$group_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['type_r'];
	}

	function getGroupIDOverUserID($user_id = "")
	{
		$sql="SELECT `numbgr` FROM `new_persons` WHERE `id`='$user_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['numbgr'];
	}

	function getUserNameOverUserID($user_id = "")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` WHERE `id`='$user_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

	function getDiscIDOverTestID($test_id = "")
	{
		$sql="SELECT `test_id` FROM `new_razd` WHERE `id`='$test_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['test_id'];
	}

	function getUserAnswersOverDifficult($user_id = "",$diff = 1)
	{
		$sql="SELECT `new_stud_ans`.`true`,`new_stud_ans`.`user`,`new_vopros`.`level` FROM `new_stud_ans`,`new_vopros` WHERE `new_vopros`.`id` = `new_stud_ans`.`quest_id` AND `new_stud_ans`.`user` = '$user_id' AND `new_vopros`.`level` = '$diff'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	function updateUserIndexOfDifficult($user_id = 1,$isrz = 0)
	{
		$sql="UPDATE `new_persons` SET `isrz`='$isrz' WHERE `id`='$user_id'";
		$this->db->query($sql);
	}

	function getCountIndexOfDifficult($isrz = 0, $type = 1, $type_r = 1)
	{
		if ($type == 1)
		{
			$isrz = $isrz + 0.0001;
			$sql="SELECT COUNT(`id`) AS `cnt` FROM `new_persons` WHERE `isrz` > '$isrz' AND `block` = '0' AND `type_r` = '$type_r'";
		}
		else
		{
			$isrz = $isrz - 0.0001;
			$sql="SELECT COUNT(`id`) AS `cnt` FROM `new_persons` WHERE `isrz` < '$isrz' AND `isrz` > '0' AND `block` = '0'  AND `type_r` = '$type_r'";
		}
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['cnt'];
	}

	function getTopOfIndex($type_r = 1)
	{
		$sql="SELECT `new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`isrz`,`new_numbers`.`name_numb` FROM `new_persons`,`new_numbers` WHERE `new_persons`.`numbgr` = `new_numbers`.`id` AND `new_persons`.`type_r` = '$type_r' AND `new_persons`.`block` = '0' ORDER BY `isrz` DESC LIMIT 10";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getReytingIDoverUserIdAndISRZ($user_id = 1,$isrz = 1,$reyt = 1)
	{
		$sql="SELECT `id` FROM `new_reyting` WHERE `user_id` = '$user_id' AND `reyt` = '$reyt' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return count($data);
	}

	function addStudReyt($user_id = 1, $reyt = 1, $isrz = 1)
	{
		$date = date("Y, n-1, d");
		$sql = "INSERT INTO `new_reyting` (`user_id`,`date`,`reyt`,`isrz`) VALUES ('$user_id', '$date', '$reyt','$isrz')";
		$this->db->query($sql);
	}

	function getFullReytingOverUserId($user_id = 1)
	{
		$sql="SELECT `date`,`reyt` FROM `new_reyting` WHERE `user_id` = '$user_id' ORDER BY `id` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getUserTypeROverUserID($user_id = 1)
	{
		$sql="SELECT `type_r` FROM `new_persons` WHERE `id`='$user_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['type_r'];
	}

}

?>