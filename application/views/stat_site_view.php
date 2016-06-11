<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
			<script type="text/javascript">
      		google.load("visualization", "1", {packages:["corechart"]});
      		google.setOnLoadCallback(drawChart);
      		function drawChart() 
      		{
        		var data = google.visualization.arrayToDataTable([
        		['Тип', 'Количество'],
        		['ВКонтакте', <?php echo $vk_users;?>],
  				['Обычно', <?php echo $nvk_users;?>]
        		]);

        		var options = {
          			title: 'Типы учётных записей'
        		};

        		var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        		chart.draw(data, options);
    	  	}
    	
			$(document).ready(function(){
				$('#exampleRange').attachDatepicker({
				rangeSelect: true,
				yearRange: '2011:2014',
				firstDay: 1
				});
			});
			
			function func_filter()	{document.date_picker.submit();}
		</script>
			<h3>Статистика сайта</h3>
			<p>Укажите диапазон дат, для которого необходима статистика 
			<table style="padding:0 0;">
				<tr>
					<td>
						<form style="margin:0 0 0 0;" action="<?php echo base_url();?>stat_site" method="get" name="date_picker"  autocomplete="off">
							<input type="text" id="exampleRange" value="" name="range" style="text-align:center;height: 30;margin: 0 0;" />
						</form>
					</td>
					<td>
						<input type="button" style="width:206px;margin:0 0 0 0" class="btn btn-inverse" value="Фильтр" onClick="javascript: func_filter()">
					</td>
				</tr>
			</table>
			<br />
			<p>За выбранный период было пройдено <b><?php echo $tests;?></b> тестов.</p>
			<h3>Пользователи среды</h3>
			<p>За весь период работы системы, благодаря статистическому анализу, было скорректировано <b><?php echo $proz_corr;?></b> результатов, 
				из них <b><?php echo $proz_corr_plus;?>%</b> в лучшую сторону.</p>
			<p>Количество пользователей, зарегистрированных через систему: <?php echo $vk_users+$nvk_users;?>, из них <?php echo $vk_users;?> авторизуются через ВКонтакте, что составляет примерно <?php echo round(($vk_users/($vk_users+$nvk_users))*100,1);?>%.</p>			
			<div id="piechart" style="width: 100%; height: 300px;margin:10 auto;" ></div>

			<h3>Обратная связь</h3>
			<p>Довольных своим результатом студентов - <?= $positive ?>, против <?= $negative ?>, которых не удовлетворил результат (позитив <?php $pos_proz=round(($positive/($positive+$negative))*100,1);$neg_proz=($pos_proz==0 ? '0' : 100-$pos_proz); echo $pos_proz."% : ".$neg_proz;?>% негатив).</p>
			<p>Заданий, которыми недовольны студенты: <?php $summ_incorr=$incorr_stud_1+$incorr_stud_2+$incorr_stud_3;echo $summ_incorr;?>, что составляет <b><?php echo round(($summ_incorr/$incorr)*100,2);?>%</b> от общего количества заданий. При этом некорректность распредилилась следующим образом:</p>
			<ul style="margin:10px 0 0 40px;">
				<li><p style="text-indent: 5px;">"Мы это не проходили" - <?php echo $incorr_stud_1;?> или <?php echo round(($incorr_stud_1/$summ_incorr)*100,2);?>%</p></li>
				<li><p style="text-indent: 5px;">"Задание некорректно" - <?php echo $incorr_stud_2;?> или <?php echo round(($incorr_stud_2/$summ_incorr)*100,2);?>%</p></li>
				<li><p style="text-indent: 5px;">"Мне не нравится задание" - <?php echo $incorr_stud_3;?> или <?php echo round(($incorr_stud_3/$summ_incorr)*100,2);?>%</p></li>
			</ul>
			<p>Некорректными в процессе статистической обработки было признано <?= $incorr_stat ?> заданий, что составляет <b><?php echo round(($incorr_stat/$incorr)*100,2);?>%</b> от общего количества заданий (<?php echo $incorr;?>).</p>
			
			<h3>Коэффициент эффективности тестов</h3>
			<p>Всего в системе было получено <?= $qual_statuses_count ?> коэффициентов качества.</p>
			<script type="text/javascript">
  				google.load("visualization", "1", {packages:["corechart"]});
  				google.setOnLoadCallback(drawChart1);
  				function drawChart1() {
    				var data = google.visualization.arrayToDataTable([
      				['Параметр', 'Коэффициент качества','Степень равномерности распределения'],
      				<?= $qual_statuses_string ?>
    				]);

    					var options = {
      					title: 'Распределение коэффициента качества тестов',
      					legend: {position: 'top',textStyle: {fontSize: 12}},
      					curveType: 'function',
      					lineWidth:'4',
      					hAxis: {title: 'Коэффициент', titleTextStyle: {color: 'red'}}
    					};

    					var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    					chart.draw(data, options);
 			 		}
    		</script>
    		<div id="chart_div" style="width: 100%; height: 500px;margin:0 auto;"></div>
    		
			<h3>Журнал системы</h3>
			<ul id="myTab" class="nav nav-tabs">
              <li class="active">
              	<a href="#visit" data-toggle="tab">
              		Пользователи 
              		<?php
              		if ($log_user_cnt[0] != 0)
              		{
              		?>
              			<span class="badge badge-success">+<?php echo $log_user_cnt[0];?></span>
              			<?php
              		}
              		?>
              	</a></li>
              <li class=""><a href="#tests" data-toggle="tab">Тесты и опросы 
              	<?php
              		if ($log_user_cnt[1] != 0)
              		{
              		?>
              			<span class="badge badge-warning">+<?php echo $log_user_cnt[1];?></span></a></li>
              			<?php
              		}
              	?>
           	<li class=""><a href="#de" data-toggle="tab">Дистанционные курсы 
           		<?php
              		if ($log_user_cnt[2] != 0)
              		{
              		?>
              			<span class="badge badge-info">+<?php echo $log_user_cnt[2];?></span></a></li>
              			<?php
              		}
              	?>
              	<li class=""><a href="#admin" data-toggle="tab">Администрирование 
              		<?php
              		if ($log_user_cnt[3] != 0)
              		{
              		?>
              			<span class="badge badge-inverse">+<?php echo $log_user_cnt[3];?></span></a></li>
              			<?php
              		}
              		?>
            </ul>

            <div id="myTabContent" class="tab-content">
            	<div class="tab-pane fade active in" id="visit">
                	<table class="sortable" style="margin:15px 0 0 0;" id="groups" width="100%">
						<thead>
							<tr>
								<td align="center"><b>Дата</b></td>
								<td align="center"><b>Пользователь</b></td>
								<td align="center"><b>Событие</b></td>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($log_0)>0)
							{
								foreach ($log_0 as $key)
								{
									echo "<tr>
									<td>".$key['date']."</td>
									<td>".$key['user']."</td>
									<td>".$key['type']."</td>
									</tr>";
								}
							}
							else
							{
								echo "<tr><td colspan=3>В выбранный Вами период посещений зарегистрировано не было</td></tr>";
							}
							?>
						</tbody>
					</table>
					<script type="text/javascript">
						highlightTableRows("groups","hoverRow","clickedRow",false);
					</script>
            	</div>
              	<div class="tab-pane fade" id="tests">
	                <table class="sortable" style="margin:15px 0 0 0;" id="groups" width="100%">
						<thead>
							<tr>
								<td align="center"><b>Дата</b></td>
								<td align="center"><b>Пользователь</b></td>
								<td align="center"><b>Событие</b></td>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($log_1)>0)
							{
								foreach ($log_1 as $key)
								{
									echo "<tr>
									<td>".$key['date']."</td>
									<td>".$key['user']."</td>
									<td>".$key['type']."</td>
									</tr>";
								}
							}
							else
							{
								echo "<tr><td colspan=3>В выбранный Вами период тестирование никто не проходил</td></tr>";
							}
							?>
						</tbody>
					</table>
					<script type="text/javascript">
						highlightTableRows("groups","hoverRow","clickedRow",false);
					</script>
				</div>
              	<div class="tab-pane fade" id="de">
                	<table class="sortable" style="margin:15px 0 0 0;" id="groups" width="100%">
						<thead>
							<tr>
								<td align="center"><b>Дата</b></td>
								<td align="center"><b>Пользователь</b></td>
								<td align="center"><b>Событие</b></td>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($log_2)>0)
							{
								foreach ($log_2 as $key)
								{
									echo "<tr>
									<td>".$key['date']."</td>
									<td>".$key['user']."</td>
									<td>".$key['type']."</td>
									</tr>";
								}
							}
							else
							{
								echo "<tr><td colspan=3>В выбранный Вами период дистанционные курсы окончены не были</td></tr>";
							}
							?>
						</tbody>
					</table>
					<script type="text/javascript">
						highlightTableRows("groups","hoverRow","clickedRow",false);
					</script>
              	</div>
              	<div class="tab-pane fade" id="admin">
                	<table class="sortable" style="margin:15px 0 0 0;" id="groups4" width="100%">
						<thead>
							<tr>
								<td align="center"><b>Дата</b></td>
								<td align="center"><b>Пользователь</b></td>
								<td align="center"><b>Событие</b></td>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($log_3)>0)
							{
								foreach ($log_3 as $key)
								{
									echo "<tr>
									<td>".$key['date']."</td>
									<td>".$key['user']."</td>
									<td>".$key['type']."</td>
									</tr>";
								}
							}
							else
							{
								echo "<tr><td colspan=3>В выбранный Вами период действий администратора не было</td></tr>";
							}
							?>
						</tbody>
					</table>
					<script type="text/javascript">
						highlightTableRows("groups4","hoverRow","clickedRow",false);
					</script>
              	</div>
            </div>
            <br />
		</div>

<?php require_once(APPPATH.'views/require_header.php');?>