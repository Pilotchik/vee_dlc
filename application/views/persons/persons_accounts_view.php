<html>
	<head>
		<title>Система тестирования. Студенты ФСПО</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_edit(id_orig,id_dubl)	
			{
				document.getElementById('hidden_id_orig').innerHTML="<input type=hidden name=id_orig value="+id_orig+">";
				document.getElementById('hidden_id_dubl').innerHTML="<input type=hidden name=id_dubl value="+id_dubl+">";
				document.editForm.submit();	
			}

		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>persons/accounts_edit" method=post name="editForm">
			<div id="hidden_id_orig"></div>
			<div id="hidden_id_dubl"></div>
		</form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<h3>Студенты c несколькими учётными записями</h3>
			<p>Всего в системе <b><?php echo $counts; ?></b> проблемных учётных записей</p>
			<br />
			<table class="sortable" border=1 id="persons" width="100%">
				<thead>
					<tr>
						<td align="center" colspan="4"><b>Оригинал</b></td>
						<td align="center" colspan="4"><b>Дубликат</b></td>
						<td align="center" rowspan="2"><b>Изменить</b></td>
					</tr>
					<tr>
						<td align="center"><b>Фамилия Имя</b></td>
						<td align="center"><b>Логин</b></td>
						<td align="center"><b>Дата регистрации</b></td>
						<td align="center"><b>Тесты</b></td>
						<td align="center"><b>Фамилия Имя</b></td>
						<td align="center"><b>Логин</b></td>
						<td align="center"><b>Дата регистрации</b></td>
						<td align="center"><b>Тесты</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($persons as $key)
				{
					$id_p=$key['id'];
					echo "<tr>";
					$count_dubl=count($persons[$key['id']]['dubl']);
					echo "<td rowspan=$count_dubl>".$key['lastname']." ".$key['firstname']."</td>";
					echo "<td rowspan=$count_dubl>".$key['login']."</td>";
					echo "<td rowspan=$count_dubl>".$key['data_r']."</td>";
					echo "<td rowspan=$count_dubl>".$key['test_cnt']."</td>";
					$i=0;
					foreach ($persons[$key['id']]['dubl'] as $key2) 
					{
						if ($i!=0)
						{
							echo "<tr>";
						}
						$id_dubl=$key2['id'];
						if ($key['data_r']>$key2['data_r'])
						{
							$color="green";
						}
						else
						{
							$color="white";
						} 
						echo "<td bgcolor=$color>".$key2['lastname']." ".$key2['firstname']."</td>";
						echo "<td bgcolor=$color>".$key2['login']."</td>";
						echo "<td bgcolor=$color>".$key2['data_r']."</td>";
						echo "<td bgcolor=$color>".$key2['test_cnt']."</td>";	
						echo "<td bgcolor=$color><div style=\"width:100px;margin:0 0 0 0;font-size:11px;\" class=\"btn btn-inverse\" onclick=\"func_edit($id_p,$id_dubl)\">Объединить</div></td>";
						$i++;
						echo "</tr>";
					}
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("persons",false);
			</script>
			<br>
		</div>
	</body>
</html>