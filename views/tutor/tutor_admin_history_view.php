<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#exampleRange').attachDatepicker({
			rangeSelect: true,
			yearRange: '2011:2016',
			firstDay: 1
			});
		});
		
		function func_filter()	{document.date_picker.submit();}
	</script>

	<div id="main">

		<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	
		<ul class="breadcrumb">
			<li><a href="<?= base_url() ?>tutor_admin">Модерирование вопросов пользователей</a></li>
			<li class="active">Архив закрытых вопросов</li>
		</ul>

		<div style="width:90%;margin:20px auto">

			<p>Укажите диапазон дат</p>
			<table style="padding:0 0;margin:15px;">
				<tr>
					<td>
						<form style="margin:0 0 0 0;" action="<?= base_url() ?>tutor_admin/all_history" method="get" name="date_picker"  autocomplete="off">
							<input type="text" id="exampleRange" value="" name="range" class="form-control" style="text-align:center;height: 30;margin: 0 0;"  />
						</form>
					</td>
					<td>
						<input type="button" style="width:206px;margin:0 0 0 0" class="btn btn-inverse" value="Фильтр" onClick="func_filter()">
					</td>
				</tr>
			</table>
			


			<?php
			if (count($old_dialogs) > 0)
			{
				?>
				<div class="panel-group" id="accordion" style="margin-top:20px;">
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
												<td width="50%" style="color:white;"><span id="user_<?= $key['id'] ?>"><?= $users[$key['id']] ?></span> <span id="helper_<?= $key['id'] ?>" style="display:none"><?= $key['user_id'] ?></span>. <b><span id="title_<?= $key['id'] ?>"><?= $key['help_title'] ?></span></b></td>
												<td align="center">
													<?php 
													switch ($key['help_type']) {
														case 1:	$type = "Работа со средой";	break;
														case 2:	$type = "Образовательный контент";	break;
														case 3:	$type = "Обший вопрос";	break;
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
									Вопрос: <span style="font-weight:bold" id="text_<?= $key['id'] ?>"><?= $key['help_text'] ?></span>
									<table class="table table-striped" width="100%" style="margin-top:10px;">
										<tbody>
											<?php
											foreach($answers[$key['id']] as $key2)
											{
												?>
												<tr>
													<td width="70%"><?= $key2['help_text'] ?></td>
										  			<td class="type-info"><?= $key2['data'] ?></td>
										  			<?php
										  			if ($key2['user_id'] != $key['user_id'])
										  			{
											  			if ($key2['grade'] > 0)
											  			{
											  				?><td class="type-info"><span class="glyphicon <?= ($key2['grade'] == 1 ? 'glyphicon-thumbs-up' : 'glyphicon-thumbs-down') ?>"></span></td><?php
											  			}
											  			else
											  			{
											  				?><td><small><i>Оценки нет</i></small></td><?php
											  			}
											  		}
											  		else
											  		{
											  			?><td><small><i>Ответ пользователя</i></small></td><?php
											  		}
											  			?>
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
				?> В выбранные Вами диапазан дат завершённые диалоги отсутствуют <?php
			}
			?>
		</div>
</div>
<?php require_once(APPPATH.'views/require_header.php');?>