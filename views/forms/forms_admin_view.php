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

			function func_open_create_dsc()	{$('#myModalCode').modal('show');}
			function send_form()	{document.createForm.submit();}

			function func_del(id_q)
			{
				if (confirm("Удалить опрос? Опрос архивируется и доступен только при просмотре статистики")) 
				{
					document.getElementById('q_id_del').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
					document.delForm.submit();	
				}
			}

			function func_edit_active(id_q)
			{
				name=prompt("Активность опроса: 0 - не активен, 1 - активен");
				if (name!='null')
				{
					document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
					document.getElementById('q_param').innerHTML="<input type=hidden name=c_param value=active>";
					document.editForm.submit();
				}
			}

			function func_edit(id_q,par)
			{
				name=prompt("Публикация результатов (если они есть): 0 - результаты скрыты, 1 - результаты опубликованы");
				if (name!='null')
				{
					document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
					$("#q_param").html('<input type=hidden name=c_param value=\"'+par+'\">');
					document.editForm.submit();
				}
			}

			function func_edit_text(id_q)
			{
				name=prompt("Введите новое название опроса:");
				if (name!='null')
				{
					document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
					document.getElementById('q_param').innerHTML="<input type=hidden name=c_param value=title>";
					document.editForm.submit();
				}
			}

			function func_edit_description(id_q)
			{
				name=prompt("Введите новое описание опроса:");
				if (name!='null')
				{
					document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
					document.getElementById('q_param').innerHTML="<input type=hidden name=c_param value=description>";
					document.editForm.submit();
				}
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>admin" method="post" name="nazad"></form>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		
		<form action="<?php echo base_url();?>forms_admin/form_del" method="post" name="delForm">
			<div id="q_id_del"></div>
		</form></td>
		
		<form action="<?php echo base_url();?>forms_admin/form_edit" method="post" name="editForm">
			<div id="q_id"></div>
			<div id="q_value"></div>
			<div id="q_param"></div>
		</form>

		<div id="myModalCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание нового опроса</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>forms_admin/form_create" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название опроса</td>
						<td align="left" width="60%">
							<input type="text" class="inputbox" name="f_title" cols="30" rows="3" style="text-align:center;">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Описание</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="f_description" cols="30" rows="5"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Образовательное учреждение</td>
						<td align="left" width="60%">
							<SELECT NAME="f_type_r">
								<?php
								foreach ($all_type_reg as $key)
								{
									echo "<option value=".$key['id'].">".$key['name'];
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Тип доступа</td>
						<td align="left" width="60%">
							<SELECT NAME="f_access">
								<option value="0">Анонимный
								<option value="1">Публичный
							</select>
						</td>
					</tr>
				</table>
			</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_form()">Ок</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Управление опросами</li>
			</ul>
			<table class="sortable" id="groups" style="font-size:10px;">
				<thead>
					<tr>
						<td align="center"><b>ОУ</b></td>
						<td align="center"><b>Название</b></td>
						<td align="center"><b>Описание</b></td>
						<td align="center"><b>Активность</b></td>
						<td align="center"><b>Автор</b></td>
						<td align="center"><b>Дата создания</b></td>
						<td align="center"><b>Анонимность</b></td>
						<td align="center"><b>Просмотр результатов</b></td>
						<td align="center" colspan="2"><b>Действия</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($all_forms as $key)
				{
					$id_c=$key['id'];
					echo "<tr>";
					echo "<td align=center>".$type_r[$key['id']]."</td>";
					echo "<td align=center><div onClick=\"javascript: func_edit_text($id_c)\">".$key['title']."</div></td>";
					echo "<td align=center><div onClick=\"javascript: func_edit_description($id_c)\">".$key['description']."</div></td>";
					if ($key['active']==0) 
					{
						$active_name="<i class=\"icon-eye-close\"></i>";
					} 
					else 
					{
						$active_name="<i class=\"icon-eye-open\"></i>";
					}
					echo "<td align=center><div onClick=\"javascript: func_edit_active($id_c)\">$active_name</div></td>";
					echo "<td align=center>".$author[$key['id']]."</td>";
					echo "<td align=center>".$key['date']."</td>";
					if ($key['access']==0) 
					{
						$active_name="Анонимно";
					} 
					else 
					{
						$active_name="Публично";
					}
					echo "<td align=center>$active_name</td>";
					if ($key['public_res']==0) 
					{
						$active_name="<i class=\"icon-eye-close\"></i>";
					} 
					else 
					{
						$active_name="<i class=\"icon-eye-open\"></i>";
					}
					echo "<td align=center><div onClick=\"javascript: func_edit($id_c,'public_res')\">$active_name</div></td>";
					echo "<td><center>
					<form action=\"";
					echo base_url();
					echo "forms_admin/quest_view/$id_c\" method=\"get\" name=\"edit$id_c\">
						<input style=\"width:90px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
					</form></td>";
					echo "<td align=center><div onClick=\"javascript: func_del($id_c)\"><i class=\"icon-remove\"></i></div></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<center>
			<div style="width:206px;margin:30px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_open_create_dsc()">
				<i class="icon-plus icon-white"></i> Добавить опрос
			</div>
			</center>
		</div>
	</body>
</html>