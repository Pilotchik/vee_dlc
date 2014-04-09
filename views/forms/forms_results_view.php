<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript">
			function func_home()	{document.home.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Результаты анкетирования</li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Опрос</b></td>
						<td align="center"><b>Тип прохождения</b></td>
						<td align="center"><b>Описание</b></td>
						<td align="center"><b>Статус</b></td>
						<td align="center"><b>Количество респондентов</b></td>
						<td align="center"><b>Результаты</b></td>
						<td align="center"><b>Публикация?</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($open_forms as $key)
				{
					$id_form=$key['id'];
					echo "<td>".$key['title']."</td>";
					echo "<td>".($key['access'] == 0 ? 'Анонимный' : 'Открытый')."</td>";
					echo "<td>".$key['description']."</td>";
					echo "<td>".($key['active'] == 0 ? 'Опрос закрыт' : 'Опрос доступен для прохождения')."</td>";
					echo "<td>".$count_resp[$id_form]."</td>";
					if ($count_resp[$id_form]>0)
					{
						echo "<td><form style=\"margin:0 0 0 0;\" action=\"".base_url()."forms_admin/view_one_result/$id_form\" method=\"post\" name=\"edit$id_form\">
						<input style=\"width:150px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
						</form>
						</td>";	
					}
					else
					{
						echo "<td>Результатов пока ещё нет</td>";
					}
					if ($key['public_res'] == 0)
					{
						echo "<td><form style=\"margin:0 0 0 0;\" action=\"".base_url()."forms_admin/public_result/$id_form/1\" method=\"post\" name=\"edit$id_form\">
						<input style=\"width:150px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Опубликовать\">
						</form>
						</td>";		
					}
					else
					{
						echo "<td><form style=\"margin:0 0 0 0;\" action=\"".base_url()."forms_admin/public_result/$id_form/0\" method=\"post\" name=\"edit$id_form\">
						<input style=\"width:150px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Скрыть\">
						</form>
						</td>";	
					}
					echo "</tr>";
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