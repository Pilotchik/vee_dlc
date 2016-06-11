<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<style>
			input[type="submit"] {width:100px;margin:0 0 0 0;font-size:11px;}
		</style>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Результаты по группам</li>
			</ul>
			<h3>ФСПО</h3>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center" width="60%"><b>Группа</b></td>
						<td align="center" width="20%"><b>Последний тест</b></td>
						<td align="center"><b>Результаты</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($fspo as $key)
				{
					$id_gr=$key['id'];
					if ($last_result[$id_gr] != "")
					{
						echo "<tr>
						<td>".$key['name_numb']."</td>
						<td>".$last_result[$id_gr]."</td>
						<td align=center>
							<form action=\"".base_url()."results/view_one_group/$id_gr\" method=\"get\" name=\"edit$id_gr\">
								<input class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
							</form>
						</td>
						</tr>";
					}
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
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
						echo "<tr>
						<td>".$key['name_numb']."</td>
						<td>".$prepods[$id_gr]."</td>
						<td>$last</td>
						<td align=center>
							<form action=\"".base_url()."results/view_one_group/$id_gr\" method=\"get\" name=\"edit$id_gr\">
								<input class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
							</form>
						</td>
						</tr>";
					}
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
			<br />
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
				<tr>
					<td>Гость</td>
				<?php
					if ($last_result[78] == "")
					{
						echo "<td colspan=2>Ни одного теста не сдано</td>";
					}
					else
					{
						echo "<td>".$last_result[78]."</td>
						<td align=center>
							<form action=\"".base_url()."results/view_one_group/78\" method=\"get\" name=\"edit78\">
								<input class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
							</form>
						</td>";
					}
				?>
				</tr>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups3","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
	</body>
</html>