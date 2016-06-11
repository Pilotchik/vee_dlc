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
			
			function func_del(id_a)
			{
				if (confirm("Удалить ответ? Ответ архивируется и доступен только при просмотре статистики")) 
				{
					document.getElementById('a_id').innerHTML="<input type=hidden name=a_id value=\""+id_a+"\">";
					document.getElementById('a_value').innerHTML="<input type=hidden name=a_value value=1>";
					document.getElementById('a_param').innerHTML="<input type=hidden name=a_param value=del>";
					document.editForm.submit();
				}
			}

			function func_edit_active(id_a)
			{
				name=prompt("Правильность");
				if (name!='null')
				{
					document.getElementById('a_id').innerHTML="<input type=hidden name=a_id value=\""+id_a+"\">";
					document.getElementById('a_value').innerHTML="<input type=hidden name=a_value value=\""+name+"\">";
					document.getElementById('a_param').innerHTML="<input type=hidden name=a_param value=true>";
					document.editForm.submit();
				}
			}

			function func_edit_text(id_a)
			{
				name=prompt("Введите новый текст ответа:");
				if (name!='null')
				{
					document.getElementById('a_id').innerHTML="<input type=hidden name=a_id value=\""+id_a+"\">";
					document.getElementById('a_value').innerHTML="<input type=hidden name=a_value value=\""+name+"\">";
					document.getElementById('a_param').innerHTML="<input type=hidden name=a_param value=text>";
					document.editForm.submit();
				}
			}

		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			table 	{font-size:10px;}
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>tests/test_view/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="nazad"></form>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<form action="<?php echo base_url();?>tests/answer_edit/<?php echo $dest."/".$id_disc."/".$id_test."/".$id_quest;?>" method="post" name="editForm">
			<div id="a_id"></div>
			<div id="a_value"></div>
			<div id="a_param"></div>
		</form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<center>
		<div id="root" style="width:1000;">
			<br />
			<h1><?php echo $quest[0]['text'];?></h1>
			<center>
			<?php 
			if($quest[0]['image'])
			{
			?>
				<img src="<?php echo base_url();?>images/<?php echo $quest[0]['image'];?>">
			<?php 
			}
			?>	
		</div>
		<div id="root" style="width:1000;" class="table_big">
			<h1>Ответы на вопрос</h1>
			<br />
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<?php
							if ($quest[0]['type'] == 4)
							{
								echo "<td align=center><b>Текст</b></td><td align=center><b>Соответствие</b></td>";
							}
							else
							{
								echo "<td align=\"center\"><b>Ответ</b></td>";
							}
						?>
						<td align="center"><b>Правильность</b></td>
						<td align="center"><b>Удаление</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($answers as $key)
				{
					$id_a=$key['id'];
					echo "<tr>";
					if ($quest[0]['type']==4)
					{
						echo "<td align=\"center\">".$key['quest_t']."</td>";
					}
					$text_a=$key['text'];
					echo "<td><center>
					<div onClick=\"javascript: func_edit_text($id_a)\">$text_a</div>
					</center></td>";
					$active=$key['true'];
					echo "<td><center>
					<div onClick=\"javascript: func_edit_active($id_a)\">$active</div>
					</center></td>";
					echo "<td><center>
					<div style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" onClick=\"javascript: func_del($id_a)\">Удалить</div>
					</center></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
		</div>
		<div id="root" style="width:1000;">
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