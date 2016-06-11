<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()		{document.nazad.submit();}
			function func_home()		{document.home.submit();}
			function func_lection_end()	{document.lection_end.submit();}
			function func_test_begin() 	{document.test_begin.submit();}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>de/continue_course" method="post" name="nazad">
			<input type=hidden name="course_id" value="<?php echo $course_id;?>">
		</form>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>

		<center>
		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<br />
			<h1><?php echo $lect_info['name'];?></h1>
			<br />
		</div>

		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<center>
				<?php echo $lect_info['content'];?>
			</center>
		</div>

		<?php
		if ($lect_status['timeend'] == 0)
		{
			?>
			<div id="root" style="width:1000;margin:15px 0 0 0;">
				<?php 
					if ($lect_info['test_id'] == '0')
					{
						?>
						<form action="<?php echo base_url();?>de/end_lection" method="post" name="lection_end" style="margin:0 0;">
							<input type=hidden name="course_id" value="<?php echo $course_id;?>">
							<input type=hidden name="lection_id" value="<?php echo $lect_info['id']?>">
						</form>
						<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-info"  onClick="javascript: func_lection_end()">
							<i class="icon-ok icon-white"></i> Лекция мною прочитана
						</div>
						<?php
					}
					else
					{
						if ($test_sdan == 1)
						{
							?>
							<form action="<?php echo base_url();?>de/end_lection" method="post" name="lection_end" style="margin:0 0;">
								<input type=hidden name="course_id" value="<?php echo $course_id;?>">
								<input type=hidden name="lection_id" value="<?php echo $lect_info['id']?>">
							</form>
							<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-info"  onClick="javascript: func_lection_end()">
								<i class="icon-ok icon-white"></i> Лекция мною прочитана
							</div>
							<?php		
						}
						else
						{
							?>
							<form action="<?php echo base_url();?>attest/play_test/<?php echo $disc_id;?>" method="post" name="test_begin" style="margin:0 0;">
								<input type=hidden name="test_id" value="<?php echo $lect_info['test_id'];?>">
								<input type=hidden name="test_key" value="<?php echo $test_key;?>">
								<input type=hidden name="lection_id" value="<?php echo $lect_info['id']?>">
							</form>
							<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-danger"  onClick="javascript: func_test_begin()">
								<i class="icon-th-list icon-white"></i> Пройти тестирование
							</div>
							<?php
						}
					}
				?>
			</div>
			<?php
		}
		?>

		<div id="root" style="width:1000;margin:15px 0 0 0;">
			<div class="btn-group">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse"  onClick="javascript: func_nazad()">
					<i class="icon-arrow-left icon-white"></i> Назад
				</div>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_home()">
					<i class="icon-home icon-white"></i> Главное меню
				</div>
			</div>
		</div>
	</body>
</html>