<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>

<script>
	function send_help_form()
	{
		error_count = 0;
		type = $('input[name=help_type]:checked', '#help_form').val();
		title = $('#help_title').val();
		if (title == "") 
		{
			$('#help_title_group').addClass("has-error");
			error_count++;
		}
		text = $('#help_text').val();
		if (text == "")
		{
			$('#help_text_group').addClass("has-error");
			error_count++;	
		}
		if (error_count == 0)
		{
			console.log(type+" "+title+" "+text);
			$.post ('<?= base_url() ?>tutor/add_message',{help_text:text,help_type:type,help_title:title},
					function(data,status)	{if( status != 'success'){alert('В процессе отправки произошла ошибка');}});
			$('#formDiv').fadeOut('fast');
			$('#formDivChange').fadeIn('fast');
		}
	}
</script>


<div id="main" style="min-height:85%">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	
	<ul class="breadcrumb">
		<li class="active">Помощь по работе со средой</li>
	</ul>

	<ul id="myTab" class="nav nav-tabs">
		<li class="active">
			<a href="#new_quest" data-toggle="tab"><span class="glyphicon glyphicon-plus"></span> Новый вопрос</a>
		</li>
		<li>
			<a href="#old_quest" data-toggle="tab"><span class="glyphicon glyphicon-question-sign"></span> Мои вопросы</a>
		</li>
		<li>
			<a href="#faq" data-toggle="tab"><span class="glyphicon glyphicon-bullhorn"></span> Часто задаваемые вопросы</a>
		</li>
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade active in" id="new_quest">
			<div style="width:80%;margin:20px auto" id="formDiv">
				<form role="form" id="help_form">
					<div class="form-group">
						<label>Укажите контекст проблемы:</label>
						<div class="radio">
							<label>
								<input type="radio" name="help_type" id="optionsRadios1" value="1" checked>
								Вопрос касается проблемы при <b>работе со средой</b>
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="help_type" id="optionsRadios2" value="2">
								Вопрос касается <b>материалов обучения или тестирования</b>
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="help_type" id="optionsRadios3" value="3">
								Вопрос <b>не касается</b> обучения и работы со средой
							</label>
						</div>
					</div>
					<div class="form-group" id="help_title_group">
						<label>Заголовок вопроса</label>
						<input type="text" class="form-control" placeholder="Пожалуйста, добавьте заголовок к Вашему вопросу" id="help_title">
						<span class="help-block">Например, не удаётся пройти тестирование или записаться на электронный курс</span>
					</div>
					<div class="form-group" id="help_text_group">
						<label>Текст вопроса</label>
						<textarea class="form-control" id="help_text" rows="3"></textarea>
						<span class="help-block">Постарайтесь указать <b>все</b> важные сведения</span>
					</div>
					<button type="button" class="btn btn-success" onClick="send_help_form()">Отправить</button>
				</form>
			</div>
			<div id="formDivChange" style="display:none;width:80%;margin:20px auto;text-align:center;">
				Ваш вопрос отправлен, в ближайшее время наши специалисты ответят на него!<br>
				<h3>Спасибо за использование нашей образовательной среды!</h3>
			</div>
		</div>
		<div class="tab-pane fade" id="old_quest">
			<div style="width:80%;margin:20px auto">
				<?php
				if (count($messages) > 0)
				{
					?>
					<div class="panel-group" id="accordion">
						<?php
						foreach($messages as $key)
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
													<td align="center"><small style="color:white;"><?= (count($answers[$key['id']]) > 0 ? 'Есть ответ' : 'Ответов нет') ?></small></td>
												</tr>
											</table>
										</a>
									</h4>
								</div>
								<div id="collapse<?= $key['id'] ?>" class="panel-collapse collapse">
									<div class="panel-body">
										<table class="table" width="100%">
											<tbody>
												<tr>
													<td width="70%"><?= $key['help_text'] ?></td>
											  		<td class="type-info"><?= $key['data'] ?></td>
												</tr>
												<?php
												foreach($answers[$key['id']] as $key2)
												{
													?>
													<tr>
														<td width="70%"><?= $key2['help_text'] ?></td>
											  			<td class="type-info"><?= $key2['data'] ?></td>
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
					?> Вы ещё не задавали ни одного вопроса <?php
				}
				?>
			</div>
		</div>
		<div class="tab-pane fade" id="faq">
			<div style="width:80%;margin:20px auto">
				<!-- Вопрос-ответ -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 class="panel-title">Как корректируется рейтинг?</h4>
					</div>
					<div class="panel-body">
						О формировании корректного результата на основе данных аналитеческого модуля можно узнать <a href="<?= base_url() ?>tutor/faq_corr_desc" class="btn btn-success">здесь</a>				
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php require_once(APPPATH.'views/require_header.php');?>