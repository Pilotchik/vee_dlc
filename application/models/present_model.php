<?php

class Present_model extends CI_Model{
	
	//Получение списка презентаций (только опубликованных или всех)
	function getAllPresents($type = 0, $user_id = 0)
	{
		if ($type == 0)
		{
			$sql="SELECT * FROM `new_present_list` WHERE `del`='0' AND `public_status`='1' AND `user_id` != '$user_id' ORDER BY `date` ASC";
		}
		else
		{
			$sql="SELECT * FROM `new_present_list` WHERE `del`='0' AND `user_id` = '$user_id' ORDER BY `date` ASC";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Изменение статуса архивации презентации
	function delPresent()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_present_list` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение имени пользователя по его идентификатору
	function getUserName($user_id = 1)
	{
		$sql = "SELECT `lastname`,`firstname` FROM `new_persons` WHERE `id` = '$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

	//Изменение параметров презентации
	function editPresent($title = "", $desc = "", $theme = "", $transition = "", $status = 0, $present_id = 1)
	{
		$sql = "UPDATE `new_present_list` SET `theme` = '$theme',`transition` = '$transition',`description`='$desc',`present_name` = '$title',`public_status`='$status' WHERE `id` = '$present_id'";
		$this->db->query($sql);
	}

	//Добавление в БД информации о презентации
	function createPresent($title = "", $desc = "", $theme = "", $transition = "", $user_id = 1)
	{
		$sql = "INSERT INTO `new_present_list` (`user_id`,`present_name`,`date`,`theme`,`transition`,`description`) VALUES ('$user_id','$title',NOW(),'$theme','$transition','$desc')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение названия презентации по её идентификатору
	function getPresentName($present_id = 1)
	{
		$sql="SELECT `present_name` FROM `new_present_list` WHERE `id` = '$present_id'";
		$query = $this->db->query($sql);
		@$data = $query->result_array();
		return (isset($data[0]['present_name']) ? $data[0]['present_name'] : "");
	}

	//Получение темы оформления презентации по её идентификатору
	function getPresentTheme($present_id = 1)
	{
		$sql="SELECT `theme` FROM `new_present_list` WHERE `id` = '$present_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['theme'];
	}

	//Получение информации о всех слайдах презентации
	function getAllSlides($present_id = 1)
	{
		$sql="SELECT * FROM `new_present_content` WHERE `present_id`='$present_id' AND `del` = '0' AND `main_slide`='0' ORDER BY `slide`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение информации о всех подслайдах презентации
	function getAllSubSlides($main_slide_id = 1)
	{
		$sql="SELECT * FROM `new_present_content` WHERE `main_slide` = '$main_slide_id' AND `del` = '0' ORDER BY `slide`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Изменение статуса архивации слайда
	function delSlide()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_present_content` SET `del` = '1' WHERE `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение максимального номера слайда в презентации по её идентификатору
	function getMaxSlide($present_id = 1)
	{
		$sql="SELECT MAX(`slide`) FROM `new_present_content` WHERE `present_id`='$present_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['MAX(`slide`)'];
	}

	//Добавление информации о слайде в БД
	function createSlide($present_id = 1,$last = 1, $content = "", $text = "",$main_slide = 1)
	{
		$sql = "INSERT INTO `new_present_content` (`text`,`slide`,`content`,`present_id`,`main_slide`) VALUES ('$text','$last','$content','$present_id','$main_slide')";
		$this->db->query($sql);
	}

	//Изменение параметров слайда
	function editSlide()
	{
		$id_c=$this->input->post('q_id');
		$value=$this->input->post('q_value');
		$param=$this->input->post('q_param');
		$sql = "UPDATE `new_present_content` SET `$param` = '$value' where `id`='$id_c'";
		$this->db->query($sql);
	}

	//функция изменения номера слайда
	function changeIndex($present_id = 1, $index_h = 0,$index_v = 0)
	{
		$sql = "UPDATE `new_present_list` SET `index_h` = '$index_h',`index_v` = '$index_v' WHERE `id` = '$present_id'";
		$this->db->query($sql);
	}

	//Получение текущих индексов
	function getCurrentIndexes($present_id = 1)
	{
		$sql = "SELECT `index_h`,`index_v` FROM `new_present_list` WHERE `id` = '$present_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0];	
	}

	//Обновление информации о текущих слайдах
	function updatePresentIndexes($present_id = 1)
	{
		$sql = "UPDATE `new_present_list` SET `index_h` = '0',`index_v` = '0' WHERE `id` = '$present_id'";
		$this->db->query($sql);
	}

}

?>