<?php

class Groups_model extends CI_Model{
	
	function getFSPO()
	{
		$sql="SELECT id,name_numb,active FROM `new_numbers` WHERE `type_r`='1' AND `del`='0' ORDER BY name_numb ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function editFSPO()
	{
		$new_name = $this->input->post('old_name');
		$active = $this->input->post('active');
		$id_gr = $this->input->post('id_gr');
		$sql = "UPDATE `new_numbers` SET `name_numb` = '$new_name',`active`='$active',`level`='1' where `id`='$id_gr'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createFSPO()
	{
		$name=$this->input->post('old_name');
		$active=$this->input->post('active');
		$level=$this->input->post('level');
		$sql = "INSERT INTO `new_numbers` (`name_numb`,`active`,`type_r`,`level`) VALUES ('$name', '$active', '1', '$level')";
		$data = $this->db->query($sql);
		return $data;
	}

	function getSegrys()
	{
		$year=$this->input->post('year');
		if ($year=='')
		{
			$sql="SELECT new_numbers.id,new_numbers.name_numb,new_numbers.date_end,new_numbers.level,new_plosh.name_plosh,new_prepods.name FROM `new_numbers`,`new_plosh`,`new_prepods` where new_numbers.prepod_id=new_prepods.id AND new_numbers.plosh_id=new_plosh.id_plosh and new_numbers.type_r=2 and new_numbers.active=1 AND `new_numbers`.`del`='0' ORDER BY new_numbers.name_numb ASC";
		}
		else
		{
			$sql="SELECT new_numbers.id,new_numbers.name_numb,new_numbers.date_end,new_numbers.level,new_plosh.name_plosh,new_prepods.name FROM `new_numbers`,`new_plosh`,`new_prepods` where new_numbers.prepod_id=new_prepods.id AND new_numbers.plosh_id=new_plosh.id_plosh and new_numbers.type_r=2 and new_numbers.date_end='$year' and new_numbers.active=1 AND `new_numbers`.`del`='0' ORDER BY new_numbers.name_numb ASC";	
		}
		$query = $this->db->query($sql);
		$sql="SELECT * FROM `new_plosh` ORDER BY `name_plosh` ASC";
		$query2 = $this->db->query($sql);
		$sql="SELECT * FROM `new_prepods` where `active`=1 ORDER BY `name` ASC";
		$query3 = $this->db->query($sql);
		$data=array($query->result_array(),$query2->result_array(),$query3->result_array());
		return $data;
	}

	function editSegrys()
	{
		$new_name=$this->input->post('old_name');
		$new_date=$this->input->post('date_end');
		$new_prepod=$this->input->post('prepod');
		$new_plosh=$this->input->post('plosh');
		$id_gr=$this->input->post('id_gr');
		$sql = "UPDATE `new_numbers` SET `name_numb` = '$new_name',`date_end`=$new_date,`prepod_id`=$new_prepod,`plosh_id`=$new_plosh where `id`='$id_gr'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createSegrys()
	{
		$name=$this->input->post('old_name');
		$date=$this->input->post('date_end');
		$level=$this->input->post('level');
		$prepod=$this->input->post('prepod');
		$plosh=$this->input->post('plosh');
		$sql = "INSERT INTO `new_numbers` (`name_numb`,`date_end`,`type_r`,`level`,`plosh_id`,`active`,`prepod_id`) VALUES ('$name', '$date', '2', '$level','$plosh','1','$prepod')";
		$query = $this->db->query($sql);
		return $query;
	}

	function delGroup()
	{
		$id_gr = $this->input->post('id_gr');
		$sql = "UPDATE `new_numbers` SET `del`='1',`active`='0' WHERE `id`='$id_gr'";
		$query = $this->db->query($sql);
		return $query;
	}

	function getAllGroups()
	{
		$sql="SELECT id,name_numb,active,level,type_r FROM `new_numbers` ORDER BY name_numb ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getBlock($test_id="")
	{
		$sql="SELECT new_themes.name_th,new_th_block.*,new_numbers.name_numb FROM `new_th_block`,`new_numbers`,`new_themes` where new_th_block.test_id='$test_id' and new_themes.id_theme=new_th_block.th_id and new_numbers.id=new_th_block.gr_id";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}
}

?>