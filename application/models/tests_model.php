<?php

class Tests_model extends CI_Model{
	
	function getKods()
	{
		$filter_type=$this->input->post('filter_type');
		if ($filter_type=="" || $filter_type=="4")
		{
			$sql="SELECT new_razd.name_razd,new_tests.name_test,new_tests.type_r,new_razd.kod,`new_razd`.`id` FROM `new_razd`,`new_tests` where new_razd.active=1 and new_razd.del=0 and new_tests.del=0 and new_razd.test_id=new_tests.id ORDER BY new_tests.type_r ASC";
		}
		else
		{
			$sql="SELECT new_razd.name_razd,new_tests.name_test,new_tests.type_r,new_razd.kod,`new_razd`.`id` FROM `new_razd`,`new_tests` where new_razd.active=1 and new_razd.del=0 and new_tests.del=0 and new_razd.test_id=new_tests.id and new_tests.type_r='$filter_type' ORDER BY new_tests.type_r ASC";	
		}
		
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function editTest()
	{
		$id_c=$this->input->post('q_id');
		$value=$this->input->post('q_value');
		$param=$this->input->post('q_param');
		$sql = "UPDATE `new_razd` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getRazdel($id_r="")
	{
		$sql="SELECT * FROM `new_razd` where id='$id_r'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getQuests($id_r="")
	{
		$sql="SELECT new_vopros.*,`new_themes`.`name_th` FROM `new_vopros`,`new_themes` where `new_vopros`.`razd_id`='$id_r' and `new_vopros`.`theme_id`=`new_themes`.`id_theme` and `new_vopros`.`del`='0' ORDER BY `new_vopros`.`number` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getAllQuests($disc_id = "")
	{
		$sql="SELECT new_vopros.*,`new_themes`.`name_th` FROM `new_vopros`,`new_themes` where `new_vopros`.`razd_id` IN (SELECT `id` FROM `new_razd` WHERE `test_id` in ('$disc_id')) AND `new_vopros`.`theme_id`=`new_themes`.`id_theme` and `new_vopros`.`del`='0' ORDER BY `new_vopros`.`id` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function delTest()
	{
		$id_r=$this->input->post('r_id');
		$sql = "UPDATE `new_razd` SET `del` = '1' where `id`='$id_r'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createTest($id_disc="")
	{
		$t_name=$this->input->post('test_name');
		$comm=$this->input->post('comment');
		$t_time=$this->input->post('test_time');
		$date_t=date("Y.m.d H:i");
		$edu_test=$this->input->post('edu_test');
		if ($edu_test=='on')
		{
			$key_r=0;
		}
		else
		{
			$key_r=rand(1111,9999);
		}
		$sql = "INSERT INTO `new_razd` (`name_razd`,`active`,`comment`,`kod`,`del`,`data`,`time_long`,`test_id`) VALUES ('$t_name','1','$comm','$key_r','0','$date_t','$t_time','$id_disc')";
		$data = $this->db->query($sql);
		return $data;
	}

	function delQuest()
	{
		$id_q=$this->input->post('q_id');
		$sql = "UPDATE `new_vopros` SET `del` = '1' where `id`='$id_q'";
		$data = $this->db->query($sql);
		return $data;
	}

	function editQuest()
	{
		$id_q=$this->input->post('q_id');
		$value=$this->input->post('q_value');
		$param=$this->input->post('q_param');
		$sql = "UPDATE `new_vopros` SET `$param` = '$value' where `id`='$id_q'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getQuest($id_r="")
	{
		$sql="SELECT new_vopros.*,new_themes.name_th FROM `new_vopros`,`new_themes` where new_vopros.id='$id_r' and new_vopros.theme_id=new_themes.id_theme and new_vopros.del='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getAnswers($id_r="")
	{
		$sql="SELECT * FROM `new_answers` where `vopros_id`='$id_r' and `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function editAnswer()
	{
		$id_a=$this->input->post('a_id');
		$value=$this->input->post('a_value');
		$param=$this->input->post('a_param');
		$sql = "UPDATE `new_answers` SET `$param` = '$value' where `id`='$id_a'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getMaxTestNumber($test_id = "")
	{
		$sql="SELECT MAX(`number`) FROM `new_vopros` WHERE `razd_id` = '$test_id' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['MAX(`number`)'];
	}

	function createQuestOne($img_name = "",$razd_id = "",$max_number = 1,$q_text = "",$q_type = 1,$q_theme = 1,$q_var = 1)
	{
		$key_r=rand(1111111,9999999);
		$sql = "INSERT INTO `new_vopros` (`type`,`theme_id`,`text`,`image`,`razd_id`,`active`,`level`,`variant`,`code`,`number`) VALUES ('$q_type','$q_theme','$q_text','$img_name','$razd_id','1','1','$q_var','$key_r','$max_number')";
		$query = $this->db->query($sql);
		$sql="SELECT `id` FROM `new_vopros` WHERE `code`='$key_r' AND `theme_id` = '$q_theme' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['id'];
	}
	
	function createQuestTwo($razd_id = 1, $quest_id = 1, $ans = "", $quest_t = "", $true_a = "",$q_type = 1, $q_kol_a = 2)
	{
		if ($q_type == 1)
		{
			for ($i = 1;$i <= $q_kol_a;$i++)
			{
				if ($ans[$i] == '') {$ans[$i] = 0;}
				if ($true_a[1] == $i) 
				{
					$sql = "INSERT INTO `new_answers` (`text`, `true`, `vopros_id`) VALUES ('$ans[$i]', '1', '$quest_id')";
					$query = $this->db->query($sql);
				}
				else
				{
					$sql = "INSERT INTO `new_answers` (`text`, `true`, `vopros_id`) VALUES ('$ans[$i]', '0', '$quest_id')";
					$query = $this->db->query($sql);
				}
			}
		}
		if ($q_type == 2)
		{
			for ($i=1;$i<=$q_kol_a;$i++)
			{
				if ($ans[$i]=='') {$ans[$i]=0;}
				if ($true_a[$i]=='on') 
				{
					$sql="INSERT INTO `new_answers` (`text`, `true`, `vopros_id`) VALUES ('$ans[$i]', '1', '$quest_id')";
					$query = $this->db->query($sql);
				}
				if ($true_a[$i]!='on') 
				{
					$sql="INSERT INTO `new_answers` (`text`, `true`, `vopros_id`) VALUES ('$ans[$i]', '0', '$quest_id')";
					$query = $this->db->query($sql);
				}
			}
		}
		if (($q_type == 3) || ($q_type == 5))
		{
			$sql="INSERT INTO `new_answers` (`text`, `true`, `vopros_id`) VALUES ('$ans[1]', '1', '$quest_id')";
			$query = $this->db->query($sql);
		}
		if ($q_type==4)
		{
			for ($i=1;$i<=$q_kol_a;$i++)
			{
				$numbers[$i][1]=$ans[$i];
				$numbers[$i][2]=$i;
			}
			shuffle($numbers);
			for ($i=1;$i<=$q_kol_a;$i++)
			{
				$quest_text="<b>$i. </b>".$quest_t[$i];
				$sql="INSERT INTO `new_answers` (`text`,`quest_t`, `true`, `vopros_id`) VALUES ('".$numbers[$i-1][1]."', '$quest_text', '".$numbers[$i-1][2]."', '$quest_id')";
				$query = $this->db->query($sql);
			}
		}
		//Числовой диапазон
		if ($q_type == 6)
		{
			$sql="INSERT INTO `new_answers` (`text`,`true`, `vopros_id`,`option_1`,`option_2`) VALUES ('$ans[1]','1', '$quest_id', '$ans[1]','$ans[2]')";
			$query = $this->db->query($sql);
		}
		$sql = "UPDATE `new_razd` SET `view` = '1' WHERE `id`='$razd_id'";
		$query = $this->db->query($sql);
		return $query;
	}

	function delBlock()
	{
		$id_block=$this->input->post('block_id');
		$sql = "DELETE FROM `new_th_block` WHERE `id`='$id_block'";
		$query = $this->db->query($sql);
		return $query;
	}

	function addBlock($test_id="")
	{
		$id_th=$this->input->post('bl_theme');
		$id_gr=$this->input->post('bl_gr');
		$sql = "INSERT INTO `new_th_block` (`test_id`,`gr_id`,`th_id`) VALUES ('$test_id','$id_gr','$id_th')";
		$data = $this->db->query($sql);
		return $data;
	}

	function dublQuest($original_id="",$test_id="")
	{
		//insert into tblA(fld1, fld2, fld3) values ((select f1 from tblB where tblB.id = 2), (select f2 from tblCwhere tblC.name = "test"), 'Field3 text');
		$sql = "INSERT INTO `new_vopros` (`type`,`theme_id`,`text`,`image`,`razd_id`,`active`,`level`,`variant`,`original`) 
		SELECT `src`.`type`,`src`.`theme_id`,`src`.`text`,`src`.`image`,('$test_id'),`src`.`active`,`src`.`level`,`src`.`variant`, ('$original_id') FROM `new_vopros` AS `src` WHERE `id` = $original_id";
		$data = $this->db->query($sql);
		return $data;
	}

	function checkDublQuest($original_id="",$test_id="")
	{
		$sql="SELECT `id` FROM `new_vopros` where `razd_id`='$test_id' and `original`='$original_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function dublAnswer($answer_id="",$quest_id="")
	{
		//insert into tblA(fld1, fld2, fld3) values ((select f1 from tblB where tblB.id = 2), (select f2 from tblCwhere tblC.name = "test"), 'Field3 text');
		$sql = "INSERT INTO `new_answers` (`text`,`quest_t`,`true`,`vopros_id`,`image`,`del`,`success`) 
		SELECT `src`.`text`,`src`.`quest_t`,`src`.`true`,('$quest_id'),`src`.`image`,`src`.`del`,`src`.`success` FROM `new_answers` AS `src` WHERE `id` = $answer_id";
		$data = $this->db->query($sql);
		return $data;
	}

	function getVariants($id_r="")
	{
		$sql="SELECT DISTINCT `variant` FROM `new_vopros` WHERE `razd_id`='$id_r' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getCountLevelVar($test_id="",$var="",$level="")
	{
		$sql="SELECT `id` FROM `new_vopros` WHERE `razd_id`='$test_id' AND `variant`='$var' AND `level`='$level' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function getCountQuestVar($test_id="",$var="")
	{
		$sql="SELECT `id` FROM `new_vopros` WHERE `razd_id`='$test_id' AND `variant`='$var' AND `del`='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function getDiscNameOverID($disc_id = "")
	{
		$sql="SELECT `name_test` FROM `new_tests` WHERE `id`='$disc_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_test'];
	}

	function getDiscNameOverTestID($test_id = "")
	{
		$sql="SELECT `name_test` FROM `new_tests` WHERE `id` IN (SELECT `test_id` FROM `new_razd` WHERE `id` = '$test_id') LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_test'];
	}

}

?>