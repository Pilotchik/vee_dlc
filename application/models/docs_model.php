<?php  if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Docs_model extends CI_Model{
    public function select ($array_pole, $array_poleu , $array_znaku , $array_textu, $sortirovka, $an = 0, $de = 0 ){

        $new_array_pole = array();       
        $go=0;

        for($i=0;$i<count($array_pole);$i++){   
            if(!empty($array_pole[$i]) AND $array_pole[$i]!=' '){  
               $new_array_pole[$go] = $array_pole[$i];
               $go++;     
            }   
        }//удаление пустых полей
        for($i=0;$i<count($array_textu);$i++){
            $array_textu[$i] = trim($array_textu[$i]);       
        }//Удаление лишних пробелов техтовых полей
        $select_pole = implode(', ', $new_array_pole);
        //Часть строки запроса с полями таблиц $arr
        $tables = array();$i = 0;
        $connections = array();$j = 0;
        $error = '0';
        $p = 0;

        if (preg_match_all('/new_persons/',$select_pole,$out)){
           $tables[$i] = 'new_persons';$i++;
           if ($an == 0 AND $de == 0){
                $connections[$j]= 'new_persons.block = 0';
                $j++;
           }
           if ($an == 1 AND $de == 0){}
           if ($an == 0 AND $de == 1){}
        }    
        
        
        if (preg_match_all('/new_results/',$select_pole,$out)){ 
           $tables[$i] = 'new_results';$i++;
           if (preg_match_all('/new_persons/',$select_pole,$out)){
                $connections[$j]= 'new_results.user = new_persons.id';
                $j++;
           }
           else{            
                $error = '!!!Ошибка!!!Добавте любое поле с информцией о студенте для отображения результатов тестов';            
           }
        }   
                
        if (preg_match_all('/new_razd/',$select_pole,$out)){ 
            $tables[$i] = 'new_razd';$i++;  
            if ($an == 0 AND $de == 0){
                $connections[$j]= 'new_razd.active = 1';
                $j++;
                $connections[$j]= 'new_razd.del = 0';
                $j++;
           }
           if ($an == 1 AND $de == 0){
                $connections[$j]= 'new_razd.active = 0';
                $j++;
           }
           if ($an == 0 AND $de == 1){
                $connections[$j]= 'new_razd.del = 1';
                $j++;
           }     
           if (preg_match_all('/new_persons/',$select_pole,$out) AND !preg_match_all('/new_results/',$select_pole,$out)){
                $error = '!!!Ошибка!!!
                Таблицы с информацией о тестах и студентах не связаны, выберите что-то одно';  
           }   
           if (preg_match_all('/new_results/',$select_pole,$out)){
                $connections[$j]= 'new_razd.id = new_results.razd_id';$j++;
           }
        }  
        
      //  if (preg_match_all('/new_annul/',$select_pole)){            
      //     $tables[$i] = 'new_annul';$i++;          
      //  }      
        
             
        if (preg_match_all('/new_crs_results/',$select_pole,$out)){
            $tables[$i] = 'new_crs_results';$i++;      
            if (preg_match_all('/new_persons/',$select_pole,$out)){
                $connections [$j]= 'new_crs_results.user_id = new_persons.id';$j++;    
            }
            else{
                
            }
        }    
                 
        if (preg_match_all('/new_courses/',$select_pole,$out)){
           $tables[$i] = 'new_courses';$i++;
           if ($an == 0 AND $de == 0){$connections[$j]= 'new_courses.active = 1';$j++;
           $connections[$j]= 'new_courses.del = 0';$j++;
           }
           if ($an == 1 AND $de == 0){$connections[$j]= 'new_courses.active = 0';$j++;}
           if ($an == 0 AND $de == 1){$connections[$j]= 'new_courses.del = 1';$j++;}
           
           
           if (preg_match_all('/new_persons/',$select_pole,$out) AND !preg_match_all('/new_crs_results/',$select_pole,$out)){
                
                $error = '!!!Ошибка!!!Таблицы с информацией о курсах и студентах не связаны, выберите что-то одно';
                
           }
           
           if (preg_match_all('/new_crs_results/',$select_pole,$out)){
            
          // $where = 'WHERE ';
           $connections[$j] = 'new_crs_results.course_id = new_courses.id';$j++;
           
           }
           
        }   
              
        if (preg_match_all('/new_lect_results/',$select_pole,$out)){
            
               $tables[$i] = 'new_lect_results';$i++;
               
               if (preg_match_all('/new_persons/',$select_pole,$out)){
             //  $where = 'WHERE ';
                   $connections[$j] = 'new_lect_results.user_id = new_persons.id';$j++;
               }
               
               else {
                
                $error = '!!!Ошибка!!!Добавте любое поле с информцией о студенте для отображения результатов лекций';
                
               }
        }  
        
        
        if (preg_match_all('/new_lections/',$select_pole,$out)){
            
           $tables[$i] = 'new_lections';$i++;
           
            if ($an == 0 AND $de == 0){$connections[$j]= 'new_lections.active = 1';$j++;
           $connections[$j]= 'new_lections.del = 0';$j++;
           }
           if ($an == 1 AND $de == 0){$connections[$j]= 'new_lections.active = 0';$j++;}
           if ($an == 0 AND $de == 1){$connections[$j]= 'new_lections.del = 1';$j++;}
           
         if (preg_match_all('/new_persons/',$select_pole,$out) AND !preg_match_all('/new_lect_results/',$select_pole,$out)){
                
                $error = '!!!Ошибка!!!Таблицы с информацией о лекциях и студентах не связаны, выберите что-то одно';
                
           }
           
          if (preg_match_all('/new_lect_results/',$select_pole,$out)){
           //$where = 'WHERE ';
           $connections[$j]= 'new_lections.id = new_lect_results.lection_id';$j++;
          }
          
           if (preg_match_all('/new_courses/',$select_pole,$out)){
           //$where = 'WHERE ';
           $connections[$j]= 'new_lections.course_id = new_courses.id';$j++;
           
           }
           
        }   
           
        if (preg_match_all('/new_materials/',$select_pole,$out)){
            
           $tables[$i] = 'new_materials';$i++;
           
            if ($an == 0 AND $de == 0){$connections[$j]= 'new_materials.active = 1';$j++;
           $connections[$j]= 'new_materials.del = 0';$j++;
           }
           if ($an == 1 AND $de == 0){$connections[$j]= 'new_materials.active = 0';$j++;}
           if ($an == 0 AND $de == 1){$connections[$j]= 'new_materials.del = 1';$j++;}
           
           if (preg_match_all('/new_persons/',$select_pole,$out)){
                
                $error = '!!!Ошибка!!!Таблицы с информацией о материалах и студентах не связаны, выберите что-то одно';
                
           }
           
           if (preg_match_all('/new_tests/',$select_pole,$out)){
           //$where = 'WHERE ';
           $connections[$j]= 'new_materials.disc_id = new_tests.id';$j++;
           
           }
        } 
        
        if (preg_match_all('/new_tests/',$select_pole,$out)){        
            $tables[$i] = 'new_tests';$i++;     
            if ($an == 0 AND $de == 0){$connections[$j]= 'new_tests.active = 1';$j++;
                $connections[$j]= 'new_tests.del = 0';$j++;
            }
            if ($an == 1 AND $de == 0){$connections[$j]= 'new_tests.active = 0';$j++;}
            if ($an == 0 AND $de == 1){$connections[$j]= 'new_tests.del = 1';$j++;}            
            if(preg_match_all('/new_razd/',$select_pole,$out)){
                $connections[$j]= 'new_tests.id = new_razd.test_id';$j++;
            }  
        } 

        if (preg_match_all('/new_themes/',$select_pole,$out)){
            $tables[$i] = 'new_themes';$i++;     
            if ($an == 0 AND $de == 0){
               $connections[$j]= 'new_themes.del = 0';$j++;
            }
            if ($an == 1 AND $de == 0){$connections[$j]= 'new_themes.del = 1';$j++;}
            if ($an == 0 AND $de == 1){$connections[$j]= 'new_themes.del = 1';$j++;}        
            if(preg_match_all('/new_tests/',$select_pole,$out)){
                $connections[$j]= 'new_themes.test_id = new_tests.id';$j++;
            }
        }
        //Добавление таблиц и связей в запрос
                
        $uslovia = array();
        $connections_or = array();
        $new_array_poleu = array();
        $inap = 0;
        if(!empty($array_poleu) AND !empty($array_znaku) AND !empty($array_textu) AND $array_znaku[0] !== ' '){
            $count_u = count($array_poleu);
            for ($i=0;$i<$count_u;$i++){
                if (!empty($array_poleu[$i]) AND !empty($array_znaku[$i]) AND !empty($array_textu[$i])){
                    $uslovia[$inap] = "$array_poleu[$i] $array_znaku[$i]  '$array_textu[$i]'"; 
                    $new_array_poleu[$inap] = $array_poleu[$i];
                    $inap++;
                }     
            }
            $count_u = count($new_array_poleu);  
            $povtor = array();
            $povtorU = array();
            $metka_or = array(); 
            for ($i=0;$i<$count_u;$i++){
                $metka_or [$i] = 0;
            }      
            $index_povtora = 0;     
            for ($i=0;$i<$count_u;$i++){                
                for ($a=0;$a<$count_u;$a++){
                    $povtor[$a] = 0;
                }   
                for ($m=0;$m<$count_u;$m++){
                    if ($new_array_poleu[$i]===$new_array_poleu[$m] AND $i!=$m){
                        $povtor[$m]=1;
                        $povtor[$i]=1;
                    }
                    $povtorU[$index_povtora] = $povtor; 
                    $index_povtora++;
                }
            }

            for ($index_povtora=0;$index_povtora<count($povtorU);$index_povtora++){  
                for ($i=0;$i<$count_u;$i++){          
                    if ($povtorU[$index_povtora][$i] == 1){
                        $metka_or[$i] = 1; 
                        if (!empty($connections_or[$p])){
                            $connections_or[$p] .= ' OR '.$uslovia[$i];             
                        }
                        else{     
                            $connections_or[$p] = '( '.$uslovia[$i];
                        } 
                    } 
                }
                if  (!empty($connections_or[$p])){
                    $connections_or[$p] .= ' ) ';
                    $p++;
                }
            }
            
            // Формирование нескольких условий для одного поля   
      
            for ($i=0;$i<count($uslovia);$i++){    
                if ($metka_or[$i]===0){
                    $connections[$j] = $uslovia[$i];$j++;       
                }    
            }
          
            
        }//Формирование условий
        
        $select_tables = implode(', ', $tables); //Часть строки запроса с таблицами
  
        if (!empty($connections_or)){   
        $select_where_or = implode(' AND ', $connections_or);//Часть строки запроса с плавующими условиями
            if (!empty($connections)){   
                    $select_where_and = implode(' AND ', $connections);//Часть строки запроса со строгими условиями       
                    if ($sortirovka !== 0){     
                        for($q=1;$q<10;$q++){
                            if ($sortirovka == $q){
                                $sortirovka = $array_pole[$q-1];
                            }
                        }      
                        $sql = "SELECT ".$select_pole." FROM ".$select_tables." WHERE ".$select_where_and." AND (".$select_where_or.") ORDER BY ".$sortirovka."";
                    }
                    else{
                        $sql = "SELECT ".$select_pole." FROM ".$select_tables." WHERE ".$select_where_and." AND (".$select_where_or.")";
                    }
            }
         
            else{       
                if ($sortirovka !== 0){
                    for($q=1;$q<10;$q++){
                        if ($sortirovka == $q){
                            $sortirovka = $array_pole[$q-1];
                        }
                    } 
                         $sql = "SELECT ".$select_pole." FROM ".$select_tables." WHERE (".$select_where_or.") ORDER BY ".$sortirovka."";
                    }
                    else{
                        $sql = "SELECT ".$select_pole." FROM ".$select_tables." WHERE (".$select_where_or.")";
                    }
            }
        }
      
        else {
            if (!empty($connections)){ 
                $select_where_and = implode(' AND ', $connections);//Часть строки запроса со строгими условиями
                if ($sortirovka !== 0){
                for($q=1;$q<10;$q++){
                        if ($sortirovka == $q){
                            $sortirovka = $array_pole[$q-1];
                        }
                }
                
                    $sql = "SELECT ".$select_pole." FROM ".$select_tables." WHERE ".$select_where_and." ORDER BY ".$sortirovka."";
                }
                else{   
                    $sql = "SELECT ".$select_pole." FROM ".$select_tables." WHERE ".$select_where_and."";
                }
            }
            else{
                if ($sortirovka !== 0){ 
                    for($q=1;$q<10;$q++){
                        if ($sortirovka == $q){ 
                            $sortirovka = $array_pole[$q-1]; 
                        }
                    }
                        $sql = "SELECT ".$select_pole." FROM ".$select_tables." ORDER BY ".$sortirovka."";
                    }
                    else{
                        $sql = "SELECT ".$select_pole." FROM ".$select_tables."";
                    }
            }
        }
       

       
        $_SESSION['sql'] = $sql;
        if ($error !== '0'){return $error;}    
        else{ 
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }
    }
        
    public function limitedSelect($start,$num){
        $sql = $_SESSION['sql'];
        $newsql = $sql.' LIMIT '.$start.', '.$num.'';
        //echo $newsql;
        $query = $this->db->query($newsql);
        $result = $query->result_array();
        return $result;
    }
 
}