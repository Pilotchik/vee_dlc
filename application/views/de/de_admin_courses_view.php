<html>
	<head>
		<title>Система тестирования. Дистанционные курсы.</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_open_create_dsc()
			{
				$('#myModalCreate').modal('show');
			}

			function func_create()	{document.createForm.submit();}

			function func_edit(id_q,type)
			{
				text = '';
				$('#myModalConfirm').modal('show');
				switch (type) 
				{
					case 'name': text = 'Введите новое название теста'; $('#q_value_text').val($('#text'+id_q).html()); break;
					case 'active': text = '0 - тест не увидят студенты, 1 - тест будет в списке доступных для прохождения'; break;
					case 'comment': text = 'Введите новый текст комментария (необходим для администрирования)'; $('#q_value_text').val($('#comm'+id_q).html()); break;
					case 'kod': text = 'Введите новый код доступа к тесту (0 - доступ будет открыт без кода)'; $('#q_value_text').val($('#kod'+id_q).html()); break;	
				}
				$('#text_param').html(text);
				$('#q_id').html("<input type=hidden name=q_id value=\""+id_q+"\">");
				$('#q_param').html("<input type=hidden name=q_param value=\""+type+"\">");
			}

			function send_editForm()	{document.editForm.submit();}

			function func_del(id_r)
			{
				$('#r_id_del').html("<input type=hidden name=r_id value=\""+id_r+"\">");
				$('#q_value_text_del').html($('#text'+id_r).html());
				$('#myModalDel').modal('show');
			}

			function send_delForm()		{document.delForm.submit();}

		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="myModalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение параметров обучающего курса</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param"></div></p>
  				<form action="<?php echo base_url();?>de_admin/edit_course/<?php echo $dest."/".$id_disc;?>" method="post" name="editForm">
					<textarea id="q_value_text" name="q_value" style="min-width:100%" rows="4"></textarea>
					<div id="q_id"></div>
					<div id="q_param"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_editForm()">Ок</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>
		
		<div id="myModalCreate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание нового удалённого курса</h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>de_admin/create_course/<?php echo $dest."/".$id_disc;?>" method="post" name="createForm" autocomplete="off">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название курса</td>
						<td align="left" width="60%">
							<input class="inputbox" name="course_name" size="50" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Комментарий</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="comment" cols="40" rows="5"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Свободный доступ</td>
						<td align="left" width="60%">
							<input type="checkbox" name="edu_test">
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

		<div id="myModalDel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Удаление курса</h3>
  			</div>
  			<div class="modal-body">
  				<p>Вы действительно хотите удалить курс <b>"<span id="q_value_text_del"></span>"</b>?</p>
  				<form action="<?php echo base_url();?>de_admin/del_course/<?php echo $dest."/".$id_disc;?>" method="post" name="delForm">
					<div id="r_id_del"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_delForm()">Удалить</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>
		
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>de_admin/disc_view/<?php echo $dest;?>">Управление ЭК. Дисциплины</a> <span class="divider">/</span></li>
  				<li class="active">Курсы дисциплины "<?php echo $disciplin[0]['name_test'];?>"</li>
			</ul>
			<table class="sortable" border=1 id="groups" width="100%" style="font-size:10px;margin:10px 0;">
				<thead>
					<tr>
						<td align="center"><b>Название</b></td>
						<td align="center"><b>Дата создания</b></td>
						<td align="center"><b>Вкл</b></td>
						<td align="center"><b>Комментарий</b></td>
						<td align="center"><b>Доступ</b></td>
						<td align="center"><b>Состав</b></td>
						<td align="center"><b>Удалить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($courses as $key)
				{
					$id_r = $key['id'];
					echo "<tr>
					<td align=center>
						<div onClick=\"func_edit($id_r,'name')\" id=\"text$id_r\">".$key['name']."</div>
					</td>
					<td align=center>".$key['data']."</td>
					<td align=center>
						<div onClick=\"func_edit($id_r,'active')\">".($key['active'] == 0 ? "<i class=\"icon-eye-close\"></i>" : "<i class=\"icon-eye-open\"></i>")."</div>
					</td>
					<td align=center>
						<div onClick=\"func_edit($id_r,'comment')\" id=\"comm$id_r\">".$key['comment']."</div>
					</td>";
					$code=$key['kod'];
					echo "
					<td align=center>
						<div onClick=\"javascript: func_edit($id_r,'kod')\" id=\"kod$id_r\">".($key['kod'] == 0 ? "свободный" : "$code")."</div>
					</td>
					<td align=center>
						<form action=\"".base_url()."de_admin/view_course/$dest/$id_disc/$id_r\" method=\"post\" name=\"edit$id_r\">
							<input style=\"width:100px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form>
					</td>
					<td align=center>
						<div onClick=\"func_del($id_r)\"><i class=\"icon-remove\"></i></div>
					</td>
					</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<center>
			<div style="width:206px;margin:10px auto;" class="btn btn-inverse" onClick="javascript: func_open_create_dsc()">
				<i class="icon-plus icon-white"></i> Создать
			</div>
			<center>
			<br>
		</div>
	</body>
</html>