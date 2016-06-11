<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_edit_send()	{document.editForm.submit();}
			function func_delete_gr()
			{
				if (confirm("Удалить дисциплину?")) 
				{
					document.delForm.submit();	
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
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>plans/view/<?php echo $dest;?>"><?php echo $dest_name;?></a> <span class="divider">/</span></li>
  				<li class="active">Изменение информации о дисциплине "<?php echo $disciplin[0]['name_test'];?>"</li>
			</ul>
			<form action="<?php echo base_url()?>plans/disc_edit/<?php echo $dest;?>" method="post" name="editForm"  autocomplete="off">
				<table width="50%">
					<tr>
						<td align="right">Название:</td>
						<td colspan="2" align="center">
							<input class="inputbox" name="disc_name" value="<?php echo $disciplin[0]['name_test'];?>" type="text" style="height:30px;width:100%;text-align:center;">
						</td>
					</tr>
					<tr>
						<td align="right">Отображение при регистрации:</td>
						<td align="center" width="30%">
							<?php 
							if ($disciplin[0]['active']=='1')
								{
									$active="Вкл";
								}
								else
								{
									$active="Выкл";
								}
								echo "<b>$active</b>";
							?>
						</td>
						<td align="center">
							<select class="inputbox" name="active" >
								<option value="0">Выкл</option>
								<option value="1" selected>Вкл</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Комментарий:</td>
						<td colspan="2">
							<textarea class="inputbox" name="comment" cols="40" rows="5" style="height:90px;width:100%;">
								<?php echo $disciplin[0]['comment'];?>
							</textarea>
						</td>
					</tr>
				</table>
				<input type="hidden" name="id_disc" value="<?php echo $id_disc?>">
			</form>
			<form action="<?php echo base_url()?>plans/disc_del/<?php echo $dest;?>" method="post" name="delForm"  autocomplete="off">
				<input type="hidden" name="id_disc" value="<?php echo $id_disc?>">
			</form>
			<center>
			<div class="btn-group">
				<div style="width:160px;margin:10px 0 10px 0;" class="btn btn-danger" onClick="javascript: func_delete_gr()">
					<i class="icon-remove-sign icon-white"></i> Удалить
				</div>
				<div style="width:160px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_send()">
					<i class="icon-edit icon-white"></i> Изменить
				</div>
			</div>
			</center>
		</div>
	</body>
</html>