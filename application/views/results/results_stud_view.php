<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.nazad.submit();}
			function func_home()	{document.home.submit();}

			function func_del()
			{
				if (confirm("Вы уверены, что хотите аннулировать результат?")) 
				{
					document.delForm.submit();	
				}
			}
		</script>
		 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	<script type="text/javascript">
      		google.load("visualization", "1", {packages:["corechart"]});
     		google.setOnLoadCallback(drawChart);
      		
      		function drawChart() 
      		{
        		var data = google.visualization.arrayToDataTable([
          		['Сложность', 'Верных ответов','Всего заданий'],
          		<?php
 				for ($i = 1;$i <= 4; $i++)
 				{
 					echo "['$i',".ceil($raspr['sdano'][$i]).", ".$raspr['vsego'][$i]."]";
 					if ($i!=4)
 					{
 						echo ",";
 					}
 				}
 				?>
		        ]);

       			var options = {
          			width: 700,
          			height: 500,
          			hAxis: {title: 'Сложность',  titleTextStyle: {color: 'red'}},
          			vAxis: {title: 'Верных ответов',  titleTextStyle: {color: 'red'}, minValue: 0},
          			legend: {position: 'top'}
        		};

        		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
       			chart.draw(data, options);
     		}
    	</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<form action="<?php echo base_url();?>results/annul_test_result/<?php echo $res_id."/".$test_id."/".$disc_id;?>" method="post" name="delForm">
			<input type=hidden name="test_name" value="<?php echo $test_name;?>">
		</form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results">Дисциплины</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/view_tests/<?php echo $disc_id;?>"><?php echo $disc_name;?></a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/view_test_results/<?php echo $test_id."/".$disc_id;?>"><?php echo $test_name;?></a> <span class="divider">/</span></li>
  				<li class="active"><?php echo $stud_name;?></li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Тема</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center" colspan="2"><b>Время (студент/avg)</b></td>
						<td align="center"><b>Вес</b></td>
						<td align="center"><b>Правильность</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					echo "<tr>";
					echo "<td>".$key['name_th']."</td>";
					echo "<td>".$key['text']."</td>";
					if ($key['level'] != 0)
					{
						if ($key['time'] > 0)
						{
							echo "<td>".$key['time']."</td>";
						}
						else
						{
							echo "<td><i class=\"icon-time\"></i></td>";
						}
						if ($key['avg_time'] > 0)
						{
							echo "<td>".$key['avg_time']."</td>";
						}
						else
						{
							echo "<td><i class=\"icon-time\"></i></td>";
						}
						echo "<td>".$key['level']."</td>";
						switch ($key['true']) 
						{
    						case 0:		echo "<td bgcolor=#db7093>Нет</td>";	break;
    						case 1:		echo "<td bgcolor=#0bda51>Да</td>";		break;
       				        default:	echo "<td>".$key['true']."</td>";      break;
						}
					}
					else
					{
						echo "<td align=center colspan=4>Некорректный вопрос</td>";
					}
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<div id="chart_div" style="width:700;height:500;margin:0px auto;"></div>
			<center>
			<div style="width:206px;margin:10px auto;" class="btn btn-danger" onClick="javascript: func_del()">
				<i class="icon-remove-sign icon-white"></i> Аннулировать результат
			</div>
			<br>
		</div>
	</body>
</html>