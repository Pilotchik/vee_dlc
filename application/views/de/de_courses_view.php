<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_create(key,id_test)
			{
				$('#test_id').html("<input type=hidden name=course_id value=\""+id_test+"\">");
				if (key==1)
				{
					$('#myModalCode').modal('show');
					$('#name_text').html($('#name'+id_test).html());
					$('#test_key').html("<center><input type=text size=10 name=course_key autocomplete=off style='height: 30px;text-align: center;font-size: 16;'></center>");
				}
				else
				{
					$('#test_key').html("<input type=hidden name=course_key value=0>");
					send_form();
				}
			}

			function send_form()	{document.goForm.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="myModalCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Доступ к дистанционному курсу <b>"<span id="name_text"></span>"</b></h3>
  			</div>
  			<div class="modal-body">
  				<p>Введите ключ для доступа к курсу</p>
  				<form action="<?php echo base_url();?>de/play_course/<?php echo $disc_id;?>" method="post" name="goForm">
					<div id="test_id"></div>
					<div id="test_key"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_form()">Ок</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>de">Дисциплины</a> <span class="divider">/</span></li>
  				<li class="active"><?php echo $disc_name[0]['name_test'];?> - Учебные курсы</li>
			</ul>
			<table class="sortable" border=1 id="groups" width="100%">
				<thead>
					<tr>
						<td align="center" width="70%"><b>Тест</b></td>
						<td align="center"><b>Действие</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($courses_uncompleted as $key)
				{
					$id_dsc=$key['id'];
					echo "
					<tr>
						<td align=center><div id=\"name$id_dsc\">".$key['name'];
						if ($key['kod'] == 0)
						{
							echo " (код не требуется)";
						}
						echo "</div>
						</td>
						<td align=center>";
						if ($key['kod'] != 0)
						{?>
							<input type="button" style="width:150px;margin:0 0 0 0;" class="btn btn-inverse" value="Пройти курс" onClick="javascript: func_create(1,<?php echo $id_dsc;?>)">
						<?php
						}
						else
						{?>
							<input type="button" style="width:150px;margin:0 0 0 0;" class="btn btn-inverse" value="Пройти курс" onClick="javascript: func_create(0,<?php echo $id_dsc;?>)">
						<?php 
						}
					echo "</td>
					</tr>";
				}
				foreach ($courses_completed as $key)
				{
					$id_dsc=$key['id'];
					echo "<tr>
						<td>".$key['name']."</td>
						<td align=center>
							<form style=\"margin:0 0 0 0;\" action=\"".base_url()."de/continue_course\" method=\"post\" name=\"edit$id_dsc\">
								<input type=hidden name=\"course_id\" value=\"$id_dsc\">
								<input type=\"submit\" style=\"margin:0 0 0 0;width:150px\" class=\"btn btn-inverse\" value=\"Просмотр\">
							</form>
						</td>
					</tr>";
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
	</body>
</html>