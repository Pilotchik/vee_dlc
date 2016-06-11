<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()		
			{
				document.nazad.submit();
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form{margin: 0 0 0 0;}
			table{font-size: 11px;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>main/auth" method="post" name="nazad"></form>
		<center>
		<?php if ($error!="") { echo "<script type=\"text/javascript\">$(document).ready(function() {alert('$error')});</script>";}?>
		<center>
		<br />
		<div id="root" style="width:800;">
			<h1>Проверка ответов</h1>
		</div>
		<br />
		<div id="root" style="width:800;">
			<h1>ФСПО НИУ ИТМО</h1>
			<br />
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Дисциплина</b></td>
						<td align="center" width="20%"><b>Количество непроверенных заданий</b></td>
						<td align="center"><b>Проверка</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				if (count($fspo)>0)
				{
					foreach ($fspo as $key)
					{
						$id_dsc=$key['id'];
						echo "<tr><td align=center>".$key['name_test']."</td><td align=center>".$count[$id_dsc]."</td>";
						echo "<td align=center>";
						if ($count[$id_dsc] == 0)
						{
							echo "Нет ответов для проверки";
						}
						else
						{
							echo "<form action=\"";
							echo base_url();
							echo "moder/view_answers/$id_dsc\" method=\"post\" name=\"edit$id_dsc\">
							<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
							</form>";
						}
						echo "</td></tr>";
					}
				}
				else
				{
					echo "<tr><td align=center colspan=3>Заданий для проверки ещё не придумано</td></tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
		<br />
		<div id="root" style="width:800;">
			<h1>НОУ "СЕГРИС-ИИТ"</h1>
			<br />
			<table class="sortable" id="groups2">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Дисциплина</b></td>
						<td align="center" width="20%"><b>Количество непроверенных заданий</b></td>
						<td align="center"><b>Проверка</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				if (count($segrys)>0)
				{
					foreach ($segrys as $key)
					{
						$id_dsc=$key['id'];
						echo "<tr><td align=center>".$key['name_test']."</td><td align=center>".$count[$id_dsc]."</td>";
						echo "<td align=center>";
						if ($count[$id_dsc] == 0)
						{
							echo "Нет ответов для проверки";
						}
						else
						{
							echo "<form action=\"";
							echo base_url();
							echo "moder/view_answers/$id_dsc\" method=\"post\" name=\"edit$id_dsc\">
							<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
							</form>";
						}
						echo "</td></tr>";
					}
				}
				else
				{
					echo "<tr><td align=center colspan=3>Заданий для проверки ещё не придумано</td></tr>";
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
		<br />
		<div id="root" style="width:800;">
			<h1>Универсальные дисциплины и направления</h1>
			<br />
			<table class="sortable" id="groups3">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Дисциплина</b></td>
						<td align="center" width="20%"><b>Количество непроверенных заданий</b></td>
						<td align="center"><b>Проверка</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				if (count($univers)>0)
				{
					foreach ($univers as $key)
					{
						$id_dsc=$key['id'];
						echo "<tr><td align=center>".$key['name_test']."</td><td align=center>".$count[$id_dsc]."</td>";
						echo "<td align=center>";
						if ($count[$id_dsc] == 0)
						{
							echo "Нет ответов для проверки";
						}
						else
						{
							echo "<form action=\"";
							echo base_url();
							echo "moder/view_answers/$id_dsc\" method=\"post\" name=\"edit$id_dsc\">
							<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
							</form>";
						}
						echo "</td></tr>";
					}
				}
				else
				{
					echo "<tr><td align=center colspan=3>Заданий для проверки ещё не придумано</td></tr>";
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups3","hoverRow","clickedRow",false);
			</script>
		</div>
		<div id="root" style="width:800;margin:15px 0 0 0;">
			<div style="width:206px;margin:0 0 0 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
				<i class="icon-home icon-white"></i> Главное меню
			</div>
		</div>
	</body>
</html>