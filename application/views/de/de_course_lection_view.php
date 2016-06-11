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
  				<li><a href="<?php echo base_url();?>de">Дистанционные курсы</a> <span class="divider">/</span></li>
  				<li class="active">Электронный курс "<?php echo $course_name;?>"</li>
			</ul>
			<table class="sortable" border=1 id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Лекция</b></td>
						<td align="center"><b>Тест</b></td>
						<td align="center"><b>Статус</b></td>
						<td align="center"><b>Действие</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				$i = 0;
				foreach ($lections as $key)
				{
					$id_lect=$key['id'];
					echo "
					<tr>
						<td align=center>".$key['name']."</td>
						<td align=center>";
						if ($key['test_id'] != 0)
						{?>
							<i class="icon-ok"></i>
						<?php
						}
						else
						{?>
							<i class="icon-remove"></i>
						<?php 
						}
					echo "</td>";
					if (count($lect_info[$key['id']]) > 0)
					{
						if ($lect_info[$key['id']]['timeend'] == 0)
						{
							$time = date('Y-m-d H:i:s', $lect_info[$key['id']]['timebeg']);
							echo "<td align=center bgcolor=#ffcc00>Изучение было начато $time";	
						}
						else
						{
							$time = date('Y-m-d H:i:s', $lect_info[$key['id']]['timeend']);
							echo "<td align=center bgcolor=green>Изучение было окончено $time";	
						}
					}
					else
					{
						echo "<td align=center>Изучение не начато";
					}
					echo "</td><td align=center>";
					if ($block[$i] == 0)
					{
						echo "<form style=\"margin:0 0 0 0;\" action=\"".base_url()."de/view_lection/$id_lect\" method=\"post\" name=\"ed$id_lect\">
							<input type=hidden name=\"course_id\" value=\"$id_course\">
							<input type=\"submit\" style=\"margin:0 0 0 0;width:150px\" class=\"btn btn-inverse\" value=\"Просмотр\">
						</form>";
					}
					else
					{
						echo "<input type=\"submit\" style=\"margin:0 0 0 0;width:150px\" class=\"btn btn-inverse disabled\" value=\"Просмотр\">";
					}
						echo "</td>
					</tr>";
					$i++;
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