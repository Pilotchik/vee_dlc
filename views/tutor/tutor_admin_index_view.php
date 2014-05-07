<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#exampleRange').attachDatepicker({
			rangeSelect: true,
			yearRange: '2011:2015',
			firstDay: 1
			});
		});
		
		function func_filter()	{document.date_picker.submit();}
	</script>

	<div id="main">

		<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	
		<ul class="breadcrumb">
			<li class="active">Модерирование вопросов пользователей</li>
		</ul>

		<ul id="myTab" class="nav nav-tabs">
			<li class="active">
				<a href="#new_dialogs" data-toggle="tab"><span class="glyphicon glyphicon-play"></span> Новые диалоги (<?= count($messages) ?>)</a>
			</li>
			<li>
				<a href="#old_dialogs" data-toggle="tab"><span class="glyphicon glyphicon-pause"></span> Незавершённые диалоги (<?= count($old_dialogs) ?>)</a>
			</li>
			<li>
				<a href="<? base_url() ?>tutor_admin/all_history"><span class="glyphicon glyphicon-stop"></span> Завершёные диалоги</a>
			</li>
		</ul>

		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="new_dialogs">
				<div style="width:90%;margin:20px auto">

					<table class="table table-stripped" style="margin:15px auto;" id="groups" width="100%">
						<thead>
							<tr>
								<th>Пользователь</th>
								<th>Вопрос</th>
								<th>Тип вопроса</b></td>
								<th>Дата</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($messages) > 0)
							{
								foreach ($messages as $key)
								{
									?>
									<tr>
										<td><?= $users[$key['id']] ?></td>
										<td><b><?= $key['help_title'] ?></b>. <?= $key['help_text'] ?></td>
										<?php
										switch ($key['help_type']) 
										{
											case 1:	$type = "Работа со средой";	break;
											case 2:	$type = "Образовательный контент";	break;
											case 2:	$type = "Обший вопрос";	break;
										}
										?>
										<td><?= $type ?></td>
										<td><?= $key['data'] ?></td>
										<td>Ответить</td>
									</tr>
									<?php
								}
							}
							else
							{
								?>
								<tr><td colspan="5">В выбранный Вами период сообщений зарегистрировано не было</td></tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="old_dialogs">
				<div style="width:90%;margin:20px auto">
					<?php
					if (count($old_dialogs) > 0)
					{
						?>
						<div class="panel-group" id="accordion">
							<?php
							foreach($old_dialogs as $key)
							{
								?>
								<div class="panel <?= ($key['help_type'] == 1 ? 'panel-primary' : 'panel-success') ?>">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key['id'] ?>">
												<table width="100%">
													<tr>
														<td width="50%" style="color:white;"><b><?= $key['help_title'] ?></b></td>
														<td align="center">
															<?php 
															switch ($key['help_type']) {
																case 1:	$type = "Работа со средой";	break;
																case 2:	$type = "Образовательный контент";	break;
	        													case 2:	$type = "Обший вопрос";	break;
															}
															?>
															<small style="color:white;"><?= $type ?></small>
														</td>
														<td class="type-info" style="color:white;"><?= $key['data'] ?></td>
													</tr>
												</table>
											</a>
										</h4>
									</div>
									<div id="collapse<?= $key['id'] ?>" class="panel-collapse collapse">
										<div class="panel-body">
											Вопрос: <b><?= $key['help_text'] ?></b>
											<table class="table" width="100%" style="margin-top:10px;">
												<tbody>
													<?php
													foreach($answers[$key['id']] as $key2)
													{
														?>
														<tr>
															<td width="70%"><?= $key2['help_text'] ?></td>
												  			<td class="type-info"><?= $key2['data'] ?></td>
												  			<td class="type-info"><?= $key2['grade'] ?></td>
														</tr>		
														<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
					else
					{
						?> Незавершённые диалоги отсутствуют <?php
					}
					?>
					
				</div>
			</div>


		</div>
		
	</div>

<?php require_once(APPPATH.'views/require_header.php');?>