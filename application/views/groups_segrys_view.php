<html>
	<head>
		<title>Система тестирования. Группы Сегрис-ИИТ</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
			});
			
			function func_edit(id_gr,name_gr,end,prepod)	
			{
				$('#root').fadeOut("slow");
				$('#root3').fadeIn("slow");
				document.getElementById('old_name').innerHTML=name_gr;
				document.getElementById('date_end').innerHTML=end;
				document.getElementById('prepod').innerHTML=prepod;
				document.getElementById('hidden_id').innerHTML="<input type=hidden name=id_gr value="+id_gr+">";
				document.getElementById('hidden_id2').innerHTML="<input type=hidden name=id_gr value="+id_gr+">";
			}

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#root').fadeIn("slow");
			}	

			function func_edit_send() 
			{
				document.editForm.submit();	
			}	

			function func_delete_gr() 
			{
				if (confirm("Удалить?")) 
				{
					document.delForm.submit();	
				}
			}	

			function func_open_create()	{$('#myModalCode').modal('show');}
			function func_create()		{document.createForm.submit();}
			function func_filter()		{document.filterForm.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<div id="root3">
			<center>
				<br />
				<form action="<?php echo base_url()?>groups/segrys_edit" method="post" name="editForm"  autocomplete="off">
				<h1>Изменение информации о группе</h1>
				<br />
				<table>
					<tr>
						<td align="right">Название:</td>
						<td align="center"><div id="old_name"></div></td>
						<td>
							<input class="inputbox" name="old_name" value="" size="20" type="text">
						</td>
					</tr>
					<tr>
						<td align="right">Дата окончания:</td>
						<td align="center"><div id="date_end"></div></td>
						<td>
							<input class="inputbox" name="date_end" value="" size="20" type="text">
						</td>
					</tr>
					<tr>
						<td align="right">Преподаватель:</td>
						<td align="center"><div id="prepod"></div></td>
						<td>
							<select class="inputbox" name="prepod">
								<?php 
								foreach ($prepods as $key) 
								{
									$id_pr=$key['id'];
									$name_pr=$key['name'];
									echo "<option value=\"$id_pr\">$name_pr</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Площадка:</td>
						<td align="center">&nbsp;</td>
						<td>
							<select class="inputbox" name="plosh">
								<?php 
								foreach ($plosh as $key) 
								{
									$id_pl=$key['id_plosh'];
									$name_pl=$key['name_plosh'];
									echo "<option value=\"$id_pl\">$name_pl</option>";
								}
								?>
							</select>
						</td>
					</tr>
				</table>
				<br />
				<div id="hidden_id"></div>
				</form>
				<form action="<?php echo base_url()?>groups/segrys_del" method="post" name="delForm"  autocomplete="off">
					<div id="hidden_id2"></div>
				</form>
				<div class="btn-group">
					<div style="width:150px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()">
						<i class="icon-arrow-left icon-white"></i> Отмена
					</div>
					<div style="width:150px;margin:10px 0 10px 0;" class="btn btn-danger" onClick="javascript: func_delete_gr()">
						<i class="icon-remove icon-white"></i> Удалить
					</div>
					<div style="width:150px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_send()">
						<i class="icon-ok icon-white"></i> Изменить
					</div>
				</div>
		</div>

		<!-- Окно создания группы -->
		<div id="myModalCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание новой группы</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>groups/segrys_create" method="post" name="createForm" autocomplete="off">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название</td>
						<td align="left" width="60%">
							<input class="inputbox" name="old_name" size="20" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Дата выпуска</td>
						<td align="left" width="60%">
							<input class="inputbox" name="date_end" size="20" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Уровень</td>
						<td align="left" width="60%">
							<select name="level">
								<option value="1">Базовая</option>
								<option value="2">Непрерывная</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Преподаватель</td>
						<td align="left" width="60%">
							<select class="inputbox" name="prepod">
								<?php 
								foreach ($prepods as $key) 
								{
									$id_pr=$key['id'];
									$name_pr=$key['name'];
									echo "<option value=\"$id_pr\">$name_pr</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Площадка</td>
						<td align="left" width="60%">
							<select class="inputbox" name="plosh">
								<?php 
								foreach ($plosh as $key) 
								{
									$id_pl=$key['id_plosh'];
									$name_pl=$key['name_plosh'];
									echo "<option value=\"$id_pl\">$name_pl</option>";
								}
								?>
							</select>
						</td>
					</tr>
				</table>
			</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="func_create()">Создать</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<h3>Группы НОУ "СЕГРИС-ИИТ"</h3>
			<table align="left">
				<tr>
					<td>
						<form action="<?php echo base_url()?>groups/segrys" method="post" name="filterForm">
							Дата окончания: <select name="year">
								<option value="">Все</option>
								<option value="2012">2012</option>
								<option value="2013">2013</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
							</select>
						</form>
					</td>
					<td>
						<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_filter()">
							<i class="icon-ok icon-white"></i> Фильтр
						</div>	
					</td>
				</tr>
			</table>
			<br />
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Номер</b></td>
						<td align="center"><b>Площадка</b></td>
						<td align="center"><b>Окончание обучения</b></td>
						<td align="center"><b>Преподаватель</b></td>
						<td align="center"><b>Изменить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($groups as $key)
				{
					$id_gr=$key['id'];
					echo "<tr>";
					$name_gr=$key['name_numb'];
					echo "<td>$name_gr</td>";
					$name_pl=$key['name_plosh'];
					echo "<td>$name_pl</td>";
					$end=$key['date_end'];
					echo "<td>$end</td>";
					$prepod_name=$key['name'];
					echo "<td>$prepod_name</td>";
					echo "<td><div style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" onclick=\"func_edit($id_gr,'$name_gr',$end,'$prepod_name')\">Изменение</div></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				//Подсветка по клику и при наведении мышки на ряд, множественный выбор по клику разрешен
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<center>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_open_create()">
				<i class="icon-plus icon-white"></i> Создать
			</div>
			</center>
		</div>
	</body>
</html>