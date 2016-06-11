<html>
	<head>
		<title>Система тестирования. Студенты ФСПО</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
			});
			
			
			function func_edit(id_p,lname,fname)	
			{
				$('#root').fadeOut("slow");
				$('#root3').fadeIn("slow");
				document.getElementById('perevod').innerHTML="<select class=inputbox name=new_group><?php	foreach ($fspo_groups as $key){	$id_gr=$key['id'];	$name_gr=$key['name_numb'];	echo "<option value=$id_gr>$name_gr</option>";}?></select>";
				document.getElementById('lname_input').innerHTML=lname;
				document.getElementById('fname_input').innerHTML=fname;
				document.getElementById('hidden_id').innerHTML="<input type=hidden name=id_p value="+id_p+">";
			}

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#root').fadeIn("slow");
			}

			function func_edit_send() {document.editForm.submit();}	
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
				<form action="<?php echo base_url()?>persons/perevod_edit" method="post" name="editForm"  autocomplete="off">
				<h1>Изменение информации о пользователе</h1>
				<br />
				<table>
					<tr>
						<td align="right">Имя:</td>
						<td align="center">
							<div id="fname_input"></div>
						</td>
					</tr>
					<tr>
						<td align="right">Фамилия:</td>
						<td align="center">
							<div id="lname_input"></div>
						</td>
					</tr>
					<tr>
						<td align="right">Перевод:</td>
						<td align="center">
							<div id="perevod"></div>
						</td>
					</tr>
				</table>
				<br />
				<div id="hidden_id"></div>
				</form>
				<div class="btn-group">
					<div style="width:150px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()">
						<i class="icon-arrow-left icon-white"></i> Отмена
					</div>
					<div style="width:150px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_send()">
						<i class="icon-ok icon-white"></i> Изменить
					</div>
				</div>
			</center>
		</div>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<h3>Студенты НОУ "СЕГРИС-ИИТ"</h3>
			<table class="sortable" id="persons">
				<thead>
					<tr>
						<td align="center"><b>Фамилия Имя</b></td>
						<td align="center"><b>Изменить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($persons as $key)
				{
					$id_p=$key['id'];
					echo "<tr>";
					$lname=$key['lastname'];
					$fname=$key['firstname'];
					$name_p=$lname." ".$fname;
					echo "<td>$name_p</td>";
					echo "<td><div style=\"width:100px;margin:0 0 0 0;font-size:11px\" class=\"btn btn-inverse\" onclick=\"func_edit($id_p,'$lname','$fname')\">Изменение</div></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("persons","hoverRow","clickedRow",false);
			</script>
			<br>
		</div>
	</body>
</html>