<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Дисциплины системы тестирования</li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Дисциплина</b></td>
						<td align="center"><b>Комментарий</b></td>
						<td align="center"><b>Активность</b></td>
						<td align="center"><b>Курсы</b></td>
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
						if ($key['active'] == 0) {$active_name="<i class=\"icon-eye-close\"></i>";} else {$active_name="<i class=\"icon-eye-open\"></i>";}
						echo "<td>$active_name</td>
						<td>
						<form style=\"margin:0 0 0 0;\" action=\"".base_url()."de_admin/courses_view/$dest/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
							<input style=\"width:100px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form>
						</td>
					</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br>
		</div>
	</body>
</html>