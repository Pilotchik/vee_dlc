<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 06.03.14
 * Time: 13:13
 */
class Api extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('mapi');
        header('Access-Control-Allow-Origin: *');
    }
    function getTestData(){

        $data = array(
            "DiscName" => $this->mapi->getDiscNames(),
            "DiscTest" => $this->mapi->getDiscTests()
        );

        echo json_encode($data);
    }
    function testStart(){
        //Создание записи о результате
        $test_id = $this->input->post('test_id');
        $user_id = $this->input->post('user_id');
        $true_all = $this->input->post('true_all');
        $now_time = time();
        $result =  $this->mapi->createResRecord($test_id,$user_id,$now_time,0,$true_all);
        if($result = '0'){
            echo '0';
        }
    }
    function autosave()
    {
        $this->form_validation->set_rules('id_q', 'ID', 'trim|required|xss_clean|is_natural_no_zero');
        $this->form_validation->set_rules('ans_id', 'ID', 'trim|xss_clean|is_natural_no_zero');
        $this->form_validation->set_rules('time_s', 'Время', 'trim|required|xss_clean|numeric');
        $this->form_validation->set_rules('idrazd', 'Раздел', 'trim|required|xss_clean|is_natural_no_zero');
        $this->form_validation->set_rules('true_q', 'Ответ', 'trim|xss_clean|max_length[30]');
        $this->form_validation->set_rules('check', 'Проверка', 'trim|xss_clean|max_length[30]');
        if ($this->form_validation->run() == TRUE)
        {
            $id_q=$this->input->post('id_q');
            $true_q=$this->input->post('true_q');
            $time_s=$this->input->post('time_s');
            $idrazd=$this->input->post('idrazd');
            $ans_id=$this->input->post('ans_id');
            $check=$this->input->post('check');
            $user_id = $this->input->post('user_id');
            //Получение ID результатной записи
            $status_array=$this->mapi->getResRecord($user_id,$idrazd);
            $result_id=$status_array[0]['id'];
            //Записать время выполнения вопроса
            //Узнать время выполнения предыдущего задания
            $prev_quest_time = $this->mapi->getPrevQuest($result_id, $id_q);
            $now_time=time();
            if ($prev_quest_time != 0)
            {
                //Если в предыдущем вопросе есть время
                $quest_time = $now_time - $prev_quest_time;
            }
            else
            {
                //Получить время начала теста
                $test_begin = $this->mapi->getTestBegin($result_id);
                $quest_time = $now_time - $test_begin;
            }

            //Все ответы на вопрос
            $answers=$this->mapi->getAnswers($id_q);
            //Все правильные ответы
            $true_answers=$this->mapi->getTrueAnswers($id_q);
            //Получение типа вопроса
            $quest=$this->mapi->getQuest($id_q);
            //Тип вопроса
            $type_q=$quest[0]['type'];
            $n=1;
            //Количество ответов
            $s2=count($answers);
            //Найти количество правильных ответов в закрытых вопросах с несколькими правильными
            $s=count($true_answers);
            $true=0;
            foreach($answers as $key)
            {
                $questtrue=$key['true'];
                $ans_text=$key['text'];
                if ($type_q==2)
                {
                    if (($true_q=="$n") and ($questtrue=='1') and ($check=='1'))
                    {
                        $true=1/$s;
                    }
                    if (($true_q=="$n") and ($questtrue=='1') and ($check!='1'))
                    {
                        $true=(-1)*(1/($s2-$s));
                    }
                    if (($true_q=="$n") and ($questtrue!='1') and ($check=='1'))
                    {
                        $true=(-1)*(1/($s2-$s));
                    }
                    if (($true_q=="$n") and ($questtrue!='1') and ($check!='1'))
                    {
                        $true=1/$s;
                    }
                }
                if ($type_q==3)
                {
                    if (((strlen($true_q)/2)==strlen($ans_text)) or ($true_q==$ans_text))
                    {
                        $true = 1;
                    }
                    else
                    {
                        $true = 0;
                    }
                }
                //Числовой диапазон
                if ($type_q == 6)
                {
                    $true_q = str_replace(",",".",$true_q);
                    if (($true_q > $key['option_1']) && ($true_q < $key['option_2']) || ($true_q == $key['option_1']) || ($true_q == $key['option_2']))
                    {
                        $true = 1;
                    }
                    else
                    {
                        $true = 0;
                    }
                }
                $n++;
            }
            //Выяснить правильный ответ для конкретного ID ответа
            $true_of_answer = $this->mapi->getAnswer($ans_id);
            if ($type_q==1)
            {
                $true = ($true_of_answer['true']=='1' ? 1 : 0);
            }
            if ($type_q==4)
            {
                if ($true_of_answer['true']==$true_q)
                {
                    $true=1/$s2;
                }
                else
                {
                    $true=-0.05;
                }
            }
            //Ответ студента
            $pers_answer=$this->mapi->getPersonalAnswer($id_q,$user_id);
            if (isset($pers_answer[0]))
            {
                //Уже есть запись ответа
                $ans_id=$pers_answer[0]['id'];
                $answer=$pers_answer[0]['true'];
                if (($type_q==2) or ($type_q==4))
                {
                    $true=$true+$answer;
                    if ($true<0) {$true=0;}
                    if ($true>1) {$true=1;}
                }
                $update_answer=$this->mapi->updatePersonalAnswer($ans_id,$true_q,$true);
            }
            else
            {
                //Ответ даётся в первый раз
                if ($true<0) {$true=0;}
                $update_answer = $this->mapi->addPersonalAnswer($user_id,$id_q,$true_q,$result_id,$true,$quest_time);
            }
            //Изменить время автосохранения
            $editTime=$this->mapi->updateResTimeRecord($result_id,$time_s);
            echo json_encode(array('answer'=>1));
        }
        else
        {
            echo json_encode(array('answer'=>0));
        }
    }

    function test_itog()
    {
        $test_id=$this->input->post('id');
        $user_id=$this->input->post('user_id');
        $now_time=time();
        $status_array=$this->mapi->getResRecord($user_id,$test_id);
        $result_id=$status_array[0]['id'];
        if ($status_array[0]['proz']>0)
        {
            redirect('auth');
        }
        else
        {
        $data['true_all']=round($status_array[0]['true_all'],3);
        $stud_answers=$this->mapi->getStudAnswers($result_id);
        $true_cnt=0;
        $data['dano']=count($stud_answers);
        foreach ($stud_answers as $key)
        {
        $true_cnt=$key['true']+$true_cnt;
        }
        $abs=round(($true_cnt/$data['true_all'])*100,3);
        if ($abs>100) {$abs=100;}
        $data['true_cnt']=$true_cnt;
        $data['abs']=$abs;
        $result=$this->mapi->updateResRecord($result_id,$true_cnt,$abs,$now_time);
        $data['result_id'] = $result_id;
        // $this->load->model('main_model');//журналирование
        // $this->load->model('tests_model');//название теста
        $data['text'] = "Пройден тест \"".$this->mapi->getDiscNameOverTestID($test_id).". ".$this->mapi->getNameTest($test_id)."\"";
        // $this->main_model->createLogRecord($msg,1);

        $data['error']="";
        echo json_encode($data);
        }
    }

    function auth(){
        $this->form_validation->set_rules('username', 'Логин', 'trim|required|xss_clean|max_length[20]|min_length[3]');
        $this->form_validation->set_rules('password', 'Пароль', 'trim|required|xss_clean|max_length[20]|min_length[2]');
        if ($this->form_validation->run() == FALSE)
        {
           // $this->index();
           // echo "form error";
        }
        else{
            $this->load->model('auth_model');
            $text = $this->mapi->getPersonData();
            $c=count($text[0]);
            $d=count($text[1]);
            $e=0;
            if ($c=='0')
            {
                $error = "Неправильный логин(login)";
               // echo $error;
                $e++;
            }
            if (($c>'0')&&($d=='0'))
            {
                $error = "Неправильный пароль(pass)";
               // echo $error;
                $e++;
            }
            if (($c>'0')&&($d>'0'))
            {
                $f=$text[0][0]['lastname'];
                $f1=$text[0][0]['firstname'];
                $f2=$text[0][0]['login'];
                $f3=$text[0][0]['guest'];
                $f4=$text[0][0]['id'];
                $f5=$text[0][0]['type_r'];
                $f6=$text[0][0]['block'];
                $f7=$this->mapi->getGroup($f4);
                $name=$f." ".$f1;
                $type="Удалённый ресурс";
                $this->mapi->addLog($name,$type,1);
                $secret_key = "1m.2be25or96not45to032be";
                $status = array(
                    'lastname'  => $f,
                    'firstname'	=> $f1,
                    'login'    	=> crypt($f2, $secret_key),
                    'guest'     => $f3,
                    'user_id'	=> $f4,
                    'type_r'	=> $f5,
                    'block'	=> $f6,
                    'group'	=> $f7,
                    'logged_in' => TRUE
                );
                echo json_encode($status);
            }
        }
    }

    function show_event()
    {
        header('Content-type: text/html; charset=utf-8');
        $test_id = $this->input->post('test_id');
        $quests = $this->mapi->getQuests($test_id);
        $CountQuests = $this->mapi->getCountQuests($test_id);
        foreach ($quests as $key)
        {
            $questsAnswers[$key->id] = $this->mapi->getQuestsAnswers($key->id);
        }
        $data_array = array($quests,$questsAnswers,array('count' => $CountQuests));
        echo json_encode($data_array);
    }

    function getTestIdOverKey()
    {
        $this->form_validation->set_rules('key', 'Ключ', 'required');
        if($this->form_validation->run() == FALSE){
        $error = 0;
        echo json_encode($error);
        }
        else{
        $key = $this->input->post('key');
        $test_id = $this->mapi->getTestIdOverKey($key);
        foreach($test_id as $value):
        echo $value->id;
        endforeach;
    }
}

}