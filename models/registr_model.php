<?php

class Registr_model extends CI_Model{
	
	function getFSPO()
	{
		$sql="SELECT id,name_numb FROM `new_numbers` where `type_r`='1' and `active`='1' ORDER BY name_numb ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getSegrys()
	{
		$sql="SELECT new_numbers.id,new_numbers.name_numb,new_plosh.name_plosh FROM `new_numbers`,`new_plosh` WHERE `new_numbers`.`type_r`='2' AND `new_numbers`.`active`='1' AND `new_numbers`.`plosh_id`=`new_plosh`.`id_plosh` AND `new_numbers`.`active`=1 ORDER BY `new_plosh`.`name_plosh` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function checkLogin($login="")
	{
		$sql="SELECT `id` FROM `new_persons` WHERE `login`='$login'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];	
	}

	function createUser()
	{
		$lastname=$this->input->post('lastname');
		$firstname=$this->input->post('firstname');
		$guest = $this->input->post('guest');
		$type=$this->input->post('type');
		if ($type=='1')
		{
			$group=$this->input->post('fspo_group');
		}
		else
		{
			$group=$this->input->post('segrys_group');
		}
		if ($guest=='0')	{$group=78;}
		if ($guest > 1)		{$guest = 1;}
		$login = $this->input->post('login');
		$pass=$this->input->post('pass');
		$pass=crypt($pass);
		$date_r=date("Y.m.d H:i");
		$sql = "INSERT INTO `new_persons` (`numbgr`,`firstname`,`lastname`,`login`,`pass`,`data_r`,`guest`,`type_r`) VALUES ('$group', '$firstname', '$lastname', '$login', '$pass', '$date_r','$guest','$type')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getUser($login="")
	{
		$sql = "SELECT * FROM `new_persons` WHERE `login`='$login'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}
	
	function createVkUser()
	{
		$lastname=$this->input->post('lastname');
		$firstname=$this->input->post('firstname');
		$uid=$this->input->post('uid');
		$guest=$this->input->post('guest');
		$photo=$this->input->post('photo');
		$type=$this->input->post('type');
		if ($type=='1')
		{
			$group=$this->input->post('fspo_group');
		}
		else
		{
			$group=$this->input->post('segrys_group');
		}
		$login="vk_".$uid;
		$pass=md5(rand(1,99999));
		$date_r=date("Y.m.d H:i");
		if ($guest > 1)		{$guest = 1;}
		$sql = "INSERT INTO `new_persons` (`numbgr`,`firstname`,`lastname`,`login`,`pass`,`data_r`,`guest`,`type_r`,`photo`) VALUES ('$group', '$firstname', '$lastname', '$login', '$pass', '$date_r','$guest','$type','$photo')";
		$data = $this->db->query($sql);
		return $data;
	}

}

?>