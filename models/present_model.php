<?php

class Present_model extends CI_Model{
	

	function getAllPresents($open = "0")
	{
		if ($open == 0)
		{
			$sql="SELECT * FROM `new_present_list` WHERE `del`='0' ORDER BY `date` ASC";
		}
		else
		{
			$sql="SELECT * FROM `new_present_list` WHERE `del`='0' AND `public_status`='1' ORDER BY `date` ASC";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function delPresent()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_present_list` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getUserName($user_id = 1)
	{
		$sql = "SELECT `lastname`,`firstname` FROM `new_persons` WHERE `id` = '$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

	function editPresent($title = "", $desc = "", $theme = "", $transition = "", $status = 0, $present_id = 1)
	{
		$sql = "UPDATE `new_present_list` SET `theme` = '$theme',`transition` = '$transition',`description`='$desc',`present_name` = '$title',`public_status`='$status' WHERE `id` = '$present_id'";
		$this->db->query($sql);
	}

	function createPresent($title = "", $desc = "", $theme = "", $transition = "", $user_id = 1)
	{
		$sql = "INSERT INTO `new_present_list` (`user_id`,`present_name`,`date`,`theme`,`transition`,`description`) VALUES ('$user_id','$title',NOW(),'$theme','$transition','$desc')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getPresentName($present_id = 1)
	{
		$sql="SELECT `present_name` FROM `new_present_list` WHERE `id` = '$present_id'";
		$query = $this->db->query($sql);
		@$data = $query->result_array();
		return (isset($data[0]['present_name']) ? $data[0]['present_name'] : "");
	}

	function getPresentTheme($present_id = 1)
	{
		$sql="SELECT `theme` FROM `new_present_list` WHERE `id` = '$present_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['theme'];
	}

	function getAllSlides($present_id = 1)
	{
		$sql="SELECT * FROM `new_present_content` WHERE `present_id`='$present_id' AND `del` = '0' AND `main_slide`='0' ORDER BY `slide`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getAllSubSlides($main_slide_id = 1)
	{
		$sql="SELECT * FROM `new_present_content` WHERE `main_slide` = '$main_slide_id' AND `del` = '0' ORDER BY `slide`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function delSlide()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_present_content` SET `del` = '1' WHERE `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getMaxSlide($present_id = 1)
	{
		$sql="SELECT MAX(`slide`) FROM `new_present_content` WHERE `present_id`='$present_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['MAX(`slide`)'];
	}

	function createSlide($present_id = 1,$last = 1, $content = "", $text = "",$main_slide = 1)
	{
		$sql = "INSERT INTO `new_present_content` (`text`,`slide`,`content`,`present_id`,`main_slide`) VALUES ('$text','$last','$content','$present_id','$main_slide')";
		$this->db->query($sql);
	}

	function editSlide()
	{
		$id_c=$this->input->post('q_id');
		$value=$this->input->post('q_value');
		$param=$this->input->post('q_param');
		$sql = "UPDATE `new_present_content` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getMinSlide($present_id="")
	{
		$sql="SELECT MIN(`slide`) FROM `new_present_content` WHERE `present_id`='$present_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['MIN(`slide`)'];
	}

	function setActiveSlide($present_id="",$first="")
	{
		$sql = "UPDATE `new_present_list` SET `current_slide` = '$first' WHERE `id`='$present_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getCurrentSlide($present_id="")
	{
		$sql="SELECT `current_slide` FROM `new_present_list` WHERE `id`='$present_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['current_slide'];	
	}

}

?>