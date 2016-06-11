<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<style>
	input {width:20px;}
	.label, .badge 
	{
		white-space: normal;
	}
	.pbreakalw
	{
		page-break-after: always;
	}
</style>
<script>
	var openquests = [];
	var openes = [0];
	var compl = 1;

	$( window ).load(function() {
		$('#preload').slideToggle("slow");
		$('#accordion').slideToggle("slow");
	    $('.collapse').collapse('hide');
	    google.load("visualization", "1", {packages:["corechart"],"callback":hello});
		function hello()
		{
			console.log("Всё готово")
			compl = 1
		}
	});

	//AJAX-подгрузка результатов анкетирования
	function func_open(nom,q_id,type,title,form_ou)
	{
		nom = parseInt(nom);
		console.log("ID: " + q_id + ", номер: "+nom+", тип: " + type + " > "+openquests);
		if ($('#collapse'+nom).css("display") == "none")	//Проверка открытия панели, в которую подгрузятся диаграммы
		{
			$('.collapse').collapse('hide'); 				//свернуть все панели
			
			if (openes.length>1)
			{
				$('#collapse'+openes[openes.length-1]).on('hidden.bs.collapse', function () {
	  			console.log("oK!"+openes[openes.length-1]);
	  			var destination = $('#title_div'+nom).offset().top - 80;
				console.log(destination);
				$("html,body").animate({scrollTop: destination}, "slow");	//Прокрутить до заголовка
				})		
			}
			
			$('#collapse'+nom).collapse('show');			//Развернуть панель, по которой был клик
			$("#preload_quest"+nom).animate({
        		marginLeft: "100%",
        		}, 4000 );
			openes.push(nom);

			if (openquests.indexOf(nom) < 0)				//Если статистика ещё не подгружалась, то обратиться к контроллеру и подгрузить диаграммы
			{
				if (type == 1 || type == 2)					//Если тип: выбор одного или выбор нескольких
				{
					$.post ('<?php echo base_url();?>forms/loadgraph',{q_id:q_id},function(data,status){
					if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
					else	
					{
						eval('var obj='+data);
						//console.log(obj);
						if (obj.answer==0)	
						{
							$("#preload_quest"+nom).html('Получить данные о вопросе не удалось');
						}
						else
						{
							openquests.push(nom);							//Добавить в массив вопросов, для которых подгружена статистика, текущий вопрос
							$("#preload_quest"+nom).slideToggle("slow");	//Скрыть прелоадер
							$("#table_div"+nom).slideToggle("fast");		//Скрыть таблицу, так как она не нужна
							obj.punkts.splice(0,0,'1');						//Добавить в начало массива вариантов ответов текст (требование Google Chart API)
							obj.proz.splice(0,0,'Параметры');				//Добавить в начало массива с результатами название оси X
							var all_itog_array = [
			  								obj.punkts,
			  								obj.proz
										];
							if (compl == 1)									//Если модуль визуализации от Google подгружен, то подгружать диаграммы
							{
								var data = google.visualization.arrayToDataTable(all_itog_array);
								
								var options = {
		  							title: title,
		  							legend: {position: 'top',textStyle: {fontSize: 12}},
		  							vAxis: {minValue: 0},
		  						};

		  						var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_a'+nom));
								chart.draw(data, options);
		  						//Если ОУ == 1, то показывать информацию по курсам
		  						if (form_ou == 1)
		  						{
		  							obj.kurs1.splice(0,0,'1 курс');
		  							obj.kurs2.splice(0,0,'2 курс');
		  							obj.kurs3.splice(0,0,'3 курс');
		  							obj.kurs4.splice(0,0,'4 курс');
		  							var kurs_itog_array = [
		  											obj.punkts,
		  											obj.kurs1,
		  											obj.kurs2,
		  											obj.kurs3,
		  											obj.kurs4
		  							]
		  							
									var data = google.visualization.arrayToDataTable(kurs_itog_array);

									var options = {
				  						title: title,
				  						legend: {position: 'top',textStyle: {fontSize: 12}},
				  						hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}},
				  						vAxis: {minValue: 0},
									};

									var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_b'+nom));
										chart.draw(data, options);
		  						}
								else
								{
									$("#chart_div_b"+nom).slideToggle("fast");
								}
								obj.other.forEach(function(entry) {
								var arr = ['default', 'primary', 'info', 'warning','danger','success'];
								var rand = Math.floor( Math.random() * arr.length );
								$("#other_div"+nom).append("<span class=\"label label-"+arr[rand]+"\" style=\"font-size:80%\">"+entry.answer+"</span> ");
								});
								
							}		//Конец проверки подгруженности модуля визуализации от Google
						}		//Конец проверки правильного ответа на AJAX-запрос
					}	//Конец проверки возможности соединения с сервером
					})
				}	//Конец проверки на 1 или 2 тип
				if (type == 3)		//Тип: ввод респондентом текста
				{
					$.post ('<?php echo base_url();?>forms/loadgraph',{q_id:q_id},function(data,status){
					if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
					else	
					{
						eval('var obj='+data);
						console.log(obj);
						if (obj.answer==0)	
						{
							$("#preload_quest"+nom).html('Получить данные о вопросе не удалось');
						}
						else
						{
							openquests.push(nom);							//Добавить в массив вопросов, для которых подгружена статистика, текущий вопрос
							$("#preload_quest"+nom).slideToggle("slow");	//Скрыть прелоадер
							$("#table_div"+nom).slideToggle("fast");		//Скрыть таблицу, так как она не нужна
							
							$("#chart_div_a"+nom).slideToggle("fast");
							$("#chart_div_b"+nom).slideToggle("fast");
							obj.other.forEach(function(entry) {
								var arr = ['default', 'primary', 'info', 'warning','danger','success'];
								var rand = Math.floor( Math.random() * arr.length );
								$("#other_div"+nom).append("<span class=\"label label-"+arr[rand]+"\" style=\"font-size:80%\">"+entry.answer+"</span> ");
							});
						}		//Конец проверки правильного ответа на AJAX-запрос
					}	//Конец проверки возможности соединения с сервером
					})
				}
				if (type == 4)		//Если тип: шкала
				{
					$.post ('<?php echo base_url();?>forms/loadgraph',{q_id:q_id},function(data,status){
					if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
					else	
					{
						eval('var obj='+data);
						console.log(obj);
						if (obj.answer==0)	
						{
							$("#preload_quest"+nom).html('Получить данные о вопросе не удалось');
						}
						else
						{
							openquests.push(nom);							//Добавить в массив вопросов, для которых подгружена статистика, текущий вопрос
							$("#preload_quest"+nom).slideToggle("slow");	//Скрыть прелоадер
							$("#table_div"+nom).slideToggle("fast");		//Скрыть таблицу, так как она не нужна
							//подготовить массив
							var i = 1;
							var all_itog_array = [];
							obj.punkts.forEach(function(entry) {
								all_itog_array.push([entry,obj.proz[i]]);
								i++;
							});
							all_itog_array.splice(0,0,['Ответ','Все курсы']);	
							if (compl == 1)									//Если модуль визуализации от Google подгружен, то подгружать диаграммы
							{
								var data = google.visualization.arrayToDataTable(all_itog_array);

								var options = {
  									title: title,
  									legend: {position: 'top',textStyle: {fontSize: 12}},
  									curveType: 'function',
  									lineWidth:'4',
  									hAxis: {title: 'Параметр', titleTextStyle: {color: 'red'}},
  									vAxis: {title: '%',titleTextStyle: {color: 'red'},minValue: 0},
									};

								var chart = new google.visualization.LineChart(document.getElementById('chart_div_a'+nom));
								chart.draw(data, options);
			 					//Если ОУ == 1, то показывать информацию по курсам
		  						if (form_ou == 1)
		  						{
		  							var i = 1;
									var kurs_itog_array = [];
									obj.punkts.forEach(function(entry) {
										kurs_itog_array.push([entry,obj.kurs1[i],obj.kurs2[i],obj.kurs3[i],obj.kurs4[i]]);
										i++;
									});
									kurs_itog_array.splice(0,0,['Ответ','1 курс','2 курс','3 курс','4 курс']);
		  							var data = google.visualization.arrayToDataTable(kurs_itog_array);

									var options = {
	  									title: title,
	  									legend: {position: 'top',textStyle: {fontSize: 12}},
	  									curveType: 'function',
	  									lineWidth:'4',
	  									hAxis: {title: 'Параметр', titleTextStyle: {color: 'red'}},
	  									vAxis: {title: '%',titleTextStyle: {color: 'red'},minValue: 0},
										};

									var chart = new google.visualization.LineChart(document.getElementById('chart_div_b'+nom));
									chart.draw(data, options);
		  						}
								else
								{
									$("#chart_div_b"+nom).slideToggle("fast");
								}
								$("#other_div"+nom).slideToggle("fast");
							}		//Конец проверки подгруженности модуля визуализации от Google
						}		//Конец проверки правильного ответа на AJAX-запрос
					}	//Конец проверки возможности соединения с сервером
					})
				}	//Конец проверки на 4 тип
				if (type == 5)		//Если тип: сетка с радио-кнопками
				{
					$.post ('<?php echo base_url();?>forms/loadgraph',{q_id:q_id},function(data,status){
					if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
					else	
					{
						eval('var obj='+data);
						console.log(obj);
						if (obj.answer==0)	
						{
							$("#preload_quest"+nom).html('Получить данные о вопросе не удалось');
						}
						else
						{
							openquests.push(nom);							//Добавить в массив вопросов, для которых подгружена статистика, текущий вопрос
							$("#preload_quest"+nom).slideToggle("slow");	//Скрыть прелоадер
							$("#other_div"+nom).slideToggle("fast");
							$("#chart_div_a"+nom).slideToggle("fast");		
							$("#chart_div_b"+nom).slideToggle("fast");
							
							table_str = '<table class="sortable" style="font-size:11px;width=100%"><thead><tr><td>Параметр</td>';
							obj.columns.forEach(function(entry) {
								table_str += '<td>'+entry+'</td>';
							});
							table_str += '</tr></thead>';

							var i = 0;
							obj.punkts.forEach(function(entry) {
								table_str += '<tr><td>'+entry+'</td>';
								obj.proz[i].forEach(function(entry2) {
									table_str += '<td>'+entry2+'</td>';
								});
								table_str += '</tr>';
								i++;
							});

							table_str += '</table>';
							$("#table_div"+nom).html(table_str);

						}		//Конец проверки правильного ответа на AJAX-запрос
					}	//Конец проверки возможности соединения с сервером
					})
				}	//Конец проверки на 5 тип
				if (type == 7)		//Если тип: сетка с радио-кнопками
				{
					$.post ('<?php echo base_url();?>forms/loadgraph',{q_id:q_id},function(data,status){
					if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
					else	
					{
						eval('var obj='+data);
						console.log(obj);
						if (obj.answer==0)	
						{
							$("#preload_quest"+nom).html('Получить данные о вопросе не удалось');
						}
						else
						{
							openquests.push(nom);							//Добавить в массив вопросов, для которых подгружена статистика, текущий вопрос
							$("#preload_quest"+nom).slideToggle("slow");	//Скрыть прелоадер
							$("#other_div"+nom).slideToggle("fast");
							
							table_str = '<table class="sortable" style="font-size:11px;width=100%"><thead><tr><td>Параметр</td>';
							obj.columns.forEach(function(entry) {
								table_str += '<td>'+entry+'</td>';
							});
							table_str += '<td>AVG</td></tr></thead>';

							var i = 0;
							obj.punkts.forEach(function(entry) {
								table_str += '<tr><td>'+entry+'</td>';
								obj.proz[i].forEach(function(entry2) {
									table_str += '<td>'+entry2+'</td>';
								});
								table_str += '</tr>';
								i++;
							});

							table_str += '</table>';
							$("#table_div"+nom).html(table_str);

							obj.punkts.splice(0,0,'1');						//Добавить в начало массива вариантов ответов текст (требование Google Chart API)
							temp_array = ['Параметры'];
							obj.proz.forEach(function(entry)
							{
								temp_array.push(entry[entry.length-1])
							});

							var all_itog_array = [
			  								obj.punkts,
			  								temp_array
										];

							if (compl == 1)									//Если модуль визуализации от Google подгружен, то подгружать диаграммы
							{
								var data = google.visualization.arrayToDataTable(all_itog_array);
								
								var options = {
		  							title: title,
		  							legend: {position: 'top',textStyle: {fontSize: 12}},
		  							vAxis: {minValue: 0},
		  						};

		  						var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_a'+nom));
								chart.draw(data, options);
		  						//Если ОУ == 1, то показывать информацию по курсам
		  						if (form_ou == 1)
		  						{
		  							obj.kurs1.splice(0,0,'1 курс');
		  							obj.kurs2.splice(0,0,'2 курс');
		  							obj.kurs3.splice(0,0,'3 курс');
		  							obj.kurs4.splice(0,0,'4 курс');
		  							var kurs_itog_array = [
		  											obj.punkts,
		  											obj.kurs1,
		  											obj.kurs2,
		  											obj.kurs3,
		  											obj.kurs4
		  							]
		  							
									var data = google.visualization.arrayToDataTable(kurs_itog_array);

									var options = {
				  						title: title,
				  						legend: {position: 'top',textStyle: {fontSize: 12}},
				  						hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}},
				  						vAxis: {minValue: 0},
									};

									var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_b'+nom));
										chart.draw(data, options);
		  						}
								else
								{
									$("#chart_div_b"+nom).slideToggle("fast");
								}
							}
						}		//Конец проверки правильного ответа на AJAX-запрос
					}	//Конец проверки возможности соединения с сервером
					})
				}	//Конец проверки на 7 тип
			}	//Конец проверки на вторичную попытку подгрузки диаграмм

			
		}	//Конец проверки открытости панели, в которую подгружаются диаграммы
		else
		{
			$('.collapse').collapse('hide');
		}
	}



	/*
	$("#accordion").on("shown.bs.collapse", function () {
			    var selected = $(this);
			    var collapseh = $(".collapse.in").height();
			    $.scrollTo(selected, 500, {
			        offset: -(collapseh)
			    });
			});
	*/
