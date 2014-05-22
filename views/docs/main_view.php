<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<?php if ($withoutcontent == 1)
{
	?>
<html>
<head> 
	<script src="http://code.jquery.com/jquery-2.1.0.js" type="text/javascript"></script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />	
    <link href = "<?= base_url() ?>css/docs_style.css" rel ="stylesheet" type="text/css">	
</head>

<script>google.load('visualization', '1', {packages:['corechart']});
////////НОВОЕ ПОЛЕ////////////////////////////////////////////
//$('table.tableOtchet').eq(1).remove();
var PoleMaket = [];


COUNT_POLE = 10;
var SchetP = 2;
var SchetU = 2;
var SchetV = 2;
var SchetD = 2;
var block = 1;
function newP(){
	if (block<=COUNT_POLE-1){
		$('#BlockPoleOtcheta').append($('#PoleOtcheta').html());
		block++;
	}

	
	var i = SchetP;

			
		$('select#PoleO_0').eq(1).attr('id','PoleO_'+i);
		$('input#newP_0').eq(1).attr('id','newP_'+i);
		$('input#delP_0').eq(1).attr('onclick','delP('+i+')');		
		$('input#delP_0').eq(1).attr('id','delP_'+i);
		$('input#sortP_0').eq(1).attr('value',i);
		$('input#sortP_0').eq(1).attr('id','sortP_'+i);	
		$('div#PoleOtcheta_0').eq(1).attr('id','PoleOtcheta_'+i);		
		i++;
		
	
	SchetP = i;	
}
	
var bloc = 1;
function newU(){

	if (bloc<=COUNT_POLE-1){
		$('#BlockUslovieFiltra').append($('#UslovieFiltra').html());
		bloc++;
	}

	
	var i = SchetU;

	
		$('select#poleU_0').eq(1).attr('id','poleU_'+i);
		$('select#znakU_0').eq(1).attr('id','znakU_'+i);
		$('textarea#textU_0').eq(1).attr('id','textU_'+i);
		$('input#newU_0').eq(1).attr('id','newU_'+i);
		$('input#delU_0').eq(1).attr('onclick','delU('+i+')');
		$('input#delU_0').eq(1).attr('id','delU_'+i);
		$('div#UslovieFiltra_0').eq(1).attr('id','UslovieFiltra_'+i);
		i++;
	
	SchetU = i;
}

var blo = 1;
function newV(){

	
	if (blo<=COUNT_POLE-1){
		$('#BlockVichPole').append($('#VichPole').html());
		blo++;
	}
	
	
	var i = SchetV;
	
	
		$('select#typePoleV_0').eq(1).attr('id','typePoleV_'+i);
		$('select#poleV_0').eq(1).attr('id','poleV_'+i);
		$('select#znakV_0').eq(1).attr('id','znakV_'+i);
		$('textarea#textV_0').eq(1).attr('id','textV_'+i);
		$('t#vior0').eq(1).attr('id','vior'+i);
		$('t1#vi0').eq(1).attr('id','vi'+i);
		$('input#newV_0').eq(1).attr('id','newV_'+i);		
		$('input#delV_0').eq(1).attr('onclick','delV('+i+')');
		$('input#delV_0').eq(1).attr('id','delV_'+i);	
		$('div#VichPole_0').eq(1).attr('id','VichPole_'+i);
		i++;
	
	SchetV	= i;
}

var bl = 1;
function newD(){
	
	if (bl<=1){
		$('#BlockDiagram').append($('#Diagram').html());bl++;
	}

	
	var i = SchetD;
//	$('select#typeD_1').eq(1).attr('id','typeD_'+i);
	$('select#poleD_1').eq(1).attr('id','poleD_'+i);
	$('select#typeRaschetD_1').eq(1).attr('id','typeRaschetD_'+i);
//	$('select#poleDO2_1').eq(1).attr('id','poleDO2_'+i);
//$('select#poleDO_1').eq(1).attr('id','poleDO_'+i);
	$('td1#sh_1').eq(1).attr('id','sh_'+i);
	$('td2#sho_1').eq(1).attr('id','sho_'+i);
	$('input#newD_1').eq(1).attr('id','newD_'+i);
	$('input#delD_1').eq(1).attr('onclick','delD('+i+')');
	$('input#delD_1').eq(1).attr('id','delD_'+i);
	$('div#Diagram_1').eq(1).attr('id','Diagram_'+i);
	i++;
	
	SchetD = i;
}
///////(/НОВОЕ ПОЛЕ)////////////////////////////////////////////



$(document).ready(function(){  
for (k=0; k < 1000; k++){

if (sessionStorage.getItem('PoleMaket'+k) !== null){
     $('#maletp').show();
	 var poleM = sessionStorage.getItem('PoleMaket'+k);
	// console.log(poleM);
	 
	$('table.maket').append('<td id ="maket'+k+'">'+poleM+'</td>'); 
		  //$('table.maket').append('<td id ="maket'+k+'">'+PoleMaket[k]+'</td>');
}
}

	if(sessionStorage.getItem('annul')==1){ $('input#annul').attr("checked", "checked");}
	if(sessionStorage.getItem('deleted')==1){ $('input#deleted').attr("checked", "checked");}


	var sessionP = [];
	var sessionPU = [];
	var sessionZU = [];
	var sessionTU = [];
	var sessionPV = [];
	var sessionTPV = [];
	var sessionZV = [];
	var sessionTV = [];
	var sessionTRD = [];
	var sessionPD = [];

	for (i=1;i<sessionStorage.getItem('countP');i++){
		newP();
	}
	for (i=1;i<sessionStorage.getItem('countU');i++){
		newU();
	}
	for (i=1;i<sessionStorage.getItem('countV');i++){
		newV();
	}
	for (i=1;i<sessionStorage.getItem('countD');i++){
		newD();
	}

	k1=1;k2=1;k3=1;
	for(i=1;i<1000;i++){
		sessionP[i] = sessionStorage.getItem('sessionP'+i);
		if(sessionP[i] == 'undefined'){delete sessionP[i]; 
		}
		sessionPU[i] = sessionStorage.getItem('sessionPU'+i);
		if(sessionPU[i] == 'undefined'){delete sessionPU[i]; 
		}
		sessionZU[i] = sessionStorage.getItem('sessionZU'+i);
		if(sessionZU[i] == 'undefined'){delete sessionZU[i]; 
		}
		sessionTU[i] = sessionStorage.getItem('sessionTU'+i);
		if(sessionTU[i] == 'undefined'){delete sessionTU[i]; 
		}
		sessionPV[i] = sessionStorage.getItem('sessionPV'+i);
		if(sessionPV[i] == 'undefined'){delete sessionPV[i]; 
		}
		sessionTPV[i] = sessionStorage.getItem('sessionTPV'+i);
		if(sessionTPV[i] == 'undefined'){delete sessionTPV[i]; 
		}
		sessionZV[i] = sessionStorage.getItem('sessionZV'+i);
		if(sessionZV[i] == 'undefined'){delete sessionZV[i]; 
		}
		sessionTV[i] = sessionStorage.getItem('sessionTV'+i);
		if(sessionTV[i] == 'undefined'){delete sessionTV[i]; 
		}
		/*
		sessionTD[i] = sessionStorage.getItem('sessionTD'+i);
		if(sessionTD[i] == 'undefined'){delete sessionTD[i]; 
		}
		*/
		sessionTRD[i] = sessionStorage.getItem('sessionTRD'+i);
		if(sessionTRD[i] == 'undefined'){delete sessionTRD[i]; 
		}
		/*
		sessionPDO[i] = sessionStorage.getItem('sessionPDO'+i);
		if(sessionPDO[i] == 'undefined'){delete sessionPDO[i]; 
		}
		sessionPDO2[i] = sessionStorage.getItem('sessionPDO2'+i);
		if(sessionPDO2[i] == 'undefined'){delete sessionPDO2[i]; 
		}
		*/
		sessionPD[i] = sessionStorage.getItem('sessionPD'+i);
		if(sessionPD[i] == 'undefined'){delete sessionPD[i]; 
		}
		if (sessionP[i] !== undefined){ console.log(sessionP[i]);
		$("select#poleO_"+k1+" [value='"+sessionP[i]+"']").attr("selected", "selected");k1++;
		console.log(k1);
		}
		if (sessionPU[i] !== undefined){
		$("select#poleU_"+k2+" [value='"+sessionPU[i]+"']").attr("selected", "selected");
		$("select#znakU_"+k2+" [value='"+sessionZU[i]+"']").attr("selected", "selected");
		$("textarea#textU_"+k2).val(sessionTU[i]);k2++;
		}
		if (sessionPV[i] !== undefined){
		$("select#poleV_"+k3+" [value='"+sessionPV[i]+"']").attr("selected", "selected");
		$("select#typePoleV_"+k3+" [value='"+sessionTPV[i]+"']").attr("selected", "selected");
		$("select#znakV_"+k3+" [value='"+sessionZV[i]+"']").attr("selected", "selected");
		$("textarea#textV_"+k3).val(sessionTV[i]);k3++;
		}
		//$("select#typeD_"+i+" [value='"+sessionTD[i]+"']").attr("selected", "selected");
		$("select#poleD_"+i+" [value='"+sessionPD[i]+"']").attr("selected", "selected");
		$("select#typeRaschetD_"+i+" [value='"+sessionTRD[i]+"']").attr("selected", "selected");
		//$("select#poleDO2_"+i+" [value='"+sessionPDO[i]+"']").attr("selected", "selected");
		//$("select#poleDO_"+i+" [value='"+sessionPDO2[i]+"']").attr("selected", "selected");
	}



	for(i=1;i<1000;i++){
	   
		if(sessionPV[i] !== 'undefined' && sessionTPV[i] !== "cz"){ 
			$("t1#vi"+i).show(); 
		}
		if(sessionZV[i] !== 'undefined' && sessionTPV[i] !== "cz"  && sessionTPV[i] !== "ca"  ){
			$("t1#vi"+i).show();
			$("t#vior"+i).show();
		}
		if(sessionTV[i] !== 'undefined' && sessionTPV[i] !== "cz"  && sessionTPV[i] !== "ca" ){ 
			$("t1#vi"+i).show();
			$("t#vior"+i).show(); 
		}
		if(sessionTRD[i] !== 'undefined' && sessionTRD[i] !== "no" && (sessionTRD[i] === "grK" || sessionTRD[i] === "grS") ){
			$("td1#sh_"+i).show(); 
			$("td2#sho_"+i).hide();
		}
		if(sessionTRD[i] !== 'undefined' && sessionTRD[i] !== "no" && (sessionTRD[i] === "otnSp" || sessionTRD[i] === "otnP")){
			$("td2#sho_"+i).show();
			$("td1#sh_"+i).hide();
		}
		if(sessionTRD[i] !== 'undefined' && sessionTRD[i] === "no" ){ 
			$("td2#sho_"+i).hide(); 
			$("td1#sh_"+i).hide();
		}
	}

})

////////УДАЛИТЬ ПОЛЕ////////////////////////////////////////////
function delP(i){



	if($('div#StopDelP').length !== 2){
		$('div#PoleOtcheta_'+i).remove();
		block--;//$('td#maket'+(i-1)).remove();
		//PoleMaket.splice(i-1);
		
		
		
		
	
	
		
			
		var length = $('div#StopDelP').length;
		// console.log(length);
		for(k=0; k<PoleMaket.length; k++){
		 $('td#maket'+k).remove();
		}
	   PoleMaket.splice(0, PoleMaket.length);
		 
		 for (k=1; k<length; k++){
	 if ($('select#PoleO_'+k).val() == undefined){
			length++;
		 }
		else{ PoleMaket.push($('select#PoleO_'+k).val());
		}
		}
		 for(k=0; k<PoleMaket.length; k++){
		
		
		
		
			
			switch (PoleMaket[k]){
											
					//	if (PoleMaket[k] !== undefined){					
										
				case "new_persons.firstname":{ PoleMaket[k] = 'Имя';break;}
				case "new_persons.lastname": {PoleMaket[k] ='Фамилия';break;}
				case "new_persons.middlename":{ PoleMaket[k] ='Отчество';break;}
				case "new_persons.numbgr":{ PoleMaket[k] = 'Номер группы';break;}
				case "new_persons.login":{ PoleMaket[k] = 'Логин';break;}
				case "new_persons.phone":{ PoleMaket[k] = 'Телефон';break;}
				case "new_persons.guest":{ PoleMaket[k] = 'Права пользователя';break;}
				case "new_persons.isrz":{ PoleMaket[k] = 'Индекс сложности решенных задач';break;}
				case "new_razd.name_razd": {PoleMaket[k] = 'Название теста';break;}
				case "new_results.true":{ PoleMaket[k] = 'Кол-во правильных';break;}
				case "new_results.true_all": {PoleMaket[k] = 'Всего вопросов';break;}
				case "new_results.proz":{ PoleMaket[k] = 'Результат (%)';break;}
				case "new_razd.multiplicity": {PoleMaket[k] = 'Сложность теста';break;}
				case "new_lections.name":{ PoleMaket[k] = 'Название лекции';break;}
				case "new_lect_results.timebeg":{ PoleMaket[k] = 'Время начала лекц.';break;}
				case "new_lect_results.timeend": {PoleMaket[k] = 'Время конца лекц.';break;}
				case "new_courses.name":{ PoleMaket[k] = 'Название курса';break;}
				case "new_courses.data":{ PoleMaket[k] = 'Дата';break;}
				case "new_courses.time_avg": {PoleMaket[k] = 'Время';break;}
				case "new_crs_results.timebeg": {PoleMaket[k] = 'Время начала курса';break;}
				case "new_crs_results.timeend": {PoleMaket[k] = 'Время конца курса';break;}
				case "new_crs_results.proz": {PoleMaket[k] = 'Статус прохождения';break;}
				case "new_crs_results.balls":{ PoleMaket[k] = 'Средний балл по тестам';break;}
				case "new_tests.name_test":{ PoleMaket[k] = 'Название дисциплины';break;}
				case "new_tests.type_r": {PoleMaket[k] = 'Образовательное учережд.';break;}
				case "new_themes.name_th":{ PoleMaket[k] = 'Название темы';break;}
				case "new_materials.name": {PoleMaket[k] = 'Имя справоч. материала';break;}
				case "new_materials.views": {PoleMaket[k] = 'Просмотры';break;}
					//	}					
			}
		
		}
	//	console.log(PoleMaket.length);
///console.log(PoleMaket);
		
			
		for (k=0; k < PoleMaket.length; k++){
					//if (PoleMaket[k] !== undefined){
			         $('table.maket').append('<td id ="maket'+k+'">'+PoleMaket[k]+'</td>');
						//}
					//if (k == PoleMaket.length) {$('#maket').append('</tr>');}
					}
		
		
		
		
		
	}
	
	else{
		$("select#poleO_1 [value='no']").attr("selected", "selected");
	}
}

function delU(i){

	if($('div#StopDelU').length !== 2){
		$('div#UslovieFiltra_'+i).remove();
		bloc--;
	}
	
	else{
		$("select#poleU_1 [value='no']").attr("selected", "selected");
		$("select#znakU_1 [value='no']").attr("selected", "selected");
		$("textarea#textU_1").val(' ');
	}
}

function delV(i){

	if($('div#StopDelV').length !== 2){
		$('div#VichPole_'+i).remove();
		blo--;
	}
	
	else{
		$("select#poleV_1 [value='no']").attr("selected", "selected");
		$("select#typePoleV_1 [value='no']").attr("selected", "selected");
		$("select#znakV_1 [value='no']").attr("selected", "selected");
		$("textarea#textV_1").val(' ');
	}
}

function delD(i){
	if(i!=1){
		if($('div#StopDelD').length > 1){
			$('div#Diagram_'+i).remove();
			bl--;
		}	
	}
	else{
		$("select#poleD_1 [value='no']").attr("selected", "selected");
		$("select#typeRaschetD_1 [value='no']").attr("selected", "selected");
	}
	
}
////////(/УДАЛИТЬ ПОЛЕ)////////////////////////////////////////////
////////ПЕРЕДАЧА ДАННЫХ НА СЕРВЕР////////////////////////////////////////////
function showData(){
	var annul;
	var deleted;
	var sortirovka;
	var AllPoleOtcheta = [];
	var AllPoleUslovie = [];
	var AllZnakUslovie = [];
	var AllTextUslovie = [];
	var AllTypeVichPole = [];
	var AllVichPole = [];
	var AllZnakVichPole = [];
	var AllTextVichPole = [];
//var AllTypeDiagramm = [];
	var AllTypeRaschetDiagramm = [];
	var AllPoleDiagramm = [];
//var AllPoleDiagrammO = [];
//var AllPoleDiagrammO2 = [];

	for (i=1;i<=1000;i++){		
		AllPoleOtcheta.push($('select#poleO_'+i).val());	
		AllPoleUslovie.push($('select#poleU_'+i).val());
		AllZnakUslovie.push($('select#znakU_'+i).val());	
		AllTextUslovie.push($('textarea#textU_'+i).val());
		AllTypeVichPole.push($('select#typePoleV_'+i).val());
		AllVichPole.push($('select#poleV_'+i).val());
		AllZnakVichPole.push($('select#znakV_'+i).val());
		AllTextVichPole.push($('textarea#textV_'+i).val());
	//	AllTypeDiagramm.push($('select#typeD_'+i).val());
		AllPoleDiagramm.push($('select#poleD_'+i).val());
		AllTypeRaschetDiagramm.push($('select#typeRaschetD_'+i).val());
	//	AllPoleDiagrammO.push($('select#poleDO_'+i).val());
	//	AllPoleDiagrammO2.push($('select#poleDO2_'+i).val());
		
		if($('input#sortP_'+i).prop("checked")){
			sortirovka = $('input#sortP_'+i).val();	
		}
	}
		
	
	if($('input#annul').prop("checked")){	
		annul = 1;
	}
	else{
		annul = 0;
	}
	if($('input#deleted').prop("checked")){
	deleted = 1; 
	}
	else{deleted = 0;};
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//$('div#delcontent').remove();
$.ajax({
	type : "POST",
	url : "<?= base_url() ?>docs_construct/index",
	data : ({
		phpAllPoleOtcheta : AllPoleOtcheta,
		phpAllPoleUslovie : AllPoleUslovie,
		phpAllZnakUslovie : AllZnakUslovie,
		phpAllTextUslovie : AllTextUslovie,
		phpAllTypeVichPole : AllTypeVichPole,
		phpAllVichPole : AllVichPole,
		phpAllZnakVichPole : AllZnakVichPole,
		phpAllTextVichPole : AllTextVichPole,
		//phpAllTypeDiagramm : AllTypeDiagramm,
		phpAllPoleDiagramm : AllPoleDiagramm,
		phpAllTypeRaschetDiagramm : AllTypeRaschetDiagramm,
		//phpAllPoleDiagrammO : AllPoleDiagrammO,
		//phpAllPoleDiagrammO2 : AllPoleDiagrammO2,
		annul : annul,
		deleted : deleted,
		sortirovka : sortirovka
	}),
	dataType: 'html',
	 success: function(html){  
          $("#content").html(html);}

})

for (i=0;i<1000;i++)
{
sessionStorage.setItem('sessionP'+i, $('select#poleO_'+i).val());
}

for (i=0;i<1000;i++)
{
sessionStorage.setItem('sessionPU'+i, $('select#poleU_'+i).val());
sessionStorage.setItem('sessionZU'+i, $('select#znakU_'+i).val());
sessionStorage.setItem('sessionTU'+i, $('textarea#textU_'+i).val());
}

for (i=0;i<1000;i++)
{
sessionStorage.setItem('sessionPV'+i, $('select#poleV_'+i).val());
sessionStorage.setItem('sessionTPV'+i, $('select#typePoleV_'+i).val());
sessionStorage.setItem('sessionZV'+i, $('select#znakV_'+i).val());
sessionStorage.setItem('sessionTV'+i, $('textarea#textV_'+i).val());
}

for (i=0;i<1000;i++)
{

sessionStorage.setItem('sessionTRD'+i, $('select#typeRaschetD_'+i).val());
//sessionStorage.setItem('sessionTD'+i, $('select#typeD_'+i).val());
sessionStorage.setItem('sessionPD'+i, $('select#poleD_'+i).val());
//sessionStorage.setItem('sessionPDO'+i, $('select#poleDO_'+i).val());
//sessionStorage.setItem('sessionPDO2'+i, $('select#poleDO2_'+i).val());
}

sessionStorage.setItem('annul', annul);
sessionStorage.setItem('deleted', deleted);


 for(k=0; k<PoleMaket.length; k++){
sessionStorage.setItem('PoleMaket'+k, PoleMaket[k]);
}
sessionStorage.setItem('countP', $('div#StopDelP').length-1);
sessionStorage.setItem('countU', $('div#StopDelU').length-1);
sessionStorage.setItem('countV', $('div#StopDelV').length-1);
sessionStorage.setItem('countD', $('div#StopDelD').length-1);

//console.log(sessionStorage.getItem('countP'));
}

	
///////(/ПЕРЕДАЧА ДАННЫХ НА СЕРВЕР)////////////////////////////////////////////




function saveData(){
	
	$.ajax({
	type : "POST",
	url : "<?= base_url() ?>docs_save/save_function",
	data : ({
		save : 'true'
	}),
	dataType: 'text',
	success: function(){
		alert( "Data Saved");
    }
	})
}
	



$(document).ready(function(){  

///////СКРЫТЫЕ ЭЛЕМЕНТЫ ДЛЯ ВЫЧИСЛЯЕМЫХ ПОЛЕЙ////////////////////////////////////////////
	function dopf(i){
	
	$('div#BlockPoleOtcheta').on('change', 'select#PoleO_'+i,
		
		function(){
		
	
	
		$('#maletp').show();
			
		var length = $('div#StopDelP').length;
		 //console.log(length);
		for(k=0; k<length; k++){
		 $('td#maket'+k).remove();//console.log(k);
		}
	   PoleMaket.splice(0, PoleMaket.length);
		 
		 for (k=1; k<length; k++){
		 if ($('select#PoleO_'+k).val() == undefined){
			length++;
		 }
		else{ PoleMaket.push($('select#PoleO_'+k).val());
		}}
		 for(k=0; k<PoleMaket.length; k++){
		
		
		
		
			
			switch (PoleMaket[k]){
											
											
										
				case "new_persons.firstname":{ PoleMaket[k] = 'Имя';break;}
				case "new_persons.lastname": {PoleMaket[k] ='Фамилия';break;}
				case "new_persons.middlename":{ PoleMaket[k] ='Отчество';break;}
				case "new_persons.numbgr":{ PoleMaket[k] = 'Номер группы';break;}
				case "new_persons.login":{ PoleMaket[k] = 'Логин';break;}
				case "new_persons.phone":{ PoleMaket[k] = 'Телефон';break;}
				case "new_persons.guest":{ PoleMaket[k] = 'Права пользователя';break;}
				case "new_persons.isrz":{ PoleMaket[k] = 'Индекс сложности решенных задач';break;}
				case "new_razd.name_razd": {PoleMaket[k] = 'Название теста';break;}
				case "new_results.true":{ PoleMaket[k] = 'Кол-во правильных';break;}
				case "new_results.true_all": {PoleMaket[k] = 'Всего вопросов';break;}
				case "new_results.proz":{ PoleMaket[k] = 'Результат (%)';break;}
				case "new_razd.multiplicity": {PoleMaket[k] = 'Сложность теста';break;}
				case "new_lections.name":{ PoleMaket[k] = 'Название лекции';break;}
				case "new_lect_results.timebeg":{ PoleMaket[k] = 'Время начала лекц.';break;}
				case "new_lect_results.timeend": {PoleMaket[k] = 'Время конца лекц.';break;}
				case "new_courses.name":{ PoleMaket[k] = 'Название курса';break;}
				case "new_courses.data":{ PoleMaket[k] = 'Дата';break;}
				case "new_courses.time_avg": {PoleMaket[k] = 'Время';break;}
				case "new_crs_results.timebeg": {PoleMaket[k] = 'Время начала курса';break;}
				case "new_crs_results.timeend": {PoleMaket[k] = 'Время конца курса';break;}
				case "new_crs_results.proz": {PoleMaket[k] = 'Статус прохождения';break;}
				case "new_crs_results.balls":{ PoleMaket[k] = 'Средний балл по тестам';break;}
				case "new_tests.name_test":{ PoleMaket[k] = 'Название дисциплины';break;}
				case "new_tests.type_r": {PoleMaket[k] = 'Образовательное учережд.';break;}
				case "new_themes.name_th":{ PoleMaket[k] = 'Название темы';break;}
				case "new_materials.name": {PoleMaket[k] = 'Имя справоч. материала';break;}
				case "new_materials.views": {PoleMaket[k] = 'Просмотры';break;}
											
			}
		
		}//console.log(PoleMaket.length);
		//console.log(PoleMaket);
		
		for (k=0; k < PoleMaket.length; k++){
			         $('table.maket').append('<td id ="maket'+k+'">'+PoleMaket[k]+'</td>');
	    
					//if (k == PoleMaket.length) {$('#maket').append('</tr>');}
					}
					//

		});
					
	
		$('div#BlockVichPole').on('change', 'select#typePoleV_'+i,
		function(){
		 
			var val = $("select#typePoleV_"+i).val();
			console.log(val);
			if(val=='cs'){
				$("t1#vi"+i).show();
				$("t#vior"+i).show();	
			}	
			if(val=='ca'){
				$("t1#vi"+i).show();
				$("t#vior"+i).hide();
			}	
			if(val==='cz'){
				$("t1#vi"+i).hide();
				$("t#vior"+i).hide();		
			}
		});
					  

		$('div#BlockDiagram').on('change', 'select#typeRaschetD_'+i,
		function(){
			var val = $("select#typeRaschetD_"+i).val();
			if(val=='otnSp'){
				$("td1#sh_"+i).hide();
				$("td2#sho_"+i).show();	
			}	
			if(val=='otnP'){
				$("td1#sh_"+i).hide();
				$("td2#sho_"+i).show();	
			}	
			if(val=='otnSpk'){
				$("td1#sh_"+i).hide();
				$("td2#sho_"+i).show();	
			}	
			if(val=='otnPR'){
				$("td1#sh_"+i).hide();
				$("td2#sho_"+i).show();
			}
			if(val=='grS'){
				$("td1#sh_"+i).show();
				$("td2#sho_"+i).hide();
			}	
			if(val=='grK'){
				$("td1#sh_"+i).show();
				$("td2#sho_"+i).hide();
			}	
			if(val==='no'){
			   $("td1#sh_"+i).hide();
				$("td2#sho_"+i).hide();	
			}
		});
	}
	for (i=1;i<1000;i++){
		dopf(i); 
	}   

//////(/СКРЫТЫЕ ЭЛЕМЕНТЫ ДЛЯ ВЫЧИСЛЯЕМЫХ ПОЛЕЙ)////////////////////////////////////////////
})
</script>

<body>
<form id = 'MainForm'  method = 'POST' action = '<?= base_url() ?>docs_save/save_function'>
<div id = 'form'>
	<div id = 'BlockPoleOtcheta'>
		<b>&nbspПостроить отчет по:</b>
		<input  type="checkbox"  value = 'annul' id = 'annul' /><big>Показать неактивные записи</big>
		<!--<input type="checkbox"  value = 'deleted' id = 'deleted' /><big id = 'deld'>Показать удаленные записи</big>-->
		<div id = 'PoleOtcheta' hidden = 'true'>
			<div id = 'PoleOtcheta_0' >
			<div id = 'StopDelP'>
			<input type="radio" id="sortP_0" value = "1" name = "sortP">сорт.</input>
			 <select id = "poleO_0">
				<option value ='' >...</option>
				<optgroup label = 'Пользователи'>
				<option value ="new_persons.firstname">Имя</option>
				<option value ="new_persons.lastname">Фамилия</option>
				<option value ="new_persons.middlename">Отчество</option>
				<option value ="new_persons.numbgr">Номер группы</option>
				<option value ="new_persons.login">Логин</option>
				<option value ="new_persons.phone">Телефон</option>
				<option value ="new_persons.guest">Права пользователя</option>
				<option value ="new_persons.isrz">Сложность решенных задач</option>
				</optgroup>
		 
				<optgroup label = 'Тестирование'>
				<option value ="new_razd.name_razd">Название теста</option>
				<option value ="new_results.true">Кол-во правильных</option>
				<option value ="new_results.true_all">Всего вопросов</option>
				<option value ="new_results.proz">Результат</option>	
				<option value ="new_razd.multiplicity">Сложность теста</option>
				</optgroup>
				 
				<optgroup label = 'Лекции'>
				<option value ="new_lections.name">Название лекции</option>
				<option value ="new_lect_results.timebeg">Время начала лекц.</option>
				<option value ="new_lect_results.timeend">Время конца</option>
				</optgroup>
				 
				<optgroup label = 'Курсы'>
				<option value ="new_courses.name">Название курса</option>
				<option value ="new_courses.data">Дата</option>
				<option value ="new_courses.time_avg">Время</option>
				<option value ="new_crs_results.timebeg">Время начала курса</option>
				<option value ="new_crs_results.timeend">Время конца</option>
				<option value ="new_crs_results.proz">Статус прохождения</option>
				<option value ="new_crs_results.balls">Средний балл по тестам</option>
				</optgroup>
				 
				<optgroup label = 'Дисциплины'>
				<option value ="new_tests.name_test">Название дисциплины</option>  
				<option value ="new_tests.type_r">Образовательное учережд.</option>
				<option value ="new_themes.name_th">Название темы</option>
				<option value ="new_materials.name">Имя справоч. материала</option>
				<option value ="new_materials.views">Просмотры</option>
				</optgroup>
					
			</select >  
			<tann hidden='true'>
			</tann>
			<input type="button" value="new" onclick="newP()" id = 'newP_0'/>
			<input type="button" value="del" onclick="delP(0)" id = 'delP_0'/>
			</div>
			</div>
		</div> 
			<div id = 'PoleOtcheta_1' >
			<div id = 'StopDelP'>
			<input type="radio" id="sortP_1" value = "1" name = "sortP">сорт.</input>
			 <select id = "PoleO_1">
				<option value ='' >...</option>
				<optgroup label = 'Пользователи'>
				<option value ="new_persons.firstname">Имя</option>
				<option value ="new_persons.lastname">Фамилия</option>
				<option value ="new_persons.middlename">Отчество</option>
				<option value ="new_persons.numbgr">Номер группы</option>
				<option value ="new_persons.login">Логин</option>
				<option value ="new_persons.phone">Телефон</option>
				<option value ="new_persons.guest">Права пользователя</option>
				<option value ="new_persons.isrz">Сложность решенных задач</option>
				</optgroup>
		 
				<optgroup label = 'Тестирование'>
				<option value ="new_razd.name_razd">Название теста</option>
				<option value ="new_results.true">Кол-во правильных</option>
				<option value ="new_results.true_all">Всего вопросов</option>
				<option value ="new_results.proz">Результат</option>	
				<option value ="new_razd.multiplicity">Сложность теста</option>
				</optgroup>
				 
				<optgroup label = 'Лекции'>
				<option value ="new_lections.name">Название лекции</option>
				<option value ="new_lect_results.timebeg">Время начала лекц.</option>
				<option value ="new_lect_results.timeend">Время конца</option>
				</optgroup>
				 
				<optgroup label = 'Курсы'>
				<option value ="new_courses.name">Название курса</option>
				<option value ="new_courses.data">Дата</option>
				<option value ="new_courses.time_avg">Время</option>
				<option value ="new_crs_results.timebeg">Время начала курса</option>
				<option value ="new_crs_results.timeend">Время конца</option>
				<option value ="new_crs_results.proz">Статус прохождения</option>
				<option value ="new_crs_results.balls">Средний балл по тестам</option>
				</optgroup>
				 
				<optgroup label = 'Дисциплины'>
				<option value ="new_tests.name_test">Название дисциплины</option>  
				<option value ="new_tests.type_r">Образовательное учережд.</option>
				<option value ="new_themes.name_th">Название темы</option>
				<option value ="new_materials.name">Имя справоч. материала</option>
				<option value ="new_materials.views">Просмотры</option>
				</optgroup>
					
			</select >  
			<tann hidden='true'>
			</tann>
			<input type="button" value="new" onclick="newP()" id = 'newP_1'/>
			<input type="button" value="del" onclick="delP(1)" id = 'delP_1'/>
			</div>
			</div>
	</div>

<div id = 'line'>
</div>
	<div id = 'BlockUslovieFiltra'>
		<b>&nbspУсловия вывода:</b><br>
		<div id = 'UslovieFiltra' hidden = 'true' >
			<div id ='UslovieFiltra_0'>
			<div id = 'StopDelU'>
			<select id = "poleU_0" >
			 
				<option value ="no">...</option>
				<optgroup label = 'Пользователи'>
				<option value ="new_persons.firstname">Имя</option>
				<option value ="new_persons.lastname">Фамилия</option>
				<option value ="new_persons.middlename">Отчество</option>
				<option value ="new_persons.numbgr">Номер группы</option>
				<option value ="new_persons.login">Логин</option>
				<option value ="new_persons.phone">Телефон</option>
				<option value ="new_persons.guest">Права пользователя</option>
				<option value ="new_persons.isrz">Сложность решенных задач</option>
				</optgroup>
				 
				<optgroup label = 'Тестирование'>
				<option value ="new_razd.name_razd">Название теста</option>
				<option value ="new_results.true">Кол-во правильных</option>
				<option value ="new_results.true_all">Всего вопросов</option>
				<option value ="new_results.proz">Результат</option>
				<option value ="new_razd.multiplicity">Сложность теста</option>
				</optgroup>
				 
				<optgroup label = 'Лекции'>
				<option value ="new_lections.name">Название лекции</option>
				<option value ="new_lect_results.timebeg">Время начала лекц.</option>
				<option value ="new_lect_results.timeend">Время конца</option>
				</optgroup>
				 
				<optgroup label = 'Курсы'>
				<option value ="new_courses.name">Название курса</option>
				<option value ="new_courses.data">Дата</option>
				<option value ="new_courses.time_avg">Время</option>
				<option value ="new_crs_results.timebeg">Время начала курса</option>
				<option value ="new_crs_results.timeend">Время конца</option>
				<option value ="new_crs_results.proz">Статус прохождения</option>
				<option value ="new_crs_results.balls">Средний балл по тестам</option>
				</optgroup>
				 
				<optgroup label = 'Дисциплины'>
				<option value ="new_tests.name_test">Название дисциплины</option>  
				<option value ="new_tests.type_r">Образовательное учережд.</option>
				<option value ="new_themes.name_th">Название темы</option>
				<option value ="new_materials.name">Имя справоч. материала</option>
				<option value ="new_materials.views">Просмотры</option>
				</optgroup>
				 
			</select > 
			 <select id = 'znakU_0'>
				<option value ="no" selected="selected">...</option>
				<option value =">">></option>
				<option value ="<"><</option>
				<option value ="=">=</option>
			</select>
			
			
			<textarea id = 'textU_0' rows = '1' class = 'textusl'>
			</textarea>
			<input type="button" value="new" onclick="newU()" id = 'newU_0'/>
			<input type="button" value="del" onclick="delU(0)" id = 'delU_0'/>
			</div>
			</div>
		</div> 
		<div id ='UslovieFiltra_1'>
			<div id = 'StopDelU'>
			<select id = "poleU_1" >
			 
				<option value ="no">...</option>
				<optgroup label = 'Пользователи'>
				<option value ="new_persons.firstname">Имя</option>
				<option value ="new_persons.lastname">Фамилия</option>
				<option value ="new_persons.middlename">Отчество</option>
				<option value ="new_persons.numbgr">Номер группы</option>
				<option value ="new_persons.login">Логин</option>
				<option value ="new_persons.phone">Телефон</option>
				<option value ="new_persons.guest">Права пользователя</option>
				<option value ="new_persons.isrz">Сложность решенных задач</option>
				</optgroup>
				 
				<optgroup label = 'Тестирование'>
				<option value ="new_razd.name_razd">Название теста</option>
				<option value ="new_results.true">Кол-во правильных</option>
				<option value ="new_results.true_all">Всего вопросов</option>
				<option value ="new_results.proz">Результат</option>
				<option value ="new_razd.multiplicity">Сложность теста</option>
				</optgroup>
				 
				<optgroup label = 'Лекции'>
				<option value ="new_lections.name">Название лекции</option>
				<option value ="new_lect_results.timebeg">Время начала лекц.</option>
				<option value ="new_lect_results.timeend">Время конца</option>
				</optgroup>
				 
				<optgroup label = 'Курсы'>
				<option value ="new_courses.name">Название курса</option>
				<option value ="new_courses.data">Дата</option>
				<option value ="new_courses.time_avg">Время</option>
				<option value ="new_crs_results.timebeg">Время начала курса</option>
				<option value ="new_crs_results.timeend">Время конца</option>
				<option value ="new_crs_results.proz">Статус прохождения</option>
				<option value ="new_crs_results.balls">Средний балл по тестам</option>
				</optgroup>
				 
				<optgroup label = 'Дисциплины'>
				<option value ="new_tests.name_test">Название дисциплины</option>  
				<option value ="new_tests.type_r">Образовательное учереждение</option>
				<option value ="new_themes.name_th">Название темы</option>
				<option value ="new_materials.name">Имя справоч. материала</option>
				<option value ="new_materials.views">Просмотры</option>
				</optgroup>
				 
			</select > 
			 <select id = 'znakU_1'>
				<option value ="no" selected="selected">...</option>
				<option value =">">></option>
				<option value ="<"><</option>
				<option value ="=">=</option>
			</select>
			
			
			<textarea id = 'textU_1' rows = '1' class = 'textusl'>
			</textarea>
			<input type="button" value="new" onclick="newU()" id = 'newU_1'/>
			<input type="button" value="del" onclick="delU(1)" id = 'delU_1'/>
			</div>
			</div>
	</div>

<div id = 'line'>
</div>

	<div id = 'BlockVichPole'>
		<b>&nbspСоздать вычисляемые поля:</b><br>
		<div id = 'VichPole' hidden = 'true'>
		<div id = 'VichPole_0'>
		<div id = 'StopDelV'>
			<select id = "typePoleV_0" >
				<option value ="no" >...</option>
				<option value ="cz" >Количество записей</option>
				<option value ="cs" >Количество совпадений</option>
				<option value ="ca" >Среднее арифметическое</option>
			</select> 
			
			<t1 id = 'vi0' hidden = 'true'>
			<select id = "poleV_0">
			 
				<option value ="no">...</option>
				<optgroup label = 'Пользователи'>
				<option value ="new_persons.firstname">Имя</option>
				<option value ="new_persons.lastname">Фамилия</option>
				<option value ="new_persons.middlename">Отчество</option>
				<option value ="new_persons.numbgr">Номер группы</option>
				<option value ="new_persons.login">Логин</option>
				<option value ="new_persons.phone">Телефон</option>
				<option value ="new_persons.guest">Права пользователя</option>
				<option value ="new_persons.isrz">Сложность решенных задач</option>
				</optgroup>
				 
				<optgroup label = 'Тестирование'>
				<option value ="new_razd.name_razd">Название теста</option>
				<option value ="new_results.true">Кол-во правильных</option>
				<option value ="new_results.true_all">Всего вопросов</option>
				<option value ="new_results.proz">Результат</option>
				<option value ="new_razd.multiplicity">Сложность теста</option>
				</optgroup>
				 
				<optgroup label = 'Лекции'>
				<option value ="new_lections.name">Название лекции</option>
				<option value ="new_lect_results.timebeg">Время начала лекции</option>
				<option value ="new_lect_results.timeend">Время конца</option>
				</optgroup>
				 
				<optgroup label = 'Курсы'>
				<option value ="new_courses.name">Название курса</option>
				<option value ="new_courses.data">Дата</option>
				<option value ="new_courses.time_avg">Время</option>
				<option value ="new_crs_results.timebeg">Время начала курса</option>
				<option value ="new_crs_results.timeend">Время конца</option>
				<option value ="new_crs_results.proz">Статус прохождения</option>
				<option value ="new_crs_results.balls">Средний балл по тестам</option>
				</optgroup>
				 
				<optgroup label = 'Дисциплины'>
				<option value ="new_tests.name_test">Название дисциплины</option>  
				<option value ="new_tests.type_r">Образовательное учережд.</option>
				<option value ="new_themes.name_th">Название темы</option>
				<option value ="new_materials.name">Имя справоч. материала</option>
				<option value ="new_materials.views">Просмотры</option>
				</optgroup>
				 
			</select > 
			 </t1>
			 <t id = 'vior0' hidden = 'true'>
			<select id='znakV_0' >
			
				<option value ="no" selected="selected" >...</option>
				<option value =">">></option>
				<option value ="<"><</option>
				<option value ="=">=</option>
							 
			</select>
			<textarea id = 'textV_0' rows = '1' >
			</textarea>
			</t>
			<input type="button" value="new" onclick="newV()" id = 'newV_0'/>
			<input type="button" value="del" onclick="delV(0)" id = 'delV_0'/>
			</div>
			</div>
		</div> 	
		<div id = 'VichPole_1'>
		<div id = 'StopDelV'>
			<select id = "typePoleV_1" >
				<option value ="no" >...</option>
				<option value ="cz" >Количество записей</option>
				<option value ="cs" >Количество совпадений</option>
				<option value ="ca" >Среднее арифметическое</option>
			</select> 
			
			<t1 id = 'vi1' hidden = 'true'>
			<select id = "poleV_1">
			 
				<option value ="no">...</option>
				<optgroup label = 'Пользователи'>
				<option value ="new_persons.firstname">Имя</option>
				<option value ="new_persons.lastname">Фамилия</option>
				<option value ="new_persons.middlename">Отчество</option>
				<option value ="new_persons.numbgr">Номер группы</option>
				<option value ="new_persons.login">Логин</option>
				<option value ="new_persons.phone">Телефон</option>
				<option value ="new_persons.guest">Права пользователя</option>
				<option value ="new_persons.isrz">Сложность решенных задач</option>
				</optgroup>
				 
				<optgroup label = 'Тестирование'>
				<option value ="new_razd.name_razd">Название теста</option>
				<option value ="new_results.true">Кол-во правильных</option>
				<option value ="new_results.true_all">Всего вопросов</option>
				<option value ="new_results.proz">Результат</option>
				<option value ="new_razd.multiplicity">Сложность теста</option>
				</optgroup>
				 
				<optgroup label = 'Лекции'>
				<option value ="new_lections.name">Название лекции</option>
				<option value ="new_lect_results.timebeg">Время начала лекц.</option>
				<option value ="new_lect_results.timeend">Время конца</option>
				</optgroup>
				 
				<optgroup label = 'Курсы'>
				<option value ="new_courses.name">Название курса</option>
				<option value ="new_courses.data">Дата</option>
				<option value ="new_courses.time_avg">Время</option>
				<option value ="new_crs_results.timebeg">Время начала курса</option>
				<option value ="new_crs_results.timeend">Время конца</option>
				<option value ="new_crs_results.proz">Статус прохождения</option>
				<option value ="new_crs_results.balls">Средний балл по тестам</option>
				</optgroup>
				 
				<optgroup label = 'Дисциплины'>
				<option value ="new_tests.name_test">Название дисциплины</option>  
				<option value ="new_tests.type_r">Образовательное учережд.</option>
				<option value ="new_themes.name_th">Название темы</option>
				<option value ="new_materials.name">Имя справоч. материала</option>
				<option value ="new_materials.views">Просмотры</option>
				</optgroup>
				 
			</select > 
			 </t1>
			 <t id = 'vior1' hidden = 'true'>
			<select id='znakV_1' >
			
				<option value ="no" selected="selected" >...</option>
				<option value =">">></option>
				<option value ="<"><</option>
				<option value ="=">=</option>
							 
			</select>
			<textarea id = 'textV_1' rows = '1' >
			</textarea>
			</t>
			<input type="button" value="new" onclick="newV()" id = 'newV_1'/>
			<input type="button" value="del" onclick="delV(1)" id = 'delV_1'/>
			</div>
			</div>
	</div>

<div id = 'line'>
</div>

	<div id = 'BlockDiagram' >
		<b>&nbspСоздать Диаграмму:</b><br>
		<div id = 'Diagram'>
		<div id = 'Diagram_1'>
		<div id = 'StopDelD'>	
			<select id = "typeRaschetD_1" >
			
				<option value ="no" selected="selected">...</option>
				<option value ="grK">Группировка (круговая диаграмма)</option>
				<option value ="grS">Группировка (столбцы)</option>
				<option value ="otnP">Среднее количество правильных по группе(столбцы)</option>
				<option value ="otnPR">Средний результат тестов по группе(столбцы)</option>
				<option value ="otnSp">Просмотры справочных матириалов(столбцы)</option>
				<option value ="otnSpk">Статус прохождения курсов(столбцы)</option>
			
			</select> <td1 id = 'sh_1' hidden = 'true'>	
			<select id = "poleD_1">
			 
				<option value ="no">...</option>
				<optgroup label = 'Пользователи'>
				<option value ="new_persons.firstname">Имя</option>
				<option value ="new_persons.lastname">Фамилия</option>
				<option value ="new_persons.middlename">Отчество</option>
				<option value ="new_persons.numbgr">Номер группы</option>
				<option value ="new_persons.login">Логин</option>
				<option value ="new_persons.phone">Телефон</option>
				<option value ="new_persons.guest">Права пользователя</option>
				<option value ="new_persons.isrz">Сложность задач</option>
				</optgroup>
				 
				<optgroup label = 'Тестирование'>
				<option value ="new_razd.name_razd">Название теста</option>
				<option value ="new_results.true">Кол-во правильных</option>
				<option value ="new_results.true_all">Всего вопросов</option>
				<option value ="new_results.proz">Результат</option>
				<option value ="new_razd.multiplicity">Сложность теста</option>
				</optgroup>
				 
				<optgroup label = 'Лекции'>
				<option value ="new_lections.name">Название лекции</option>
				<option value ="new_lect_results.timebeg">Время начала лекц.</option>
				<option value ="new_lect_results.timeend">Время конца</option>
				</optgroup>
				 
				<optgroup label = 'Курсы'>
				<option value ="new_courses.name">Название курса</option>
				<option value ="new_courses.data">Дата</option>
				<option value ="new_courses.time_avg">Время</option>
				<option value ="new_crs_results.timebeg">Время начала курса</option>
				<option value ="new_crs_results.timeend">Время конца</option>
				<option value ="new_crs_results.proz">Статус прохождения</option>
				<option value ="new_crs_results.balls">Средний балл по тестам</option>
				</optgroup>
				 
				<optgroup label = 'Дисциплины'>
				<option value ="new_tests.name_test">Название дисциплины</option>  
				<option value ="new_tests.type_r">Образовательное учережд.</option>
				<option value ="new_themes.name_th">Название темы</option>
				<option value ="new_materials.name">Имя справоч. материала</option>
				<option value ="new_materials.views">Просмотры</option>
				</optgroup>
				 
			</select > 
			 </td1>
			 <td2 id = 'sho_1' hidden = 'true'>	

			 </td2>
			<!--<input type="button" value="new" onclick="newD()" id = 'newD_1'/>-->
			<input type="button" value="del" onclick="delD(1)" id = 'delD_1'/>
			</div>
			</div>
		</div> 	
	</div>

<hr>
<div id = 'maket'>
<b hidden = 'true' id = 'maletp'>
Выбранные поля :
</b>
<table class = 'maket' >

</table>
</div>
<hr>
<input type="button" value="Показать отчет" onclick="showData()" id = 'sendata'/>
<!--<input type="button" value="Сохранить отчет" onclick="saveData()" id = 'savedata'/>-->
<input type="submit" value="Сохранить отчет"  id = 'savedata'/>
</div>

<hr>

</form>


<div id = 'session_content'>
<div id = 'delcontent'>
<?php 
}
////////////////////////////////////////////////////
if ($content == 1){
    $pole_d = $_SESSION['pole_d'];    
    $nabor = $_SESSION['nabor']; 
    $result = $_SESSION['result'];
	$typeRD = $_SESSION['type_raschet_d'];
	
    $iD = 0;

	if ($typeRD[0] == 'grK'){	//Круговая групировка	
	 $diagrOK = 0;
	    foreach($nabor as $n){
			if ($n == $pole_d[0]){
				$diagrOK++;
			}
		}
		
		if ($diagrOK == 1){
        DiagrammData_group($pole_d, $nabor, $result);
    
      
		echo "<script type='text/javascript'>";
		
		echo "google.load('visualization', '1.0', {'packages':['corechart']});";
		if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "  

     
      function drawChart() {";
		}
			echo "var data = google.visualization.arrayToDataTable([";
			echo "['Елемент', 'Кол.'],";
			for ($i=0;$i<count($GLOBALS['Znachenia']);$i++){
				
				 echo "['".$GLOBALS['Pola'][$i]."',     ".$GLOBALS['Znachenia'][$i]."],";
				  
			}
			echo "]);
			var options = {
			};
			var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
			chart.draw(data, options);";
        if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "}google.setOnLoadCallback(drawChart);";
		}
			echo "</script>";
		echo "<div id='chart_div' ></div>";	
        }
		else{
		echo "<h3>Выброного поля диаграммы нет в отчете</h3>";
		}
		 
	}
		       
	if ($typeRD[0] == 'grS'){//Столбцы групировка
       $diagrOK = 0;
	    foreach($nabor as $n){
			if ($n == $pole_d[0]){
				$diagrOK++;
			}
		}
		
		if ($diagrOK == 1){
		DiagrammData_group($pole_d, $nabor, $result);
		
    
		echo "<script type='text/javascript'>";
		
		echo "google.load('visualization', '1.0', {'packages':['corechart']});";
		if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "  

     
      function drawChart() {";
		}
			echo "var data = google.visualization.arrayToDataTable([";
			echo "['Елемент', 'Кол.'],";
			for ($i=0;$i<count($GLOBALS['Znachenia']);$i++){
				
				 echo "['".$GLOBALS['Pola'][$i]."',     ".$GLOBALS['Znachenia'][$i]."],";
				  
			}
			echo "]);
			var options = {
			};
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);";
        if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "}google.setOnLoadCallback(drawChart);";
		}
			echo "</script>";
		echo "<div id='chart_div' ></div>";	
		}
		else{
		echo "<h3>Выброного поля диаграммы нет в отчете</h3>";
		}
	}

	if($typeRD[0] == 'otnP'){//Результаты тестов по группам
	
		$polex = 'new_results.true';
		$poley = 'new_persons.numbgr';
		
		$diagrOK = 0;
	    foreach($nabor as $n){
			if ($n == 'new_results.true' OR $n == 'new_persons.numbgr'){
				$diagrOK++;
			}
		}
		
		if ($diagrOK == 2){
		
		DiagrammData_results($poley,$polex,$nabor,$result);

		
		echo "<script type='text/javascript'>";
		
		echo "google.load('visualization', '1.0', {'packages':['corechart']});";
		if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "  

     
      function drawChart() {";
		}
			echo "var data = google.visualization.arrayToDataTable([";
			echo "['Елемент', 'Кол.'],";
			for ($i=0;$i<count($GLOBALS['Znachenia']);$i++){
				
				 echo "['".$GLOBALS['Pola'][$i]."',     ".$GLOBALS['Znachenia'][$i]."],";
				  
			}
			echo "]);
			var options = {
			};
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);";
        if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "}google.setOnLoadCallback(drawChart);";
		}
			echo "</script>";
		echo "<div id='chart_div' ></div>";	
		}
		else{
		echo "<h3>Выберте поля кол-во правильных и названий тестов для создания диаграммы</h3>";
		}
	}
	
	if ($typeRD[0] == 'otnPR'){
	    $polex = 'new_results.proz';
		$poley = 'new_persons.numbgr';
$diagrOK = 0;
	    foreach($nabor as $n){
			if ($n == 'new_results.proz' OR $n == 'new_persons.numbgr'){
				$diagrOK++;
			}
		}
		
		if ($diagrOK == 2){
		DiagrammData_results($poley,$polex,$nabor,$result);
	
		echo "<script type='text/javascript'>";
		
		echo "google.load('visualization', '1.0', {'packages':['corechart']});";
		if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "  

     
      function drawChart() {";
		}
			echo "var data = google.visualization.arrayToDataTable([";
			echo "['Елемент', 'Кол.'],";
			for ($i=0;$i<count($GLOBALS['Znachenia']);$i++){
				
				 echo "['".$GLOBALS['Pola'][$i]."',     ".$GLOBALS['Znachenia'][$i]."],";
				  
			}
			echo "]);
			var options = {
			};
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);";
        if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "}google.setOnLoadCallback(drawChart);";
		}
			echo "</script>";
		echo "<div id='chart_div' ></div>";	
		}
		else{
		echo "<h3>Выберте поля результатов и названий тестов для создания диаграммы</h3>";
		}
	}	
	   
	   
	   
	if ($typeRD[0] == 'otnSp'){
	
	    $polex = 'new_materials.views';
	    $poley = 'new_materials.name';
		$diagrOK = 0;
	    foreach($nabor as $n){
			if ($n == 'new_materials.views' OR $n == 'new_materials.name'){
				$diagrOK++;
			}
		}
		
		if ($diagrOK == 2){
        DiagrammData_other($poley,$polex,$nabor,$result);         
				
		
		echo "<script type='text/javascript'>";
		
		echo "google.load('visualization', '1.0', {'packages':['corechart']});";
		if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "  

     
      function drawChart() {";
		}
			echo "var data = google.visualization.arrayToDataTable([";
			echo "['Елемент', 'Кол.'],";
			for ($i=0;$i<count($GLOBALS['Znachenia']);$i++){
				
				 echo "['".$GLOBALS['Pola'][$i]."',     ".$GLOBALS['Znachenia'][$i]."],";
				  
			}
			echo "]);
			var options = {
			};
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);";
        if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "}google.setOnLoadCallback(drawChart);";
		}
			echo "</script>";
		echo "<div id='chart_div' ></div>";	
		}
		else{
		echo "<h3>Выберте поля просмотры и назвния матриалов для создания диаграммы</h3>";
		}
	}

			
            

			
			
	 if ($typeRD[0] == 'otnSpk'){
		
	   $polex = 'new_crs_results.proz';
	   $poley = 'new_courses.name';
	   $diagrOK = 0;
	    foreach($nabor as $n){
			if ($n == 'new_crs_results.proz' OR $n == 'new_courses.name'){
				$diagrOK++;
			}
		}
		
		echo $diagrOK;
		if ($diagrOK == 2){
	     DiagrammData_other($poley,$polex,$nabor,$result);         
			
		echo "<script type='text/javascript'>";
		
		echo "google.load('visualization', '1.0', {'packages':['corechart']});";
		if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "  

     
      function drawChart() {";
		}
			echo "var data = google.visualization.arrayToDataTable([";
			echo "['Елемент', 'Кол.'],";
			for ($i=0;$i<count($GLOBALS['Znachenia']);$i++){
				
				 echo "['".$GLOBALS['Pola'][$i]."',     ".$GLOBALS['Znachenia'][$i]."],";
				  
			}
			echo "]);
			var options = {
			};
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);";
        if(!isset($_REQUEST['phpAllTypeRaschetDiagramm'])){
        echo "}google.setOnLoadCallback(drawChart);";
		}
			echo "</script>";
		echo "<div id='chart_div' ></div>";	
	   }
	   
		else{
		echo "<h3>Выберте поля статусов прохождения и названий курсов для создания диаграммы</h3>";
		}
	}		


