<?php

class Captcha_model extends CI_Model{
	
	function getAllCaptches()
	{
		$sql="SELECT * FROM `new_captcha` WHERE `del`='0' ORDER BY `date` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getTypeReg($type_r="")
	{
		$sql="SELECT `name` FROM `new_type_reg` where `id`='$type_r'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];
	}

	

	function getAllTypeReg()
	{
		$sql="SELECT `id`,`name` FROM `new_type_reg`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getCountAnswers($captcha_id="")
	{
		$sql="SELECT `id` FROM `new_captcha_answers` WHERE `captcha_id`='$captcha_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function editCaptcha()
	{
		$id_c=$this->input->post('c_id');
		$value=$this->input->post('c_value');
		$param=$this->input->post('c_param');
		$sql = "UPDATE `new_captcha` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function delCaptcha()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_captcha` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createCaptcha()
	{
		$quest=$this->input->post('q_text');
		$type_r=$this->input->post('type_r');
		$answer=$this->input->post('answer');
		$user_id=$this->session->userdata('user_id');
		$sql = "INSERT INTO `new_captcha` (`quest`,`type_r`,`author_id`,`date`,`answer`,`active`) VALUES ('$quest','$type_r','$user_id',NOW(),'$answer','1')";
		$data = $this->db->query($sql);
		return $data;
	}

}

?>