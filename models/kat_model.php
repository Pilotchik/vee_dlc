<?php

class Kat_model extends CI_Model
{
	function getDisciplines($type_r = "1,2")
	{
		$sql="SELECT `id`,`name_test` FROM `new_tests` WHERE `type_r` IN ($type_r,3) AND `del`='0' AND `active`='1' AND `id` IN (SELECT `disc_id` FROM `new_materials` WHERE `active`='1' AND `del`='0') ORDER BY `name_test` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getMaterials($disc_id = "")
	{
		$sql="SELECT `id`,`name` FROM `new_materials` WHERE `disc_id`='$disc_id' AND `del`='0' AND `active`='1' ORDER BY `name` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getAllDisciplines($dest = "")
	{
		$sql="SELECT `id`,`name_test` FROM `new_tests` WHERE `type_r`='$dest' AND `del`='0' AND `active`='1' ORDER BY `name_test` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function createMat($file_name = "",$name = "",$disc_id = "")
	{
		$content = addslashes($this->input->post('area'));
		$date_t=date("Y.m.d H:i");
		$sql = "INSERT INTO `new_materials` (`name`,`active`,`del`,`date`,`disc_id`,`url`,`content`) VALUES ('$name','1','0','$date_t','$disc_id','$file_name','$content')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getNameOfDisc($disc_id = "")
	{
		$sql="SELECT `name_test` FROM `new_tests` WHERE `id` = '$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_test'];
	}

	function editMat()
	{
		$id=$this->input->post('mat_id');
		$value=$this->input->post('mat_value');
		$param=$this->input->post('mat_param');
		$sql = "UPDATE `new_materials` SET `$param` = '$value' where `id`='$id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getOneMaterialOverId($mat_id = "")
	{
		$sql="SELECT * FROM `new_materials` WHERE `id` = '$mat_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function updateMaterialViewsOverId($mat_id = 1,$views = 1)
	{
		$sql = "UPDATE `new_materials` SET `views` = '$views' where `id`='$mat_id'";
		$data = $this->db->query($sql);
		return $data;
	}

}

?>