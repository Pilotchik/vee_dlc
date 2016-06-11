<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			#root 	{margin:15px 0 0 0;}
			table 	{font-size:11px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>stat">Статистика по дисциплинам</a> <span class="divider">/</span></li>
  				<li class="active">Тесты дисциплины "<?php echo $disc_name;?>"</li>
			</ul>
			<table class="sortable" border="1" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Тест</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Средний балл</b></td>
						<td align="center"><b>Средний балл <br />скорректированный</b></td>
						<td align="center"><b>Среднее<br />время, мин</b></td>
						<td align="center"><b>Последняя статистика</td>
						<td align="center"><b>Темы</b></td>
						<td align="center"><b>Группы</b></td>
						<td align="center"><b>Вопросы</b></td>
						<td align="center"><b>Отчёт</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($tests as $key)
				{
					$test_id=$key['id'];
					echo "<tr>";
					echo "<td>".$key['name_razd']."</td>";
					$name_t=$key['name_razd'];
					$count=$tests_results[$test_id]['count'];
					echo "<td>$count</td>";
					echo "<td>".$tests_results[$test_id]['abs']."</td>";
					echo "<td>".$tests_results[$test_id]['abs_corr']."</td>";
					echo "<td>".$tests_results[$test_id]['time_avg']."</td>";
					echo "<td>".$key['stat_date']."</td>";
					echo "<td><center>
					<form action=\"";
					echo base_url();
					echo "stat/view_theme_results/$test_id/$disc_id\" method=\"post\" name=\"edit$test_id\">
						<input type=hidden name=\"test_name\" value=\"$name_t\">
						<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" value=\"Темы\">
					</form></center>
					</td>";
					echo "<td><center>
					<form action=\"";
					echo base_url();
					echo "stat/view_test_groups/$test_id/$disc_id\" method=\"post\" name=\"edit$test_id\">
						<input type=hidden name=\"test_name\" value=\"$name_t\">
						<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" value=\"Группы\">
					</form></center>
					</td>";
					echo "<td><center>
					<form action=\"";
					echo base_url();
					echo "stat/view_test_stat/$test_id/$disc_id\" method=\"post\" name=\"edit$test_id\">
						<input type=hidden name=\"test_name\" value=\"$name_t\">
						<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" value=\"Вопросы\">
					</form></center>
					</td>";
					echo "<td><center>
					<form action=\"";
					echo base_url();
					echo "stat/view_test_report/$test_id/$disc_id\" method=\"post\" name=\"edit$test_id\">
						<input type=hidden name=\"test_name\" value=\"$name_t\">
						<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" value=\"Отчёт\">
					</form></center>
					</td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
	</body>
</html>