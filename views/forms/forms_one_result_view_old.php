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
	$( window ).load(function() {
		$('#preload').slideToggle("slow");
		$('#accordion').slideToggle("slow");
	    $('.collapse').collapse('hide');
	});

	function func_open(nom,q_id)
	{
		console.log(nom);
		$('.collapse').collapse('hide');
		$('#collapse'+nom).collapse('show');
		$.post ('<?php echo base_url();?>forms/loadgraph',{q_id:q_id},function(data,status){
		if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
		else	
		{
			eval('var obj='+data);	
			if (obj.answer==0)	
			{
				$("#preload_quest"+nom).html('Получить данные о вопросе не удалось');
			}
			else
			{
				$("#preload_quest"+nom).slideToggle("fast");
			}
		}
		})
	}
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
      			<h4 class="panel-title" onClick="func_open(<?= $i ?>,<?= $key['id'] ?>)" style="cursor:pointer;">
        			<?= $key['title'] ?> <small>Вопрос №<?= $nom ?> из <?= $chislo_vopr ?></small>
      			</h4>
    		</div>
    		<div id="collapse<?= $i ?>" class="panel-collapse collapse in">
      			<div class="panel-body">
					
					<i><?= $key['subtitle'] ?><b><?= ($key['required'] == 1 ? "Вопрос является обязательным" : "") ?></b></i>
					<br />
					<br />
					<div id="preload_quest<?= $i ?>" style="margin:10 auto; width: 10px;">
						<img src="<?= base_url() ?>images/ajax-loader.gif" />
					</div>
					<?php
					/*
					$id_q=$key['id'];
					$type=$key['type'];
					$str="";
					$str_arr = array();
					$stroka="";
					if ($type<3)
					{
						$arr_elem = explode(", ",$key['option1']);
						//Строка хранит названия пунктов
						$str_punkts = "";
						//Строка хранит все результаты
						$str_res_all = "";
						if ($form_ou == 1)
						{
							//массив из четырёх строк с результатами по курсам
							$str_course = array();
							//обнуление строк
							for ($j=1;$j<5;$j++)
							{
								$str_course[$j] = "";
								$summ[$j] = 0;
							}
						}
						if ($type == 2)
						{
							for($k=0;$k<count($arr_elem);$k++)
							{
								$str_punkts = $str_punkts."'".$arr_elem[$k]."',";
								$str_res_all = $str_res_all.$quest_options1[$key['id']]['proz'][$k].",";
								if ($form_ou == 1)
								{
									for ($j=1;$j<5;$j++)
									{
										$summ[$j] += $quest_options1[$key['id']]['answers_kurs'][$j][$k];
										$str_course[$j] = $str_course[$j].$quest_options1[$key['id']]['proz_kurs'][$k][$j].",";
									}
								}
							}
						}
						else
						{
							for($k=0;$k<count($arr_elem);$k++)
							{
								if ($quest_options1[$key['id']]['proz'][$k] == '') {$quest_options1[$key['id']]['proz'][$k] = 0;}
								$str_res_all = $str_res_all."['".$arr_elem[$k]."',".$quest_options1[$key['id']]['proz'][$k]."],";
								$str_punkts = $str_punkts."'".$arr_elem[$k]."',";
								if ($form_ou == 1)
								{
									for ($j=1;$j<5;$j++)
									{
										$summ[$j] += $quest_options1[$key['id']]['answers_kurs'][$j][$k];
										$str_course[$j] = $str_course[$j].$quest_options1[$key['id']]['proz_kurs'][$k][$j].",";
									}
								}
							}
						}
			$str_punkts = substr($str_punkts,0,-1);
			$str_res_all = substr($str_res_all, 0,-1);
			if ($form_ou == 1)
			{
				for ($j=1;$j<5;$j++)
				{
					$str_course[$j] = substr($str_course[$j],0,-1);
				}
			}
			if ($type == 2)
			{
				?>
				<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChart<?php echo "a".$i;?>);
						function drawChart<?php echo "a".$i;?>() {
						var data = google.visualization.arrayToDataTable([
  						['Курс', <?php echo $str_punkts;?>],
  						['Все',  <?php echo $str_res_all;?>]
						]);

						var options = {
  						title: <?php echo "'".$key['title']."'";?>,
  						legend: {position: 'top',textStyle: {fontSize: 12}},
  						//hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}}
						};

						var chart = new google.visualization.ColumnChart(document.getElementById('chart_diva'+<?php echo $i;?>));
						chart.draw(data, options);
				 		}
				</script>
				<div id="chart_diva<?php echo $i;?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
				<?php
				if ($key['option3'] > 0)
				{
					$balls_punkts = "";
					for($k=0;$k<count($arr_elem);$k++)
					{
						$balls_punkts = $balls_punkts.$quest_options1[$key['id']]['ball_answers'][$k].",";
					}
					$balls_punkts = substr($balls_punkts,0,-1);
					?>
					<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawCharta2<?= $i ?>);
							function drawCharta2<?= $i ?>() {
							var data = google.visualization.arrayToDataTable([
	  						['Курс', <?= $str_punkts ?>],
	  						['Все',  <?= $balls_punkts ?>]
							]);

							var options = {
	  						title: <?php echo "'".$key['title'].". По мощности ответа.'";?>,
	  						legend: {position: 'top',textStyle: {fontSize: 12}},
	  						//hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}}
							};

							var chart = new google.visualization.ColumnChart(document.getElementById('chart_diva2'+<?= $i ?>));
							chart.draw(data, options);
					 		}
					</script>
					<div id="chart_diva2<?= $i ?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
					<?php
				}
			}
			else
			{
				?>
				<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChart<?php echo "a".$i;?>);
						function drawChart<?php echo "a".$i;?>() {
						var data = google.visualization.arrayToDataTable([
  						['Курс', 'Значение'],
  						<?php echo $str_res_all;?>
						]);

						var options = {
  						title: <?php echo "'".$key['title']."'";?>,
  						pieHole: 0.2,
  						hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}}
						};

						var chart = new google.visualization.PieChart(document.getElementById('chart_diva'+<?php echo $i;?>));
						chart.draw(data, options);
				 		}
				</script>
				<div id="chart_diva<?php echo $i;?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
				<?php

			}
			if ($form_ou == 1)
			{
				?>
				<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChart<?php echo "b".$i;?>);
						function drawChart<?php echo "b".$i;?>() {
						var data = google.visualization.arrayToDataTable([
  						['Курс', <?php echo $str_punkts;?>],
  						[<?php echo "'1 курс (".$summ[1].")'";?>,  <?php echo $str_course[1];?>],
  						[<?php echo "'2 курс (".$summ[2].")'";?>,  <?php echo $str_course[2];?>],
  						[<?php echo "'3 курс (".$summ[3].")'";?>,  <?php echo $str_course[3];?>],
  						[<?php echo "'4 курс (".$summ[4].")'";?>,  <?php echo $str_course[4];?>]
					]);

						var options = {
  						title: <?php echo "'".$key['title']."'";?>,
  						legend: {position: 'top',textStyle: {fontSize: 12}},
  						hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}}
						};

						var chart = new google.visualization.ColumnChart(document.getElementById('chart_divb'+<?php echo $i;?>));
						chart.draw(data, options);
			 			}
				</script>
				<div id="chart_divb<?php echo $i;?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
				<?php
			}
			if ($form_access == 0)
			{
				if (isset($quest_options1[$key['id']]['other_answers']))
				{
					foreach ($quest_options1[$key['id']]['other_answers'] as $key2)
					{
						$stroka = $stroka."<span class=\"label label-inverse\">".$key2."</span>, ";
					}
					$stroka = substr($stroka, 0, -2);
				}
			}
			else
			{
				$ig=0;
				foreach ($quest_options1[$key['id']]['other_answers'] as $key2)
				{
					$str_arr[$ig]['answer'] = $key2;
					$ig++;
				}
				$ig=0;
				foreach ($quest_options1[$key['id']]['other_user'] as $key2)
				{
					$str_arr[$ig]['person'] = $key2;
					$ig++;
				}
				for ($ig=0;$ig<count($str_arr);$ig++)
				{
					$stroka=$stroka.$str_arr[$ig]['answer']." (".$str_arr[$ig]['person']."), ";
				}
				$stroka=substr($stroka, 0, -2);
			}
			if ($stroka != "")
			{
				echo "Cвой вариант: $stroka";
			}
		}
		if ($type == 3)
		{
			?>
			<table class="sortable" id="groups" style="font-size:11px;width=100%">
				<tr>
					<td>Ответ</td>
					<?php
		if ($form_access == 1)
		{
			echo "<td align=center width=30%>Пользователь</td>";
		}
		echo "</tr>";
		if ($form_access == 0)
		{
			foreach ($quest_options1[$key['id']]['answers'] as $key2)
			{
				echo "<tr><td align=center>$key2</td></tr>";
			}
		}
		else
		{
			$ig=0;
			foreach ($quest_options1[$key['id']]['answers'] as $key2)
			{
				$str[$ig]['answer'] = $key2;
				$ig++;
			}
			$ig=0;
			foreach ($quest_options1[$key['id']]['users'] as $key2)
			{
				$str[$ig]['person'] = $key2;
				$ig++;
			}
			for ($ig=0;$ig<count($str);$ig++)
			{
				echo "<tr><td align=center>".$str[$ig]['answer']."</td><td align=center>".$str[$ig]['person']."</td></tr>";
			}
		}
		echo "</table>";
	}
	if ($type==4)
	{
		//Строка хранит названия пунктов
		$str_punkts = "";
		if ($form_ou == 1)
		{
			//массив из четырёх строк с результатами по курсам
			$str_course_line = "";
		}
		for($k=1;$k<=$key['option3'];$k++)
		{
			$param=$k;
			if ($k==1) {$param=$key['option1'];}
			if ($k==$key['option3']) {$param=$key['option2'];}
			if ($quest_options1[$key['id']]['proz'][$k] == '') {$quest_options1[$key['id']]['proz'][$k] = 0;}
			$str_punkts = $str_punkts."['".$param."',".$quest_options1[$key['id']]['proz'][$k]."],";
			if ($form_ou == 1)
			{
				$str_course_line = $str_course_line."['".$param."',";
				for ($j=1;$j<5;$j++)
				{
					if ($quest_options1[$key['id']]['proz_kurs'][$k][$j] == '') {$quest_options1[$key['id']]['proz_kurs'][$k][$j] = 0;}
					$str_course_line = $str_course_line.ceil($quest_options1[$key['id']]['proz_kurs'][$k][$j]).",";
				}
				$str_course_line = substr($str_course_line,0,-1);
				$str_course_line = $str_course_line."],";
			}
		}
		$str_punkts = substr($str_punkts,0,-1);
		if ($form_ou == 1)
		{
			$str_course_line = substr($str_course_line,0,-1);
		}
		?>
		<script type="text/javascript">
				google.load("visualization", "1", {packages:["corechart"]});
				google.setOnLoadCallback(drawChart<?php echo "c".$i;?>);
				function drawChart<?php echo "c".$i;?>() {
				var data = google.visualization.arrayToDataTable([
  				['Параметр', 'Значение'],
  				<?php echo $str_punkts;?>
				]);

					var options = {
  					title: <?php echo "'".$key['title']."'";?>,
  					legend: {position: 'top',textStyle: {fontSize: 12}},
  					curveType: 'function',
  					lineWidth:'4',
  					hAxis: {title: 'Параметр', titleTextStyle: {color: 'red'}}
					};

					var chart = new google.visualization.LineChart(document.getElementById('chart_divc'+<?php echo $i;?>));
					chart.draw(data, options);
			 		}
			</script>
			<?php
			if ($form_ou == 1)
			{
				?>
				<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChart<?php echo "d".$i;?>);
						function drawChart<?php echo "d".$i;?>() {
						var data = google.visualization.arrayToDataTable([
  						['Параметр', '1 курс', '2 курс', '3 курс', '4 курс'],
  						<?php echo $str_course_line;?>
					]);

						var options = {
  						title: <?php echo "'".$key['title']."'";?>,
  						legend: {position: 'top',textStyle: {fontSize: 14}},
  						curveType: 'function',
  						hAxis: {title: 'Параметр', titleTextStyle: {color: 'red'}}
						};

						var chart = new google.visualization.LineChart(document.getElementById('chart_divd'+<?php echo $i;?>));
						chart.draw(data, options);
			 			}
				</script>
				<?php
			}
			?>
			<div id="chart_divc<?php echo $i;?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
			<?php
			if ($form_ou == 1)
			{
				?>
				<div id="chart_divd<?php echo $i;?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
				<?php
			}
		}
		if ($type==5)
		{
			$arr_elem_str = explode(", ",$key['option1']);
			$arr_elem_stlb = explode(", ",$key['option2']);
			echo "<table class=\"sortable\" id=\"groups\" style=\"font-size:11px;width=100%\"><tr><td>&nbsp;</td>";
			for ($k=0;$k<count($arr_elem_stlb);$k++)
			{
				if ($form_access == 1)
				{
					echo "<td colspan=2>".$arr_elem_stlb[$k]."</td>";
				}
				else
				{
					echo "<td>".$arr_elem_stlb[$k]."</td>";
				}
			}
			echo "</tr>";
			for ($k=0;$k<count($arr_elem_str);$k++)
			{
				echo "<tr><td>".$arr_elem_str[$k]."</td>";
				if ($form_access == 1)
				{
					for ($j=0;$j<count($arr_elem_stlb);$j++)
					{
						echo "<td>".$quest_options1[$key['id']]['proz_stlb'][$k][$j]."%</td><td>".$quest_options1[$key['id']]['users_setka'][$k][$j]."</td>";
					}
				}
				else
				{
					for ($j=0;$j<count($arr_elem_stlb);$j++)
					{
						echo "<td>".$quest_options1[$key['id']]['proz_stlb'][$k][$j]."%</td>";
					}
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		//Сетка с селекторами
		if ($type == 7)
		{
			$arr_elem_str = explode(", ",$key['option1']);
			$arr_elem_stlb = explode(", ",$key['option2']);
			?>
			<table class="sortable" id="groups" style="font-size:11px;width=100%">
				<tr>
					<td>Параметр</td>
					<?php
					for ($k = 0; $k < count($arr_elem_stlb); $k++)
					{
						?>
						<td><?= $arr_elem_stlb[$k] ?></td>
						<?php
					}
					?>
					<td>AVG</td>
				</tr>
			<?php
			$str_punkts = "";
			$str_res_all = "";
			$str_course = array();
			for ($j = 1;$j < 5;$j++)
			{
				$str_course[$j] = "";
			}
			for ($k = 0;$k < count($arr_elem_str);$k++)
			{
				?>
				<tr>
					<td><?= $arr_elem_str[$k] ?></td>
					<?php
					//Наращиваем строку с пунктами
					$str_punkts = $str_punkts."'".$arr_elem_str[$k]."',";
					for ($j = 0;$j < count($arr_elem_stlb);$j++)
					{
						?>
						<td><?= $quest_options1[$key['id']]['cell_avg'][$k][$j] ?></td>
						<?php
					}
					?>
					<td><?= $quest_options1[$key['id']]['avg_str'][$k] ?></td>
				</tr>	
				<?php
				$str_res_all = $str_res_all.$quest_options1[$key['id']]['avg_str'][$k].",";
				if ($form_ou == 1)
				{
					for ($j = 1;$j < 5;$j++)
					{
						$str_course[$j] = $str_course[$j].round($quest_options1[$key['id']]['row_avg_kurs'][$k][$j],2).",";
					}
				}
			}
			for ($j = 1;$j < 5;$j++)
			{
				$str_course[$j] = substr($str_course[$j],0,-1);
			}
			$str_punkts = substr($str_punkts,0,-1);
			$str_res_all = substr($str_res_all, 0,-1);
			?>
			</table>
			
			<script type="text/javascript">
					google.load("visualization", "1", {packages:["corechart"]});
					google.setOnLoadCallback(drawCharta<?= $i ?>);
					function drawCharta<?= $i ?>() 
					{
					var data = google.visualization.arrayToDataTable([
  						['Параметр', <?= $str_punkts ?>],
  						['Все',  <?= $str_res_all ?>]
						]);

						var options = {
  						title: <?= "'".$key['title']."'" ?>,
  						legend: {position: 'top',textStyle: {fontSize: 12}},
  						hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}}
						};

						var chart = new google.visualization.ColumnChart(document.getElementById('chart_diva'+<?= $i ?>));
						chart.draw(data, options);
				 	}
				</script>
				<div id="chart_diva<?= $i ?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
			<?php
			if ($form_ou == 1)
			{
				?>
				<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChartb<?= $i ?>);
						function drawChartb<?= $i ?>() {
						var data = google.visualization.arrayToDataTable([
  						['Курс', <?= $str_punkts ?>],
  						['1 курс',  <?= $str_course[1] ?>],
  						['2 курс',  <?= $str_course[2] ?>],
  						['3 курс',  <?= $str_course[3] ?>],
  						['4 курс',  <?= $str_course[4] ?>]
					]);

						var options = {
  						title: <?php echo "'".$key['title']."'";?>,
  						legend: {position: 'top',textStyle: {fontSize: 12}},
  						hAxis: {title: 'Курсы', titleTextStyle: {color: 'red'}}
						};

						var chart = new google.visualization.ColumnChart(document.getElementById('chart_divb'+<?= $i ?>));
						chart.draw(data, options);
			 			}
				</script>
				<div id="chart_divb<?= $i ?>" style="width: 100%; height: 500px;margin:0 auto;"></div>
					<?php
					}
				}
				//Конец обработки сетки с селекторами
				*/
				$i++;
				?>
				</div>
    		</div>
    	</div>
  		<?php
	}
?>
</div>
<div id="vk_comments" style="margin:20px auto;"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 30, width: "700", attach: "graffiti,photo,link"});
</script>
</div>

<?php require_once(APPPATH.'views/require_header.php');?>