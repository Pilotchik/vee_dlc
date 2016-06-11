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
  				<li class="active">Дисциплины с дистанционными курсами</li>
			</ul>
			<table class="sortable" border=1 id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Дисциплина</b></td>
						<td align="center"><b>Курсы</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($disciplines as $key)
				{
					$id_dsc=$key['id'];
					echo "<tr>
						<td align=center>".$key['name_test']."</td>
						<td align=center>
							<form style=\"margin:0 0 0 0;\" action=\"".base_url()."de/view_courses/$id_dsc\" method=\"get\" name=\"edit$id_dsc\">
								<input type=\"submit\" style=\"margin:0 0 0 0;\" class=\"btn btn-inverse\" value=\"Просмотр\">
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