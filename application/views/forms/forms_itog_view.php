<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.home.submit();}
			function func_results()	{document.results.submit();}

		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form{margin:0 0 0 0;}
			table{font-size:12;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<form action="<?php echo base_url();?>forms/view_one_result/<?php echo $form_id;?>" method="post" name="results"></form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<center>
		<div id="root" style="width:700;margin:20px 0 10px 0;">
			<br />
			<h3>Спасибо!</h3>
			<h4>Результаты помогут нам стать лучше!</h4>
			<?php 
			if ($right == 1)
			{
				?>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse"  onClick="javascript: func_results()">
					<i class="icon-file icon-white"></i> Результаты
				</div>
				<?php
			}
			?>
			<br />
		</div>
		<div id="root" style="width:700;margin:20px 0 10px 0;">
			<div style="width:206px;margin:20px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
				<i class="icon-home icon-white"></i> Главное меню
			</div>
		</div>
	</body>
</html>