</script>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>forms">Опросы</a></li>
		<li class="active">Результаты опроса "<?= $form_name ?>". Тип доступа к результатам: <?= ($form_access == 1 ? "Публичный" : "Анонимный") ?></li>
	</ul>
	
	<div id="preload">
		<center>
			<br />
			<h1>Пожалуйста, подождите...</h1>
			<img src="<?= base_url() ?>images/preload.gif" style="margin:10 auto;margin-bottom:20px;">
			<br>
			Происходит обработка данных. Процесс может занять некоторое время.
			<br /><br />
		</center>
	</div>

	<div class="panel-group" id="accordion" style="display:none;">
	<?php
	$i=0;
	$n_id=0;
	$chislo_vopr = count($form_quests);
	foreach($form_quests as $key) 
	{
		$nom=$i+1;
		?>
		<div class="panel panel-default">
		    <div class="panel-heading">
      			<h4 class="panel-title" onClick="func_open(<?= $i ?>,<?= $key['id'] ?>,<?= $key['type'] ?>,'<?= $key['title'] ?>',<?= $form_ou ?>)" style="cursor:pointer;" id="title_div<?= $i ?>">
        			<?= $key['title'] ?> <small>Вопрос №<?= $nom ?> из <?= $chislo_vopr ?></small>
      			</h4>
    		</div>
    		<div id="collapse<?= $i ?>" class="panel-collapse collapse in">
      			<div class="panel-body">
					<i><?= $key['subtitle'] ?> <b><?= ($key['required'] == 1 ? "Вопрос являлся обязательным" : "") ?></b></i>
					<br />
					<br />
					<div id="preload_quest<?= $i ?>" style="width: 10px;">
						<img src="<?= base_url() ?>images/ajax-loader.gif" />
					</div>
					<div id="table_div<?= $i ?>" style="width: 100%;"></div>
					<div id="chart_div_a<?= $i ?>" style="width: 100%; height: 500px;margin:10 auto;"></div>
					<div id="chart_div_b<?= $i ?>" style="width: 100%; height: 500px;margin:10 auto;"></div>
					<div id="other_div<?= $i ?>" style="width: 100%;"></div>
				</div>
    		</div>
    	</div>
  		<?php
  		$i++;
	}
?>
</div>
<div id="vk_comments" style="margin:20px auto;"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 30, width: "700", attach: "graffiti,photo,link"});
</script>
</div>

<?php require_once(APPPATH.'views/require_header.php');?>