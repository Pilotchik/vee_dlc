<?php

class Forms_model extends CI_Model{
	
	//Получение списка всех образовательных учреждений
	function getAllTypeReg()
	{
		$sql="SELECT `id`,`name` FROM `new_type_reg`";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение название образовательного учреждения по его идентификатору
	function getTypeReg($type_r = 1)
	{
		$sql="SELECT `name` FROM `new_type_reg` where `id`='$type_r'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['name'];
	}

	//Получение имени и фамилии автора опроса
	function getUserName($author_id="")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` where `id`='$author_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

	//Получение списка всех неудалённых опросов
	function getAllForms($active="0")
	{
		if ($active==0)
		{
			$sql="SELECT * FROM `new_forms` where `active`='1' and `del`='0' ORDER BY `date` ASC";	
		}
		else
		{
			$sql="SELECT * FROM `new_forms` where `del`='0' ORDER BY `date` ASC";
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение списка всех неудалённых опросов в зависимости от образовательного учреждения
	function getTypeRForms($type_r="1")
	{
		if (($type_r<1) || ($type_r>2))
		{
			$sql="SELECT * FROM `new_forms` where `active`='1' AND `del`='0' ORDER BY `date` ASC";	
		}
		else
		{
			$sql="SELECT * FROM `new_forms` where `active`='1' AND `type_r` in ('$type_r','3') AND `del`='0' ORDER BY `date` ASC";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение списка архивных опросов
	function getArchiveForms($type_r="1")
	{
		if (($type_r<1) || ($type_r>2))
		{
			$sql="SELECT * FROM `new_forms` where `active`='0' AND `del`='0' ORDER BY `date` ASC";	
		}
		else
		{
			$sql="SELECT * FROM `new_forms` where `active`='0' AND `type_r`='$type_r' and `del`='0' ORDER BY `date` ASC";	
		}
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение количества респондентов по идентификатору опроса
	function getCountForms($form_id="")
	{
		$sql="SELECT * FROM `new_form_results` WHERE `form_id`='$form_id' AND `end`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Изменение параметров опроса
	function editForm()
	{
		$id_c=$this->input->post('c_id');
		$value=$this->input->post('c_value');
		$param=$this->input->post('c_param');
		$sql = "UPDATE `new_forms` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Удаление опроса
	function delForm()
	{
		$id_c=$this->input->post('c_id');
		$sql = "UPDATE `new_forms` SET `del` = '1' where `id`='$id_c'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Функция добавления данных об опросе в БД
	function createForm($title = "",$type_r = 1,$desc = "",$access = 1,$user_id = 1)
	{
		$sql = "INSERT INTO `new_forms` (`title`,`type_r`,`author_id`,`date`,`description`,`active`,`access`) VALUES ('$title','$type_r','$user_id',NOW(),'$desc','1','$access')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение идентификатора опроса по названию и описанию
	function getFormIDOverTitleAndDesc($title = "",$desc = "")
	{
		$sql="SELECT `id` FROM `new_forms` WHERE `title`='$title' AND `description`='$desc' AND `active`='1' AND `del`='0' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['id'];
	}

	//Функция добавления информации о странице опроса
	function createMainSite($form_id = 1,$title = "Главная страница",$numb = 0)
	{
		$sql = "INSERT INTO `new_form_quests` (`title`,`type`,`form_id`,`numb`) VALUES ('$title','0','$form_id','$numb')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение максимального номера страницы опроса
	function getMaxSiteNumbOverFormID($form_id = 1)
	{
		$sql="SELECT MAX(`numb`) as `i` FROM `new_form_quests` WHERE `form_id`='$form_id' AND `type`='0' AND `del`='0'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['i'];
	}

	//Функция для нахождения всех страниц опроса
	function getAllSitesOverFormID($form_id = 1)
	{
		$sql="SELECT `id`,`numb`,`title` FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `type`='0' ORDER BY `numb`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Функция для выборки всех вопросов на указанной странице
	function getAllQuestsOverSiteID($form_id = 1,$site_id = 1)
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `site`='$site_id' ORDER BY `numb`";
		$query = $this->db->query($sql);
		return $query->result_array();	
	}

	//Получение списка всех элементов анкеты (вопросов, страниц и групп переходов)
	function getAllQuests($form_id = 1)
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' ORDER BY `site`,`numb`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение списка всех вопросов анкеты
	function getAllActiveQuests($form_id="")
	{
		$sql="SELECT * FROM `new_form_quests` where `form_id`='$form_id' AND `del`='0' AND `type`!=0 AND `type`!=6 AND `active`='1'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение названия опроса по его идентификатору
	function getFormName($form_id = 1)
	{
		$sql="SELECT `title` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['title'];	
	}

	//Получение описания опроса по его идентификатору
	function getFormDesc($form_id = 1)
	{
		$sql="SELECT `description` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['description'];	
	}

	//Получение статуса доступа к результатам опроса
	function getFormAccess($form_id="")
	{
		$sql="SELECT `access` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['access'];	
	}

	//Получение идентификатора образовательного учреждения, для которого был создан опрос
	function getFormOU($form_id="")
	{
		$sql="SELECT `type_r` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['type_r'];	
	}	

	//изменение параметров вопроса анкеты
	function editQuest($id_c = 1,$value = "",$param = "title")
	{
		$sql = "UPDATE `new_form_quests` SET `$param` = '$value' where `id`='$id_c'";
		$data = $this->db->query($sql);
	}

	//удаление вопроса из анкеты
	function delQuest($quest_id = 1)
	{
		$sql = "UPDATE `new_form_quests` SET `del` = '1' where `id`='$quest_id'";
		$data = $this->db->query($sql);
	}

	//Получение главной (первой) страницы опроса по его идентификатору
	function getMainSiteIdOverFormId($form_id = 1)
	{
		$sql = "SELECT `id` FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `numb`='0' AND `type`='0' LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['id'];
	}

	//изменение параметров страницы опроса по её идентификатору
	function updateQuestSite($quest_id = 1,$main_site_id = 1)
	{
		$sql = "UPDATE `new_form_quests` SET `site` = '$main_site_id' WHERE `site`='$quest_id'";
		$data = $this->db->query($sql);
	}

	//добавление в БД информации о вопросе
	function createQuest($form_id = 1, $title = "",$subtitle = "",$type = 1,$option1 = "",$option2 = "",$option3 = "",$req = 1,$site = 1,$numb = 1)
	{
		if ($type == 6)
		{
			$numb = 10;
		}
		if ($req == 'on')	{$req=1;}	else	{$req=0;}
		$sql = "INSERT INTO `new_form_quests` (`title`,`subtitle`,`type`,`required`,`option1`,`option2`,`option3`,`active`,`del`,`form_id`,`site`,`numb`) VALUES ('$title','$subtitle','$type','$req','$option1','$option2','$option3','1','0','$form_id','$site','$numb')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение статуса окончания прохождения опроса респондентом
	function getRespStatus($form_id="",$user_id="")
	{
		$sql="SELECT `end` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		if (isset($data[0]))
		{
			return $data[0]['end'];
		}
		else
		{
			return 0;
		}
	}

	//Получение списка вопросов, на которые пользователь не дал своего ответа
	function getFormQuests($form_id="",$user_id="")
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `id` NOT IN (SELECT `quest_id` FROM `new_form_answers` WHERE `res_id` IN (SELECT `id` FROM `new_form_results` WHERE `person_id` = '$user_id'))";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение списка страниц, предназначенных для студента в зависимости от его образовательного учреждения
	function getFormSiteQuests($form_id="",$user_id="",$site_id = 1)
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `form_id`='$form_id' AND `del`='0' AND `active`='1' AND `site`='$site_id' AND `id` NOT IN (SELECT `quest_id` FROM `new_form_answers` WHERE `res_id` IN (SELECT `id` FROM `new_form_results` WHERE `person_id` = '$user_id'))";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Проверка наличия записи о результате
	function checkFormResult($form_id="")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Добавление в БД записи о начале прохождения анкетирования
	function createFormResult($form_id="",$now_time="")
	{
		$user_id = $this->session->userdata('user_id');
		$sql = "INSERT INTO `new_form_results` (`form_id`,`person_id`,`begin`) VALUES ('$form_id','$user_id','$now_time')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение идентификатора записи результата
	function getResId($form_id="",$user_id="")
	{
		$sql="SELECT `id` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['id'];
	}

	//Получение типа вопроса
	function getTypeQuest($id_q="")
	{
		$sql="SELECT * FROM `new_form_quests` WHERE `id`='$id_q'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['type'];	
	}

	//Проверка, сдавался ли вопрос пользователем
	function getCheckAnswer($id_q="",$res_id="")
	{
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$id_q' AND `res_id`='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Создание записи об ответе пользователя
	function insertAnswer($id_q="",$res_id="",$value="",$value2="")
	{
		$sql = "INSERT INTO `new_form_answers` (`quest_id`,`res_id`,`answer`,`option`) VALUES ('$id_q','$res_id','$value','$value2')";
		$data = $this->db->query($sql);
		return $data;
	}

	//Обновление записи об ответе
	function updateAnswer($id_q="",$res_id="",$value="",$value2="")
	{
		$sql="UPDATE `new_form_answers` SET `answer` ='$value',`option`='$value2' WHERE `quest_id`='$id_q' AND `res_id`='$res_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Создание записи об ответе
	function insertAnswerSetkaSelect($id_q = 1,$res_id = 1,$value = "",$value2 = "",$value3 = 0)
	{
		$sql = "INSERT INTO `new_form_answers` (`quest_id`,`res_id`,`answer`,`option`,`option_7`) VALUES ('$id_q','$res_id','$value','$value2','$value3')";
		$this->db->query($sql);
	}

	//Обновление записи об ответе
	function updateAnswerSetkaSelect($id_q = 1,$res_id = 1,$value = "",$value2 = "",$value3 = 0)
	{
		$sql="UPDATE `new_form_answers` SET `option_7` = '$value3' WHERE `quest_id`='$id_q' AND `res_id`='$res_id' AND `answer` = '$value' AND `option` = '$value2'";
		$this->db->query($sql);
	}

	//Проверка, сдавался ли вопрос
	function getCheckAnswerSetka($id_q="",$res_id="",$value="")
	{
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$id_q' AND `res_id`='$res_id' AND `answer`='$value'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Проверка давался ли ответ для вопроса типа "сетка с селекторами"
	function getCheckAnswerSetkaSelect($id_q = 1,$res_id = 1,$value = 0,$value2 = 0)
	{
		$sql="SELECT `id` FROM `new_form_answers` WHERE `quest_id`='$id_q' AND `res_id`='$res_id' AND `answer`='$value' AND `option`='$value2' LIMIT 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Проверка окончания анкетирования
	function checkEndFormResult($form_id="")
	{
		$user_id = $this->session->userdata('user_id');
		$sql="SELECT `id` FROM `new_form_results` WHERE `form_id`='$form_id' AND `person_id`='$user_id' AND `end`!='0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Обновление записи о результате при завершении анкетирования
	function updateFormResult($user_id="",$form_id="",$now_time="")
	{
		$sql="UPDATE `new_form_results` SET `end` ='$now_time' WHERE `person_id`='$user_id' AND `form_id`='$form_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Изменение статуса опубликования результатов
	function updatePublicForm($form_id="",$status="")
	{
		$sql="UPDATE `new_forms` SET `public_res` ='$status' WHERE `id`='$form_id'";
		$data = $this->db->query($sql);
		return $data;
	}

	//Получение списка ответов пользователей на вопрос по его идентификатору
	function getAllQuestResults($quest_id="")
	{
		$sql="SELECT `answer`,`res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Получение количества респондентов, ответивших на вопрос у указавших в качестве ответа запрашиваемый параметр
	function getCountOptionResult($quest_id="",$answer="")
	{
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		if (isset($data))
		{
			return count($data);	
		}
		else
		{
			return 0;
		}
	}

	//Получение количества респондентов по идентификатору курса
	function getCountOptionKursResult($quest_id="",$answer="",$kurs="")
	{
		$kurs = $kurs."__";
		$sql="SELECT `id` FROM `new_numbers` WHERE `type_r`='1' AND `name_numb` LIKE '$kurs' ORDER BY `name_numb` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		$numbers="(";
		foreach ($data as $key)
		{
			$numbers=$numbers.$key['id'].",";
		}
		$numbers=substr($numbers, 0, -1);
		$numbers = $numbers.")";
		$sql="SELECT * FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `res_id` IN (SELECT `id` FROM `new_form_results` WHERE `person_id` IN (SELECT `id` FROM `new_persons` WHERE `numbgr` in $numbers))";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Получение количества респондентов, ответивших на вопрос по его идентификатору
	function getCountUniqOptionResult($quest_id="")
	{
		$sql="SELECT DISTINCT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		if (isset($data))
		{
			return count($data);	
		}
		else
		{
			return 0;
		}
	}

	//Получение ID пользователей, которые отвечали на вопросы
	function getUsersOptionResult($quest_id="",$answer="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` IN (SELECT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['person_id'];	
	}

	//Получение ID пользователей, которые отвечали на вопрос и указывали в качестве ответа запрашиваемый параметр
	function getAllUsersOptionResult($quest_id="",$answer="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` IN (SELECT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение идентификаторов результов прохождения опросов по идентификатору вопроса
	function getAllResIdOptionResult($quest_id = 1)
	{
		$sql="SELECT DISTINCT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Получение количества ответов на вопрос одного пользователя по идентификаторам вопроса и результата
	function getCountUserAnswers($quest_id = 1,$res_id = 1)
	{
		$sql="SELECT COUNT(`id`) as `cnt` FROM `new_form_answers` WHERE `quest_id` = '$quest_id' AND `res_id` = '$res_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['cnt'];
	}

	//Получение идентификаторов результатов прохождения опросов по идентификаторам вопроса и ответа
	function getPunktResIdOptionResult($quest_id = 1,$answer = 1)
	{
		$sql = "SELECT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Удаление данных об ответе респондента
	function delUserAnswer($id_q = 1,$res_id = 1,$value = 1)
	{
		$sql = "DELETE FROM `new_form_answers` WHERE `res_id`='$res_id' AND `quest_id`='$id_q' AND `answer`='$value'";
		$this->db->query($sql);
	}

	//Получение идентификатора пользователя по идентификатору результата прохождения опроса
	function getUserByResId($res_id="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` ='$res_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['person_id'];	
	}

	//Получение информации об учётной записи пользователя по его идентификатору
	function getUser($user_id="")
	{
		$sql="SELECT `lastname`,`firstname` FROM `new_persons` WHERE `id`='$user_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['lastname']." ".$data[0]['firstname'];
	}

	//Получение количества респондентов, отвечавших на вопрос типа "сетка"
	function getCountOptionResultSetka($quest_id="",$answer="",$option="")
	{
		$sql="SELECT DISTINCT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `option`='$option'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return count($data);
	}

	//Получение среднего значения результата на пересечении строки и столбца
	function getAVGOptionResultSetkaSelector($quest_id = 1,$answer = 0,$option = 0)
	{
		$sql="SELECT AVG(`option_7`) as avg FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `option`='$option'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['avg'];
	}

	//Посчитать среднее значение ячейки для каждого курса
	function getAVGOptionResultSetkaSelectorKurs($quest_id = 1,$answer = 0,$option = 0,$kurs = 1)
	{
		$kurs = $kurs."__";
		$sql="SELECT `id` FROM `new_numbers` WHERE `type_r`='1' AND `name_numb` LIKE '$kurs' ORDER BY `name_numb` ASC";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		$numbers="(";
		foreach ($data as $key)
		{
			$numbers=$numbers.$key['id'].",";
		}
		$numbers=substr($numbers, 0, -1);
		$numbers = $numbers.")";
		$sql="SELECT AVG(`option_7`) as avg FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `option`='$option' AND `res_id` IN (SELECT `id` FROM `new_form_results` WHERE `person_id` IN (SELECT `id` FROM `new_persons` WHERE `numbgr` in $numbers))";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		if (isset($data[0]['avg']))
		{
			return $data[0]['avg'];
		}
		else
		{
			return 0;
		}
	}

	//Получение ID пользователей, ответивших на сетку
	function getUsersOptionResultSetka($quest_id="",$answer="",$option="")
	{
		$sql="SELECT `person_id` FROM `new_form_results` WHERE `id` IN (SELECT `res_id` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer`='$answer' AND `option`='$option')";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;	
	}

	//Выборка пользовательских ответов
	function getOtherTestResult($quest_id="")
	{
		$sql="SELECT `res_id`,`answer` FROM `new_form_answers` WHERE `quest_id`='$quest_id' AND `answer` REGEXP '[[:alpha:]]+'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	//Журналирование событий
	function createLogRecord($form_name="")
	{
		$lname=$this->session->userdata('lastname');
		$fname=$this->session->userdata('firstname');
		$name=$lname." ".$fname;
		$now_time=time();
		$type="Пройден опрос \"".$form_name."\"";
		$date_t = date("Y.m.d H:i");
		$sql = "INSERT INTO `new_log` (`user`,`date`,`type`,`time`,`status`) VALUES ('$name','$date_t','$type','$now_time','1')";
		$this->db->query($sql);
	}

	//Получение статуса доступа к результатам анкетирования
	function getRightResults($form_id="")
	{
		$sql="SELECT `public_res` FROM `new_forms` where `id`='$form_id'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['public_res'];
	}

	//Получение списка всех опросов, в которых участвовал пользователь по его идентификатору
	function getAllUserForms($user_id = "")
	{
		$sql="SELECT `new_form_results`.`end`,`new_forms`.`title`,`new_forms`.`description` FROM `new_forms`,`new_form_results` WHERE `new_form_results`.`person_id`='$user_id' AND `new_form_results`.`form_id` = `new_forms`.`id` AND `new_forms`.`del`='0'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Проверка существования записи об опросе по его идентификатору
	function checkFormId($form_id="")
	{
		$sql="SELECT `id` FROM `new_forms` WHERE `id` = '$form_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return count($data);
	}

	//Получение типа вопроса по его идентификатору
	function getTypeQuestOverID($quest_id = 1)
	{
		$sql="SELECT `type` FROM `new_form_quests` WHERE `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['type'];
	}

	//Получение статуса о возможности указания своей версии ответа на вопрос по его идентификатору
	function getOwnQuestOverID($quest_id = 1)
	{
		$sql="SELECT `own_version` FROM `new_form_quests` WHERE `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['own_version'];
	}

	//Получение параметров вопроса по его идентификатору
	function getOption1QuestOverID($quest_id = 1)
	{
		$sql="SELECT `option1` FROM `new_form_quests` WHERE `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['option1'];
	}

	//Получение параметров вопроса по его идентификатору
	function getOption2QuestOverID($quest_id = 1)
	{
		$sql="SELECT `option2` FROM `new_form_quests` WHERE `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['option2'];
	}

	//Получение параметров вопроса по его идентификатору
	function getOption3QuestOverID($quest_id = 1)
	{
		$sql="SELECT `option3` FROM `new_form_quests` WHERE `id`='$quest_id'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['option3'];
	}

	//Получение количества респондентов по каждому курсу
	function getCountResultsOverKursAndFormId($form_id = 1,$kurs = 1)
	{
		$kurs = $kurs."__";
		$sql="SELECT `id` FROM `new_numbers` WHERE `type_r`='1' AND `name_numb` LIKE '$kurs' ORDER BY `name_numb` ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		$numbers="(";
		foreach ($data as $key)
		{
			$numbers=$numbers.$key['id'].",";
		}
		$numbers = substr($numbers, 0, -1);
		$numbers = $numbers.")";
		$sql = "SELECT COUNT(`id`) as `cnt` FROM `new_form_results` WHERE `form_id` = '$form_id' AND `person_id` IN (SELECT `id` FROM `new_persons` WHERE `numbgr` in $numbers) AND `end` != '0'";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data[0]['cnt'];
	}

}

?>