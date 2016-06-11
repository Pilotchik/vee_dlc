<?php

class Persons_model extends CI_Model{
	
	//Выборка информации о персонале
	function getPersonal()
	{
		$filter_guest=$this->input->post('filter_guest');
		if ($filter_guest=="" || $filter_guest=="5")
		{
			$sql="SELECT id,lastname,firstname,guest,mail_adr FROM `new_persons` where guest>1 AND `block` = '0'";
		}
		else
		{
			$sql="SELECT id,lastname,firstname,guest,mail_adr FROM `new_persons` where guest='$filter_guest' AND `block`='0'";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Редактирование информации о персонале
	function editPersonal()
	{
		$level=$this->input->post('level');
		$mail=$this->input->post('email');
		$id_p=$this->input->post('id_p');
		$sql = "UPDATE `new_persons` SET `guest` = '$level',`mail_adr`='$mail' where `id`='$id_p'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getFSPO($numbgr="")
	{
		$sql="SELECT `lastname`,`firstname`,`id`,`mail_adr` FROM `new_persons` where numbgr='$numbgr' and `block`=0 AND `guest`<3 ORDER BY `lastname` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getAllFSPOGroups()
	{
		$sql="SELECT `name_numb`,`id`,`active` FROM `new_numbers` WHERE `type_r`='1' ORDER BY `name_numb` ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}

	function getAllGroups()
	{
		$sql="SELECT `name_numb`,`id`,`type_r` FROM `new_numbers` WHERE `active`='1' ORDER BY `type_r`,`name_numb` ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}

	//Получение типа группы
	function getTypeGroup($new_gr="")
	{
		$sql="SELECT `type_r` FROM `new_numbers` WHERE `id`='$new_gr'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['type_r'];		
	}

	//Выборка информации о группах
	function getFspoGroups()
	{
		$filter_guest="";
		$filter_guest=$this->input->post('filter_guest');
		if ($filter_guest=="" || $filter_guest=="5")
		{
			$sql="SELECT `name_numb`,`id` FROM `new_numbers` WHERE `type_r`='1' ORDER BY `name_numb` ASC";
		}
		else
		{
			$filter_guest=$filter_guest."__";
			$sql="SELECT `name_numb`,`id` FROM `new_numbers` WHERE `type_r`='1' AND `name_numb` LIKE '$filter_guest' ORDER BY `name_numb` ASC";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Перевод всей группы
	function updateFSPOLeto($old_id="",$new_id="")
	{
		if ($old_id>0 && $new_id>0)
		{
			$sql = "UPDATE `new_persons` SET `numbgr` = '$new_id' WHERE `numbgr`='$old_id'";
			$data = $this->db->query($sql);
			return $data;
		}
		else
		{
			return 0;
		}
	}

	//Обновление информации о группе
	function updateGroup($user_id="",$new_gr="",$type_r="")
	{
		$sql = "UPDATE `new_persons` SET `numbgr` = '$new_gr',`type_r`='$type_r',`block`=0 WHERE `id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Редактирование информации о студенте ФСПО
	function editFSPO()
	{
		$lname=$this->input->post('lname');
		$fname=$this->input->post('fname');
		$level=$this->input->post('level');
		$new_group = $this->input->post('new_group');
		$email=$this->input->post('email');
		$id_p=$this->input->post('id_p');
		if ($new_group!='0')
		{
			if($new_group != 76)
			{
				$sql = "UPDATE `new_persons` SET `guest` = '$level',`mail_adr`='$email',`numbgr`='$new_group',`firstname`='$fname',`lastname`='$lname' where `id`='$id_p'";	
			}
			else
			{
				$sql = "UPDATE `new_persons` SET `guest` = '$level',`mail_adr`='$email',`numbgr`='$new_group',`firstname`='$fname',`lastname`='$lname',`block`='1' WHERE `id`='$id_p'";		
			}

		}
		else
		{
			$sql = "UPDATE `new_persons` SET `guest` = '$level',`mail_adr`='$email',`firstname`='$fname',`lastname`='$lname' where `id`='$id_p'";		
		}
		$data = $this->db->query($sql);
		return $data;
	}

	function getSegrys($numbgr="")
	{
		$filter_plosh="";
		$filter_plosh=$this->input->post('filter_plosh');
		if ($numbgr=="")
		{
			if ($filter_plosh=="" || $filter_plosh=="99")
			{
				$sql="SELECT new_numbers.name_numb,new_plosh.name_plosh,new_persons.* FROM `new_numbers`,`new_persons`,`new_plosh` where new_numbers.plosh_id=new_plosh.id_plosh and new_persons.numbgr=new_numbers.id and new_persons.type_r=2 AND new_persons.block=0";
			}
			else
			{
				$sql="SELECT new_numbers.name_numb,new_plosh.name_plosh,new_persons.* FROM `new_numbers`,`new_persons`,`new_plosh` where new_numbers.plosh_id=new_plosh.id_plosh and new_persons.numbgr=new_numbers.id and new_persons.type_r=2 and new_numbers.plosh_id='$filter_plosh' AND new_persons.block=0";
			}
		}
		else
		{
			if ($filter_plosh=="" || $filter_plosh=="99")
			{
				$sql="SELECT new_numbers.name_numb,new_plosh.name_plosh,new_persons.* FROM `new_numbers`,`new_persons`,`new_plosh` where new_numbers.plosh_id=new_plosh.id_plosh and new_persons.numbgr=new_numbers.id and new_persons.type_r=2 AND new_persons.block=0 AND new_persons.numbgr='$numbgr'";
			}
			else
			{
				$sql="SELECT new_numbers.name_numb,new_plosh.name_plosh,new_persons.* FROM `new_numbers`,`new_persons`,`new_plosh` where new_numbers.plosh_id=new_plosh.id_plosh and new_persons.numbgr=new_numbers.id and new_persons.type_r=2 and new_numbers.plosh_id='$filter_plosh' AND new_persons.block=0 AND new_persons.numbgr='$numbgr'";
			}
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Выборка информации о группах
	function getSegrysGroups()
	{
		$sql="SELECT `name_numb`,`id` FROM `new_numbers` WHERE `type_r`='2' AND `active`=1 ORDER BY `name_numb` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Выборка информации о площадках
	function getSegrysPlosh()
	{
		$sql="SELECT * FROM `new_plosh`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function editSegrys()
	{
		$lname=$this->input->post('lname');
		$fname=$this->input->post('fname');
		$level=$this->input->post('level');
		$id_gr=$this->input->post('new_group');
		$email=$this->input->post('email');
		$id_p=$this->input->post('id_p');
		if ($id_gr!='0')
		{
			$sql = "UPDATE `new_persons` SET `guest` = '$level',`mail_adr`='$email',`numbgr`='$id_gr',`firstname`='$fname',`lastname`='$lname' where `id`='$id_p'";	
		}
		else
		{
			$sql = "UPDATE `new_persons` SET `guest` = '$level',`mail_adr`='$email',`firstname`='$fname',`lastname`='$lname' where `id`='$id_p'";	
		}
		$data = $this->db->query($sql);
		return $data;
	}

	function getGuest()
	{
		$filter_type="";
		$filter_type=$this->input->post('filter_type');
		if ($filter_type=="" || $filter_type=="99")
		{
			$sql="SELECT new_persons.* FROM `new_persons` where `guest`='0' AND new_persons.block=0";
		}
		else
		{
			$sql="SELECT new_persons.* FROM `new_persons` where `guest`='0' and type_r='$filter_type' AND new_persons.block=0";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function editGuest()
	{
		$lname=$this->input->post('lname');
		$fname=$this->input->post('fname');
		$id_gr=$this->input->post('new_group');
		$id_p=$this->input->post('id_p');
		$sql = "UPDATE `new_persons` SET `numbgr`='$id_gr',`firstname`='$fname',`lastname`='$lname',`guest`='1' where `id`='$id_p'";	
		$data = $this->db->query($sql);
		return $data;
	}

	function editPerevod()
	{
		$id_gr=$this->input->post('new_group');
		$sql = "UPDATE `new_persons` SET `numbgr`='$id_gr',`type_r`=1 where `id`='$id_p'";	
		$data = $this->db->query($sql);
		return $data;
	}

	//Выборка информации о всех аккаунтах
	function getAll($user_id="",$lastname="",$firstname="")
	{
		if (($user_id=="") && ($lastname=="") && ($firstname==""))
		{
			$sql="SELECT `id`,`data_r`,`login`,`lastname`,`firstname` FROM `new_persons` WHERE `block`=0";	
		}
		else
		{
			$sql="SELECT `id`,`data_r`,`login`,`lastname`,`firstname` FROM `new_persons` WHERE `block`=0 AND `id`!='$user_id' AND (`lastname` LIKE '$lastname' OR `lastname` LIKE '$firstname') AND (`firstname` LIKE '$firstname' OR `firstname` LIKE '$lastname')";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getStudTests($user_id="")
	{
		$sql="SELECT `id`,`razd_id`,`proz_corr` FROM `new_results` WHERE `user`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getStudTestsCount($user_id="")
	{
		$sql="SELECT COUNT(*) FROM `new_results` WHERE `user`='$user_id' and `timeend`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return  $data[0]['COUNT(*)'];
	}

	function updateStudBlock($user_id="")
	{
		$sql = "UPDATE `new_persons` SET `block`=1 where `id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function updateStudResult($id_orig="",$id_dubl="")
	{
		$sql = "UPDATE `new_results` SET `user`='$id_orig' where `user`='$id_dubl'";
		$data = $this->db->query($sql);
		$sql = "UPDATE `new_stud_ans` SET `user`='$id_orig' where `user`='$id_dubl'";
		$data = $this->db->query($sql);
		return $data;
	}

	function deleteStudResult($res_id="")
	{
		$sql = "DELETE FROM `new_results` WHERE `id`='$res_id'";
		$data = $this->db->query($sql);
		$sql = "DELETE FROM `new_stud_ans` WHERE `results`='$res_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function delPerson($user_id="")
	{
		$sql = "UPDATE `new_persons` SET `block`=1 where `id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}
}

?>