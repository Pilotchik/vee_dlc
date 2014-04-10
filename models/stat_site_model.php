<?php

class Stat_site_model extends CI_Model{
	
	function getLogs($time1 = "",$time2 = "",$status = "")
	{
		$sql="SELECT * FROM `new_log` where time>'$time1' AND time<'$time2' AND `status`='$status' ORDER BY time DESC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getCountTests($time1="",$time2="")
	{
		$sql="SELECT COUNT(*) FROM `new_results` where timeend>'$time1' AND timeend<'$time2'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['COUNT(*)'];
	}

	function  getCountCorr()
	{
		$sql="SELECT COUNT(*) FROM `new_results` where `proz`!=`proz_corr`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['COUNT(*)'];
	}

	function  getCountCorrPlus()
	{
		$sql="SELECT COUNT(*) FROM `new_results` where `proz`<`proz_corr`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['COUNT(*)'];
	}

	function  getVkUsers()
	{
		$sql="SELECT COUNT(*) FROM `new_persons` where `block`=0 AND `login` LIKE  '%vk_%'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['COUNT(*)'];
	}

	function getNotVkUsers()
	{
		$sql="SELECT COUNT(*) FROM `new_persons` where `block`=0 AND `login` NOT LIKE  '%vk_%'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['COUNT(*)'];	
	}

	function getCountIncorrStud($type="")
	{
		$sql="SELECT DISTINCT `quest_id` FROM `new_vopros_feedback` where `type`='$type' AND `quest_id` IN (SELECT `id` FROM `new_vopros` WHERE `del`='0')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);	
	}

	function getCountIncorrStat()
	{
		$sql="SELECT `id` FROM `new_vopros` WHERE `del`='0' AND `level`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);	
	}

	//Количество активных заданий
	function getCountQuest()
	{
		$sql="SELECT `id` FROM `new_vopros` WHERE `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);	
	}

	function getCountOpinion($opinion=0)
	{
		$sql="SELECT `id` FROM `new_results` WHERE `opinion`='$opinion'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);		
	}

	function getLogCount($type = "")
	{
		$sql="SELECT count(*) FROM `new_log` WHERE `status` = '$type'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['count(*)'];
	}

	function getUserLogString()
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT count(*) FROM `new_log_status` WHERE `user` = '$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['count(*)'];
	}

	function createUserLogString()
	{
		$user_id = $this->session->userdata('user_id');
		for ($i=0;$i<4;$i++)
		{
			$sql = "INSERT INTO `new_log_status` (`user`,`log_type`) VALUES ('$user_id', '$i')";
			$query = $this->db->query($sql);	
		}
		return $query;
	}

	function getUserLogCount($type = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `count` FROM `new_log_status` WHERE `user` = '$user_id' AND `log_type` = '$type'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['count'];
	}

	function updateUserLogCount($type = "",$count = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql = "UPDATE `new_log_status` SET `count` = '$count' WHERE `user`='$user_id' AND `log_type`='$type'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getQualStatuses()
	{
		$sql = "SELECT `qual_status`,`equability` FROM `new_razd` WHERE `del`='0' AND `active`='1' AND `qual_status`>0 AND `qual_status`!='100'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

}

?>