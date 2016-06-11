<html>
	<head>
		<title>Система тестирования. Студенты ФСПО</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_edit(id_p,lname,fname,level,group)	
			{
				$('#myModalEdit').modal('show');
				if (level==2) {level="Преподаватель";} 
				if (level==3) {level="Администратор";}
				if (level==1) {level="Студент";}
				$('#level').html(level);
				$('#group').html(group);
				$('#lname_input').val(lname);
				$('#fname_input').val(fname);
				$('#hidden_id').val(id_p);
			}

			function func_del(id_gr,name_gr) 
			{
				$('#myModalDel').modal('show');
				document.getElementById('del_name').innerHTML = name_gr;
				document.getElementById('hidden_id2').innerHTML = "<input type=hidden name=id_p value="+id_gr+">";
			}
			function func_del_send()	{document.delForm.submit();}
			function func_filter()		{document.filterForm.submit();}
			function func_leto()		{document.letoForm.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form {margin:0 0 0 0;}
			#root 	{margin:15px 0 0 0;}
			.inputbox {font-size: 14px;height:30px;}
			td {vertical-align:center;padding-left: 5px;}
		</style>
	</head>
	<body>

	<div id="myModalEdit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
  			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
   			<h3 id="myModalLabel">Изменение информации о пользователе</h3>
		</div>
		<div class="modal-body">
			<form action="<?php echo base_url()?>persons/students_fspo_edit" method="post" autocomplete="off">
  				<table style="margin:0 auto;">
					<tr>
						<td align="right"><b>Имя:</b></td>
						<td align="center" colspan="2">
							<input class="inputbox" id="fname_input" name="fname" value="" size="30" type="text" style="font-size: 14px;height:30px;margin:0 auto;">
						</td>
					</tr>
					<tr>
						<td align="right"><b>Фамилия:</b></td>
						<td align="center" colspan="2">
							<input class="inputbox" id="lname_input" name="lname" value="" size="30" type="text" style="font-size: 14px;height:30px;margin:0 auto;">
						</td>
					</tr>
					<tr>
						<td align="right"><b>Права:</b></td>
						<td align="center">
							<div id="level"></div>
						</td>
						<td>
							<select class="inputbox" name="level" style="margin:0 auto;">
								<option value="1">Студент</option>
								<option value="2">Преподаватель</option>
								<option value="3">Администратор</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b>Перевод:</b></td>
						<td align="center">
							<div id="group"></div>
						</td>
						<td>
							<select class="inputbox" name="new_group" style="margin:0 auto;">
								<option value="0"></option>
								<?php
								foreach ($all_groups as $key)
								{
									$id_gr=$key['id'];
									$name_gr=$key['name_numb'];
									echo "<option value=\"$id_gr\">$name_gr</option>";
								}
								?>
							</select>
						</td>
					</tr>
				</table>
				<input type="hidden" name="id_p" value="" id="hidden_id">
			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" type="submit" style="width:100px">Изменить</button>
    			</form>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<div id="myModalDel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Удаление сотрудника</h3>
  			</div>
  			<div class="modal-body">
  				<p>Вы действительно хотите удалить студента: <h3><div id="del_name"></div></h3></p>
  				<form action="<?php echo base_url()?>persons/students_fspo_del" method="post" name="delForm"  autocomplete="off">
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
			<h3>Студенты ФСПО</h3>
			<table align="left">
				<tr>
					<td>
						<form action="<?php echo base_url()?>persons/students_fspo" method="post" name="filterForm">
							Курс: <select name="filter_guest" onChange="javascript: func_filter()">
								<option value=""></option>
								<option value="5">Все</option>
								<option value="1">Первый</option>
								<option value="2">Второй</option>
								<option value="3">Третий</option>
								<option value="4">Четвёртый</option>
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
						<td align="center" colspan="2"><b>Изменить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($groups as $key)
				{
					$id_gr=$key['id'];
					if(isset($persons[$id_gr]))
					{
						echo "<tr><td colspan=4><b>".$key['name_numb']."</b></td></tr>";
						$i=1;
						foreach ($persons[$id_gr] as $key2)
						{
							$id_p=$key2['id'];
							echo "<tr>
							<td>".$i."</td>
							<td>".$key2['lastname']." ".$key2['firstname']."</td>
							<td><div style=\"width:100px;margin:0 0 0 0;font-size:11px\" class=\"btn btn-inverse\" onclick=\"func_edit($id_p,'".$key2['lastname']."','".$key2['firstname']."',1,'".$key['name_numb']."')\">Изменение</div></td>
							<td align=center>
								<div onClick=\"func_del($id_p,'".$key2['lastname']." ".$key2['firstname']."')\"><i class=\"icon-remove\"></i></div>
							</td>
							</tr>";
							$i++;
						}
					}
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("persons","hoverRow","clickedRow",false);
			</script>
			<br>
			<h3>Перевести группу</h3>
			<form action="<?php echo base_url()?>persons/students_fspo_leto" method="post" name="letoForm">
			<table>
				<tr>
					<td>
						Студенты группы:
					</td>
					<td>
						<select class="inputbox" name="old_id">
						<option value="0"></option>
						<?php
						foreach ($all_groups as $key)
						{
							$id_gr=$key['id'];
							$name_gr=$key['name_numb'];
							echo "<option value=\"$id_gr\">$name_gr</option>";
						}
						?>
						</select>
					</td>
					<td>
						стали студентами:
					</td>
					<td>
						<select class="inputbox" name="new_id">
						<option value="0"></option>
						<?php
						foreach ($all_groups as $key)
						{
							$id_gr=$key['id'];
							$name_gr=$key['name_numb'];
							echo "<option value=\"$id_gr\">$name_gr</option>";
						}
						?>
						</select>
					</td>
					<td>
						<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_leto()">
							Перевести!
						</div>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>