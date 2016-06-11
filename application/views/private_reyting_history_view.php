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
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.categoryAxisRenderer.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>plugins/jqplot.barRenderer.min.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.nazad.submit();}
			function func_home()	{document.home.submit();}

			$(document).ready(function(){
  			var line1 = 
  			[
  				<?php
				foreach ($history as $key)
				{
					echo "['".$key['date']."', ".$key['reyt']."],";
				}
				?>
  			];
 	
 			var plot1 = $.jqplot('chart1', [line1], 
 			{
 				title: 'Рейтинг',
    			series:[{color:'gray'}],
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
      				},
      				yaxis:
      				{
         				label:'Место',
         				labelRenderer: $.jqplot.CanvasAxisLabelRenderer
        			}
    			}
  			});
			});
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.jqplot.min.css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>private_site" method="post" name="nazad"></form>
		<form action="<?php echo base_url();?>main/auth" method="post" name="home"></form>
		<center>
		<?php if ($error!="") { echo "<script type=\"text/javascript\">$(document).ready(function() {alert('$error')});</script>";}?>
		<center>
		<div id="root" style="width:800;margin:15px 0 0 0;">
			<h1><?php echo $user['firstname']." ".$user['lastname'];?>. История рейтинга</h1>
		</div>
		<div id="root" style="width:800;margin:15px 0 0 0;">
			<br />
			<table class="sortable" id="groups">
				<thead>
					<tr>
						<td align="center"><b>Дата</b></td>
						<td align="center"><b>Позиция</b></td>
						<td align="center"><b>Рейтинг</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($history as $key)
				{
					echo "<tr>";
					echo "<td>".$key['date']."</td>";
					echo "<td>".$key['reyt']."</td>";
					echo "<td>".$key['balls']."</td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
		</div>
		<br />
		<div id="root" style="width:800;margin:15px 0 0 0;">
			<div id="chart1" style="width:700;height:400;"></div>
		</div>
		<div id="root" style="width:800;margin:15px 0 0 0;">
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