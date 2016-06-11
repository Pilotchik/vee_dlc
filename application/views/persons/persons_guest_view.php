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
			
			function func_edit(id_p,lname,fname,type)	
			{
				$('#root').fadeOut("slow");
				$('#root3').fadeIn("slow");
				if (type==1) 
				{
					document.getElementById('perevod').innerHTML="<select class=inputbox name=new_group><?php	foreach ($fspo_groups as $key){	$id_gr=$key['id'];	$name_gr=$key['name_numb'];	echo "<option value=$id_gr>$name_gr</option>";}?></select>";
				} 
				else 
				{
					document.getElementById('perevod').innerHTML="<select class=inputbox name=new_group><?php	foreach ($segrys_groups as $key){	$id_gr=$key['id'];	$name_gr=$key['name_numb'];	echo "<option value=$id_gr>$name_gr</option>";}?></select>";
				}
				document.getElementById('lname_input').innerHTML="<input class=inputbox name=lname value=\""+lname+"\" size=30 type=text>";
				document.getElementById('fname_input').innerHTML="<input class=inputbox name=fname value=\""+fname+"\" size=30 type=text>";
				document.getElementById('hidden_id').innerHTML="<input type=hidden name=id_p value="+id_p+">";
			}

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#root').fadeIn("slow");
			}	

			function func_edit_send()	{document.editForm.submit();}	
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
				<form action="<?php echo base_url()?>persons/guest_edit" method="post" name="editForm"  autocomplete="off">
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
			<h3>Гости</h3>
			<table align="left">
				<tr>
					<td>
						<form action="<?php echo base_url()?>persons/guest" method="post" name="filterForm">
							Тип: <select name="filter_type" onChange="javascript: func_filter()">
								<option value=""></option>
								<option value="99">Все</option>
								<option value="1">ИТМО</option>
								<option value="2">Сегрис</option>
							</select>
						</form>
					</td>
				</tr>
			</table>
			<br />
			<table class="sortable" id="persons">
				<thead>
					<tr>
						<td align="center"><b>Фамилия Имя</b></td>
						<td align="center"><b>Дата регистрации</b></td>
						<td align="center"><b>Тип</b></td>
						<td align="center"><b>Телефон</b></td>
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
					$date_r=$key['data_r'];
					echo "<td>$date_r</td>";
					$type_r=$key['type_r'];
					if ($type_r=='1') {echo "<td>ИТМО</td>";} else {echo "<td>Сегрис</td>";}
					$phone=$key['phone'];
					echo "<td>$phone</td>";
					echo "<td><div style=\"width:100px;margin:0 0 0 0;font-size:11px\" class=\"btn btn-inverse\" onclick=\"func_edit($id_p,'$lname','$fname','$type_r')\">Изменение</div></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("persons","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
	</body>
</html>