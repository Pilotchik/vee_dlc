<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_del()
			{
				if (confirm("Вы уверены, что хотите аннулировать результат?")) 
				{
					document.delForm.submit();	
				}
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>results/annul_group_test_result/<?php echo $res_id."/".$test_id."/".$disc_id;?>" method="post" name="delForm">
			<input type=hidden name="test_name" value="<?php echo $test_name;?>">
		</form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results/view_groups">Результаты по группам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/view_one_group/<?php echo $group_id; ?>">Результаты группы "<?php echo $gr_name;?>"</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/view_one_stud/<?php echo $stud_id; ?>"><?php echo $stud_name;?></a> <span class="divider">/</span></li>
  				<li class="active"><?php echo $test_name;?></li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Тема</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Время</b></td>
						<td align="center"><b>Уровень</b></td>
						<td align="center"><b>Правильность</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					echo "<tr>";
					echo "<td>".$key['name_th']."</td>";
					echo "<td>".$key['text']."</td>";
					echo "<td>".$key['time']."</td>";
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
			<center>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-danger" onClick="javascript: func_del()">
				<i class="icon-remove-sign icon-white"></i> Аннулировать результат
			</div>
			</center>
		</div>
	</body>
</html>