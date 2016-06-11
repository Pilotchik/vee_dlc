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
			function func_create()	{document.createForm.submit();}
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
		<form action="<?php echo base_url();?>moder/view_answers/<?php echo $id_disc;?>" method="post" name="nazad"></form>
		<center>
		<?php if ($error!="") { echo "<script type=\"text/javascript\">$(document).ready(function() {alert('$error')});</script>";}?>
		<center>
		<br />
		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<h1>Проверка ответа студента</h1>
		</div>
		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<form action="<?php echo base_url()?>moder/view_answers/<?php echo $id_disc;?>/<?php echo $id_answer;?>" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Студент</td>
						<td align="left" width="60%">
							<?php echo $user[$id_answer]; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Группа</td>
						<td align="left" width="60%">
							<?php echo $group[$id_answer]; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Дисциплина: тест</td>
						<td align="left" width="60%">
							<?php echo $test_name[$id_answer]; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Дата прохождения тестирования</td>
						<td align="left" width="60%">
							<?php echo $test_date[$id_answer]; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Текущий результат</td>
						<td align="left" width="60%">
							<?php echo $user_result[$id_answer]; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Текст вопроса</td>
						<td align="left" width="60%">
							<?php echo $quest_text[$id_answer]; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Ответ студента</td>
						<td align="left" width="60%">
							<?php echo $stud_answer[0]['answer']; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Степень правильности</td>
						<td align="left" width="60%">
							<SELECT NAME="ans_true">
								<option value="0">Ответ неверный
								<option value="1">1
								<option value="2">2
								<option value="3">3
								<option value="4">4
								<option value="5">5
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Комментарий (будет отправлен студенту)</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="ans_comm" cols="60" rows="3"></textarea>
						</td>
					</tr>
				</table>
			</form>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_create()">
				<i class="icon-ok icon-white"></i> Готово!
			</div>
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