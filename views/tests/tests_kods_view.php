<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_filter()	{document.filterForm.submit();}

			function func_edit(id_q,type)
			{
				text = '';
				$('#myModalConfirm').modal('show');
				$('#text_param').html('Введите новый код доступа к тесту');
				$('#q_id').html("<input type=hidden name=q_id value=\""+id_q+"\">");
				$('#q_value_text').val($('#kod'+id_q).html());
				$('#q_param').html("<input type=hidden name=q_param value=\""+type+"\">");
			}

			function send_editForm()	{document.editForm.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>

		<div id="myModalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение кода</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param"></div></p>
  				<form action="<?php echo base_url();?>tests/kod_edit" method="post" name="editForm">
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

		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<h3>Ключи тестов</h3>
			<p>Нажмите на код, чтобы его изменить</p>
			<table align="left" style="font-size:11px;">
				<tr>
					<td>
						<form action="<?php echo base_url()?>tests/kods" method="post" name="filterForm">
							Тип: <select name="filter_type" onChange="javascript: func_filter()">
								<option value=""></option>
								<option value="4">Все</option>
								<option value="1">ФСПО</option>
								<option value="2">Сегрис</option>
								<option value="3">Универсальная</option>
							</select>
						</form>
					</td>
				</tr>
			</table>
			<br />
			<br />
			<table class="sortable" id="kods" style="font-size:11px;">
				<thead>
					<tr>
						<td align="center"><b>Тип</b></td>
						<td align="center" width="35%"><b>Дисциплина</b></td>
						<td align="center" width="35%"><b>Раздел</b></td>
						<td align="center" width="10%"><b>Код</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($kods as $key)
				{
					$id_r = $key['id'];
					if ($key['type_r'] == 1) {$tmp="ФСПО";$tcolor = "yellow";}
					if ($key['type_r']==2) {$tmp="Сегрис";$tcolor = "#abcdef";}
					if ($key['type_r']==3) {$tmp="Универсальная";$tcolor = "white";}
					echo "<tr bgcolor=$tcolor>
						<td>$tmp</td>
						<td>".$key['name_test']."</td>
						<td>".$key['name_razd']."</td>";
					$tmp=$key['kod'];
					echo "<td><b><div onClick=\"javascript: func_edit($id_r,'kod')\" id=\"kod$id_r\">".($key['kod'] == 0 ? "обучающий" : "$tmp")."</div></b></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				//Подсветка по клику и при наведении мышки на ряд, множественный выбор по клику разрешен
				highlightTableRows("kods","hoverRow","clickedRow",false);
			</script>
			<br>
		</div>
	</body>
</html>