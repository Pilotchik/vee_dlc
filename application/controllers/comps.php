<?php

class Comps extends CI_Controller {

	function Comps()
	{
		parent::__construct();
		
	}

	function _remap($method)
	{
		$guest=$this->session->userdata('guest');
		if ($guest == '')
		{
			redirect('/', 'refresh');
		}	
		else
		{
			$this->load->model('comps_model');
			$this->load->model('attest_model');
			$this->$method();
		}
	}

	//Формирование диаграммы с компетентностным портретом
	function view_popup_stud()
	{
		$user_id = $this->session->userdata('user_id');
		//Получение информации о студенте
		$this->load->model('private_model');
		$user_info = $this->private_model->getStudReyt($user_id);
		?>
		<script type="text/javascript" src="<?= base_url() ?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/hltable.js"></script>
		<script language="javascript" type="text/javascript" src="<?= base_url() ?>js/jquery.jqplot.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>plugins/jqplot.dateAxisRenderer.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>plugins/jqplot.canvasTextRenderer.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>plugins/jqplot.categoryAxisRenderer.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>plugins/jqplot.barRenderer.min.js"></script>
		<?php
		echo "<h1>".$user_info['lastname']." ".$user_info['firstname']."</h1><br />";	
		
		//Получение информации о компетенциях
		$comps = $this->comps_model->getAllUserBalls($user_id);
		?>
		<script>
		$(document).ready(function(){
  			var line1 = 
  			[
  				<?php
  				$i = 1;
				foreach ($comps as $key2)
				{
					$abs=ceil($key2['balls']);
					echo "['Компетенция $i', $abs],";
					$i++;
				}
				?>
  			];

  		var plot1 = $.jqplot('chart1', [line1], 
 			{
 				title: 'Компетентностный портрет',
    			series:[{renderer:$.jqplot.BarRenderer,color:'gray'}],
   				axesDefaults: 
   				{
    			    tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
    			    tickOptions: 
    			    {
          				angle: -30,
          				fontSize: '10pt'
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
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.jqplot.min.css" />
		<?php
		echo "<table class=\"sortable\" border=\"1\" id=\"groups\" width=\"100%\" style=\"font-size:10px;\">
				<tr>
					<td align=\"center\"><b>#</b></td>
					<td align=\"center\" width=90%><b>Компетенция</b></td>
					<td align=\"center\"><b>Баллы</b></td>
				</tr>";
		$i = 1;
		foreach ($comps as $key2)
		{
			echo "<tr><td align=center>$i</td><td align=center>";
			$name = $this->comps_model->getCompTiDe($key2['compet_id']);
			echo $name."</td><td align=center>".round($key2['balls'],2)."</td></tr>";
			$i++;
		}
		echo "</table>";
		?>
			<div id="chart1" style="width:600;height:400;margin:20px 0 0 0;"></div>
		<?php
		
	}

	
}

?>