<?php

function DiagrammData_group($pole_d, $nabor, $result){
	$iD = 0;
    $iSD = 0;
    $massDP = array();
    $massDPC = array();
    $iM = 0;
	$shiftD = 0;  $nabor = array_unique($nabor);
  foreach ($nabor as $n){
			
            if ($n == $pole_d[$iD]){$Pd = $iSD;}
            $iSD++;
        }
		
        foreach($result as $res){
            $iR = 0;
            foreach ($res as $R){   
                if ($iR == $Pd){
                    $masDP[$iM] = $R;$iM++; 
                } 
                $iR++;
            }
        }
                	
		$newmasDP = array();
        for($i=0;$i<count($masDP);$i++){
			$stop = 0;
            for($j=0;$j<count($newmasDP);$j++){
                if ($masDP[$i]==$newmasDP[$j]){
					$stop = 1;
                    $massDPC[$j]++;
                }
            
            }
            if ($stop != 1){
				$newmasDP[] = $masDP[$i];
				$massDPC[] = 1;
            }
        }
        
        $GLOBALS["Znachenia"] = $massDPC;
        $GLOBALS["Pola"] = $newmasDP;
}

function DiagrammData_results($poley,$polex,$nabor,$result){
	
	    $ss = 0;
		          
			$shiftD = 0;
		 $iSD = 0;
		  $iM = 0;
		  $ID = 0;
		 $massDPy = array();
        $massDPCy = array();
	           $nabor = array_unique($nabor);
                foreach ($nabor as $n){
				    if (!empty($n)){
                    if ($n == $poley){$Pdy = $iSD;}
                    $iSD++;}
                }
				
                foreach($result as $res){
                    $iR = 0;
                    foreach ($res as $R){
                        
                    if ($iR == $Pdy){
                       $masDPy[$iM] = $R;$iM++; 
                    } 
                    $iR++;
                    }
                }
                
				
				
				  $newmasDPy = array();
        
        
           for($i=0;$i<count($masDPy);$i++){$stop = 0;
                for($j=0;$j<count($newmasDPy);$j++){
                if ($masDPy[$i]==$newmasDPy[$j]){$stop = 1;
                    $massDPCy[$j]++;
                }
            
           }
            if ($stop != 1){
            $newmasDPy[] = $masDPy[$i];
            $massDPCy[] = 1;
           }
        }
		
		 $iSD = 0;
		  $iM = 0;
		  $ID = 0;
		
		$massDPx = array();
        $massDPCx = array();
        foreach ($nabor as $n){
				 if (!empty($n)){
                    if ($n == $polex){$Pdx = $iSD;}
                    $iSD++;}
                }
				  
        
             foreach($result as $res){
                    $iR = 0;
                    foreach ($res as $R){
                        
                    if ($iR == $Pdx){
                       $masDPx[$iM] = $R;$iM++; 
                    } 
                    $iR++;
                    }
                }
                
				
				
			
				
				$massDSum = array();
				$massDCol = array();
				$massDSC = array();
			for($i=0;$i<count($masDPy);$i++){
				for($j=0;$j<count($newmasDPy);$j++){
				if ($masDPy[$i] == $newmasDPy[$j]){
				if (empty($massDSum [$j])){
				$massDSum [$j]= 0; $massDCol [$j] = 0;
				}
				  $massDSum [$j] += $masDPx[$i];
				  $massDCol [$j]++;
				}
			}	
			}
			for($i=0;$i<count($newmasDPy);$i++){
			$massDSC[$i] =  $massDSum [$i]/$massDCol [$i];
			}
        
		
		  $GLOBALS["Znachenia"] = $massDSC;
          $GLOBALS["Pola"] = $newmasDPy;
}

