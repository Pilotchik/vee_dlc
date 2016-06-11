<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
			});

			function func_filter()		{document.count_form.submit();}
			
			function func_view(id_p)	
			{
				$('#overlay').fadeIn('fast');
				$('#root3').fadeIn("slow");
				$('body,html').animate({scrollTop:0},500);
				$.post('<?php echo base_url();?>results/view_popup_stud',{user_id:id_p},function(data,status)
				{
					if( status=='success')
					{
						$("#content").html(data);
					}
					else
					{
						alert('В процессе отправки произошла ошибка :(');
					}
				})
			}

			setInterval(
				function()
				{
					<?php 
					foreach ($results as $key)
					{
						if ($key['timeend'] == 0)
						{
							?>
							
							$.post ('<?php echo base_url();?>results/autocheck',{id_res:<?php echo $key['id']?>,true_all:<?php echo $key['true_all'];?>},function(data,status){
							if( status!='success' ) {alert('В процессе запроса результата произошла ошибка');}
							else {
								eval('var obj='+data);
								if (obj.answer==0)	{alert('Запрос не смог выполниться');}
								else 
								{
									$('#summ'+<?php echo $key['id'];?>).html(obj.otn);
									$('#cmpl'+<?php echo $key['id'];?>).html(obj.cmpl);
									w1 = obj.summ + '%';
									w2 = obj.razn + '%';
									$('#bar_true'+<?php echo $key['id'];?>).animate({width: w1}, 100);
									$('#bar_razn'+<?php echo $key['id'];?>).animate({width: w2}, 100);
								}
							}});
					<?php 
						}
					}
					?>
				},20000);

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#overlay').fadeOut('fast');
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
		<!--Всплывающее окно с результатами студента -->
		<div id="root3" style="top:100px;margin:0 0 0 -250px;z-index:100;">
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()"><i class="icon-remove-sign icon-white"></i> Закрыть окно</div>
			<div id="content"></div>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()"><i class="icon-remove-sign icon-white"></i> Закрыть окно</div>
		</div>
		<!-- Конец окна с результатами -->
			<h3>Последние результаты</h3>
			<p>В столбце "Стат обработка" указан результат после проведения статистической обработки теста, если такая обработка проводилась. Следует учитывать, что результат статистической обработки зависит от 
				количества человек, принявших участие в тестировании. Если тест был создан недавно - доверять столбцам, в которых указаны скорректированные результаты, не стоит.</p>
			<table align="left" style="fint-size:12px;">
				<tr>
					<td>
						<p>Количество последних результатов:</p>
					</td>
					<td>
						<form action="<?php echo base_url();?>results/view_last" style="margin:0 0 0 0;" method="get" name="count_form"  autocomplete="off">
							<select name="count">
								<option value="5">5
								<option value="10">10
								<option value="15">15
								<option value="20">20
								<option value="25">25
							</select>
						<form>
					</td>
					<td>
						<div style="width:206px;margin:0px 0 0px 0;" class="btn btn-inverse" onClick="javascript: func_filter()">
							<i class="icon-ok icon-white"></i> Фильтр
						</div>	
					</td>
				</tr>
			</table>
			<br />
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<td align="center"><b>Группа</b></td>
						<td align="center"><b>Дисциплина</b></td>
						<td align="center"><b>Тест</b></td>
						<td align="center"><b>Дата</b></td>
						<td align="center"><b>Время, мин</b></td>
						<td align="center" colspan="2"><b>Результат</b></td>
						<td align="center" colspan="2"><b>Обработка</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					$time=strtotime("-1 day");
					$res_id=$key['id'];
					if ($key['timeend'] != 0)
					{
						echo "<tr>
						<td>
						<div style=\"width:150px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" onclick=\"func_view(".$pers_info[$res_id]['user_id'].")\">
							".$pers_info[$res_id]['name']."
						</div></td>
						<td>".$pers_info[$res_id]['group']."</td>
						<td>".$disc_name[$res_id]['name']."</td>
						<td>".$test_name[$res_id]."</td>
						<td>".$key['data']."</td>
						<td>".ceil(($key['timeend']-$key['timebeg'])/60)."</td>
						<td>".round($key['proz'],2)."</td>";
						$oz=$ozenka[$res_id];
						switch ($oz) 
						{
							case 2:	echo "<td bgcolor=#db7093>$oz</td>";	break;
							case 3:	echo "<td bgcolor=#e28b00>$oz</td>";	break;
							case 4:	echo "<td bgcolor=#adff2f>$oz</td>";	break;
							case 5:	echo "<td bgcolor=#0bda51>$oz</td>";	break;
    					}
    					if ($test_corr[$res_id]!=0)
    					{
    						$proz_corr=$res_correct[$res_id];
							if ($proz_corr>$key['proz'])
							{
								$color="4682b4";
							}
							else
							{
								$color="cd5c5c";
							}
							echo "<td bgcolor=$color>$proz_corr</td>";
							$oz=$ozenka_corr[$res_id];
							switch ($oz) 
							{
								case 2:	echo "<td bgcolor=#db7093>$oz</td>";	break;
								case 3:	echo "<td bgcolor=#e28b00>$oz</td>";	break;
								case 4:	echo "<td bgcolor=#adff2f>$oz</td>";	break;
								case 5:	echo "<td bgcolor=#0bda51>$oz</td>";	break;
    						}
    					}
    					else
    					{
    						echo "<td colspan=2>Нет данных</td>";	
    					}
    				}
    				if (($key['timeend'] == 0) && ($key['timebeg']>$time))
    				{
    					echo "<tr>
						<td>
						<div style=\"width:150px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" onclick=\"func_view(".$pers_info[$res_id]['user_id'].")\">
							".$pers_info[$res_id]['name']."
						</div></td>
						<td>".$pers_info[$res_id]['group']."</td>
						<td>".$disc_name[$res_id]['name']."</td>
						<td>".$test_name[$res_id]."</td>
						<td>".$key['data']."</td>";
						$cmpl = round(($endless_res[$key['id']]['cmpl']/$endless_res[$key['id']]['all'])*100,1);
						$balls = round(($endless_res[$key['id']]['summ']/$endless_res[$key['id']]['all'])*100,1);
						$otn = round(($endless_res[$key['id']]['summ']/$endless_res[$key['id']]['cmpl'])*100,1);
						$razn = $cmpl - $balls;
						echo "<td colspan=5>
							<div class=\"progress\">
								<div class=\"bar bar-success\" style=\"width: ".$balls."%;\" id=bar_true".$key['id']."></div>
 								<div class=\"bar\" style=\"width: ".$razn."%;\" id=bar_razn".$key['id']."></div>
							</div>
							<table style=\"font-size:10px;width:100%\"><tr><td>Текущий результат (%):</td><td align=center><div id=summ".$key['id'].">$otn</div></td><td>Выполнено (%)</td><td align=center><div id=cmpl".$key['id'].">$cmpl</div></td></tr></table>
							</td>";
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