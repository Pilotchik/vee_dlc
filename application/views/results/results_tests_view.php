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
			form{margin:0 0 0 0;}
			table{font-size: 11px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results">Дисциплины</a> <span class="divider">/</span></li>
  				<li class="active"><?php echo $disc_name;?> - Результаты тестов</li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center" width="50%"><b>Тест</b></td>
						<td align="center" width="20%"><b>Последний<br /> результат</b></td>
						<td align="center"><b>Статистическая<br /> обработка</b></td>
						<td align="center"><b>Результаты</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($tests as $key)
				{
					$test_id=$key['id'];
					echo "<tr>";
					$name_t=$key['name_razd'];
					echo "<td>$name_t</td>
					<td>".$last_result[$test_id]."</td>";
					$corr=$key['stat_date'];
					if ($corr==0)
					{
						echo "<td><center>Не проводилась</center></td>";	
					}
					else
					{
						echo "<td bgcolor=#0bda51><center>$corr</center></td>";	
					}
					echo "<td><center>
					<form action=\"";
					echo base_url();
					echo "results/view_test_results/$test_id/$disc_id\" method=\"post\" name=\"edit$test_id\">
						<input type=hidden name=\"test_name\" value=\"$name_t\">
						<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" value=\"Просмотр\">
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