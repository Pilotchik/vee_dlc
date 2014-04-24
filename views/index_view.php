<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php 
	if ($block == 0)
	{
		require_once(APPPATH.'views/require_main_menu_bs3.php');
	}
	?>

	<style>
		form {margin:0 0 0 0;}
		input {margin:20px 0 0 0;}
  
	</style>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		$(window).load(function()
      	{
        	<?php 
        	if ($block == 1) 
          	{ 
          		?> 
            	$('#myModalBlock').modal('show'); 
            	<?php 
          	}
          	?>
      	});

      	google.load("visualization", "1", {packages:["corechart"]});
  		google.setOnLoadCallback(drawChart);
  		function drawChart() 
  		{
    		var data = google.visualization.arrayToDataTable([
      			['Тест', 'Мой результат','Средний результат'],
      			<?php 
      			foreach ($tests as $key)
      			{
      				echo "['".$key['name']."', ".$key['proz'].", ".$key['avg']."],";
      			}
      			?>
      			]);

    		var options = {
    		  title: 'Результаты тестов',
    		  legend: {position: 'none'},
          vAxes:[{title:'%',minValue:0,maxValue:100}]
    		};

    		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    		chart.draw(data, options);
  		}

		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart2);

      	function drawChart2() 
      	{
            var data = google.visualization.arrayToDataTable([
				['Сложность','Уровень 1','Уровень 2','Уровень 3','Уровень 4'],
                <?php 
                echo "['Сложность',";
                for($i = 1; $i < 4; $i++)
                {
                  echo $diff[$i].", ";
                }
                echo $diff[4]."]";
                ?>
                ]);

            var options = {
              title: 'Сложность решённых заданий',
              legend: {position: 'top'},
              vAxes:[{title:'%',minValue:0,maxValue:100}]
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
            chart.draw(data, options);
      	}

  		google.load("visualization", "1", {packages:["corechart"]});
  		google.setOnLoadCallback(drawChart4);

  		function drawChart4() 
  		{
        	var data = google.visualization.arrayToDataTable([
	        	['Дата', 'Место'],
	        	<?php
	        	foreach ($reyting as $key) 
	        	{
	        		?>
	        		[new Date(<?= $key['date'] ?>), <?= $key['reyt'] ?>],
	        		<?php
	          	}
	          	?>
        	]);

	        var options = {
              title: 'История рейтинга',
              vAxis: {title:'Место',minValue:1,direction:-1},
              hAxis: {format:'MMM d, y'}
            };

	        var chart = new google.visualization.LineChart(document.getElementById('chart_div4'));
	        chart.draw(data, options);
      	}
	</script>

    <?php 
	if ($block == 1) 
	{ 
		?> 
		<div class="modal fade" id="myModalBlock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  		<div class="modal-dialog">
		    	<div class="modal-content">
		    		<div class="modal-header">
		    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    			<h4 class="modal-title">Разблокировка</h4>
		    		</div>
		    		<div class="modal-body">
		    			<p style="text-align: center;text-indent: 0px;">Вы не поверите, но по каким-то причинам Ваша учётная запись заблокирована. Для разблокировки нажмите кнопку "Разблокировать"</p>
						<form action="<?= base_url() ?>main/unblock" method="get" name="unblock_form">
		      		</div>
		      		<div class="modal-footer">
		      			<button class="btn btn-success" style="width:200px" type="submit"><span class="glyphicon glyphicon-ok"></span> Разблокировать</button>
		      			</form>
		        		<button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
		      		</div>
		 		</div><!-- /.modal-content -->
	  		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<?php
	}
	?>

	<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Изменение параметров учётной записи</h4>
	    		</div>
	    		<div class="modal-body">
	    			<form action="<?= base_url() ?>main/renew_info" method="post" name="adminForm" autocomplete="off" style="margin:0 0;">
						<div class="form-group">
							<label>Укажите новый номер Вашей группы:</label>
							<select class="form-control" name="new_group" style="margin:10px 0 0 0;">
								<option value="0"></option>
								<?php
								foreach ($all_groups as $key)
								{
									if ($key['type_r'] == '1')
									{
										$type_r = "ФСПО";
									}
									else
									{
										$type_r="СЕГРИС-ИИТ";
									}
									?>
									<option value="<?= $key['id'] ?>"><?= $type_r ?>: <?= $key['name_numb'] ?></option>
									<?php
								}
								?>
							</select>
						</div>
	      		</div>
	      		<div class="modal-footer">
	      			<button class="btn btn-success" style="width:200px" type="submit"><span class="glyphicon glyphicon-ok"></span> Изменить</button>
	      			</form>
	        		<button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-8">
			<h3><?= $name ?></h3>
			<h4>
				Группа: <?= $group ?>
				<div style="width:120px;margin:0px 0 0 0;" class="btn btn-success" onClick="$('#myModalConfirm').modal('show');">
					<span class="glyphicon glyphicon-pencil"></span> Изменить 
				</div>
			</h4>
			<p>Сдано тестов: <span class="label label-info " style="font-size:16px"><?= $sdano_t;?></span></p>
			<p>Пройдено курсов: <span class="label label-info" style="font-size:16px"><?= $sdano_de;?></span></p>
			<p>Средний результат по тестам: <span class="label label-warning" style="font-size:16px"><?= $avg ?>%</span></p>
		
		</div>
		<div class="col-xs-6 col-md-4">	
			<?php 
			if ($block == 0)
			{
				?>
				<a href="<?= base_url() ?>attest" class="btn btn-success btn-lg" style="width:250px;margin:0 0 20px 0;">Тестирование</a>
				<a href="<?= base_url() ?>forms" class="btn btn-warning btn-lg" style="width:250px;margin:0 0 20px 0;">Анкетирование</a>
				<?php
			}
			?>
			<?php 
			if($guest >= 2)
			{
				?>
				<a href="<?= base_url() ?>results/view_last" class="btn btn-info btn-lg" style="width:250px;margin:0 0 20px 0;">Последние результаты</a>
				<a href="<?= base_url() ?>stat_site" class="btn btn-primary btn-lg" style="width:250px;margin:0 0 20px 0;">Журнал системы</a>
				<?php
			}
			?>
		</div>
	</div>
			
	<?php 
	if (count($tests) > 0)
	{
		?>
		<h3>Личные результаты</h3>
		<div id="chart_div" style="width: 100%; height: 300px; margin: 10 auto;"></div>
		
		<h3>Личный рейтинг</h3>
		<p><?= $status ?></p>
		<div class="row">
			<div class="col-xs-6">
				<div id="chart_div3" style="width: 100%; height: 250px; margin: 10 auto;"></div>
			</div>
			<div class="col-xs-6" style="text-align:center;">
				<h4 style="font-size: 28px;">И<small>ндекс</small> C<small>ложности</small> Р<small>ешённых</small> З<small>адач</small></h4>
				<?= round($diff[1],1) ?>% * 1 + <?= round($diff[2],1) ?>% * 2 + <?= round($diff[3],1) ?>% * 3 + <?= round($diff[4],1) ?>% * 4
				<?php
				if ($isrz > 0)
				{
					?>
					<h2><?= $isrz;?><small>/10</small></h2>
					<table width="100%" border="0">
						<tr>
							<td align="center">
							 	<small>Индекс<br>меньше<br>у <?= $low_isrz ?>% (<?= $low_isrz_abs ?>)</small>
							</td>
							<td align="center" width="50%" style="vertical-align:middle;padding-top:20px">
								<div class="progress">
									<div class="progress-bar progress-bar-success" style="width: <?= $low_isrz ?>%">
										<span class="sr-only"><?= $low_isrz ?>% Complete (success)</span>
										</div>
										<div class="progress-bar progress-bar-warning" style="width: <?= $high_isrz ?>%">
										<span class="sr-only"><?= $high_isrz ?>% Complete (warning)</span>
										</div>
								</div>
							</td>
							<td align="center">
							 	<small>Индекс<br>больше<br>у <?= $high_isrz ?>% (<?= $high_isrz_abs ?>)</small>
							</td>
						</tr>
					</table>
					<?php
				}
				else
				{
					?>
					<br>Слишком мало сдано тестов. Индекс появится после наличия результатов хотя бы по пяти тестам
					<?php
				}
			?>
			</div>
		</div>
		<div style="width:100%;margin:10px auto;">
			<div id="chart_div4" style="width: 100%; height: 400px;"></div>
		</div>
		<?php 
	}
	?> 
	<h3>Общий рейтинг</h3>
	<?php
	if($guest > 1)
	{
		//TOP для админов
		?>
		<ul id="myTab" class="nav nav-tabs" style="margin-top:20px;">
			<li class="active"><a href="#fspo" data-toggle="tab">ФСПО</a></li>
			<li class=""><a href="#segrys" data-toggle="tab">СЕГРИС-ИИТ</a></li>
		</ul>

		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="fspo">
				<table class="table table-hover table-bordered" style="font-size:12px;width:80%;margin:10 auto;">
					<thead style="font-size:14px;">
						<tr>
							<td align="center" colspan="2"><b>Фамилия Имя</b></td>
							<td align="center"><b>Номер группы</b></td>
							<td align="center"><b>Рейтинг</b></td>
						</tr>
					</thead>
					<tbody>
					<?php
					$i = 1;
					foreach ($top_index_f as $key) 
					{
						?>
						<tr>
							<td width="5%">
								<?= $i ?>
								<?= ($i == 1 ? "<span class=\"glyphicon glyphicon-tower\" style=\"font-size:16px;\"></span>" : "") ?>
							</td>
							<td><?= $key['lastname'] ?> <?= $key['firstname'] ?></td>
							<td><?= $key['name_numb'] ?></td>
							<td><b><?= $key['isrz'] ?></b></td>
						</tr>
						<?php
						$i++;
					}
					?>
					</tbody>
				</table>
				<div style="margin:20px auto;width:100%;text-align:center;">
					<a href="<?= base_url() ?>rating?type=1" class="btn btn-info" style="width:50%;">Полный рейтинг НИУ ИТМО ФСПО</a>
				</div>
			</div>
			<div class="tab-pane fade" id="segrys">
				<table class="table table-hover table-bordered" style="font-size:12px;width:80%;margin:10 auto;">
					<thead style="font-size:14px;">
						<tr>
							<td align="center" colspan="2"><b>Фамилия Имя</b></td>
							<td align="center"><b>Номер группы</b></td>
							<td align="center"><b>Рейтинг</b></td>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($top_index_s as $key) 
						{
							?>
							<tr>
								<td width="5%">
									<?= $i ?>
									<?= ($i == 1 ? "<span class=\"glyphicon glyphicon-tower\" style=\"font-size:16px;\"></span>" : "") ?>
								</td>
								<td><?= $key['lastname'] ?> <?= $key['firstname'] ?></td>
								<td><?= $key['name_numb'] ?></td>
								<td><b><?= $key['isrz'] ?></b></td>
							</tr>
							<?php
							$i++;
						}
						?>
					</tbody>
				</table>
				<div style="margin:20px auto;width:100%;text-align:center;">
					<a href="<?= base_url() ?>rating?type=2" class="btn btn-info" style="width:50%;">Полный рейтинг НОУ СЕГРИС-ИИТ</a>
				</div>
			</div>
		</div>
		<?php
	}
	else
	{
		//ТОР для регистрационного типа
		?>
		<table class="table table-hover table-bordered" id="groups" style="font-size:12px;width:80%;margin:10 auto;margin-top: 20px;">
			<thead style="font-size:14px;">
				<tr>
					<td align="center" colspan="2"><b>Фамилия Имя</b></td>
					<td align="center"><b>Номер группы</b></td>
					<td align="center"><b>Рейтинг</b></td>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($top_index as $key) 
				{
					?>
					<tr>
						<td width="5%">
							<?= $i ?>
							<?= ($i == 1 ? "<span class=\"glyphicon glyphicon-tower\" style=\"font-size:16px;\"></span>" : "") ?>
						</td>
						<td><?= $key['lastname'] ?> <?= $key['firstname'] ?></td>
						<td><?= $key['name_numb'] ?></td>
						<td><b><?= $key['isrz'] ?></b></td>
					</tr>
					<?php
					$i++;
				}
				?>
			</tbody>
		</table>
		<div style="margin:20px auto;width:100%;text-align:center;">
			<a href="<?= base_url() ?>rating?type=<?= $this->session->userdata('type_r') ?>" class="btn btn-default" style="width:250px;margin:0 0 20px 0;">Полный рейтинг <?= $type_r_name ?></a>
		</div>
		<?php
	}
	?>
</div>

<?php require_once "require_header.php";?>