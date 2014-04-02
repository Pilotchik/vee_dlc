<?php

class Reyting_model extends CI_Model{
	
	function getStudFSPO()
	{
		$sql="SELECT `id`,`lastname`,`firstname` FROM `new_persons` where type_r=1 and `block`=0 and id in (SELECT `user` FROM `new_results` WHERE `timeend`!=0)";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function updateAllReyt($type_r="", $progr="")
	{
		if ($type_r==1)
		{
			$sql="UPDATE `new_persons` SET `reyt_type`=0 WHERE `type_r`='1'";	
		}
		else
		{
			if ($progr=="bk")
			{
				$sql="UPDATE `new_persons` SET `reyt_type`=0 WHERE `type_r`='2' AND numbgr in (SELECT id FROM `new_numbers` WHERE `name_numb` LIKE '%Б%')";
			}	
			else
			{
				$sql="UPDATE `new_persons` SET `reyt_type`=0 WHERE `type_r`='2' AND numbgr in (SELECT id FROM `new_numbers` WHERE `name_numb` NOT LIKE '%Б%')";
			}	
		}
		$data = $this->db->query($sql);
		return $data;	
	}

	function getStudType($progr="")
	{
		if ($progr=="bk")
		{
			$sql="SELECT `id`,`lastname`,`firstname` FROM `new_persons` where type_r=2 and `block`=0 and id in (SELECT `user` FROM `new_results` WHERE `timeend`!=0) AND numbgr in (SELECT id FROM `new_numbers` WHERE `name_numb` LIKE '%Б%')";
		}
		else
		{
			$sql="SELECT `id`,`lastname`,`firstname` FROM `new_persons` where type_r=2 and `block`=0 and id in (SELECT `user` FROM `new_results` WHERE `timeend`!=0) AND ((numbgr in (SELECT id FROM `new_numbers` WHERE `name_numb` NOT LIKE '%Б%')) OR (numbgr not in (SELECT id FROM `new_numbers`)))";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}	

	function getStudResult($user_id="")
	{
		$sql="SELECT `razd_id`,`proz_corr`,`timeend`,`timebeg` FROM `new_results` where `user`='$user_id' and `timeend`!=0 AND `proz_corr`>3";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function updateStudReyt($user_id="",$pos="",$reyt="")
	{
		$sql="UPDATE `new_persons` SET `reyt_type`='$pos',`reyting`='$reyt' WHERE `id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;	
	}

	function updateTypeReyt($type="")
	{
		$date_t=date("Y.m.d H:i");
		$sql="UPDATE `new_type_reg` SET `reyt_date`='$date_t' WHERE `id`='$type'";
		$data = $this->db->query($sql);
		return $data;		
	}

	function getStudGroup($user_id="")
	{
		$sql="SELECT new_numbers.name_numb,new_prepods.name FROM `new_numbers`,`new_prepods` WHERE new_numbers.id in (SELECT numbgr FROM `new_persons` WHERE `id`='$user_id') AND new_numbers.prepod_id=new_prepods.id";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		if (!isset($data[0]))
		{
			$data[0]['name_numb']="Неизвестно";
			$data[0]['name']="Неизвестно";
			return $data[0];
		}
		else
		{
			return $data[0];			
		}
	}

	function getTestPars($razd_id="")
	{
		$sql="SELECT `multiplicity`,`time_avg` FROM `new_razd` where `id`='$razd_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];		
	}

	function getDateStud($user_id="")
	{
		$sql="SELECT `reyt`,`date` FROM `new_reyting` where `user`='$user_id' ORDER BY `date` DESC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		if (!isset($data[0]))
		{
			$data[0]['reyt']="hell";
			$data[0]['date']="hell";
		}
		return $data[0];
	}

	function addDateStudReyt($user_id="",$pos="",$avg="")
	{
		$date=date("Y.m.d");
		$sql = "INSERT INTO `new_reyting` (`user`,`date`,`reyt`,`balls`) VALUES ('$user_id', '$date', '$pos','$avg')";
		$data = $this->db->query($sql);
		return $data;
	}

	function updateDateStudReyt($user_id="",$pos="",$avg="")
	{
		$date=date("Y.m.d");
		$sql="UPDATE `new_reyting` SET `reyt`='$pos',`balls`='$avg' WHERE `user`='$user_id' AND `date`='$date'";
		$data = $this->db->query($sql);
		return $data;	
	}

	function getHistory($user_id="")
	{
		$sql="SELECT * FROM `new_reyting` where `user`='$user_id' ORDER BY `date` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getStudInfo($user_id="")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` where `id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];	
	}

	function delHistory($id_rec="")
	{
		$sql = "DELETE FROM `new_reyting` WHERE `id`='$id_rec'";
		$query = $this->db->query($sql);
		return 0;
	}

	function getPrepods()
	{
		$sql="SELECT `id`,`name` FROM `new_prepods` where `active`=1 AND id in (SELECT prepod_id FROM new_numbers WHERE `active`=1) AND id!=16";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function getPrepodStudents($prepod_id="")
	{
		$sql="SELECT `reyting` FROM `new_persons` WHERE `numbgr` in (SELECT `id` FROM `new_numbers` where `prepod_id`='$prepod_id') AND block=0 AND `reyting`>0";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;		
	}

}

?>