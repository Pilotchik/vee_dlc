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

		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Выбор презентации для управления показом</li>
			</ul>
			<table class="sortable" id="groups" style="font-size:10px;">
				<thead>
					<tr>
						<td align="center"><b>Название</b></td>
						<td align="center"><b>Автор</b></td>
						<td align="center"><b>Дата создания</b></td>
						<td align="center"><b>Действие</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($presents as $key)
				{
					$id_c=$key['id'];
					echo "<tr>
						<td align=center>".$key['present_name']."</td>
						<td align=center>".$author[$key['id']]."</td>
						<td align=center>".$key['date']."</td>
						<td align=center>
							<form action=\"".base_url()."present_admin/present_view/$id_c\" method=\"get\" name=\"edit$id_c\">
								<input style=\"width:90px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Запуск\">
							</form>
						</td>
					</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
	</body>
</html>