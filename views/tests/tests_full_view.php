<html>
	<head>
		<title>ВОС. Вопросы теста "<?= $razdel[0]['name_razd'] ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		
	</head>
	<body>
		<div style="margin:20px;">
		<h1>Вопросы теста "<?= $razdel[0]['name_razd'] ?>"</h1>
		
		<?php
		$ch = 1;
		foreach ($questions as $key)
		{
			?>
			<h3 style="margin-top:30px;margin-bottom:5px;text-decoration: underline;">Задание <?= $ch ?>.<?= $key['variant'] ?></h3>
			<b>Тема:</b> <?= $key['name_th'] ?><br>
			<b>Вопрос:</b> <?= $key['text'] ?><br>
			<?php
			switch ($key['type'])
			{
				case '1': $type_name = "(выберите один вариант ответа)"; break;
				case '2': $type_name = "(выберите один или несколько вариантов ответа)"; break;
				case '3': $type_name = "(введите текст ответа)"; break;
				case '4': $type_name = "(установите соответствие между ответами)"; break;
				case '6': $type_name = "(введите текст ответа)"; break;
				default: $type_name = "(выберите один вариант ответа)"; break;
			}
			?>
			<i><?= $type_name ?></i><br>
			<b>Варианты ответов:</b><br>
		
			<?php
			$ans_numb = 1;
			$ans_str = "";
			foreach($answers[$key['id']] as $key2)
			{
				?>
				<?= $ans_numb ?>) <?= $key2['text'] ?><br>
				<?php
				if ($key['type'] == 4)
				{
					?>
					<?= $key2['quest_t'] ?>
					<?php
				}
				if ($key2['true'] == 1) $ans_str .= $ans_numb.", ";
				$ans_numb++;
			}
			$ans_str = substr($ans_str, 0, -2);
			?>
			<b>Ответ: </b><?= $ans_str ?>
			<?php
			$ch++;
		}
		?>

		<h3>ТАБЛИЦА ПРАВИЛЬНЫХ ОТВЕТОВ</h3>
		<table border=1 cellspacing = "0" cellpadding=3 style="border: 1px solid black;border-collapse: collapse;">
		<?php 
		$ch = 1;

		foreach ($questions as $key)
		{
			if (($ch - 1) % 5 == 0)
			{
				?>
				<tr>
				<?php
			}
			?>
			
			<td><b><?= $ch ?>.<?= $key['variant'] ?></b></td>
			
			<?php
			$ans_numb = 1;
			$ans_str = "";
			foreach($answers[$key['id']] as $key2)
			{
				if ($key2['true'] == 1) $ans_str .= $ans_numb.", ";
				$ans_numb++;
			}
			$ans_str = substr($ans_str, 0, -2);
			?>
			
			<td><?= $ans_str ?></td>
			
			<?php
			$ch++;
			if (($ch-1) % 5 == 0)
			{
				?>
				</tr>
				<?php
			}

		}
		?>
		</div>
	</body>
</html>