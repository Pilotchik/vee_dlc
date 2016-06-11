<?php

class Plans_model extends CI_Model{
	
	function getDisciplines($type_r = "")
	{
		$sql="SELECT * FROM `new_tests` where `type_r`='$type_r' and `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getDisciplin($id_d="")
	{
		$sql="SELECT * FROM `new_tests` where id='$id_d'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function create_disc($type_r="")
	{
		$disc_name=$this->input->post('disc_name');
		$active=$this->input->post('active');
		$comment=$this->input->post('comment');
		$date_t=date("Y.m.d H:i");
		$sql = "INSERT INTO `new_tests` (`name_test`,`data`,`comment`,`active`,`del`,`type_r`) VALUES ('$disc_name','$date_t','$comment','$active', '0', '$type_r')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Редактирование информации о дисциплине
	function edit_disc()
	{
		$disc_name=$this->input->post('disc_name');
		$active=$this->input->post('active');
		$comment=$this->input->post('comment');
		$id_disc=$this->input->post('id_disc');
		$sql = "UPDATE `new_tests` SET `name_test` = '$disc_name',`active`='$active',`comment`='$comment' where `id`='$id_disc'";
		$data = $this->db->query($sql);
		return $data;
	}

	function delDisc()
	{
		$id_disc=$this->input->post('id_disc');
		$sql = "UPDATE `new_tests` SET `del` = '1' where `id`='$id_disc'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getThemes($id_d="")
	{
		$sql="SELECT * FROM `new_themes` where test_id='$id_d' and `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getRazdels($id_d="")
	{
		$sql="SELECT * FROM `new_razd` where test_id='$id_d' and del='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function delTheme($id_th="")
	{
		$sql = "UPDATE `new_themes` SET `del` = '1' where `id_theme`='$id_th'";
		$data = $this->db->query($sql);
		return $data;
	}

	function editTheme()
	{
		$id_th=$this->input->post('th_id');
		$name_th=$this->input->post('th_name');
		$sql = "UPDATE `new_themes` SET `name_th` = '$name_th' where `id_theme`='$id_th'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createTheme()
	{
		$name_th=$this->input->post('th_name');
		$id_disc=$this->input->post('disc_id');
		$sql = "INSERT INTO `new_themes` (`name_th`,`del`,`test_id`) VALUES ('$name_th','0','$id_disc')";
		$data = $this->db->query($sql);
		return $data;
	}

}

?>