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
		<form action="<?php echo base_url();?>results/" method="get" name="nazad"></form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results/de">Результаты по курсам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/de_view_courses/<?php echo $disc_id;?>">Электронные курсы дисциплины "<?php echo $disc_name;?>"</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/de_course_results/<?php echo $course_id."/".$disc_id;?>">Результаты дистанционного курса "<?php echo $course_name;?>"</a> <span class="divider">/</span></li>
  				<li class="active"><?php echo $stud_name;?></li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center" width="30%"><b>Лекция</b></td>
						<td align="center" colspan="2"><b>Статус</b></td>
						<td align="center" colspan="2"><b>Результаты теста (если имеются)</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					echo "<tr>
					<td>".$lection_names[$key['id']]."</td><td>";
					if ($key['timeend'] != 0)
					{
						$time = round(($key['timeend'] - $key['timebeg'])/3600,2);
						if ($time < 1)
						{
							$time = round(($key['timeend'] - $key['timebeg'])/60,2)." минут";
						}
						else
						{
							$time = $time." часов";
						}
						echo "<i class=\"icon-ok\"></i></td><td>".$time;
					}
					else
					{
						echo "<i class=\"icon-remove\"></i></td><td>Изучение было начато ".date('Y-m-d H:i:s', $key['timebeg']);
					}
					echo "</td>";
					if ($key['test_res_id'] != 0)
					{
						echo "<td align=center>".$test_results[$key['id']]['proz']."%</td>
						<td align=center bgcolor=#ffcc00>".$test_results[$key['id']]['proz_corr']."%</td>";
					}
					else
					{
						echo "<td align=center colspan=2>Результатов тестирования нет</td>";
					}
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