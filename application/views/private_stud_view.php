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
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once "require_modal_metrika.php";?>
		<div id="main">
			<?php require_once "require_main_menu.php";?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>private_site">Мои результаты</a> <span class="divider">/</span></li>
  				<li class="active">Результаты теста "<?php echo $test_name; ?>"</li>
			</ul>
			<center>
			<br />
			<table class="sortable" id="groups" style="font-size:11px;">
				<thead>
					<tr>
						<td align="center"><b>Тема</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Вec</b></td>
						<td align="center"><b>Правильность</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					echo "<tr>";
					$name_th=$key['name_th'];
					echo "<td>$name_th</td>";
					echo "<td>".$key['text']."</td>";
					if ($key['level']==0)
					{
						echo "<td colspan=2>Вопрос некорректен</td>";
					}
					else
					{
						echo "<td>".$key['level']."</td>";
						switch ($key['true']) 
						{
    						case 0:		echo "<td bgcolor=#db7093>Нет</td>";	break;
    						case 1:		echo "<td bgcolor=#0bda51>Да</td>";		break;
       			    	    default:	echo "<td>".$key['true']."</td>";      break;
						}
					}
					echo "</tr>";
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