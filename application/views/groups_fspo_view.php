<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_edit(id_gr,name_gr,active)	
			{
				$('#myModalConfirm').modal('show');
				document.getElementById('old_name').innerHTML=name_gr;
				if (active==0) {active="Выкл";} else {active="Вкл";}
				document.getElementById('active').innerHTML=active;
				document.getElementById('hidden_id').innerHTML="<input type=hidden name=id_gr value="+id_gr+">";
			}

			function func_edit_send() 	{document.editForm.submit();}	

			function func_del(id_gr,name_gr) 
			{
				$('#myModalDel').modal('show');
				document.getElementById('del_name').innerHTML = name_gr;
				document.getElementById('hidden_id2').innerHTML = "<input type=hidden name=id_gr value="+id_gr+">";
			}
			function func_del_send()	{document.delForm.submit();}

			function func_open_create()	{$('#myModalCode').modal('show');}
			function func_create()		{document.createForm.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<!-- Окно создания группы -->
		<div id="myModalCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание новой группы</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>groups/fspo_create" method="post" name="createForm" autocomplete="off">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название</td>
						<td align="left" width="60%">
							<input class="inputbox" name="old_name" size="20" type="text" style="width:150px;">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Отображение в системе</td>
						<td align="left" width="60%">
							<select name="active" style="width:150px;">
								<option value="0">Выкл</option>
								<option value="1">Вкл</option>
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

		<div id="myModalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение параметров</h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>groups/fspo_edit" method="post" name="editForm"  autocomplete="off">
				<table width="70%" style="margin:5 auto;">
					<tr>
						<td align="right">Название:</td>
						<td align="center" width=50%><div id="old_name"></div></td>
						<td>
							<input class="inputbox" name="old_name" value="" type="text" style="width:150px;text-align:center;font-size:16px;height: 30px;">
						</td>
					</tr>
					<tr>
						<td align="right">Отображение при регистрации:</td>
						<td align="center"><div id="active"></div></td>
						<td>
							<select class="inputbox" name="active" style="width:150px;">
								<option value="0">Выкл</option>
								<option value="1" selected>Вкл</option>
							</select>
						</td>
					</tr>
				</table>
				<div id="hidden_id"></div>
			</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="func_edit_send()">Изменить</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>
		
		<div id="myModalDel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Удаление группы</h3>
  			</div>
  			<div class="modal-body">
  				<p>Вы действительно хотите удалить группу <h3><div id="del_name"></div></h3></p>
  				<form action="<?php echo base_url()?>groups/fspo_del" method="post" name="delForm"  autocomplete="off">
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
			<h3>Группы НИУ ИТМО ФСПО</h3>
			<table class="sortable" border=1 id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Номер</b></td>
						<td align="center"><b>Отображение<br />в системе</b></td>
						<td align="center" colspan=2><b>Изменить</b></td>
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
					$active=$key['active'];
					if ($active==0) {$active_name="<i class=\"icon-eye-close\"></i>";} else {$active_name="<i class=\"icon-eye-open\"></i>";}
					echo "<td>$active_name</td>
					<td><div style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" onclick=\"func_edit($id_gr,'$name_gr',$active)\">Изменение</div></td>
					<td align=center>
						<div onClick=\"func_del($id_gr,'$name_gr')\"><i class=\"icon-remove\"></i></div>
					</td>
					</tr>";
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