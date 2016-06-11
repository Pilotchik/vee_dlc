<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.home.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<!-- Yandex.Metrika counter -->
			<div style="display:none;">
				<script type="text/javascript">
				(function(w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter11384695 = new Ya.Metrika({id:11384695, enableAll: true, webvisor:true}); } catch(e) { } }); })(window, "yandex_metrika_callbacks");</script>
			</div>
			<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
			<noscript>
				<div>
					<img src="//mc.yandex.ru/watch/11384695" style="position:absolute; left:-9999px;" alt="" />
				</div>
			</noscript>
		<!-- /Yandex.Metrika counter -->
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<center>
		<div id="root" style="width:1000;">
			<h1>Проверенные задания</h1>
			<?php 
			if (count($stud_answers)>0)
			{
				?>
				<br />
				<table class="sortable" id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<td align="center"><b>Дисциплина: Тест</b></td>
						<td align="center"><b>Дата сдачи</b></td>
						<td align="center"><b>Текст вопроса</b></td>
						<td align="center"><b>Ответ</b></td>
						<td align="center"><b>Дата проверки</td>
						<td align="center"><b>Преподаватель</td>
						<td align="center"><b>Комментарий</td>
						<td align="center"><b>Баллы</b></td>
						<td align="center"><b>Процент до</b></td>
						<td align="center"><b>Процент после</b></td>
						<td align="center"><b>Студент уведомлён</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($stud_answers as $key)
				{
					$ans_id=$key['id'];
					echo "<tr>
					<td align=center>".$student_name[$ans_id]."</td>
					<td>".$test_name[$ans_id]."</td>
					<td>".$test_date[$ans_id]."</td>
					<td>".$quest_text[$ans_id]."</td>
					<td>".$stud_answer[$ans_id]."</td>
					<td>".$prepod_date[$ans_id]."</td>
					<td>".$prepod_name[$ans_id]."</td>
					<td>".$prepod_comm[$ans_id]."</td>
					<td>".$balls[$ans_id]."</td>
					<td>".$proz_before[$ans_id]."</td>
					<td>".$proz_after[$ans_id]."</td>";
					if ($read_status[$ans_id] == 1)
					{
						echo "<td>Да</td>";	
					}
					else
					{
						echo "<td>Нет</td>";		
					}
					echo "</tr>";
				}
				echo "</table>";
			}
			else
			{
				echo "Проверенных заданий пока нет";
			}

			?>
		</div>
		<div id="root" style="width:1000;margin:20px 0 0 0;">
			<div style="width:206px;margin:20px 0 10px 0;" class="btn btn-inverse"  onClick="javascript: func_nazad()">
				<i class="icon-home icon-white"></i> Главное меню
			</div>
		</div>
	</body>
</html>