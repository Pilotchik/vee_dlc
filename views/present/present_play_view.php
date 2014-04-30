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
				my_func();
			});

			var curr = <?php echo $first;?>

			<?php
			$mass_quest="";
			foreach ($present_slides as $key)
			{
				$mass_quest = $mass_quest.$key['slide'].",";
			}
			$mass_quest=substr($mass_quest, 0, -1);
			?>
			
			var arr = [<?php echo $mass_quest;?>]

		
			function my_func()
			{
				temp = arr.indexOf(curr);
				temp = parseInt(temp);
				$('.quest').eq(temp).fadeIn("fast");
				processTimer();
			}

			function processTimer()
			{
				$.post ('<?php echo base_url();?>present/check_slide',{present_id:<?php echo $present_id; ?>},function(data,status){
				if( status!='success' )	{alert('В процессе проверки произошла ошибка :(');}
				else
				{
					eval('var obj='+data);
					if (obj.answer==0)
					{
						alert('Ответ не сохранился');
					}
					else
					{
						active = obj.current_slide;
						active = parseInt(active);
						if (curr != active)
						{
							temp = arr.indexOf(curr);
							temp2 = arr.indexOf(active);
							$('.quest').eq(temp).fadeOut("fast");
							$('.quest').eq(temp2).fadeIn("fast");
							curr = active;
						}
					}
				}
				})
				setTimeout("processTimer()",1000);
			}
						
		</script>
		<style>
			img { max-height: 100%; }
		</style>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika_noreg3.php');?>
		<center>
		<?php
		$i=0;
		$n_id=0;
		foreach($present_slides as $key) 
		{
			$nom=$i;
			$temp=100-$nom;
			if ($i==0)
			{
				echo "
				<div id=\"block$nom\"  class=\"quest\" style=\"position:absolute;display:none;width:100%;z-index:$temp;\">
					<img src=\"".$key['image']."\">
				</div>";
			}
			else 
			{
				echo "
				<div id=\"block$nom\" class=\"quest\" style=\"position:absolute;display:none;width:100%;z-index:$temp;\">
					<img src=\"".$key['image']."\">
				</div>";
			}
			$i++;
		}
		?>
	</body>
</html>