<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.nazad.submit();}
			function func_home()	{document.home.submit();}

			function func_open_create_dsc()
			{
				$(".createDscForm").slideToggle("slow");
				var height= $(".createDscForm").height()+$("root").height()+$(".table_big").height()+50; 
				$("html,body").animate({"scrollTop":height},"slow");
			}

			function func_create()
			{
				document.createForm.submit();	
			}

			function func_del(id_q)
			{
				if (confirm("Удалить блокировку?")) 
				{
					document.getElementById('q_id_del').innerHTML="<input type=hidden name=block_id value=\""+id_q+"\">";
					document.delForm.submit();	
				}
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form 	{margin:0 0 0 0;}
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>tests/disc_view/<?php echo $dest."/".$id_disc;?>" method=post name=nazad></form>
		<form action="<?php echo base_url();?>main/auth" method=post name="home"></form>
		<form action="<?php echo base_url();?>tests/block_del/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="delForm">
			<div id="q_id_del"></div>
		</form>
		<center>
		<?php if ($error!="") { echo "<script type=\"text/javascript\">$(document).ready(function() {alert('$error')});</script>";}?>
		<div id="root" style="width:900;">
			<br />
			<h1><?php echo $disciplin[0]['name_test'];?>: <?php echo $razdel[0]['name_razd'];?></h1>
		</div>
		<div id="root" style="width:900;" class="table_big">
			<h1>Блокировка тем теста для групп</h1>
			<br />
			<table class="sortable" border=1 id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Тема</b></td>
						<td align="center"><b>Группа</b></td>
						<td align="center"><b>Удаление</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($block as $key)
				{
					$id_block=$key['id'];
					echo "<tr>";
					$name_th=$key['name_th'];
					echo "<td><center>$name_th</center></td>";
					$name_gr=$key['name_numb'];
					echo "<td><center>$name_gr</center></td>";
					echo "<td><center>
					<div id=input2 onClick=\"javascript: func_del($id_block)\">Удалить</div>
					</center></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_open_create_dsc()">
				<i class="icon-plus icon-white"></i> Создать блокировку
			</div>
		</div>
		<div id="root" class="createDscForm" style="width:900;display:none;">
			<h1>Добавить блокировку</h1>
			<form action="<?php echo base_url()?>tests/create_block/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Тема</td>
						<td align="left" width="60%">
							<SELECT NAME="bl_theme">
								<?php
								foreach ($themes as $key)
								{
									$id_th=$key['id_theme'];
									$name_theme=$key['name_th'];
									echo "<option value=$id_th>$name_theme";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Тема</td>
						<td align="left" width="60%">
							<SELECT NAME="bl_gr">
								<?php
								foreach ($groups as $key)
								{
									$id_gr=$key['id'];
									$name_gr=$key['name_numb'];
									echo "<option value=$id_gr>$name_gr";
								}
								?>
							</select>
						</td>
					</tr>
				</table>
			</form>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_create()">
				<i class="icon-plus icon-white"></i> Создать блокировку
			</div>
		</div>
		<div id="root" style="width:900;margin:15px 0 0 0;">
			<div class="btn-group">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
					<i class="icon-arrow-left icon-white"></i> Назад
				</div>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_home()">
					<i class="icon-home icon-white"></i> Главное меню
				</div>
			</div>
		</div>
	</body>
</html>