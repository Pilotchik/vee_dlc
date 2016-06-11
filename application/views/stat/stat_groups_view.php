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
			table 	{font-size:10px;}
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Статистика по группам</li>
			</ul>
			<h3>ФСПО</h3>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Группа</b></td>
						<td align="center" width="20%"><b>Последний тест</b></td>
						<td align="center"><b>Статистика</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($fspo as $key)
				{
					$id_gr=$key['id'];
					$last=$last_result[$id_gr];
					if ($last!="")
					{
						$type_r=$key['type_r'];
						echo "<tr>";
						$name_gr=$key['name_numb'];
						echo "<td>$name_gr</td>";
						echo "<td>$last</td>";
						echo "<td><center>
						<form action=\"";
						echo base_url();
						echo "stat/view_one_group/$id_gr\" method=\"post\" name=\"edit$id_gr\">
							<input type=hidden name=\"gr_name\" value=\"$name_gr\">
							<input type=hidden name=\"type_r\" value=\"$type_r\">
							<input style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form></center>
						</td>";
						echo "</tr>";
					}
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<h3>СЕГРИС</h3>
			<table class="sortable" border="1" id="groups2" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Группа</b></td>
						<td align="center"><b>Преподаватель</b></td>
						<td align="center"><b>Последний тест</b></td>
						<td align="center"><b>Результаты</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($segrys as $key)
				{
					$id_gr=$key['id'];
					$last=$last_result[$id_gr];
					if ($last!="")
					{
						$type_r=$key['type_r'];
						echo "<tr>";
						$name_gr=$key['name_numb'];
						echo "<td>$name_gr</td>";
						$pr_name=$prepods[$id_gr];
						echo "<td>$pr_name</td>";
						echo "<td>$last</td>";
						echo "<td><center>
						<form action=\"";
						echo base_url();
						echo "stat/view_one_group/$id_gr\" method=\"post\" name=\"edit$id_gr\">
							<input type=hidden name=\"gr_name\" value=\"$name_gr\">
							<input type=hidden name=\"type_r\" value=\"$type_r\">
							<input style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form></center>
						</td>";
						echo "</tr>";
					}
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
			<h3>Гости</h3>
			<table class="sortable" border="1" id="groups3" width="100%">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Группа</b></td>
						<td align="center" width="20%"><b>Последний тест</b></td>
						<td align="center"><b>Результаты</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				echo "<tr>";
				echo "<td>Гость</td>";
					$last=$last_result[78];
					if ($last=="")
					{
						echo "<td colspan=2>Ни одного теста не сдано</td>";
					}
					else
					{
						echo "<td>$last</td>";
						echo "<td><center>
						<form action=\"";
						echo base_url();
						echo "stat/view_one_group/78\" method=\"post\" name=\"edit78\">
							<input type=hidden name=\"gr_name\" value=\"Гость\">
							<input type=hidden name=\"type_r\" value=\"0\">
							<input style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form></center>
						</td>";
					}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups3","hoverRow","clickedRow",false);
			</script>
			<br>
		</div>
	</body>
</html>