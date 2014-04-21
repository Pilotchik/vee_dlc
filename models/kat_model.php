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

	function getUserInfo($user_id = "")
	{
		$sql = "SELECT * FROM `new_persons` WHERE `id` = '$user_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0];
	}
	function getUserResults($user_id = "")
	{
		$sql =  "SELECT `new_results`.`razd_id`,`new_results`.`true_all`,`new_results`.`true`,`new_razd`.`name_razd`,`new_tests`.`name_test`
		 FROM `new_results`,`new_razd`,`new_tests` WHERE `new_results`.`user` = '$user_id' AND `new_razd`.`id`=`new_results`.`razd_id` AND `new_tests`.`id`=`new_razd`.`test_id`";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;

	}

	function getUserThemes($user_id = 1)
	{
		$sql = "SELECT DISTINCT `new_vopros`.`theme_id`,`new_themes`.`name_th`,`new_stud_ans`.`quest_id` FROM `new_stud_ans`,`new_vopros`,`new_themes` WHERE `new_vopros`.`theme_id` = `new_themes`.`id_theme` AND `new_vopros`.`id`=`new_stud_ans`.`quest_id` AND `new_stud_ans`.`user` = '$user_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getUserThemeResult($user_id = 1, $theme_id = 1)
	{
		$sql =  "SELECT (SUM(`true`)/COUNT(*))*100 as `theme_result` FROM `new_stud_ans` WHERE `user`= '$user_id' AND `quest_id` in (SELECT `id` FROM `new_vopros` WHERE `theme_id` = '$theme_id')";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['theme_result'];		
	}

	function edit_mat($data,$id)

	{
		 $this->db->where('id',$id);
 		 $this->db->update('new_materials',$data);
	}

	function getAllMaterials()
	{
		$sql = "SELECT * FROM `new_materials` WHERE `del`='0'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function updateMaterial($id = 1,$name = "",$content = "")
	{
		$sql = "UPDATE `new_materials` SET `name`='$name',`content`='$content' WHERE `id` = '$id'";
		$this->db->query($sql);	
	}
	function deleteMaterial($id = 1)
	{
				$sql = "UPDATE `new_materials` SET `del`='1' WHERE `id` = '$id'";
				$this->db->query($sql);	
	}
	function getAllAccordance($id_mat)
	{
		$sql = "SELECT  `new_mat_themes`.`id`,`new_themes`.`name_th` ,  `new_mat_themes`.`balls` 
		FROM  `new_themes` 
		LEFT JOIN  `new_mat_themes` 
		ON  `new_themes`.`id_theme` =  `new_mat_themes`.`theme_id`
		WHERE  `new_mat_themes`.`theme_id` =  `new_themes`.`id_theme` 
		AND `new_mat_themes`.`mat_id` = '$id_mat' ";

		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	function deleteAccordance($id)
	{
		
		$sql = "DELETE FROM `new_mat_themes` WHERE `new_mat_themes`.`id` = '$id'";
		$this->db->query($sql);	
	}

	function getCurrentMat($id_mat)
	{
		$sql = "SELECT `id`,`name` FROM `new_materials` WHERE `id` = '$id_mat' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function getAllThemes()
	{
		$sql = "SELECT * FROM `new_themes` WHERE `del`='0'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function setAccordance($id_mat,$id_th,$accordance)
	{
				$sql = "INSERT INTO `new_mat_themes` (`mat_id`, `theme_id`, `balls`) VALUES ('$id_mat', '$id_th', '$accordance')";
				$this->db->query($sql);	
	}

	function getNeedMaterials($name)
	{
		$sql = "SELECT `new_materials`.`name`,`new_materials`.`id`
		FROM `new_materials` 
		LEFT JOIN `new_mat_themes` 
		ON `new_materials`.`id` = `new_mat_themes`.`mat_id`
		LEFT JOIN `new_themes` ON `new_mat_themes`.`theme_id` = `new_themes`.`id_theme`
		WHERE `new_themes`.`name_th` = '$name' AND `new_mat_themes`.`balls` > '50'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}

?>