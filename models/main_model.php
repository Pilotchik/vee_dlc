<?php

class Main_model extends CI_Model{
	
	function getLast()
	{
		$tim=time();
		$tim=$tim-60*60*24;
		$sql = "SELECT count(*) FROM new_results where timeend=0 and timebeg>$tim";
		$query = $this->db->query($sql);
		$sql2 = "SELECT `data` FROM  `new_results` where `data`!=0 ORDER BY  `timeend` DESC limit 1";
		$query2 = $this->db->query($sql2);
		$data=array($query->result_array(),$query2->result_array());
		return $data;
	}

	function createLogRecord($msg = "", $status = 0)
	{
		$lname=$this->session->userdata('lastname');
		$fname=$this->session->userdata('firstname');
		$name=$lname." ".$fname;
		$now_time=time();
		$date_t=date("Y.m.d H:i");
		$sql = "INSERT INTO `new_log` (`user`,`date`,`type`,`time`,`status`) VALUES ('$name','$date_t','$msg','$now_time','$status')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getTestCount()
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT count(*) FROM `new_results` WHERE `user`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['count(*)'];
	}

	function getDeCount()
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT count(*) FROM `new_crs_results` WHERE `user_id`='$user_id' AND `timeend`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['count(*)'];
	}

	function getTestOpinionCount($opinion = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT count(*) FROM `new_results` WHERE `user`='$user_id' AND `opinion` = '$opinion'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['count(*)'];
	}

	function getGroupOverUserId()
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `name_numb` FROM `new_numbers` WHERE `id` IN (SELECT `numbgr` FROM `new_persons` WHERE `id`='$user_id') LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_numb'];
	}

	function getUserOverId($user_id = "")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` WHERE `id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

	function getAllPrepods()
	{
		$sql="SELECT `lastname`,`firstname`,`id` FROM `new_persons` WHERE `block`='0' AND `guest`>'1'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getBlockOverUserId()
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `block` FROM `new_persons` WHERE `id`='$user_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['block'];
	}

	function unblockPerson()
	{
		$user_id = $this->session->userdata('user_id');
		$sql = "UPDATE `new_persons` SET `block` = '0' where `id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getPhotoOverUserId()
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `photo` FROM `new_persons` WHERE `id`='$user_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['photo'];
	}

	function getAllPersonsLikeName($name = "")
	{
		$sql = "SELECT * FROM `new_persons` WHERE (`lastname` LIKE '%$name%' OR `firstname` LIKE '%$name%' OR `login` LIKE '%$name%') AND `block`='0' ORDER BY `lastname`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

}

?>