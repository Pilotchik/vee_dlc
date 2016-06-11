<?php

class Auth_model extends CI_Model{
	
	function getData()
	{
		$uname=$this->input->post('username');
		$upass=$this->input->post('password');
		$pass_db="";
		$sql = "select * from new_persons where login='$uname'";
		$query = $this->db->query($sql);
		$res_array=$query->result_array();
		if (count($res_array)>0) {$pass_db=$res_array[0]['pass'];}
		$upass=crypt($upass, $pass_db);
		//echo $upass;
		$sql1 = "select * from new_persons where login='$uname' and pass='$upass'";
		$query1 = $this->db->query($sql1);
		$data=array($query->result_array(),$query1->result_array());
		return $data;
	}

	function addLog($user="",$type="",$goal="")
	{
		$date_t=date("Y.m.d H:i");
		$now_time=time();
		$sql = "INSERT INTO `new_log` (`user`,`date`,`type`,`time`,`goal`) VALUES ('$user', '$date_t','$type','$now_time','$goal')";
		$query = $this->db->query($sql);
		return $query;		
	}

	function updatePhoto($user_id="",$photo="")
	{
		$sql="UPDATE `new_persons` SET `photo`='$photo' WHERE `id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getGroup($user_id="")
	{
		$sql="SELECT `name_numb` FROM `new_numbers` WHERE `id` in (SELECT `numbgr` FROM `new_persons` WHERE `id`='$user_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_numb'];
	}
}

?>