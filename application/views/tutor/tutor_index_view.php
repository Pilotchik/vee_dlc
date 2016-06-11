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

	function func_grade(id_q,grade)
	{
		if (grade == 1)
		{
			$('#grade_td_'+id_q).html('<span class="glyphicon glyphicon-thumbs-up"></span>');
		}
		else
		{
			$('#grade_td_'+id_q).html('<span class="glyphicon glyphicon-thumbs-down"></span>');	
		}
		$.post ('<?= base_url() ?>tutor/add_grade',{help_id:id_q,help_grade:grade},
					function(data,status)	{if( status != 'success'){alert('В процессе отправки произошла ошибка');}});
	}

	function func_answer(id_q)
	{
		answer = $('#help_answer_text_'+id_q).val();
		$.post ('<?= base_url() ?>tutor/add_answer',{help_id:id_q,help_answer:answer},
					function(data,status)	{if( status != 'success'){alert('В процессе отправки произошла ошибка');}});
		$('#answers_table_'+id_q).append('<tr><td>'+answer+'</td><td>Только что</td><td><small><i>Ваш ответ</i></small></td></tr>'); 
		$('#answer_'+id_q).collapse('hide');
	}

	function func_close(id_q)
	{
		$.post ('<?= base_url() ?>tutor/close_quest',{help_id:id_q},
					function(data,status)	{if( status != 'success'){alert('В процессе отправки произошла ошибка');}});
		$('#answer_group_'+id_q).html('<i>Вопрос закрыт</i>')
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
							<div class="panel <?= ($key['archive'] == 0 ? 'panel-primary' : 'panel-success') ?>">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key['id'] ?>">
											<table width="100%">
												<tr>
													<td width="50%" style="color:white;"><b><?= $key['help_title'] ?> <span class="label label-success"><?= (count($answers[$key['id']]) > 0 ? count($answers[$key['id']]) : '') ?></span></b></td>
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
													<td align="center" width="20%"><small style="color:white;"><?= (count($answers[$key['id']]) > 0 ? 'Есть ответ' : 'Ответов нет') ?></small></td>
												</tr>
											</table>
										</a>
									</h4>
								</div>
								<div id="collapse<?= $key['id'] ?>" class="panel-collapse collapse">
									<div class="panel-body">
										Вопрос: <span style="font-weight:bold" id="text_<?= $key['id'] ?>"><?= $key['help_text'] ?></span><br><?= $key['data'] ?>
										<table class="table table-striped" width="100%" style="margin-top:10px;" id="answers_table_<?= $key['id'] ?>">
											<tbody>
												<?php
												foreach($answers[$key['id']] as $key2)
												{
													?>
													<tr>
														<td width="70%"><?= $key2['help_text'] ?></td>
											  			<td><?= $key2['data'] ?></td>
											  			<?php
											  			if ($key2['grade'] > 0)
											  			{
											  				?>
											  				<td class="type-info">
											  					<span class="glyphicon <?= ($key2['grade'] == 1 ? 'glyphicon-thumbs-up' : 'glyphicon-thumbs-down') ?>"></span>
											  				</td>
											  				<?php
											  			}
											  			else
											  			{
											  				if ($key2['user_id'] != $this->session->userdata('user_id'))
											  				{
												  				?>
												  				<td id="grade_td_<?= $key2['id'] ?>">
												  					<div class="btn-group">
	  																	<button type="button" class="btn btn-default" onClick="func_grade(<?= $key2['id'] ?>,1)"><span class="glyphicon glyphicon-thumbs-up"></span> </button>
	  																	<button type="button" class="btn btn-default" onClick="func_grade(<?= $key2['id'] ?>,2)"><span class="glyphicon glyphicon-thumbs-down"></span></button>
	  																</div>
												  				</td>
												  				<?php
												  			}
												  			else
												  			{
												  				?> <td><small><i>Ваш ответ</i></small></td> <?php
												  			}
											  			}
											  			?>
											  		</tr>		
													<?php
												}
												?>
											</tbody>
										</table>
										<?php
										if ($key['archive'] == 0)
										{
											?>
											<div id="answer_group_<?= $key['id'] ?>">
												<button type="button" class="btn btn-success" data-toggle="collapse" data-target="#answer_<?= $key['id'] ?>">
		  											<span class="glyphicon glyphicon-check"></span> Ответить
												</button>
												<button type="button" class="btn btn-danger" onClick="func_close(<?= $key['id'] ?>)"><span class="glyphicon glyphicon-save"></span> Вопрос закрыт</button>
												
												<div id="answer_<?= $key['id'] ?>" class="collapse" style="padding-top:10px;">
													<div class="form-group">
														<label>Ваш ответ:</label>
														<textarea class="form-control" rows="3" name="help_answer" id="help_answer_text_<?= $key['id'] ?>"></textarea>
		  											</div>
		  											<div style="width:100%;text-align:right;">
														<button type="button" class="btn btn-info" onClick="func_answer(<?= $key['id'] ?>)">Ответить</button>
													</div>
		  										</div>
		  									</div>
	  										<?php
	  									}
	  									else
	  									{
	  										?> <i>Вопрос закрыт</i> <?php
	  									}
	  									?>
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