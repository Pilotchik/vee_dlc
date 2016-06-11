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
			input[type="submit"] {width:100px;margin:0 0 0 0;font-size:11px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results/view_quests">Результаты по вопросам</a> <span class="divider">/</span></li>
  				<li class="active">Тесты дисциплины "<?php echo $disc_name;?>"</li>
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
					echo "<tr>
					<td>".$key['name_razd']."</td>
					<td>".$last_result[$test_id]."</td>";
					if ($key['stat_date'] == 0)
					{
						echo "<td align=center>Не проводилась</td>";	
					}
					else
					{
						echo "<td bgcolor=green align=center>".$key['stat_date']."</td>";	
					}
					echo "<td align=center>
						<form action=\"".base_url()."results/view_test_quests_results/$test_id\" method=\"get\" name=\"edit$test_id\">
							<input class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
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
		</div>
	</body>
</html>