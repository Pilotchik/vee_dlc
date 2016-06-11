<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>stat">Статистика по дисциплинам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>stat/view_tests/<?php echo $disc_id;?>"><?php echo $disc_name;?></a> <span class="divider">/</span></li>
  				<li class="active">Отчёт по тесту "<?php echo $test_name;?>"</li>
			</ul>
			<table class="sortable" id="groups" style="font-size:11px;">
				<thead>
					<tr>
						<td align="center"><b>ID</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Успешность<br />выполнения</b></td>
						<td align="center"><b>Сложность</b></td>
						<td align="center"><b>Статус</b></td>
						<td align="center"><b>Ответ</b></td>					
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($quests as $key)
					{
						echo "<tr>";
						$ans_count=count($answers[$key['id']]['info']);
						echo "<td rowspan=$ans_count>".$key['id']."</td>";
						echo "<td rowspan=$ans_count width=30%>".$key['text']."</td>";
						$balls=round($key['success']*100,2);
						$brak=0;
						if ($balls>90 || $balls<10)
						{
							echo "<td bgcolor=#d5d5d5 rowspan=$ans_count>$balls</td>";
							$brak=1;
						}
						else
						{
							echo "<td rowspan=$ans_count>$balls</td>";	
						}
						if ($key['level']>0)
						{
							echo "<td rowspan=$ans_count>".$key['level']."</td>";
							echo "<td rowspan=$ans_count>ОК</td>";
						}
						else
						{
							echo "<td rowspan=$ans_count bgcolor=#d5d5d5>".$key['level']."</td>";
							if ($brak==0 && $key['level']==0)
							{
								echo "<td rowspan=$ans_count bgcolor=#d5d5d5>Некорректен из-за низкой корреляции с общим результатом</td>";
							}
							if ($balls>90)
							{
								echo "<td rowspan=$ans_count bgcolor=#d5d5d5>Вопрос слишком простой</td>";
							}
							if ($balls<10)
							{
								echo "<td rowspan=$ans_count bgcolor=#d5d5d5>Вопрос слишком cложный</td>";
							}
						}
						$k=0;
						foreach ($answers[$key['id']]['info'] as $key2)
						{
							if ($k==0)
							{
								echo "<td>".$key2['text']."</td></tr>";	
							}
							else
							{
								echo "<tr><td>".$key2['text']."</td></tr>";		
							}
						}
					}
					?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br>
		</div>
	</body>
</html>