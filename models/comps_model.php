<?php

class Comps_model extends CI_Model{
	
	function getAllComps()
	{
		$sql="SELECT * FROM `new_comps` WHERE `del`='0' ORDER BY `type` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function editComp()
	{
		$id_c=$this->input->post('c_id');
		$value=$this->input->post('c_value');
		$param=$this->input->post('c_param');
		$sql = "UPDATE `new_comps` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function delComp()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_comps` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createComp()
	{
		$title=$this->input->post('c_title');
		$type=$this->input->post('c_type');
		$desc=$this->input->post('c_desc');
		$prof=$this->input->post('c_prof');
		$sql = "INSERT INTO `new_comps` (`title`,`type`,`description`,`prof_activity`) VALUES ('$title','$type','$desc','$prof')";
		$data = $this->db->query($sql);
		return $data;
	}

	//выборка всех вкладов дисциплин
	function getAllContributions()
	{
		$sql="SELECT * FROM `new_comps_contributions` WHERE `del`='0' ORDER BY `compet_id` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getComp($comp_id="")
	{
		$sql="SELECT `title`,`description` FROM `new_comps` WHERE `id`='$comp_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function getCompTiDe($comp_id="")
	{
		$sql="SELECT `title`,`description` FROM `new_comps` WHERE `id`='$comp_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['title']." ".$data[0]['description'];
	}

	function getDiscParams($disc_id="")
	{	
		$sql="SELECT `name_test`,`kurs` FROM `new_tests` WHERE `id`='$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	//Добавление записи о вкладе
	function createVklad()
	{
		$comp=$this->input->post('c_comp');
		$disc=$this->input->post('c_disc');
		$vklad=$this->input->post('c_vklad');
		$comm=$this->input->post('c_comm');
		$user=$this->session->userdata('user_id');
		$sql = "INSERT INTO `new_comps_contributions` (`compet_id`,`date`,`discipline_id`,`expert_id`,`contribution`,`description`) VALUES ('$comp',NOW(),'$disc','$user','$vklad','$comm')";
		$data = $this->db->query($sql);
		return $data;
	}	

	function delVklad()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_comps_contributions` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function editVklad()
	{
		$id_c=$this->input->post('c_id');
		$value=$this->input->post('c_value');
		$param=$this->input->post('c_param');
		$sql = "UPDATE `new_comps_contributions` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение всех процентов для одной компетенции
	function getCompVklad($compet_id="")
	{
		$sql="SELECT `contribution` FROM `new_comps_contributions` WHERE `compet_id`='$compet_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Обновление коэффициента вклада
	function updateContrProz($comp_id="",$proz="")
	{
		$sql = "UPDATE `new_comps_contributions` SET `contr_proz` = '$proz' where `id`='$comp_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Выбор уникальных компетенций, для которых определён вклад
	function getUniqComps()
	{
		$sql="SELECT DISTINCT `compet_id` FROM `new_comps_contributions` WHERE `del`='0' AND `contr_proz`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Выбор дисциплин, для которых определён вклад
	function getDiscContr($compet_id="")
	{
		$sql="SELECT `contr_proz`,`discipline_id` FROM `new_comps_contributions` WHERE `compet_id`='$compet_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Выбор всех студентов, которые хоть что-то сдавали в этой дисциплине
	function getDiscUniqStudents($disc_id="")
	{
		$sql="SELECT DISTINCT `user` FROM `new_results` WHERE `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$disc_id') AND `timeend`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//выбрать все результаты студента по данной дисциплине
	function getUserResults($disc_id="",$user_id="")
	{
		$sql="SELECT `proz_corr` FROM `new_results` WHERE `razd_id` in (SELECT `id` FROM `new_razd` WHERE `test_id`='$disc_id') AND `user`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Выбрать результат пользователя
	function getResultCompUser($comp_id="",$user_id="")
	{
		$sql="SELECT * FROM `new_comps_image` WHERE `compet_id`='$comp_id' AND `user_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Запись результата
	function addResultCompUser($comp_id="",$user_id="",$balls="")
	{
		$sql = "INSERT INTO `new_comps_image` (`compet_id`,`date`,`user_id`,`balls`) VALUES ('$comp_id',NOW(),'$user_id','$balls')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Обновление результата
	function updateResultCompUser($comp_id="",$user_id="",$balls="")
	{
		$sql = "UPDATE `new_comps_image` SET `balls` = '$balls',`date`=NOW() where `compet_id`='$comp_id' AND `user_id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение студентов, для которых составлены портреты
	function getUniqStudents()
	{
		$sql="SELECT DISTINCT `user_id` FROM `new_comps_image`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение всех компетенций студента
	function getAllUserBalls($user_id="")
	{
		$sql="SELECT * FROM `new_comps_image` WHERE `user_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

}

?>