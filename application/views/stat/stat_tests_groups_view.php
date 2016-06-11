<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url()?>js/jquery.jqplot.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.dateAxisRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.canvasTextRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.categoryAxisRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.barRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.ohlcRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.highlighter.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
  			ohlc = 
  			[
  				<?php
				foreach ($groups_results as $key)
				{
					if ($key['count']>2)
					{
						$name=$key['name'];
						$avg=$key['avg'];
						$avg=ceil($avg);
						$name_st=substr($name,0, 90);
						$otkl1=$key['avg']-$key['otkl'];
						if ($otkl1<$key['min']) {$otkl1=$key['min'];}
						$otkl2=$key['avg']+$key['otkl'];
						if ($otkl2>$key['max']) {$otkl2=$key['max'];}
						echo "['$name', $otkl1,".$key['max'].", ".$key['min'].", $otkl2],";
					}
				}
				?>
  			];
 	
 			var plot1 = $.jqplot('chart1', [ohlc], 
 			{
 				title: 'Статистика групп по тесту',
    			series:[
    			{
    				renderer:$.jqplot.OHLCRenderer, 
			        rendererOptions:{ candleStick:true },
        			color:'gray'
        		}
        		],
        		highlighter: {
      			show: true,
      			showMarker:false,
      			tooltipAxes: 'xy',
      			yvalues: 4,
      			formatString:'<table class="jqplot-highlighter"> \
     				<tr><td>Группа:</td><td>%s</td></tr> \
      				<tr><td>Отклонение:</td><td>%s</td></tr> \
      				<tr><td>Максимум:</td><td>%s</td></tr> \
      				<tr><td>Минимум:</td><td>%s</td></tr> \
      				<tr><td>Отклонение:</td><td>%s</td></tr></table>'
    			},
   				axesDefaults: 
   				{
    			    tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
    			    tickOptions: 
    			    {
          				angle: -30,
          				fontSize: '8pt'
			        }
    			},
			    axes: 
			    {
      				xaxis: 
      				{
        				renderer: $.jqplot.CategoryAxisRenderer
      				}
    			}
  			});

  			var line2 = 
  			[
  				<?php
				foreach ($prepods_results as $key)
				{
		
					$name=$key['name'];
					$avg=$key['avg'];
					$avg=ceil($avg);
					$name_st=substr($name,0, 90);
					echo "['$name', $avg],";
				}
				?>
  			];
 	
 			var plot2 = $.jqplot('chart2', [line2], 
 			{
 				title: 'Статистика преподавателей по тесту',
    			series:[{renderer:$.jqplot.BarRenderer,color:'gray'}],
   				axesDefaults: 
   				{
    			    tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
    			    tickOptions: 
    			    {
          				angle: -30,
          				fontSize: '8pt'
			        }
    			},
			    axes: 
			    {
      				xaxis: 
      				{
        				renderer: $.jqplot.CategoryAxisRenderer
      				}
    			}
  			});

			});
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.jqplot.min.css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			table 	{font-size:10px;}
			#root 	{margin:15px 0 0 0;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>stat">Статистика по дисциплинам</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>stat/view_tests/<?php echo $disc_id;?>"><?php echo $disc_name;?></a> <span class="divider">/</span></li>
  				<li class="active">Статистика по группам, сдавшим тест "<?php echo $test_name;?>"</li>
			</ul>
			<p>Коэффициент вариации показывает однородность данных. Если он менее 33% - то данные однородны.</p>
			<h3>Группы</h3>
			<table class="sortable" border="1" id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Группа</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Средний балл</b></td>
						<td align="center"><b>Коэффициент вариации</b></td>
						<td align="center"><b>Минимум</b></td>
						<td align="center"><b>Максимум</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($groups_results as $key)
				{
					echo "<tr>";
					echo "<td>".$key['name']."</td>";
					echo "<td>".$key['count']."</td>";
					echo "<td>".$key['avg']."</td>";
					if ($key['count']<3)
					{
						echo "<td colspan=3>Недостаточно данных</td>";
					}
					else
					{
						$var=round(($key['otkl']/$key['avg'])*100,2);
						echo "<td>".$var."%</td>";
						echo "<td>".$key['min']."</td>";
						echo "<td>".$key['max']."</td>";
					}
					echo "</tr>";
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<center>
				<div id="chart1" style="width:600;height:400;margin:15px 0 15px 0;"></div>
			</center>
			<h3>Преподаватели</h3>
			<table class="sortable" id="groups2">
				<thead>
					<tr>
						<td align="center"><b>Преподаватель</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Средний балл</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($prepods_results as $key)
				{
					echo "<tr>";
					$name_t=$key['name'];
					echo "<td>$name_t</td>";
					$count=$key['count'];
					echo "<td>$count</td>";
					$avg=$key['avg'];
					echo "<td>$avg</td>";
					echo "</tr>";
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
			<center>
				<div id="chart2" style="width:600;height:400;margin: 15px auto;"></div>
			</center>
		</div>
	</body>
</html>