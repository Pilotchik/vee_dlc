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
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.barRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.ohlcRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.highlighter.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
  			ohlc = 
  			[
  				<?php
				foreach ($tests_results as $key)
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
 				title: 'Статистика групп по дисциплинам',
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
			    axes: 
			    {
      				xaxis: 
      				{
        				renderer: $.jqplot.CategoryAxisRenderer,
        				tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
    			   		tickOptions: 
    			    	{
          					angle: -30,
          					fontSize: '8pt'
			        	}
      				},
      				yaxis:
      				{
      					min: null,      // minimum numerical value of the axis.  Determined automatically.
				        max: 100  
      				}
    			}
  			});
			});
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
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
  				<li><a href="<?php echo base_url();?>stat/view_groups">Статистика по группам</a> <span class="divider">/</span></li>
  				<li class="active">Тесты группы "<?php echo $gr_name;?>"</li>
			</ul>
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Дисциплина</b></td>
						<td align="center"><b>Выборка</b></td>
						<td align="center"><b>Средний балл</b></td>
						<td align="center"><b>Коэффициент вариации</b></td>
						<td align="center"><b>Минимум</b></td>
						<td align="center"><b>Максимум</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				$avg_var=0;
				$cnt_var=0;
				foreach ($tests_results as $key)
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
						$avg_var+=$key['var'];
						$cnt_var++;
						echo "<td>".$key['var']."%</td>";
						echo "<td>".$key['min']."</td>";
						echo "<td>".$key['max']."</td>";
					}
					echo "</tr>";
				}
				$avg_var=round($avg_var/$cnt_var,2);
				?>
				</tbody>
			</table>
			<br />
			Средний коэффициента вариации: <?php echo $avg_var; ?>%<br />
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<center>
				<div id="chart1" style="width:600;height:400;margin:15px auto;"></div>
			</center>
		</div>
	</body>
</html>