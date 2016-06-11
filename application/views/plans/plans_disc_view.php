<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_open_create_dsc() {$('#myModalCode').modal('show');}
			function func_create()	{document.createForm.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			#root 	{margin:15px 0 0 0;}
			input[type="submit"] {width:100px;margin:0 0 0 0;font-size:11px;}
		</style>
	</head>
	<body>
		<div id="myModalCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание новой дисциплины</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>plans/create_disc/<?php echo $dest;?>" method="post" name="createForm" autocomplete="off">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название</td>
						<td align="left" width="60%">
							<input class="inputbox" name="disc_name" size="20" type="text">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Отображение в системе</td>
						<td align="left" width="60%">
							<select name="active">
								<option value="0">Выкл</option>
								<option value="1">Вкл</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Комментарий</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="comment" cols="40" rows="5"></textarea>
						</td>
					</tr>
				</table>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" onClick="func_create()">Создать</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active"><?php echo $dest_name;?></li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Дисциплина</b></td>
						<td align="center"><b>Комментарий</b></td>
						<td align="center"><b>Активность</b></td>
						<td align="center"><b>Изменить</b></td>
						<td align="center"><b>Состав</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($disciplines as $key)
				{
					$id_dsc=$key['id'];
					echo "<tr>
					<td>".$key['name_test']."</td>
					<td>".$key['comment']."</td>";
					$active=$key['active'];
					if ($active==0) {$active_name="<i class=\"icon-eye-close\"></i>";} else {$active_name="<i class=\"icon-eye-open\"></i>";}
					echo "<td>$active_name</td>
					<td>
						<form action=\"".base_url()."plans/edit/$dest/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input class=\"btn btn-inverse\" type=\"submit\" value=\"Изменение\">
						</form>
					</td>
					<td>
						<form action=\"".base_url()."plans/disc_view/$dest/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form>
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
				<i class="icon-plus icon-white"></i> Создать
			</div>
			</center>
		</div>
	</body>
</html>