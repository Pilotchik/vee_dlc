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
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>admin" method=post name=nazad></form>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<?php if ($error!="") { echo "<script type=\"text/javascript\">$(document).ready(function() {alert('$error')});</script>";}?>
		<center>
		<div id="root" style="width:1000;">
			<br />
			<h1>Резюме пользователей</h1>
			<br />
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<td align="center"><b>ОУ</b></td>
						<td align="center"><b>Сопоставимость с руководителем</b></td>
						<td align="center"><b>Корпоративная культура</b></td>
						<td align="center"><b>Командная роль</b></td>
						<td align="center"><b>Прикладные навыки</b></td>
						<td align="center"><b>Количество проектов</b></td>
						<td align="center"><b>Средний балл компетентностного портрета</b></td>
						<td align="center"><b>Резюме</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($students as $key)
				{
					echo "<tr><td>".$key['lastname']." ".$key['firstname']."</td><td>";
					switch ($key['type_r']) 
					{
    					case 1: echo "ФСПО";	break;
    					case 2:	echo "НОУ \"СЕГРИС-ИИТ\"";	break;
    					default:	echo "Преподаватель";
					}
					echo "</td>";
					for ($i=1;$i<5;$i++)
					{
						echo "<td>".$skill_groups[$key['id']][$i]."%</td>";
					}
					echo "<td>".$portf_count[$key['id']]."</td>";
					echo "<td>".$comps_avg[$key['id']]."</td>";
					echo "<td>
					<form style=\"margin:0 0 0 0;\" action=\"";
					echo base_url();
					echo "persons/student_resume/".$key['id']."\" method=\"post\">
						<input style=\"width:100px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
					</form></td></tr>";
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
		</div>
		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<div class="btn-group">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
					<i class="icon-arrow-left icon-white"></i> Назад
				</div>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_home()">
					<i class="icon-home icon-white"></i> Главное меню
				</div>
			</div>
		</div>
	</body>
</html>