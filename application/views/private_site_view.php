<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
	<div id="main">
		<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
			
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
			});

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#overlay').fadeOut('fast');
			}
		</script>
			
			<?php 
			if (count($disciplines) > 0)
			{
				?>
				<h3>Результаты</h3>
				<p>Скорректированный результат расчитывается после статистической обработки	ответов студентов и вычисления невалидных (некорректных) вопросов. Если скорректированный результат больше
					полученного - значит, вы больше отвечали правильно на показательные вопросы.</p>
				<div class="panel-group" id="accordion">
  					<?php
  					foreach ($disciplines as $key) 
  					{
  						?>
  						<div class="panel panel-default">
  							<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key['id']?>" style="text-decoration:none;">
          					<div class="panel-heading" style="color: #fff;background-color: #428bca;border-color: #428bca;">
      							<h4 class="panel-title">
        								<?= $key['name_test'] ?>
        						</h4>
    						</div>
    						</a>
      						<div id="collapse<?= $key['id']?>" class="panel-collapse collapse">
      							<div class="panel-body">
        							<div class="row">
        								<?php
										foreach ($results[$key['id']] as $key2)
										{
											?>
											<div class="col-sm-6 col-md-6">
												<div class="panel panel-default" style="margin-top:10px">
													<div class="panel-heading">
														<h4 class="panel-title" style="min-height: 40px;"><b><?= $key2['name_razd'] ?></b></h4>
													</div>
													<div class="panel-collapse collapse in"> 
						  								<div class="panel-body">
						  									<?php
						  									if ($key2['timeend']-$key2['timebeg'] < 0)
						  									{
						  										?>
						  										Тест не был завершён. Попробуйте запустить тестирование и завершить его
						  										<?php
						  									}
						  									else
						  									{
						  										?>
						  										Тест был пройден<span class="label label-default" style="font-size:14px;"><?= $key2['data'] ?></span> за<span class="label label-default" style="font-size:14px;"><?= ceil(($key2['timeend']-$key2['timebeg'])/60) ?></span> минуты
						  										<?php
						  									}
						  									?>
						    							</div>
												  		<ul class="list-group">
															<li class="list-group-item">Ваш результат: <span class="label label-success"><?= $key2['proz'] ?></span></li>
															<li class="list-group-item">Результат скорректированный: <span class="label label-info" style="font-size:18px;"><?= $key2['proz_corr'] ?></span></li>
															<li class="list-group-item">Средний результат всех студентов: <span class="label label-primary" style="font-size:18px;"><?= $key2['multiplicity'] ?></span></li>
															<li class="list-group-item">
																<?php
																if ($key2['stud_view'] == '1')
																{
																	?>
																	<form style="text-align: right;margin:0 auto;" action="<?= base_url() ?>private_site/view_stud_result/<?= $key2['res_id'] ?>" method="post">
																		<input type="hidden" name="test_name" value="<?= $key2['name_razd'] ?>">
																		<input type="submit" style="width:120px;margin:0 auto;" class="btn btn-primary" value="Просмотр">
																	</form>
																	<?php
																}
																else
																{
																	?>
																	Просмотр результатов закрыт
																	<?php
																}
																?>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<?php
										}
										?>
        							</div>
      							</div>
    						</div>
  						</div>
  						<?php
  					}
  					?>
  				</div>
				<?php 
			}
			
		if (count($courses)>0)
		{
		?>
			<h3>Результаты прохождения дистанционных курсов</h3>
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
				foreach ($courses as $key)
				{
					echo "<tr>
						<td>".$disc_names[$key['id']]."</td>
						<td>".$course_names[$key['id']]."</td>
						<td>".date('Y-m-d H:i:s', $key['timebeg'])."</td><td>";
						if ($key['timeend'] != 0)
						{
							echo "Курс пройден за ".ceil(($key['timeend']-$key['timebeg'])/3600)." часов";
						}
						else
						{
							echo $key['proz']."%";
						}
						echo "</td><td>".round($key['balls'],2)."%</td></tr>";	
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups2","hoverRow","clickedRow",false);
			</script>
		
		<?php 
		}

		if (count($stud_answers)>0)
		{
				?>
				<br />
				<h3>Модерируемые задания</h3>
				<table class="sortable" id="groups" width="100%">
				<thead>
					<tr>
						<td align="center"><b>Дисциплина: Тест</b></td>
						<td align="center"><b>Дата сдачи</b></td>
						<td align="center"><b>Текст вопроса</b></td>
						<td align="center"><b>Ответ</b></td>
						<td align="center"><b>Дата проверки</td>
						<td align="center"><b>Преподаватель</td>
						<td align="center"><b>Комментарий</td>
						<td align="center"><b>Баллы</b></td>
						<td align="center"><b>Процент до</b></td>
						<td align="center"><b>Процент после</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($stud_answers as $key)
				{
					$ans_id=$key['id'];
					echo "<tr>
					<td>".$test_name[$ans_id]."</td>
					<td>".$test_date[$ans_id]."</td>
					<td>".$quest_text[$ans_id]."</td>
					<td>".$key['answer']."</td>";
					if ($key['check'] == 0)
					{
						echo "<td align=center colspan=6>Ответ ещё не проверен</td>";
					}
					else
					{
						echo "<td>".$prepod_date[$ans_id]."</td>
						<td>".$prepod_name[$ans_id]."</td>
						<td>".$prepod_comm[$ans_id]."</td>
						<td>".$balls[$ans_id]."</td>
						<td>".$proz_before[$ans_id]."</td>
						<td>".$proz_after[$ans_id]."</td>";	
					}
					echo "</tr>";
				}
				echo "</table>";
			}
			?>
			<br>
		</div>

<?php require_once(APPPATH.'views/require_header.php');?>