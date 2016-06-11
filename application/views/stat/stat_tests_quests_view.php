<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
   		<script type="text/javascript">
      		google.load("visualization", "1", {packages:["corechart"]});
      		google.setOnLoadCallback(drawChart);
      
      		function drawChart() 
      		{
        		var data = google.visualization.arrayToDataTable([
          		['Результат', 'Количество'],
          		<?php
 				for ($i=0;$i<10;$i++)
 				{
 					$temp=$raspr[$i];
 					$name = $i*10;
 					echo "[$name,$temp]";
 					if ($i!=9)
 					{
 						echo ",";
 					}
 				}
 				?>
        		]);

        		var options = {
          		title: 'Распределение результатов',
          		curveType: 'none',
          		width: 900,
          		height: 500,
          		hAxis: {title: 'Результат',  titleTextStyle: {color: 'red'},minValue: 0},
          		vAxis: {title: 'Количество',  titleTextStyle: {color: 'red'}, minValue: 0},
          		legend: {position: 'none'}
        		};

        		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        		chart.draw(data, options);
      }
    </script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.jqplot.min.css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>stat">Статистика по дисциплинам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>stat/view_tests/<?php echo $disc_id;?>"><?php echo $disc_name;?></a> <span class="divider">/</span></li>
  				<li class="active">Статистика по вопросам теста "<?php echo $test_name;?>"</li>
			</ul>
			<p>Стандартное отклонение вопроса говорит о степени разнообразия ответов на вопрос. Корреляция с общим результатом
			 показывает, какую роль, по статистике, вопрос играет в результате</p>
			 <p>Количество заданий, <b>не</b>удовлетворяющих индексу дискриминативности: <b><?php echo $bad_quests['discr'];?></b> из <b><?php echo count($zadanie);?></b></p>
			 <p>Количество заданий, <b>не</b>удовлетворяющих условию корелляции результата задания с общим результатом: <b><?php echo $bad_quests['korel'];?></b> из <b><?php echo count($zadanie);?></b></p>
			 <p>Количество забракованных заданий: <b><?php echo $bad_quests['edit'];?></b> из <b><?php echo count($zadanie);?></b></p>
			 <p>Коэффициент качества теста: <b><?php echo $valid_coeff;?></b> баллов из 200 возможных. Чем ближе этот коэффициент к нулю, тем лучше.</p>
			<table class="sortable" border="1" id="groups" style="font-size:11px;">
				<thead>
					<tr>
						<td align="center"><b>ID</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Успешность<br />выполнения</b></td>
						<td align="center"><b>Стандартное<br />отклонение</b></td>
						<td align="center"><b>Корелляция с общим результатом</b></td>
						<td align="center"><b>Индекс дискриминативности</b></td>
						<td align="center"><b>Сложность</b></td>
						<td align="center"><b>Время, сек</b></td>
						<td align="center"><b>Недовольство</b></td>
					</tr>
				</thead>
				<tbody>	
					<?php
					$summ = 0;
					foreach ($zadanie as $key)
					{
						echo "<tr>";
						$id=$key['id'];
						echo "<td>$id</td>";
						$text=$key['text'];
						echo "<td>$text</td>";
						$balls=round($key['balls']*100,2);
						if ($balls>90 || $balls<10)
						{
							echo "<td bgcolor=#db7093>$balls</td>";
						}
						else
						{
							echo "<td>$balls</td>";	
						}
						$otkl=round($key['otkl']*100,2);
						echo "<td>$otkl</td>";
						$kor=round($key['korel'],2);
						if ($kor<0.15)
						{
							echo "<td bgcolor=#db7093>$kor</td>";	
						}
						else
						{
							echo "<td>$kor</td>";		
						}
						$discr=round($key['discr'],2);
						if ($discr<0.3)
						{
							echo "<td bgcolor=#db7093>$discr</td>";	
						}
						else
						{
							echo "<td>$discr</td>";		
						}
						$diff=round($key['diff'],2);
						echo "<td>$diff</td>";
						if ($key['avg_time'] != 0)
						{
							$summ += $key['avg_time'];
							echo "<td>".$key['avg_time']."</td>";
						}
						else
						{
							echo "<td><i class=\"icon-time\"></i></td>";
						}
						echo "<td>".$key['incorr_stud']."</td>";
						echo "</tr>";
					}
					$summ = round($summ/60,1);
					?>
				</tbody>
			</table>
			Суммарное идеальное время: <?php echo $summ;?> минут
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
			<table class="sortable" border="1" id="groups2" style="font-size:10px;">
				<thead>
					<tr><td>&nbsp;</td>
					<?php
					foreach ($quests as $key)
					{
						$id=$key['id'];
						echo "<td>$id</td>";
					}
					?>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($quests as $key)
					{
						echo "<tr>";
						$id=$key['id'];
						echo "<td><b>$id</b></td>";	
						foreach ($quests as $key2)
						{
							if ($key['id']==$key2['id'])
							{
								echo "<td bgcolor=black>&nbsp;</td>";
							}
							else
							{
								$temp=round($korel[$key['id']][$key2['id']],2);
								if ($temp<0)
								{
									echo "<td bgcolor=#db7093>$temp</td>";	
								}
								else
								{
									echo "<td>$temp</td>";	
								}
							}
						}
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
			<center>
				<div id="chart_div" style="width:900;height:500;margin:15px auto;"></div>
			</center>
		</div>
	</body>
</html>