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

	function editPresent()
	{
		$id_c=$this->input->post('c_id');
		$value=$this->input->post('c_value');
		$param=$this->input->post('c_param');
		$sql = "UPDATE `new_present_list` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createPresent()
	{
		$title=$this->input->post('f_title');
		$user=$this->session->userdata('user_id');
		$sql = "INSERT INTO `new_present_list` (`user_id`,`present_name`,`del`,`date`,`public_status`) VALUES ('$user','$title','0',NOW(),'0')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getPresentName($present_id="")
	{
		$sql="SELECT `present_name` FROM `new_present_list` WHERE `id`='$present_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['present_name'];
	}

	function getAllSlides($present_id="")
	{
		$sql="SELECT * FROM `new_present_content` WHERE `present_id`='$present_id' AND `del`='0' ORDER BY `slide`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function delSlide()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_present_content` SET `del` = '1' WHERE `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getMaxSlide($present_id="")
	{
		$sql="SELECT MAX(`slide`) FROM `new_present_content` WHERE `present_id`='$present_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['MAX(`slide`)'];
	}

	function createSlide($present_id="",$last="")
	{
		$title = $this->input->post('f_title');
		$image = $this->input->post('f_file');
		$sql = "INSERT INTO `new_present_content` (`text`,`slide`,`image`,`present_id`,`del`) VALUES ('$title','$last','$image','$present_id','0')";
		$data = $this->db->query($sql);
		return $data;
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