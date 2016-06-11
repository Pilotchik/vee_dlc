<?php

class De_model extends CI_Model
{
	function getAllDiscCourses()
	{
		$sql="SELECT `id`,`name_test` FROM `new_tests` where `del`='0' and `active`='1'  and id in (SELECT `test_id` FROM `new_courses` WHERE `active`='1' AND `del`='0')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}	

	function getCourses($disc_id="")
	{
		$sql="SELECT * FROM `new_courses` where `test_id`='$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function delCourse()
	{
		$id_r = $this->input->post('r_id');
		$sql = "UPDATE `new_courses` SET `del` = '1' WHERE `id`='$id_r'";
		$data = $this->db->query($sql);
		return $data;
	}

	function createCourse($id_disc="")
	{
		$t_name = $this->input->post('course_name');
		$comm = $this->input->post('comment');
		$date_t = date("Y.m.d H:i");
		$edu_test = $this->input->post('edu_test');
		if ($edu_test == 'on')
		{
			$key_r = 0;
		}
		else
		{
			$key_r = rand(1111,9999);
		}
		$sql = "INSERT INTO `new_courses` (`name`,`active`,`comment`,`kod`,`del`,`data`,`test_id`) VALUES ('$t_name','1','$comm','$key_r','0','$date_t','$id_disc')";
		$data = $this->db->query($sql);
		return $data;
	}

	function editCourse()
	{
		$id_c=$this->input->post('q_id');
		$value=$this->input->post('q_value');
		$param=$this->input->post('q_param');
		$sql = "UPDATE `new_courses` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getCourse($course_id = "")
	{
		$sql="SELECT `name` FROM `new_courses` where `id`='$course_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];
	}

	function getLections($course_id = "")
	{
		$sql="SELECT * FROM `new_lections` WHERE `course_id` = '$course_id' AND `del` = '0' ORDER BY `number` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function createLection($course_id = "",$numb = "")
	{
		$name = $this->input->post('lection_name');
		$comm = $this->input->post('comment');
		$tags = $this->input->post('tags');
		$type = $this->input->post('type');
		$test_id = $this->input->post('test_id');
		if ($type == 0)
		{
			$content = $this->input->post('area');	
		}
		else
		{
			$content = $this->input->post('area_docs');
		}	
		$content = addslashes($content);
		$date_t = date("Y.m.d H:i");
		$sql = "INSERT INTO `new_lections` (`name`,`active`,`comment`,`del`,`data`,`course_id`,`tags`,`content`,`test_id`,`type`,`number`) VALUES ('$name','1','$comm','0','$date_t','$course_id','$tags','$content','$test_id','$type','$numb')";
		$data = $this->db->query($sql);
		return $data;	
	}

	function editLection()
	{
		$id_c=$this->input->post('q_id');
		$value=$this->input->post('q_value');
		$value = addslashes($value);
		$param=$this->input->post('q_param');
		$sql = "UPDATE `new_lections` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getTestName($test_id = "")
	{
		$sql="SELECT `name_razd` FROM `new_razd` where `id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_razd'];
	}

	function getDiscTests($disc_id = "")
	{
		$sql="SELECT `id`,`name_razd` FROM `new_razd` WHERE `test_id`='$disc_id' AND `active`='1' AND `del`='0' AND `id` NOT IN (SELECT `test_id` FROM `new_lections` WHERE `del`='0') ORDER BY `name_razd` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getUserCourse($disc_id = "", $user_id = "", $status = "")
	{
		if ($status == 0)
		{
			//Выборка неначатых курсов для проверки кода доступа
			$sql="SELECT `id`,`name`,`kod` FROM `new_courses` WHERE `test_id`='$disc_id' AND `active`='1' AND `del`='0' AND `id` NOT IN (SELECT `course_id` FROM `new_crs_results` WHERE `user_id`='$user_id') ORDER BY `name` ASC";
		}
		else
		{
			//Выборка начатых курсов
			$sql="SELECT `id`,`name` FROM `new_courses` WHERE `test_id`='$disc_id' AND `active`='1' AND `del`='0' AND `id` IN (SELECT `course_id` FROM `new_crs_results` WHERE `user_id`='$user_id') ORDER BY `name` ASC";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getCourseCode($course_id = "")
	{
		$sql="SELECT `kod` FROM `new_courses` WHERE `id`='$course_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['kod'];
	}

	function addUserCourse($course_id = "")
	{
		$time_beg = time();
		$user_id = $this->session->userdata('user_id');
		$sql = "INSERT INTO `new_crs_results` (`user_id`,`course_id`,`timebeg`) VALUES ('$user_id','$course_id','$time_beg')";
		$data = $this->db->query($sql);
		return $data;	
	}

	function getUserCourseLect($course_id = "")
	{
		$sql="SELECT `id`,`name`,`test_id`,`tags`,`number` FROM `new_lections` WHERE `course_id` = '$course_id' AND `del` = '0' AND `active` = '1' ORDER BY `number` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getLectStatus($lection_id = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT * FROM `new_lect_results` WHERE `lection_id` = '$lection_id' AND `user_id` = '$user_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		if (count($data)>0) {return $data[0];} else {return $data;}
	}

	function getUserCourseStatus($course_id = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_crs_results` WHERE `course_id` = '$course_id' AND `user_id` = '$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function checkLectInCourse($course_id = "",$lection_id = "")
	{
		$sql="SELECT `id` FROM `new_lections` WHERE `course_id` = '$course_id' AND `id` = '$lection_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function checkUserLectInCourse($lection_id = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_lect_results` WHERE `lection_id` = '$lection_id' AND `user_id` = '$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	function addUserLectInCourse($lection_id = "")
	{
		$time_beg = time();
		$user_id = $this->session->userdata('user_id');
		$sql = "INSERT INTO `new_lect_results` (`user_id`,`lection_id`,`timebeg`) VALUES ('$user_id','$lection_id','$time_beg')";
		$data = $this->db->query($sql);
		return $data;	
	}

	function getLectionContent($lection_id = "")
	{
		$sql="SELECT `content`,`name`,`test_id`,`id` FROM `new_lections` WHERE `id` = '$lection_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function updateUserLectInCourse($lection_id = "", $result_id = "0")
	{
		$time_end = time();
		$user_id = $this->session->userdata('user_id');
		$sql = "UPDATE `new_lect_results` SET `timeend` = '$time_end',`test_res_id` = '$result_id' WHERE `lection_id`='$lection_id' AND `user_id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function searchTestResult($test_id = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_results` WHERE `razd_id` = '$test_id' AND `user` = '$user_id' AND `timeend`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function addTestResultInLect($result_id = "",$lection_id = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql = "UPDATE `new_lect_results` SET `test_res_id` = '$result_id' WHERE `lection_id`='$lection_id' AND `user_id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getDiscId($lection_id = "")
	{
		$sql="SELECT `test_id` FROM `new_courses` WHERE `id` IN (SELECT `course_id` FROM `new_lections` WHERE `id`='$lection_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['test_id'];
	}

	function getTestKey($test_id = "")
	{
		$sql="SELECT `kod` FROM `new_razd` WHERE `id`='$test_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['kod'];
	}

	function getLectionCount($course_id = "")
	{
		$sql="SELECT `id` FROM `new_lections` WHERE `course_id`='$course_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function getLectionCountClose($course_id = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_lect_results` WHERE `timeend`!='0' AND `user_id`='$user_id' AND `lection_id` IN (SELECT `id` FROM `new_lections` WHERE `course_id`='$course_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	function getCourseWhereLection($lection_id = "")
	{
		$sql="SELECT `course_id` FROM `new_lections` WHERE `id`='$lection_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['course_id'];
	}

	function getAVGTestResults($course_id = "")
	{
		$user_id = $this->session->userdata('user_id');
		$sql = "SELECT AVG(proz) FROM `new_results` WHERE `id` IN (SELECT `test_res_id` FROM `new_lect_results` WHERE `user_id`='$user_id' AND `lection_id` IN (SELECT `id` FROM `new_lections` WHERE `course_id`='$course_id'))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['AVG(proz)'];
	}

	function updateCourseResult($course_id = "",$proz_course = "",$balls_course = "",$status = "0")
	{
		if ($status == 1)	{$time_end = time();} else {$time_end = 0;}
		$user_id = $this->session->userdata('user_id');
		$sql = "UPDATE `new_crs_results` SET `timeend` = '$time_end',`proz` = '$proz_course',`balls` = '$balls_course',`status` = '$status' WHERE `course_id`='$course_id' AND `user_id`='$user_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getNameCourse($course_id = "")
	{
		$sql="SELECT `name` FROM `new_courses` WHERE `id`='$course_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];
	}

	function getStudCourses()
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT * FROM `new_crs_results` WHERE `user_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getNotMyStudCourses($user_id = "")
	{
		$sql="SELECT * FROM `new_crs_results` WHERE `user_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getDiscName($course_id = "")
	{
		$sql="SELECT `name_test` FROM `new_tests` WHERE `id` IN (SELECT `test_id` FROM `new_courses` WHERE `id` = '$course_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_test'];	
	}

	function getDisciplines($type_r = "")
	{
		$sql="SELECT `id`,`name_test` FROM `new_tests` WHERE `type_r`='$type_r' AND `id` IN (SELECT `test_id` FROM `new_courses` WHERE `del` = '0') ORDER BY `name_test` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getCoursesWithResults($disc_id = "")
	{
		$sql="SELECT `id`,`name` FROM `new_courses` WHERE `test_id`='$disc_id' AND `id` IN (SELECT `course_id` FROM `new_crs_results`) ORDER BY `name` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getDiscNameOverID($disc_id = "")
	{
		$sql="SELECT `name_test` FROM `new_tests` WHERE `id` = '$disc_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name_test'];
	}

	function getResults($course_id="",$time1="0",$time2="9999999999999")
	{
		$sql="SELECT `new_crs_results`.*,`new_numbers`.`name_numb`,`new_persons`.`lastname`,`new_persons`.`firstname`,`new_persons`.`guest` FROM `new_crs_results`,`new_numbers`,`new_persons` WHERE `new_crs_results`.`course_id`='$course_id' AND `new_numbers`.`id` = `new_persons`.`numbgr` and `new_persons`.`id`=`new_crs_results`.`user_id` AND `new_persons`.`block`='0' AND `new_crs_results`.`timebeg`>'$time1' AND `new_crs_results`.`timebeg`<'$time2' ORDER BY `new_persons`.`lastname` ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	function getStudNameOverCrsRes($crs_res_id = "")
	{
		$sql="SELECT `lastname`,`firstname`,`id` FROM `new_persons` WHERE `id` IN (SELECT `user_id` FROM `new_crs_results` WHERE `id` = '$crs_res_id')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function getStudLectionResult($course_id = "",$user_id = "")
	{
		$sql="SELECT * FROM `new_lect_results` WHERE `user_id` = '$user_id' AND `lection_id` IN (SELECT `id` FROM `new_lections` WHERE `course_id` = '$course_id') ORDER BY `timebeg` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	function getLectionName($id = "")
	{
		$sql="SELECT `name` FROM `new_lections` WHERE `id` = '$id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];

	}

	function getTestResult($res_id = "")
	{
		$sql="SELECT `proz`,`proz_corr` FROM `new_results` WHERE `id` = '$res_id' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0];
	}

	function getDiscIDOverCourseID($course_id = "")
	{
		$sql="SELECT `test_id` FROM `new_courses` WHERE `id` = '$course_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['test_id'];
	}

	function delLection()
	{
		$id_c = $this->input->post('q_id');
		$sql = "UPDATE `new_lections` SET `del` = '1' WHERE `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	function getMaxNumberOfLectInCourse($id_course = "")
	{
		$sql="SELECT MAX(`number`) as `i` FROM `new_lections` WHERE `course_id` = '$id_course' AND `del`='0'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['i'];
	}

	function getAllLectionsInCourse($course_id = 0)
	{
		$sql="SELECT * FROM `new_lections` WHERE `course_id` = '$course_id' AND `del`='0' ORDER BY `number` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

}

?>