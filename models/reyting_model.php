<?php

class Reyting_model extends CI_Model{
	
	function getStudFSPO()
	{
		$sql="SELECT `id`,`lastname`,`firstname` FROM `new_persons` where type_r=1 and `block`=0 and id in (SELECT `user` FROM `new_results` WHERE `timeend`!=0)";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Рейтинг. Версия 2.0

	function getTypeRegNameOverTypeRegId($type_r = 1)
	{
		$sql="SELECT `name` FROM `new_type_reg` WHERE `id` = '$type_r'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['name'];
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
		$sql="SELECT `new_persons`.`id`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`isrz`,`new_numbers`.`name_numb` FROM `new_persons`,`new_numbers` WHERE `new_persons`.`numbgr` = `new_numbers`.`id` AND `new_persons`.`type_r` = '$type_r' AND `new_persons`.`block` = '0' ORDER BY `isrz` DESC LIMIT 10";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getFullTopOfIndex($type_r = 1)
	{
		$sql="SELECT `new_persons`.`id`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`isrz`,`new_numbers`.`name_numb` FROM `new_persons`,`new_numbers` WHERE `new_persons`.`numbgr` = `new_numbers`.`id` AND `new_persons`.`type_r` = '$type_r' AND `new_persons`.`block` = '0' AND `new_persons`.`isrz` > 0 ORDER BY `isrz` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getLastReytingRecordOverUserId($user_id = 1)
	{
		$sql="SELECT * FROM `new_reyting` WHERE `user_id` = '$user_id' ORDER BY `id` DESC LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0];
	}

	function addStudReyt($user_id = 1, $reyt = 1, $isrz = 1, $forecast = 5)
	{
		$date = date("Y, n-1, d");
		$sql = "INSERT INTO `new_reyting` (`user_id`,`date`,`reyt`,`isrz`,`forecast`) VALUES ('$user_id', '$date', '$reyt','$isrz','$forecast')";
		$this->db->query($sql);
	}

	function getFullReytingOverUserId($user_id = 1)
	{
		$sql="SELECT `date`,`reyt`,`forecast`,`isrz` FROM `new_reyting` WHERE `user_id` = '$user_id' ORDER BY `id` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function updateStudReyt($rec_id = 1,$rank = 1,$isrz = 1, $forecast = 5)
	{
		$sql="UPDATE `new_reyting` SET `reyt`='$rank',`isrz`='$isrz',`forecast`='$forecast' WHERE `id` = '$rec_id'";
		$this->db->query($sql);
	}

	function getDateRateResort()
	{
		$sql="SELECT `rate_resort` FROM `new_conf` WHERE `id` = '1' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['rate_resort'];
	}

}

?>