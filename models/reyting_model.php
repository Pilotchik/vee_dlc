<?php

class Reyting_model extends CI_Model{
	
	//Получение информации об учётных записях студентов ФСПО
	function getStudFSPO()
	{
		$sql="SELECT `id`,`lastname`,`firstname` FROM `new_persons` where type_r=1 and `block`=0 and id in (SELECT `user` FROM `new_results` WHERE `timeend`!=0)";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение названия образовательного учреждения по его идентификатору
	function getTypeRegNameOverTypeRegId($type_r = 1)
	{
		$sql="SELECT `name` FROM `new_type_reg` WHERE `id` = '$type_r'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['name'];
	}

	//обновить индекс сложности решённых задач по идентификатору пользователя
	function updateUserIndexOfDifficult($user_id = 1,$isrz = 0)
	{
		$sql="UPDATE `new_persons` SET `isrz`='$isrz' WHERE `id`='$user_id'";
		$this->db->query($sql);
	}

	//Получние количества пользователей, имеющих больший или меньший индекс
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

	//Получение информации первых 10 учётных записей, имеющих наибольший рейтинг
	function getTopOfIndex($type_r = 1)
	{
		$sql="SELECT `new_persons`.`id`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`isrz`,`new_numbers`.`name_numb` FROM `new_persons`,`new_numbers` WHERE `new_persons`.`numbgr` = `new_numbers`.`id` AND `new_persons`.`type_r` = '$type_r' AND `new_persons`.`block` = '0' ORDER BY `isrz` DESC LIMIT 10";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации об учётных записях и рейтингу по идентификатору образовательного учреждения
	function getFullTopOfIndex($type_r = 1)
	{
		$sql="SELECT `new_persons`.`id`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`isrz`,`new_numbers`.`name_numb` FROM `new_persons`,`new_numbers` WHERE `new_persons`.`numbgr` = `new_numbers`.`id` AND `new_persons`.`type_r` = '$type_r' AND `new_persons`.`block` = '0' AND `new_persons`.`isrz` > 0 ORDER BY `isrz` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение последней записи пользователя в истории рейтинга по его идентификатору
	function getLastReytingRecordOverUserId($user_id = 1)
	{
		$sql="SELECT * FROM `new_reyting` WHERE `user_id` = '$user_id' ORDER BY `id` DESC LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0];
	}

	//Добавление данных в историю рейтинга
	function addStudReyt($user_id = 1, $reyt = 1, $isrz = 1, $forecast = 5)
	{
		$date = date("Y, n-1, d");
		$sql = "INSERT INTO `new_reyting` (`user_id`,`date`,`reyt`,`isrz`,`forecast`) VALUES ('$user_id', '$date', '$reyt','$isrz','$forecast')";
		$this->db->query($sql);
	}

	//Получение полной истории изменения рейтинга пользователя
	function getFullReytingOverUserId($user_id = 1)
	{
		$sql="SELECT `date`,`reyt`,`forecast`,`isrz` FROM `new_reyting` WHERE `user_id` = '$user_id' ORDER BY `id` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Изменение данных в записи из истории изменения рейтинга пользователя
	function updateStudReyt($rec_id = 1,$rank = 1,$isrz = 1, $forecast = 5)
	{
		$sql="UPDATE `new_reyting` SET `reyt`='$rank',`isrz`='$isrz',`forecast`='$forecast' WHERE `id` = '$rec_id'";
		$this->db->query($sql);
	}

	//Обновление даты последней пересортировки рейтинга с помощью робота
	function updateRateResortDate()
	{
		$date_t = date("H:i d.m.Y");
		$sql="UPDATE `new_conf` SET `rate_resort` ='$date_t' WHERE `id` = '1'";
		$this->db->query($sql);
	}

	//Получение даты последней пересортировки рейтинга
	function getDateRateResort()
	{
		$sql="SELECT `rate_resort` FROM `new_conf` WHERE `id` = '1' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['rate_resort'];
	}

}

?>