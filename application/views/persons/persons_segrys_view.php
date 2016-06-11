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
			
			function func_edit(id_p,lname,fname,level,group,mail)	
			{
				$('#root').fadeOut("slow");
				$('#root3').fadeIn("slow");
				if (level==2) {level="Преподаватель";} 
				if (level==3) {level="Администратор";}
				if (level==1) {level="Студент";}
				document.getElementById('level').innerHTML=level;
				document.getElementById('group').innerHTML=group;
				document.getElementById('lname_input').innerHTML="<input class=inputbox name=lname value=\""+lname+"\" size=30 type=text>";
				document.getElementById('fname_input').innerHTML="<input class=inputbox name=fname value=\""+fname+"\" size=30 type=text>";
				document.getElementById('mail_input').innerHTML="<input class=inputbox name=email value=\""+mail+"\" size=30 type=text>";
				document.getElementById('hidden_id').innerHTML="<input type=hidden name=id_p value="+id_p+">";
				document.getElementById('hidden_id_del').innerHTML="<input type=hidden name=id_p value="+id_p+">";
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

			function func_edit_del() 
			{
				if (confirm("Удалить?")) 
				{
					document.delForm.submit();	
				}
			}	

			function func_filter()	{document.filterForm.submit();}
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
				<form action="<?php echo base_url();?>persons/students_segrys_del" method=post name="delForm">
					<div id="hidden_id_del"></div>
				</form>
				<form action="<?php echo base_url();?>persons/students_segrys_edit" method="post" name="editForm"  autocomplete="off">
				<h1>Изменение информации о пользователе</h1>
				<br />
				<table>
					<tr>
						<td align="right">Имя:</td>
						<td align="center" colspan="2">
							<div id="fname_input"></div>
						</td>
					</tr>
					<tr>
						<td align="right">Фамилия:</td>
						<td align="center" colspan="2">
							<div id="lname_input"></div>
						</td>
					</tr>
					<tr>
						<td align="right">Права:</td>
						<td align="center">
							<div id="level"></div>
						</td>
						<td>
							<select class="inputbox" name="level">
								<option value="1">Студент</option>
								<option value="2">Преподаватель</option>
								<option value="3">Администратор</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Перевод:</td>
						<td align="center">
							<div id="group"></div>
						</td>
						<td>
							<select class="inputbox" name="new_group">
								<option value="0"></option>
								<?php
								foreach ($groups as $key)
								{
									$id_gr=$key['id'];
									$name_gr=$key['name_numb'];
									echo "<option value=\"$id_gr\">$name_gr</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Почтовый адрес:</td>
						<td colspan="2">
							<div id="mail_input"></div>
						</td>
					</tr>
				</table>
				<div id="hidden_id"></div>
				</form>
				<div class="btn-group">
					<div style="width:150px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()">
						<i class="icon-arrow-left icon-white"></i> Отмена
					</div>
					<div style="width:150px;margin:10px 0 10px 0;" class="btn btn-danger" onClick="javascript: func_edit_del()">
						<i class="icon-remove icon-white"></i> Отчислить
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
			<h3>Студенты НОУ "Сегрис-ИИТ"</h3>
			<table align="left">
				<tr>
					<td>
						<form action="<?php echo base_url()?>persons/students_segrys" method="post" name="filterForm">
							Курс: <select name="filter_plosh" onChange="javascript: func_filter()">
								<option value=""></option>
								<option value="99">Все</option>
								<?php
								foreach ($plosh as $key)
								{
									$id_plosh=$key['id_plosh'];
									$name_plosh=$key['name_plosh'];
									echo "<option value=\"$id_plosh\">$name_plosh</option>";
								}
								?>
							</select>
						</form>
					</td>
				</tr>
			</table>
			<br />
			<table class="sortable" border=1 id="persons" width="100%">
				<thead>
					<tr>
						<td align="center"><b>#</b></td>
						<td align="center"><b>Фамилия Имя</b></td>
						<td align="center"><b>Связь</b></td>
						<td align="center"><b>Изменить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($groups as $key)
				{
					$id_gr=$key['id'];
					if(isset($persons[$id_gr]))
					{
						echo "<tr><td colspan=4><b>".$key['name_numb'].": ".$plosh_name[$id_gr]['plosh']."</b></td></tr>";
						$i=1;
						foreach ($persons[$id_gr] as $key2)
						{
							$id_p=$key2['id'];
							echo "<tr>";
							echo "<td>".$i."</td>";	
							echo "<td>".$key2['lastname']." ".$key2['firstname']."</td>";
							echo "<td>".$key2['mail']."</td>";
							$mail=$key2['mail'];
							if ($mail=='') {$mail=0;}
							echo "<td><div style=\"width:100px;margin:0 0 0 0;font-size:11px\" class=\"btn btn-inverse\" onclick=\"func_edit($id_p,'".$key2['lastname']."','".$key2['firstname']."',1,'".$key['name_numb']."','$mail')\">Изменить</div></td>";
							echo "</tr>";
							$i++;
						}
					}
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