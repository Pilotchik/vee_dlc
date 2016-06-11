<html>
	<head>
		<title>Система тестирования. Персонал системы тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
			});
			
			function func_edit(id_p,name_p,level,mail)	
			{
				$('#root').fadeOut("slow");
				$('#root3').fadeIn("slow");
				document.getElementById('name_p').innerHTML=name_p;
				if (level==2) {level="Преподаватель";} else {level="Администратор";}
				document.getElementById('level').innerHTML=level;
				document.getElementById('mail_input').innerHTML="<input class=inputbox name=email value="+mail+" size=30 type=text>";
				document.getElementById('hidden_id').innerHTML="<input type=hidden name=id_p value="+id_p+">";
				document.getElementById('hidden_id2').innerHTML="<input type=hidden name=id_p value="+id_p+">";
			}

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#root').fadeIn("slow");
			}	

			function func_edit_send() 	{document.editForm.submit();}	
			function func_filter()		{document.filterForm.submit();}

			function func_del(id_gr,name_gr) 
			{
				$('#myModalDel').modal('show');
				document.getElementById('del_name').innerHTML = name_gr;
				document.getElementById('hidden_id2').innerHTML = "<input type=hidden name=id_p value="+id_gr+">";
			}
			function func_del_send()	{document.delForm.submit();}

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
				<form action="<?php echo base_url()?>persons/personal_edit" method="post" name="editForm"  autocomplete="off">
				<h1>Изменение информации о пользователе</h1>
				<br />
				<table>
					<tr>
						<td align="center" colspan="3">
							<div id="name_p"></div>
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
						<td align="right">Почтовый адрес:</td>
						<td colspan="2">
							<div id="mail_input"></div>
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

		<div id="myModalDel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Удаление сотрудника</h3>
  			</div>
  			<div class="modal-body">
  				<p>Вы действительно хотите удалить сотрудника: <h3><div id="del_name"></div></h3></p>
  				<form action="<?php echo base_url()?>persons/person_del" method="post" name="delForm"  autocomplete="off">
				<div id="hidden_id2"></div>
			</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="func_del_send()">Удалить</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Отмена</button>
  			</div>
		</div>
		

		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<h3>Персонал системы тестирования</h3>
			<table align="left">
				<tr>
					<td>
						<form action="<?php echo base_url()?>persons/personal" method="post" name="filterForm">
							Права: <select name="filter_guest" onChange="javascript: func_filter()">
								<option value=""></option>
								<option value="1">Все</option>
								<option value="2">Преподаватель</option>
								<option value="3">Администратор</option>
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
						<td align="center"><b>Права</b></td>
						<td align="center"><b>Адрес для отчётов</b></td>
						<td align="center" colspan="2"><b>Изменить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($persons as $key)
				{
					$id_p=$key['id'];
					echo "<tr>";
					$name_p=$key['lastname']." ".$key['firstname'];
					echo "<td>$name_p</td>";
					$level=$key['guest'];
					if ($level==2) {$level_name="Преподаватель";} else {$level_name="Администратор";}
					echo "<td>$level_name</td>";
					$mail=$key['mail'];
					echo "<td>$mail</td>";
					if ($mail=='') {$mail=0;}
					echo "<td><div style=\"width:100px;margin:0 0 0 0;font-size:11px\" class=\"btn btn-inverse\" onclick=\"func_edit($id_p,'$name_p',$level,'$mail')\">Изменение</div></td>
					<td align=center>
						<div onClick=\"func_del($id_p,'$name_p')\"><i class=\"icon-remove\"></i></div>
					</td>
					</tr>";
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