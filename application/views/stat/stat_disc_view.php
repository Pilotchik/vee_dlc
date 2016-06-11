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
			input[type="submit"] {width:100px;margin:0 0 0 0;font-size:11px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Статистика по дисциплинам</li>
			</ul>
			<h3>ФСПО</h3>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Дисциплина</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Тесты</b></td>
						<td align="center"><b>Группы</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($fspo as $key)
				{
					$id_dsc=$key['id'];
					echo "<tr>
					<td>".$key['name_test']."</td>
					<td>".$count_results[$id_dsc]."</td>
					<td align=center>
						<form action=\"".base_url()."stat/view_tests/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input type=\"submit\" class=\"btn btn-inverse\" value=\"Тесты\">
						</form>
					</td>
					<td align=center>
						<form action=\"".base_url()."stat/view_disc_groups/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input type=\"submit\" class=\"btn btn-inverse\" value=\"Группы\">
						</form>
					</td>
					</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
			<h3>НОУ "СЕГРИС-ИИТ"</h3>
			<table class="sortable" id="groups2">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Дисциплина</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Тесты</b></td>
						<td align="center"><b>Группы</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($segrys as $key)
				{
					$id_dsc=$key['id'];
					echo "<tr>
					<td>".$key['name_test']."</td>
					<td>".$count_results[$id_dsc]."</td>
					<td align=center>
						<form action=\"".base_url()."stat/view_tests/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input type=\"submit\" class=\"btn btn-inverse\" value=\"Тесты\">
						</form>
					</td>
					<td align=center>
						<form action=\"".base_url()."stat/view_disc_groups/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input type=\"submit\" class=\"btn btn-inverse\" value=\"Группы\">
						</form>
					</td>
					</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
			<br>
			<h3>Универсальные дисциплины и направления</h3>
			<table class="sortable" id="groups3">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Дисциплина</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Тесты</b></td>
						<td align="center"><b>Группы</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($univers as $key)
				{
					$id_dsc=$key['id'];
					echo "<tr>
					<td>".$key['name_test']."</td>
					<td>".$count_results[$id_dsc]."</td>
					<td align=center>
						<form action=\"".base_url()."stat/view_tests/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input type=\"submit\" class=\"btn btn-inverse\" value=\"Тесты\">
						</form>
					</td>
					<td align=center>
						<form action=\"".base_url()."stat/view_disc_groups/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input type=\"submit\" class=\"btn btn-inverse\" value=\"Группы\">
						</form>
					</td>
					</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups3","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
	</body>
</html>