<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');	?>
	<script type="text/javascript">
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
	<ul class="breadcrumb">
		<li class="active"><h3><?= $stud_name ?>. <?= $group_name ?> <small>Активность пользователя</small></h3></li>
	</ul>
	<h3>Тесты</h3>
	<table class="sortable" id="groups">
		<thead>
			<tr>
				<td align="center"><b>Дисциплина</b></td>
				<td align="center"><b>Тест</b></td>
				<td align="center"><b>Дата</b></td>
				<td align="center"><b>Время, мин</b></td>
				<td align="center"><b>Результат</b></td>
				<td align="center"><b>Оценка</b></td>
				<td align="center"><b>Подробно</b></td>
			</tr>
		</thead>
		<tbody>
		<?php
				foreach ($results as $key)
				{
					?>
					<tr>
						<td><?= $disc_name[$key['id']]['name'] ?></td>
						<td><?= $test_name[$key['id']]['name'] ?></td>
						<td><?= $key['data'] ?></td>
						<td><?= ceil(($key['timeend']-$key['timebeg'])/60) ?></td>
						<td><?= $key['proz'] ?></td>
						<?php
						$oz = $ozenka[$key['id']];
						switch ($oz) 
						{
							case 2:	echo "<td bgcolor=red>$oz</td>";	break;
							case 3:	echo "<td bgcolor=#e28b00>$oz</td>";	break;
							case 4:	echo "<td bgcolor=#adff2f>$oz</td>";	break;
							case 5:	echo "<td bgcolor=green>$oz</td>";	break;
						}
						?>
						<td>
							<form action="<?= base_url() ?>results/view_stud_group_result/<?= $key['id'] ?>" method="post">
								<input type="hidden" name="stud_id" value="<?= $stud_id ?>">
								<input type="hidden" name="test_name" value="<?= $test_name[$key['id']]['name'] ?>">
								<input type="hidden" name="group_id" value="<?= $group_id ?>">
								<input type="hidden" name="test_id" value="<?= $test_name[$key['id']]['id'] ?>">
								<input type="hidden" name="disc_id" value="<?= $disc_name[$key['id']]['id'] ?>">
								<input style="width:100px;margin:0 auto;font-size:11px;" class="btn btn-info" type="submit" value="Просмотр">
							</form>
						</td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
		<h3>Личный рейтинг</h3>
		<div class="row">
			<div class="col-xs-6">
				<div id="chart_div3" style="width: 100%; height: 250px; margin: 10 auto;"></div>
			</div>
			<div class="col-xs-6" style="text-align:center;">
				<h4>И<small>ндекс</small> C<small>ложности</small> Р<small>ешённых</small> З<small>адач</small></h4>
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
							<td align="center" width="100%" style="vertical-align:middle;padding-top:20px">
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
			<br>
			<h3>Электронные курсы</h3>
			<?php
			if(count($course_results) > 0)
			{
				?>
				<table class="sortable" id="groups2" width="100%">
					<thead>
						<tr>
							<td align="center"><b>Дисциплина</b></td>
							<td align="center"><b>Дистанционный курс</b></td>
							<td align="center"><b>Дата начала обучения</b></td>
							<td align="center"><b>Статус<br>прохождения</b></td>
							<td align="center"><b>Результат по тестам</b></td>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ($course_results as $key)
					{
						?>
						<tr>
							<td><?= $disc_names[$key['id']] ?></td>
							<td><?= $course_names[$key['id']] ?></td>
							<td><?= date('Y-m-d H:i:s', $key['timebeg']) ?></td>
							<td>
								<?php
								if ($key['timeend'] != 0)
								{
									echo "Курс пройден за ".ceil(($key['timeend']-$key['timebeg'])/3600)." часов";
								}
								else
								{
									echo $key['proz']."%";
								}
								?>
							</td>
							<td><?= round($key['balls'],2) ?>%</td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
				<script type="text/javascript">
					highlightTableRows("groups2","hoverRow","clickedRow",false);
				</script>
				<?php
			}
			else
			{
				?> Пользователь ещё не прошёл ни одного электронного курса <?php
			}
			?>
			<br>
			<h3>Опросы</h3>
			<?php
			if(count($form_results) > 0)
			{
				?>
				<table class="sortable" id="groups3" width="100%">
					<thead>
						<tr>
							<td align="center"><b>Название</b></td>
							<td align="center"><b>Описание</b></td>
							<td align="center"><b>Дата прохождения опроса</b></td>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ($form_results as $key)
					{
						?>
						<tr>
							<td><?= $key['title'] ?></td>
							<td><?= $key['description'] ?></td>
							<td><?= date('Y-m-d H:i:s', $key['end']) ?></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
				<script type="text/javascript">
					highlightTableRows("groups3","hoverRow","clickedRow",false);
				</script>
				<?php
			}
			else
			{
				?>
				Пользователь ещё не прошёл ни одного опроса
				<?php
			}
			?>
			<br>
		</div>

<?php require_once(APPPATH.'views/require_header.php');?>