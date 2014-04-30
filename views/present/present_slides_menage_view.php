<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('.rootid').eq(0).css({"background":"#bef574"});
				$('.btn').eq(0).css("display", "none");
			});

			function func_nazad()		{document.nazad.submit();}
			function func_home()		{document.home.submit();}

			function postAjax(slide,nomer)
			{
				var nom = parseInt(nomer);
				$('.btn').css("display", "block");
				$('.btn').eq(nom).css("display", "none");
				$('.rootid').eq(nom).css({"background":"#bef574"});
				$.post ('<?php echo base_url();?>present_admin/setactive_slide',{slide:slide,present_id:<?php echo $present_id; ?>},function(data,status){
				if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
				else{eval('var obj='+data);	if (obj.answer==0)	{alert('Ответ не сохранился');}}})
			}
						
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form {margin:0 0 0 0;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>present_admin/present_menage" method="get" name="nazad"></form>
		<form action="<?php echo base_url();?>main/auth" method="get" name="home"></form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<center>
		<div id="root" style="width:90%;">
			<h1><?php echo $present_name;?></h1>
		</div>
		<?php
		$i = 0;
		foreach ($present_slides as $key)
		{
			?>
			<div id="root" style="width:90%;margin:20px 0 0 0;" class="rootid">
				<h2><?php  echo $key['slide'];?></h2>
				<p style="font-size:28px;line-height:30px;"><?php  echo $key['text'];?></p>
				<div style="width:306px;height:100px;line-height:100px;margin:10px 0 10px 0;font-size:20px;" class="btn btn-inverse" onClick="postAjax(<?php echo $key['slide'].", ".$i;?>)">
					Сделать активным
				</div>
			</div>
			<?php
			$i++;
		}
		?>
		<div id="root" style="width:90%;margin:25px 0 0 0;">
			<div class="btn-group">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
					<i class="icon-arrow-left icon-white"></i> Назад
				</div>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_home()">
					<i class="icon-home icon-white"></i> Главное меню
				</div>
			</div>
		</div>
	</body>
</html>