function DiagrammData_other($poley,$polex,$nabor,$result){
	 $ss = 0;
		          
			$shiftD = 0;
		 $iSD = 0;
		  $iM = 0;
		  $ID = 0;
		     
	
	    $iSD = 0;
		  $iM = 0;
		  $ID = 0;
		    $massDPy = array();
        $massDPCy = array();
	            $pDy = '';
				
				 $nabor = array_unique($nabor);
                foreach ($nabor as $n){
				
					if (!empty($n)){
                    if ($n == $poley){$Pdy = $iSD; }
                    $iSD++;}
                }
				
                foreach($result as $res){
                    $iR = 0;
                    foreach ($res as $R){
                        
                    if ($iR == $Pdy){
                       $masDPy[$iM] = $R;$iM++; 
                    } 
                    $iR++;
                    }
                }
              
				
				
				  $newmasDPy = array();
        
        
           for($i=0;$i<count($masDPy);$i++){$stop = 0;
                for($j=0;$j<count($newmasDPy);$j++){
                if ($masDPy[$i]==$newmasDPy[$j]){$stop = 1;
                    $massDPCy[$j]++;
                }
            
           }
            if ($stop != 1){
            $newmasDPy[] = $masDPy[$i];
            $massDPCy[] = 1;
           }
        }
		
		 $iSD = 0;
		  $iM = 0;
		  $ID = 0;
		$pDx = '';
		$massDPx = array();
        $massDPCx = array();
        foreach ($nabor as $n){
				if (!empty($n)){
                    if ($n == $polex){$Pdx = $iSD;}
                    $iSD++;}
                }
				 
        
             foreach($result as $res){
                    $iR = 0;
                    foreach ($res as $R){
                        
                    if ($iR == $Pdx){
                       $masDPx[$iM] = $R;$iM++; 
                    } 
                    $iR++;
                    }
                }
				
				
		  $GLOBALS["Znachenia"] = $masDPx;
          $GLOBALS["Pola"] = $masDPy;
}


function poleToRus($pole){

	for ($i=0;$i<count($pole);$i++){
		switch ($pole[$i]){
										
										
										case 'new_persons.firstname': $new_pole[$i] = 'Имя';break;
										case 'new_persons.lastname': $new_pole[$i] ='Фамилия' ;break;
										case 'new_persons.middlename': $new_pole[$i] ='Отчество' ;break;
										case 'new_persons.numbgr': $new_pole[$i] = 'Номер группы';break;
										case 'new_persons.login': $new_pole[$i] = 'Логин';break;
										case 'new_persons.phone': $new_pole[$i] = 'Телефон';break;
										case 'new_persons.guest': $new_pole[$i] = 'Права пользователя';break;
										case 'new_persons.isrz': $new_pole[$i] = 'Индекс сложности решенных задач';break;
										case 'new_razd.name_razd': $new_pole[$i] = 'Название теста';break;
										case 'new_results.true': $new_pole[$i] = 'Кол-во правильных';break;
										case 'new_results.true_all': $new_pole[$i] = 'Всего вопросов';break;
										case 'new_results.proz': $new_pole[$i] = 'Результат (%)';break;
										case 'new_razd.multiplicity': $new_pole[$i] = 'Сложность теста';break;
										case 'new_lections.name': $new_pole[$i] = 'Название лекции';break;
										case 'new_lect_results.timebeg': $new_pole[$i] = 'Время начала лекц.';break;
										case 'new_lect_results.timeend': $new_pole[$i] = 'Время конца лекц.';break;
										case 'new_courses.name': $new_pole[$i] = 'Название курса';break;
										case 'new_courses.data': $new_pole[$i] = 'Дата';break;
										case 'new_courses.time_avg': $new_pole[$i] = 'Время';break;
										case 'new_crs_results.timebeg': $new_pole[$i] = 'Время начала курса';break;
										case 'new_crs_results.timeend': $new_pole[$i] = 'Время конца курса';break;
										case 'new_crs_results.proz': $new_pole[$i] = 'Статус прохождения';break;
										case 'new_crs_results.balls': $new_pole[$i] = 'Средний балл по тестам';break;
										case 'new_tests.name_test': $new_pole[$i] = 'Название дисциплины';break;
										case 'new_tests.type_r': $new_pole[$i] = 'Образовательное учережд.';break;
										case 'new_themes.name_th': $new_pole[$i] = 'Название темы';break;
										case 'new_materials.name': $new_pole[$i] = 'Имя справоч. материала';break;
										case 'new_materials.views': $new_pole[$i] = 'Просмотры';break;
										
		}
	}
	$GLOBALS['RusPola'] = $new_pole;
}

