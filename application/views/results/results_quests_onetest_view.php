<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			table {font-size:10px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>results/view_quests">Результаты по вопросам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>results/view_quests_disc/<?php echo $disc_id?>">Tесты дисциплины "<?php echo $disc_name;?>"</a> <span class="divider">/</span></li>
  				<li class="active">Результаты теста "<?php echo $test_name;?>"</li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Студент</b></td>
						<td align="center"><b>Результат</b></td>
						<?php
							$i=1;
							foreach($quests as $key)
							{
								echo "<td align=\"center\"><b>$i</b></td>";
								$i++;
							}	
						?>	
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($results as $key)
				{
					if ($key['timeend']!=0)
					{
						$res_id=$key['id'];
						echo "<tr>";
						echo "<td>".$key['lastname']." ".$key['firstname']."</td>";
						echo "<td>".$key['proz']."%</td>";
						foreach($quests as $key2)
							{
								if ($answers[$key['id']][$key2['id']]==0)
								{
									$color="red";
								}
								else
								{
									$color="white";
								}
								echo "<td align=\"center\" bgcolor=$color>".round($answers[$key['id']][$key2['id']],1)."</td>";	
							}	
						echo "</tr>";
					}
				}
				?>
				<tr>
					<td align=right colspan=2>Среднее значение:</td>
					<?php
						foreach($quests as $key2)
						{
							echo "<td align=\"center\">".$quest_avg[$key2['id']]."</td>";
						}
					?>
				</tr>
				</tbody>
			</table>
			<br />
			<table class="sortable" id="groups2">
				<thead>
					<tr>
						<td align="center"><b>#</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>ID</b></td>
						<td align="center"><b>Корректность</b></td>
					</tr>
				</thead>
				<tbody>		
					<?php
						$i=1;
						foreach($quests as $key)
						{
							echo "<tr><td align=\"center\"><b>$i</b></td>";
							echo "<td align=\"center\">".$key['text']."</td>";
							echo "<td align=\"center\">".$key['id']."</td>";
							if ($key['incorrect']=="1")
							{
								$corr="Брак";
								$color="red";
							}
							else
							{
								$corr="ОК";
								$color="white";
							}
							echo "<td align=\"center\" bgcolor=$color>".$corr."</td></tr>";
							$i++;
						}	
					?>	
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
			<br>
		</div>
	</body>
</html>