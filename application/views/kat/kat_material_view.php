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
  				<li><a href="<?php echo base_url();?>kat">Справочные материалы</a> <span class="divider">/</span></li>
  				<li class="active"><?php echo $disc_name.". ".$material['name'];?></li>
			</ul>
			<?php echo $material['content'];?>
			<br />
			<?php if ($material['url'] != "")
			{
				?>
					<p>Ссылка на прикреплённый файл: <a target="_blank" href="<?php echo base_url()."files/".$material['url'];?>"><?php echo $material['url'];?></a></p>
			<?php
			}
			?>
		</div>
	</body>
</html>