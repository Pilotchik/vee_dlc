<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			table{font-size: 11px;}
			input[type="submit"] {width:100px;margin:0 0 0 0;font-size:11px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results/de">Результаты по курсам</a> <span class="divider">/</span></li>
  				<li class="active">Электронные курсы дисциплины "<?php echo $disc_name;?>"</li>
			</ul>
			<?php
			if (count($courses) > 0)
			{
			?>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center" width="50%"><b>Курс</b></td>
						<td align="center"><b>Результаты</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($courses as $key)
				{
					$c_id=$key['id'];
					echo "<tr>
					<td>".$key['name']."</td>
					<td align=center>
						<form action=\"".base_url()."results/de_course_results/$c_id/$disc_id\" method=\"get\" name=\"edit$c_id\">
							<input type=\"submit\" class=\"btn btn-inverse\" value=\"Просмотр\">
						</form>
					</td></tr>";
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<?php
		}
		else
		{
			echo "Никто не начинал прохождение курсов по данной дисциплине";
		}
		?>
		<br>
		</div>
	</body>
</html>