<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_home()	{document.home.submit();}
			function func_nazad()	{document.nazad.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form{margin: 0 0 0 0;}
			table{font-size: 11px;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<form action="<?php echo base_url();?>moder" method="post" name="nazad"></form>
		<center>
		<?php if ($error!="") { echo "<script type=\"text/javascript\">$(document).ready(function() {alert('$error')});</script>";}?>
		<center>
		<br />
		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<h1>Ответы студентов</h1>
		</div>
		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<td align="center"><b>Группа</b></td>
						<td align="center"><b>Дисциплина: тест</b></td>
						<td align="center"><b>Дата</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Проверка</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				if (count($stud_answers)>0)
				{
					foreach ($stud_answers as $key)
					{
						$id_ans=$key['id'];
						echo "<tr><td align=center>".$user[$id_ans]."</td>
						<td align=center>".$group[$id_ans]."</td>
						<td align=center>".$test_name[$id_ans]."</td>
						<td align=center>".$test_date[$id_ans]."</td>
						<td align=center>".$quest_text[$id_ans]."</td>";
						echo "<td align=center><form action=\"";
						echo base_url();
						echo "moder/check_answer/$id_disc/$id_ans\" method=\"post\" name=\"edit$id_ans\">
						<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Проверка\">
						</form></td></tr>";
					}
				}
				else
				{
					echo "<tr><td align=center colspan=6>Заданий для проверки больше нет</td></tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
		</div>
		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<div class="btn-group">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse"  onClick="javascript: func_nazad()">
					<i class="icon-arrow-left icon-white"></i> Назад
				</div>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_home()">
					<i class="icon-home icon-white"></i> Главное меню
				</div>
			</div>
		</div>
	</body>
</html>