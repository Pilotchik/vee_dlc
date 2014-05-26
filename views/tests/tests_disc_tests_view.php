<html>
	<head>
		<title>ВОС</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_open_create_dsc()	{$('#myModalCreate').modal('show');}
			function func_create()			{document.createForm.submit();}

			function func_edit(id_q,type)
			{
				text = '';
				$('#myModalConfirm').modal('show');
				switch (type) 
				{
					case 'name_razd': text = 'Введите новое название теста'; break;
					case 'active': text = '0 - тест не увидят студенты, 1 - тест будет в списке доступных для прохождения'; break;
					case 'comment': text = 'Введите новый текст комментария (необходим для администрирования)'; break;
					case 'kod': text = 'Введите новый код доступа к тесту'; break;
					case 'time_long': text = 'Укажите время (в минутах) на тест'; break;
					case 'three': text = 'Укажите количество процентов, необходимых для получения тройки'; break;
					case 'four': text = 'Укажите количество процентов, необходимых для получения четвёрки'; break;
					case 'five': text = 'Укажите количество процентов, необходимых для получения пятёрки'; break;
					case 'stud_view': text = '0 - доступ к ответам студентам запрещён, 1 - разрешён'; break;
				}
				$('#text_param').html(text);
				$('#q_id').html("<input type=hidden name=q_id value=\""+id_q+"\">");
				switch (type) 
				{
					case 'name_razd': $('#q_value_text').val($('#text'+id_q).html()); break;
					case 'comment': $('#q_value_text').val($('#comm'+id_q).html()); break;
					case 'kod': $('#q_value_text').val($('#kod'+id_q).html()); break;
					case 'time_long': $('#q_value_text').val($('#long'+id_q).html()); break;
					case 'three': $('#q_value_text').val($('#three'+id_q).html()); break;
					case 'four': $('#q_value_text').val($('#four'+id_q).html()); break;
					case 'five': $('#q_value_text').val($('#five'+id_q).html()); break;
				}
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
		<style>
			input[type="submit"] {width:100px;margin:0 0 0 0;font-size:10px;}
		</style>
	</head>
	<body>
		<div id="myModalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение параметров</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param"></div></p>
  				<form action="<?php echo base_url();?>tests/test_edit/<?php echo $dest."/".$id_disc;?>" method="post" name="editForm">
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
    			<h3 id="myModalLabel">Создание нового теста</h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>tests/create_test/<?php echo $dest."/".$id_disc;?>" method="post" name="createForm" autocomplete="off">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название теста</td>
						<td align="left" width="60%">
							<input class="inputbox" name="test_name" size="50" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Комментарий</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="comment" cols="40" rows="5"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Время на тест</td>
						<td align="left" width="60%">
							<input class="inputbox" name="test_time" size="20" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Обучающий тест</td>
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
    			<h3 id="myModalLabel">Удаление теста</h3>
  			</div>
  			<div class="modal-body">
  				<p>Вы действительно хотите удалить тест <b>"<span id="q_value_text_del"></span>"</b>?</p>
  				<form action="<?php echo base_url();?>tests/del_test/<?php echo $dest."/".$id_disc;?>" method="post" name="delForm">
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
  				<li><a href="<?php echo base_url();?>tests/dest_view/<?php echo $dest;?>">Управление тестами. Дисциплины</a> <span class="divider">/</span></li>
  				<li class="active">Тесты дисциплины "<?php echo $disciplin[0]['name_test'];?>"</li>
			</ul>
			<table class="sortable" border=1 id="groups" width="100%" style="font-size:10px;margin:10px 0;">
				<thead>
					<tr>
						<td align="center"><b>Название</b></td>
						<td align="center"><b>Дата создания</b></td>
						<td align="center"><b>Вкл</b></td>
						<td align="center"><b>Комментарий</b></td>
						<td align="center"><b>Код</b></td>
						<td align="center"><b>Время</b></td>
						<td align="center"><b>Состав</b></td>
						<td align="center"><b>Список</b></td>
						<td align="center"><b>Блокировка</b></td>
						<td align="center"><b>3</b></td>
						<td align="center"><b>4</b></td>
						<td align="center"><b>5</b></td>
						<td align="center"><b>Статус</b></td>
						<td align="center"><b>Доступ<br />к ответам</b></td>
						<td align="center"><b>Удалить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($razdels as $key)
				{
					$id_r=$key['id'];
					echo "<tr>
					<td align=center>
						<div onClick=\"func_edit($id_r,'name_razd')\" id=\"text$id_r\">".$key['name_razd']."</div>
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
						<div onClick=\"javascript: func_edit($id_r,'kod')\" id=\"kod$id_r\">".($key['kod'] == 0 ? "обучающий" : "$code")."</div>
					</td>
					<td align=center>
						<div onClick=\"javascript: func_edit($id_r,'time_long')\" id=\"long$id_r\">".$key['time_long']."</div>
					</td>
					<td>
						<form action=\"".base_url()."tests/test_view/$dest/$id_disc/$id_r\" method=\"post\" name=\"edit$id_r\">
							<input style=\"width:100px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form>
					</td>
					<td>
						<form action=\"".base_url()."tests/test_full_view/$dest/$id_disc/$id_r\" method=\"post\" name=\"edit$id_r\">
							<input style=\"width:100px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Список\">
						</form>
					</td>
					<td>
						<form action=\"".base_url()."tests/themes_block/$dest/$id_disc/$id_r\" method=\"post\" name=\"edit$id_r\">
							<input style=\"width:100px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Правила\">
						</form>
					</td>
					<td align=center>
						<div onClick=\"javascript: func_edit($id_r,'three')\" id=\"three$id_r\">".$key['three']."</div>
					</td>
					<td align=center>
						<div onClick=\"javascript: func_edit($id_r,'four')\" id=\"four$id_r\">".$key['four']."</div>
					</td>
					<td align=center>
						<div onClick=\"javascript: func_edit($id_r,'five')\" id=\"five$id_r\">".$key['five']."</div>
					</td>
						".($key['view'] == 0 ? "<td bgcolor=red>Пустой" : "<td bgcolor=green>OK")."
					</td>
					<td align=center>
						<div onClick=\"func_edit($id_r,'stud_view')\">".($key['stud_view'] == 0 ? "<i class=\"icon-eye-close\"></i>" : "<i class=\"icon-eye-open\"></i>")."</div>
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
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_open_create_dsc()">
				<i class="icon-plus icon-white"></i> Создать тест
			</div>
			</center>
		</div>
	</body>
</html>