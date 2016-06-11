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
          			['Тема', 'Результат'],
          			<?php
					foreach ($results as $key)
					{
						$res_id=$key['id_theme'];
						$abs = ceil($tests_results[$res_id]['abs']);
						echo "['".$key['name_th']."', $abs],";
					}
					?>
          			]);

        		var options = {
        		  title: 'Статистика по темам',
        		  legend: {position: 'none'},
        		  vAxis: {maxValue: 100,minValue: 0}
        		};

        		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        		chart.draw(data, options);
      		}
      	</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			table 	{font-size:10px;}
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>stat/view_tests/<?php echo $disc_id;?>" method="post" name="nazad"></form>
		<form action="<?php echo base_url();?>main/auth" method="post" name="menuForm"></form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>stat">Статистика по дисциплинам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>stat/view_tests/<?php echo $disc_id;?>"><?php echo $disc_name;?></a> <span class="divider">/</span></li>
  				<li class="active">Темы теста "<?php echo $test_name;?>"</li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Успешность, %</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					$res_id=$key['id_theme'];
					echo "<tr>
					<td>".$key['name_th']."</td>
					<td>".$tests_results[$res_id]['count']."</td>";
					$abs=$tests_results[$res_id]['abs'];
					if ($abs<50)
					{
						echo "<td bgcolor=\"red\"><font color=white>$abs</font></td>";
					}
					else
					{
						echo "<td>$abs</td>";
					}
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<center>
				<div id="chart_div" style="width:100%;height:600;margin:15px 0 15px 0;"></div>
			</center>
		</div>
	</body>
</html>