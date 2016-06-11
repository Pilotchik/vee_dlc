<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/ui.datepicker.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#exampleRange').attachDatepicker({
				rangeSelect: true,
				yearRange: '2011:2014',
				firstDay: 1
				});
			});
			
			function func_filter()		{document.date_picker.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form{margin: 0 0 0 0;}
			table{font-size: 11px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results/de">Результаты по курсам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/de_view_courses/<?php echo $disc_id;?>">Электронные курсы дисциплины "<?php echo $disc_name;?>"</a> <span class="divider">/</span></li>
  				<li class="active">Результаты дистанционного курса "<?php echo $course_name;?>"</li>
			</ul>
			<p>Укажите диапазон дат, для которого необходимы результаты (дни начала прохождения курса). По умолчанию отображаются курсы, которые были начаты не раньше месяца назад.</p>
			<table>
				<tr>
					<td>
						<form style="margin:0 0 0 0;margin-bottom:0" action="<?php echo base_url();?>results/de_course_results/<?php echo $course_id;?>/<?php echo $disc_id;?>" method="get" name="date_picker"  autocomplete="off">
							<input type="text" id="exampleRange" value="" name="range" style="text-align:center;height: 30px;font-size: 12;">
						</form>
					</td>
					<td>
						<div style="width:206px;margin:0 0 0 0" class="btn btn-inverse" onClick="javascript: func_filter()">
							<i class="icon-ok icon-white"></i> Фильтр
						</div>
					</td>
				</tr>
			</table>
			<br />
			<table class="sortable" border="1" id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<td align="center"><b>Группа</b></td>
						<td align="center"><b>Дата начала<br>прохождения курса</b></td>
						<td align="center"><b>Статус</b></td>
						<td align="center"><b>Результат<br>по тестам</b></td>
						<td align="center"><b>Подробно</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				if (count($results)>0)
				{
					foreach ($results as $key)
					{
						$res_id=$key['id'];
						echo "<tr>
						<td>".$key['lastname']." ".$key['firstname']."</td>";
						if ($key['guest'] == '0')
						{
							echo "<td>Гость</td>";	
						}
						else
						{
							echo "<td>".$key['name_numb']."</td>";	
						}
						echo "<td>".date('Y-m-d H:i:s', $key['timebeg'])."</td><td>";
						if ($key['timeend'] != 0)
						{
							if (($key['timeend']-$key['timebeg'])/3600 >= 1)
							{
								echo "Курс пройден за ".ceil(($key['timeend']-$key['timebeg'])/3600)." часов";
							}
							else
							{
								echo "Курс пройден за ".round(($key['timeend']-$key['timebeg'])/60,2)." минут";	
							}
						}
						else
						{
							echo $key['proz']."%";
						}
						echo "</td><td>".round($key['balls'],2)."%</td>
						<td>
							<form action=\"".base_url()."results/de_view_stud_result/$res_id/$course_id/$disc_id\" method=\"get\" name=\"edit$res_id\">
								<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" value=\"Просмотр\">
							</form>
						</td>
						</tr>";
					}
				}
				else
				{
					echo "<tr><td colspan=10>В указанный период к обучению по дистанционному курсу не приступали</td></tr>";
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