$type_v = $_SESSION['type_v'];
$text_v = $_SESSION['text_v'];
$pole_v = $_SESSION['pole_v'];
$znak_v = $_SESSION['znak_v'];
$limitedResult = $_SESSION['limitedResult'];
$page = $_SESSION['page'];


$naborV = array();
$poleV = array();

 $schet_vpole = 0;
        
        if (!empty($type_v)){
			
            foreach($type_v as $vpole){

                switch($vpole){ 
                    
                    case 'cz':  
						echo '<table class = "tableOtchetV" ';echo "<tr>";
						echo "<td bgcolor='paleturquoise'>Количество записей</td><td><b class = 'white'>".count($result)."</b></td>";
						echo "</tr>";
						echo '</table>';

						$schet_vpole++;
						$naborV[] = 'Количество записей';
						$poleV[] = count($result);
					break;
                                
         
                    case 'cs' :                               
                        for($i=0;$i<count($text_v);$i++){     
                            $text_v[$i] = trim($text_v[$i]); 
                        }
						$count = 0;
                        $counts = 0;
						$shift = 0;
                        for($i=0;$i<count($nabor);$i++){
                            if (empty($nabor[$i])){$shift++;}
                                if ($nabor[$i]==$pole_v[$schet_vpole]){
                                        $count =$i;
                                } 
                        }
						$count -= $shift;
                            foreach ($result as $quer){
                    		    $p = 0; 
                                foreach($quer as $it){
                                    if ($p==$count){
                                            switch ($znak_v[$schet_vpole]){
                                                
                                                case '=': if ($it == $text_v[$schet_vpole]){$counts++;}break;
                                
                                                case '>': if ($it > $text_v[$schet_vpole]){$counts++;}break;
                                                
                                                case '<': if ($it < $text_v[$schet_vpole]){$counts++;}break;  
     
                                            }    
                                    } 
                                    $p++; 
                                }
 
                            }
								
								
								poleToRus($pole_v);


                              $new_pole = $GLOBALS['RusPola'];

                             
                                echo '<table  class = "tableOtchetV">';echo "<tr>";
                             
                               
                                echo "<td bgcolor='paleturquoise'>Количество, где $new_pole[$schet_vpole] $znak_v[$schet_vpole] $text_v[$schet_vpole]</td><td>
								<b class = 'white'>".$counts."</b></td>";
                                
								
                                echo "</tr>";
                                
                                
								echo '</table>';
                    
								$naborV[] ='Количество '.$new_pole[$schet_vpole].' '.$znak_v[$schet_vpole].' '.$text_v[$schet_vpole].'';
								$poleV[] = $counts;$schet_vpole++;
								
								break;
         
        
					case 'ca' :  
					
					           $count = 0;
                               $counts = 0;
							   
							   $summa = 0;
							   $col = 0;
                                
                                for($i=0;$i<count($nabor);$i++){
                                   
                                    if ($nabor[$i]==$pole_v[$schet_vpole]){
                                        $count =$i;
                                    } 
                                }//(***)Возможность выбора двух одинаковых полей, процентные вычисления
								
                            	foreach ($result as $quer){
                            	   
                    		      $p = 0; 
                       
                                    foreach($quer as $it){
                                       
                                        if ($p==$count){
                                            
                                            $summa += $it;
                                            $col++;
                                                
                                          } 
                                          $p++; 
                                    }
                                        
                                
                                    
                                }
								
								$CA = $summa/$col; 

								poleToRus($pole_v);
								$new_pole = $GLOBALS['RusPola'];
                                echo '<table class = "tableOtchetV">';echo "<tr>";
                               
                             
                                echo "<td bgcolor='paleturquoise'>Среднее арифметическое $new_pole[$schet_vpole]</td><td><b class = 'white'>".sprintf("%.03f",$CA)."</b></td>";
                                echo "</tr>";
								
                               
                                echo '</table>';
                    
                                
								
								$naborV[] ='Количество '.$new_pole[$schet_vpole].'';
								$poleV[] = sprintf("%.03f",$CA);$schet_vpole++;
					
					
					break;
					default:$schet_vpole++; break;
                }
            }
			
        }
        ///Построение вычисляемых полей
    
	

	  
       $io=0;
	 for($i=0;$i<count($nabor);$i++){
	   
        if(!empty($nabor[$i]) AND $nabor[$i]!=''){
            
           $new_nabor[$io] = $nabor[$i];
           
           $io++; 
           
        }
    }
	
	
	$date = array();


	poleToRus($new_nabor);
	

    $_SESSION['nabor2'] = $GLOBALS['RusPola']; 
   
     
     
     $new_nabor = array_unique($GLOBALS['RusPola']);
     
		$ind = 0;
	  	foreach($new_nabor as $new_n){
		if ($new_n == 'Время начала курса' OR $new_n == 'Время конца курса' OR $new_n == 'Время начала лекц.' OR $new_n == 'Время конца лекц.'){
			$date[$ind] = 1;
		}
		$ind++;
	}
	
	 

	 

	 
	echo   '<div  id = pagination>';
	echo $page;	
echo   '</div>'; 
     
        echo '<br><table   class = "tableOtchet">';
        echo "<tr bgcolor='paleturquoise'>";
      

    
  
    
	foreach ($new_nabor as $key){
		echo "<th><b>".$key."</b></th>";
	} 
	
	echo "</tr>";
		foreach ($limitedResult as $quer){
			$index = 0;
          echo "<tr>";
            foreach($quer as $it){
			if (isset($date[$index])){$it = date('Y-m-d H:i:s', $it);}
                echo "<td>".$it."</td>";$index++;
            }

            echo "</tr>";
        }

        echo '</table><br>
		';


	
$_SESSION['naborV'] = $naborV;
$_SESSION['poleV'] = $poleV;
}


if ($withoutcontent == 1){?>

</div>
</div>


<div id = 'content'>


</body>
</html>
<?php
}
?>