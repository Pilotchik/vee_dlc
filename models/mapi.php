<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 06.03.14
 * Time: 13:13
 */
class Mapi extends CI_Model{
    function __construct()
    {
        // вызываем конструктор модели
        parent::__construct();
        /*Connection to Virtual Education System*/

    }
    function getTestNames(){
        $sql="SELECT `name_razd` FROM `new_razd` ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function getDiscNameOverTestID($test_id){
        $sql="SELECT `name_razd` FROM `new_razd` WHERE `id` = '$test_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data[0]['name_razd'];
    }
    function getDiscTests()// тесты по ID дисцеплины
    {
        $sql="SELECT `id`,`name_razd`, `test_id`, `kod` FROM `new_razd` WHERE  `active`='1' AND `del`='0' AND `id` NOT IN (SELECT `test_id` FROM `new_lections` WHERE `del`='0') ORDER BY `name_razd` ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function getDiscNames()
    {
        $sql="SELECT `name_test`, `id` FROM `new_tests` WHERE `active` = '1' AND `del` = '0'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function getThemes()
    {
        $sql="SELECT `id_theme`, `name_th`, `test_id` FROM `new_themes`";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function getQuests($disc_id)
    {
        $sql="SELECT `id`,`text`, `image`, `type` FROM `new_vopros` where  `razd_id`='$disc_id' AND `active` = '1' and `del` = '0' AND `variant` = '1'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function getCountQuests($disc_id){
        $sql="SELECT 'id' FROM `new_vopros` where  `razd_id`='$disc_id' AND `active` = '1' and `del` = '0' AND `variant` = '1'";
        $query = $this->db->query($sql);
        $data = $query->result();
        return count($data);
    }
    
    function getQuestsAnswers($quest_id = 1)
    {
        $sql="SELECT * FROM `new_answers` WHERE `del` = 0 AND `vopros_id`='$quest_id'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getTestIdOverKey($key){
        $sql="SELECT `id` FROM `new_razd` WHERE `kod` = '$key'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function createResRecord($test_id="",$user_id="",$now_time="",$var="",$true_all="")
    {
        $date_t=date("Y.m.d H:i");
        $year=date("Y");
        $sql="SELECT `id` FROM `new_results` WHERE `razd_id` = '$test_id' AND `user` = '$user_id' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        echo $result[0]['id'];
        if($result == NULL){
            if ($test_id!=0)
            {
                $sql = "INSERT INTO `new_results` (`razd_id`,`user`,`timebeg`,`data`,`year`,`variant`,`true_all`) VALUES ('$test_id','$user_id','$now_time','$date_t','$year','$var','$true_all')";
            }
            $data = $this->db->query($sql);
            return $data;
        } else{
            return $data = "0";
        }
    }
    function getPersonData(){
        $uname=$this->input->post('username');
        $upass=$this->input->post('password');
        $pass_db="";
        $sql = "select * from new_persons where login='$uname'";
        $query = $this->db->query($sql);
        $res_array=$query->result_array();
        if (count($res_array)>0) {$pass_db=$res_array[0]['pass'];}
        $upass=crypt($upass, $pass_db);
        $sql1 = "select * from new_persons where login='$uname' and pass='$upass'";
        $query1 = $this->db->query($sql1);
        $data=array($query->result_array(),$query1->result_array());
        return $data;
    }

    function getPersonDataToVK($uname = "")
    {
        $sql = "SELECT * FROM `new_persons` WHERE `login`='$uname' LIMIT 1";
        $query = $this->db->query($sql);
        $res_array = $query->result_array();
        return $res_array[0];
    }

    function getResRecord($user_id="",$test_id="")
    {
        $sql="SELECT `id`,`true_all`,`proz` FROM `new_results` where `user`='$user_id' and `razd_id`='$test_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data;
    }
    //Время выполнения предыдущего вопроса
    function getPrevQuest($result_id = "",$quest_id = "")
    {
        $sql="SELECT `unix_time` FROM `new_stud_ans` WHERE `results` = '$result_id' AND `quest_id` != '$quest_id' ORDER BY  `id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        if (isset($data[0]['unix_time']))
        {
            return $data[0]['unix_time'];
        }
        else
        {
            return 0;
        }
    }
    //Узнать начало сдачи теста
    function getTestBegin($res_id = "")
    {
        $sql="SELECT `timebeg` FROM `new_results` where `id`='$res_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data[0]['timebeg'];
    }
    function getAnswers($vopros_id="")
    {
        $sql="SELECT `text`,`image`,`id`,`true`,`quest_t`,`option_1`,`option_2` FROM `new_answers` where `vopros_id`='$vopros_id' and `del`='0'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data;
    }
    function getTrueAnswers($vopros_id="")
    {
        $sql="SELECT `text`,`image`,`id`,`true`,`quest_t`,`option_1`,`option_2` FROM `new_answers` WHERE `true`='1' AND `vopros_id`='$vopros_id' AND `del`='0'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data;
    }
    function getQuest($quest_id="")
    {
        $sql="SELECT `type` FROM `new_vopros` where `id`='$quest_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data;
    }
    //Данные об ответе
    function getAnswer($ans_id="")
    {
        $sql="SELECT `true` FROM `new_answers` WHERE `id`='$ans_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data[0];
    }
    function getPersonalAnswer($quest_id="",$user_id="")
    {
        $sql="SELECT * FROM `new_stud_ans` WHERE `quest_id`='$quest_id' AND `user`='$user_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data;
    }
    function updatePersonalAnswer($ans_id="",$true_q="",$true="")
    {
        $sql="UPDATE `new_stud_ans` SET `answer` ='$true_q',`true`='$true' where id='$ans_id'";
        $data = $this->db->query($sql);
        return $data;
    }
    function addPersonalAnswer($user_id="",$id_q="",$true_q="",$result_id="",$true="",$quest_time = "0")
    {
        $now_time = time();
        $sql = "INSERT INTO `new_stud_ans` (`user` ,`quest_id` ,`answer` ,`results`,`true`,`unix_time`,`time`) VALUES ('$user_id','$id_q','$true_q','$result_id','$true','$now_time','$quest_time')";
        $data = $this->db->query($sql);
        return $data;
    }
    function updateResTimeRecord($result_id="",$time_s="")
    {
        $sql="UPDATE `new_results` SET `timesave` ='$time_s' WHERE id='$result_id'";
        $data = $this->db->query($sql);
        return $data;
    }
    function getStudAnswers($result_id="")
    {
        $sql="SELECT `true` FROM `new_stud_ans` WHERE `results`='$result_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data;
    }
    function updateResRecord($result_id="",$true_cnt="",$abs="",$now_time="")
    {
        $sql="UPDATE `new_results` SET `timeend` ='$now_time',`true`='$true_cnt',`proz`='$abs',`proz_corr`='$abs' WHERE id='$result_id'";
        $data = $this->db->query($sql);
        return $data;
    }
    function getNameTest($test_id="")
    {
        $sql="SELECT `name_razd` FROM `new_razd` where `id`='$test_id'";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data[0]['name_razd'];
    }
    function getGroup($user_id="")
    {
        $sql="SELECT `name_numb` FROM `new_numbers` WHERE `id` in (SELECT `numbgr` FROM `new_persons` WHERE `id`='$user_id')";
        $query = $this->db->query($sql);
        $data=$query->result_array();
        return $data[0]['name_numb'];
    }
    function addLog($user="",$type="",$goal="")
    {
        $date_t=date("Y.m.d H:i");
        $now_time=time();
        $sql = "INSERT INTO `new_log` (`user`,`date`,`type`,`time`,`goal`) VALUES ('$user', '$date_t','$type','$now_time','$goal')";
        $query = $this->db->query($sql);
        return $query;
    }

    function checkUserAccount($user_id = 1)
    {
        $sql="SELECT `id`,`lastname`,`firstname` FROM `new_persons` WHERE `id` = '$user_id' AND `block` = '0' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getMaxUserId()
    {
        $sql="SELECT MAX(`id`) as `maxid` FROM `new_persons`";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data[0]['maxid'];
    }

}