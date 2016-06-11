<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_open_create_dsc()		{$('#myModalCode').modal('show');}
			function func_create()	{document.createForm.submit();}

			function func_edit(id_th)
			{
				name=prompt("Введите новое название темы");
				if (name!='null')
				{
					document.getElementById('th_id').innerHTML="<input type=hidden name=th_id value=\""+id_th+"\">";
					document.getElementById('th_name').innerHTML="<input type=hidden name=th_name value=\""+name+"\">";
					document.editForm.submit();
				}
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<div id="myModalCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание новой темы в дисциплине</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>plans/create_theme/<?php echo $dest;?>/<?php echo $id_disc;?>" method="post" name="createForm" autocomplete="off">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название</td>
						<td align="left" width="60%">
							<input class="inputbox" name="th_name" size="20" type="text">
							<input type="hidden" name="disc_id" value="<?php echo $id_disc;?>">
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

		<form action="<?php echo base_url();?>plans/theme_edit/fspo/<?php echo $id_disc;?>" method="post" name="editForm">
			<div id="th_id"></div>
			<div id="th_name"></div>
		</form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>plans/view/<?php echo $dest;?>"><?php echo $dest_name;?></a> <span class="divider">/</span></li>
  				<li class="active">Темы дисциплины "<?php echo $disciplin[0]['name_test'];?>"</li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Тема</b></td>
						<td align="center"><b>Изменить</b></td>
						<td align="center"><b>Удалить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($themes as $key)
				{
					$id_th=$key['id_theme'];
					echo "<tr>
					<td>".$key['name_th']."</td>
					<td align=center>
						<div style=\"margin:0 0 0 0;width:100px\" class=\"btn btn-inverse\" onClick=\"javascript: func_edit($id_th)\">Изменить</div>
					</td>
					<td>
					<form action=\"".base_url()."plans/theme_del/$dest/$id_disc/$id_th\" method=\"post\" name=\"edit$id_th\">
						<center><input style=\"margin:0 0 0 0;width:100px\" class=\"btn btn-inverse\" type=\"submit\" value=\"Удалить\"></center>
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