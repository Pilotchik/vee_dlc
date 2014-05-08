<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#exampleRange').attachDatepicker({
			rangeSelect: true,
			yearRange: '2011:2015',
			firstDay: 1
			});
		});
		
		function func_answer(id_q)
		{
			$('#answer_title').html($('#title_'+id_q).html());
			$('#answer_user').html($('#user_'+id_q).html());
			$('#answer_text').html($('#text_'+id_q).html());
			$('#answer_helper_id').val($('#helper_'+id_q).html());
			$('#answer_id').val(id_q);
			$('#myModalAnswer').modal('show')
		}

		function func_block(id_q)
		{
			$('#del_title').html($('#title_'+id_q).html());
			$('#del_id').val(id_q);
			$('#myModalDel').modal('show')
		}
	</script>

	<div class="modal fade" id="myModalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Блокировка сообщения</h4>
	    		</div>
	    		<div class="modal-body">
	    			<p style="text-align: center;text-indent: 0px;">Вы уверены, что хотите удалить вопрос <b>"<span id="del_title"></span>"</b></p>
					<form action="<?= base_url() ?>tutor_admin/help_del" method="post" role="form">
						<input type="hidden" id="del_id" value="" name="help_id">
	      		</div>
	      		<div class="modal-footer">
	      			<button class="btn btn-danger" type="submit">Архивировать</button>
	      			</form>
	        		<button type="button" class="btn" data-dismiss="modal">Отмена</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="myModalAnswer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Ответ на сообщение</h4>
	    		</div>
	    		<div class="modal-body">
	    			<p style="text-indent: 0px;">Пользователь <span style="font-weight:bold;" id="answer_user"></span> указал следующую проблему:</p>
	    			<p style="text-indent: 0px;"><span style="font-weight:bold;" id="answer_title"></span></p>
	    			<p style="text-indent: 0px;"><span id="answer_text"></span></p>
					<form action="<?= base_url() ?>tutor_admin/help_answer" method="post" role="form">
						<div class="form-group">
    						<label>Ваш ответ:</label>
    						<textarea class="form-control" rows="3" name="help_answer"></textarea>
  						</div>
						<input type="hidden" id="answer_id" value="" name="help_id">
						<input type="hidden" id="answer_helper_id" value="" name="helper_id">
	      		</div>
	      		<div class="modal-footer">
	      			<button class="btn btn-success" type="submit">Ответить</button>
	      			</form>
	        		<button type="button" class="btn" data-dismiss="modal">Отмена</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

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
								<th style="width:35%">Вопрос</th>
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
										<td><span id="user_<?= $key['id'] ?>"><?= $users[$key['id']] ?></span> <span id="helper_<?= $key['id'] ?>" style="display:none"><?= $key['user_id'] ?></span></td>
										<td><b><span id="title_<?= $key['id'] ?>"><?= $key['help_title'] ?></span></b> <span style="display:none" id="text_<?= $key['id'] ?>"><?= $key['help_text'] ?></span></td>
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
										<td>
											<div class="btn-group">
  												<button type="button" class="btn btn-success" onClick="func_answer(<?= $key['id'] ?>)"><span class="glyphicon glyphicon-check"></span> </button>
  												<button type="button" class="btn btn-warning" onClick="func_block(<?= $key['id'] ?>)"><span class="glyphicon glyphicon-remove"></span></button>
  											</div>
										</td>
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
														<td width="50%" style="color:white;"><span id="user_<?= $key['id'] ?>"><?= $users[$key['id']] ?></span> <span id="helper_<?= $key['id'] ?>" style="display:none"><?= $key['user_id'] ?></span>. <b><span id="title_<?= $key['id'] ?>"><?= $key['help_title'] ?></span></b></td>
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
											Вопрос: <span style="font-weight:bold" id="text_<?= $key['id'] ?>"><?= $key['help_text'] ?></span>
											<table class="table table-stripped" width="100%" style="margin-top:10px;">
												<tbody>
													<?php
													foreach($answers[$key['id']] as $key2)
													{
														?>
														<tr>
															<td width="70%"><?= $key2['help_text'] ?></td>
												  			<td class="type-info"><?= $key2['data'] ?></td>
												  			<?php
												  			if ($key2['grade'] > 0)
												  			{
												  				?><td class="type-info"><span class="glyphicon <?= ($key2['grade'] == 1 ? 'glyphicon-thumbs-up' : 'glyphicon-thumbs-down') ?>"></span></td><?php
												  			}
												  			else
												  			{
												  				?><td>&nbsp;</td><?php
												  			}
												  			?>
												  		</tr>		
														<?php
													}
													?>
												</tbody>
											</table>
											<button type="button" class="btn btn-success" onClick="func_answer(<?= $key['id'] ?>)"><span class="glyphicon glyphicon-check"></span> Ответить</button>
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