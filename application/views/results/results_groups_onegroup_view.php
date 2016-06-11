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
				$('#root3').css("display", "none");
			});

			function func_view(id_p)	
			{
				$('#overlay').fadeIn('fast');
				$('#root3').fadeIn("slow");
				$('body,html').animate({scrollTop:0},500);
				$.post('<?php echo base_url();?>results/view_popup_stud',{user_id:id_p},function(data,status)
				{
					if( status=='success')
					{
						$("#content").html(data);
					}
					else
					{
						alert('В процессе отправки произошла ошибка :(');
					}
				})
			}			

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#overlay').fadeOut('fast');
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<!--Всплывающее окно с результатами студента -->
		<div id="root3" style="top:100px;margin:0 0 0 -250px;z-index:100;">
			<center>
			<div style="width:206px;margin:10px 0 5px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()"><i class="icon-remove-sign icon-white"></i> Закрыть окно</div>
			<div id="content"></div>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()"><i class="icon-remove-sign icon-white"></i> Закрыть окно</div>
			</center>
		</div>
		<!-- Конец окна с результатами -->
		<div class="overlay" id="overlay" style="background-color:black;display:none;position:fixed;top:0px;bottom:0px;left:0px;right:0px;z-index:50;opacity:0.5;"></div>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results/view_groups">Результаты по группам</a> <span class="divider">/</span></li>
  				<li class="active">Результаты группы "<?php echo $gr_name;?>"</li>
			</ul>
			<table class="sortable" id="groups" style="font-size:10px">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<?php 
							$i=1;
							foreach ($tests as $key2)
							{
								echo "<td align=\"center\"><b>".$i."</b></td>";
								$i++;
							}
						?>
						<td align="center"><b>Средний балл</b></td>
						<td align="center"><b>Подробно</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($students as $key)
				{
					$id_stud=$key['id'];
					echo "<tr>
					<td>
						<div style=\"width:150px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" onclick=\"func_view(".$id_stud.")\">".$key['lastname']." ".$key['firstname']."</div>
					</td>";
					foreach ($tests as $key2)
					{
						if ($stud_results[$id_stud]['tests'][$key2['id']]['value']>0)
						{
							if ($stud_results[$id_stud]['tests'][$key2['id']]['type']==2)
							{
								$color="#f36223";
							}
							else
							{
								$color="white";
							}
							echo "<td align=\"center\" bgcolor=$color>".$stud_results[$id_stud]['tests'][$key2['id']]['value']."</td>";	
						}
						else
						{
							echo "<td bgcolor=\"black\">&nbsp;</td>";		
						}
						
					}
					echo "<td>".$stud_results[$id_stud]['avg']."</td>
					<td align=center>
					<form action=\"".base_url()."results/view_one_stud/$id_stud\" method=\"get\" name=\"edit$id_stud\">
						<input style=\"width:100px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Подробно\">
					</form>
					</td>
					</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups",false);
			</script>
			<br />
			<table class="sortable" border="1" id="groups23" width="50%">
				<tr>
					<td bgcolor=#f36223>56</td>
					<td>Отображение НЕскорректированного результата</td>
				</tr>
			</table>
			<br>
			<?php 
				$i=1;
				foreach ($tests as $key)
				{
					echo "<p><b>$i</b>"." ".$key['name_test'].": ".$key['name_razd']."</p>";
					$i++;
				}
			?>
			<br>
		</div>
	</body>
</html>