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
			
			function func_filter()
			{
				document.date_picker.submit();
			}

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
  				<li><a href="<?php echo base_url();?>results">Дисциплины</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/view_tests/<?php echo $disc_id;?>"><?php echo $disc_name;?></a> <span class="divider">/</span></li>
  				<li class="active">Результаты теста "<?php echo $test_name;?>"</li>
			</ul>
			<a href="<?php echo base_url();?>results/downloadExcel/<?php echo $test_id."/".$disc_id;?>" target="_blank" class="btn btn-info btn-large">Скачать все результаты</a>
			<br><br>
			<p>Укажите диапазон дат, для которого необходимы результаты</p>
			<table>
				<tr>
					<td width=30px>&nbsp;</td>
					<td>
						<form style="margin:0 0px 20px 0;margin-bottom: 0px;right: 0px;" action="<?php echo base_url();?>results/view_test_results/<?php echo $test_id;?>/<?php echo $disc_id;?>" method="post" name="date_picker"  autocomplete="off">
							<input type="hidden" name="test_name" value="<?php echo $test_name;?>">
							<input type="text" id="exampleRange" value="" name="range" style="text-align:center;height: 30px;">
							<SELECT NAME="group_id">
								<OPTION VALUE="">Все
								<?php
									foreach($filter_group as $key)
									{
										echo "<OPTION VALUE=".$key['id'].">".$key['name_numb'];
									}
								?>
							</select>
						</form>
					</td>
					<td>
						<div style="width:206px;margin:0 0 0 0;" class="btn btn-inverse" onClick="javascript: func_filter()">
							<i class="icon-ok icon-white"></i> Фильтр
						</div>
					</td>
				</tr>
			</table>
			<p>Цифры в столбце "Результат откорректированный" получены после исключения ответов на некорректные с точки
			зрения корреляции и дискриминативности вопросы. Статистические данные о вопросах доступны в разделе "Статистика".</p>
			<p>Оценка определена по шкале:<br />
				Отлично - более <?php echo $skala['five'];?><br />
				Хорошо - более <?php echo $skala['four'];?><br />
				Удовлетворительно - более <?php echo $skala['three'];?><br />
			</p>
			<p>Буква в результате проставлена по системе ECTS:<br />
				A - 10% лучших студентов<br />
				В — следующие 25 %<br />
				С — следующие 30 %<br />
				D — следующие 25 %<br />
				Е — следующие 10 %<br />
			</p>
			<table class="sortable" border="1" id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<td align="center"><b>Группа</b></td>
						<td align="center"><b>Дата</b></td>
						<td align="center"><b>Время, мин</b></td>
						<td align="center"><b>Результат</b></td>
						<td align="center"><b>Оценка</b></td>
						<td align="center" colspan=3><b>Результат<br>откорректированный</b></td>
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
						$name_st=$key['lastname']." ".$key['firstname'];
						echo "<tr>
						<td>$name_st</td>";
						$guest=$key['guest'];
						if ($guest=='0')
						{
							echo "<td>Гость</td>";	
						}
						else
						{
							$name_gr=$key['name_numb'];
							echo "<td>$name_gr</td>";	
						}
						$date_test=$key['data'];
						echo "<td>$date_test</td>";
						if ($key['timeend']==0)
						{
							echo "<td colspan=6>Тестирование</td>";	
						}
						else
						{
							$time=ceil(($key['timeend']-$key['timebeg'])/60);
							echo "<td>$time</td>";	
							$proz=$key['proz'];
							$ball_norm=$ozenka[$key['id']]['norm'];
							$ball_corr=$res_correct[$key['id']];
							$ozenka_corr=$ozenka[$key['id']]['corr'];
							$color="white";
							if ($proz<$ball_corr)
							{
								$color="4682b4";
							}
							else
							{
								$color="cd5c5c";
							}
							echo "<td>$proz</td>";
							echo "<td>$ball_norm</td>";
							echo "<td bgcolor=$color>$ball_corr</td>";
							echo "<td bgcolor=$color>$ozenka_corr</td>";
							$bukva=$reyt[$key['id']];
							if ($bukva=="A")
							{
								echo "<td bgcolor=green>$bukva</td>";	
							}
							else
							{
								if ($bukva=="E")
								{
									echo "<td bgcolor=red>$bukva</td>";
								}
								else
								{
									echo "<td bgcolor=$color>$bukva</td>";
								}
							}
						}	
						echo "<td>
						<form action=\"";
						echo base_url();
						echo "results/view_stud_result/$res_id/$test_id/$disc_id\" method=\"get\" name=\"edit$res_id\">
							<input type=\"submit\" style=\"margin:0 0 0 0;width:100px;font-size:11px;\" class=\"btn btn-inverse\" value=\"Просмотр\">
						</form>
						</td>
						</tr>";
					}
				}
				else
				{
					echo "<tr><td colspan=10>В указанный период данный тест не сдавался</td></tr>";
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