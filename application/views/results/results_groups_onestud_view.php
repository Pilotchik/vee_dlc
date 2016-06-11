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
  				<li><a href="<?php echo base_url();?>results/view_groups">Результаты по группам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/view_one_group/<?php echo $group_id; ?>">Результаты группы "<?php echo $gr_name;?>"</a> <span class="divider">/</span></li>
  				<li class="active"><?php echo $stud_name;?></li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Дисциплина</b></td>
						<td align="center"><b>Тест</b></td>
						<td align="center"><b>Дата</b></td>
						<td align="center"><b>Время, мин</b></td>
						<td align="center"><b>Результат</b></td>
						<td align="center"><b>Оценка</b></td>
						<td align="center"><b>Подробно</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					$res_id=$key['id'];
					echo "<tr>";
					$dsc_name=$disc_name[$res_id]['name'];
					$disc_id=$disc_name[$res_id]['id'];
					echo "<td>$dsc_name</td>";	
					$tst_name=$test_name[$res_id]['name'];
					$test_id=$test_name[$res_id]['id'];
					echo "<td>$tst_name</td>";
					$date_test=$key['data'];
					echo "<td>$date_test</td>";
					$time=ceil(($key['timeend']-$key['timebeg'])/60);
					echo "<td>$time</td>";	
					$proz=$key['proz'];
					echo "<td>$proz</td>";
					$oz=$ozenka[$res_id];
					switch ($oz) 
					{
						case 2:	echo "<td bgcolor=red>$oz</td>";	break;
						case 3:	echo "<td bgcolor=#e28b00>$oz</td>";	break;
						case 4:	echo "<td bgcolor=#adff2f>$oz</td>";	break;
						case 5:	echo "<td bgcolor=green>$oz</td>";	break;
    				}
    				echo "<td>
					<form action=\"".base_url()."results/view_stud_group_result/$res_id/\" method=\"post\" name=\"edit$res_id\">
						<input type=hidden name=\"stud_id\" value=\"$stud_id\">
						<input type=hidden name=\"test_name\" value=\"$tst_name\">
						<input type=hidden name=\"group_id\" value=\"$group_id\">
						<input type=hidden name=\"test_id\" value=\"$test_id\">
						<input type=hidden name=\"disc_id\" value=\"$disc_id\">
						<input style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
					</form></center>
					</td>";
					echo "</tr>";
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