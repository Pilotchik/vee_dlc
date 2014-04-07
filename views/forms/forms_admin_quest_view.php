<html>
	<head>
		<title>ВОС.Анкетирование</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://blattchat.com/demos/typeahead/js/bootstrap-typeahead.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			form {margin:0 0 0 0;}
			textarea {width: 100%;}
		</style>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
				$("#option1").css("display", "none");
				$("#option2").css("display", "none");
				$("#option3").css("display", "none");
				$("#create_quest_option_table").css("display","none");
				$("#submitButton").prop( "disabled", true );
			});

			function func_open_create_quest()	{$('#myModalCode').modal('show');}
			function func_open_create_site()	{$('#myModalCreateSite').modal('show');}
			function func_open_create_siteselect()	{$('#myModalCreateSiteSelect').modal('show');}

			function func_del(id_q)
			{
				if (confirm("Удалить вопрос? Опрос архивируется и доступен только при просмотре статистики")) 
				{
					$("#questDelId").val(id_q);
					document.delForm.submit();	
				}
			}

			function func_del_site(id_q)
			{
				if (confirm("Удалить вопрос? Опрос архивируется и доступен только при просмотре статистики")) 
				{
					$("#questDelSiteId").val(id_q);
					document.delSiteForm.submit();	
				}
			}

			function func_edit_active(id_q)
			{
				name=prompt("Активность вопроса: 0 - не активен, 1 - активен");
				if (name!='null')
				{
					$("#questEditId").val(id_q);
					$("#questEditValue").val(name);
					$("#questEditParam").val("active");
					document.editForm.submit();
				}
			}

			function func_edit_own(id_q)
			{
				name=prompt("Наличие поля собственного ответа: 0 - нет, 1 - есть");
				if (name!='null')
				{
					$("#questEditId").val(id_q);
					$("#questEditValue").val(name);
					$("#questEditParam").val("own_version");
					document.editForm.submit();
				}
			}

			function func_edit_required(id_q)
			{
				name=prompt("Обязательность вопроса: 0 - необязательный вопрос, 1 - необходим ответ");
				if (name!='null')
				{
					$("#questEditId").val(id_q);
					$("#questEditValue").val(name);
					$("#questEditParam").val("required");
					document.editForm.submit();
				}
			}

			function func_edit_number(id_q,value)
			{
				$("#questEditId").val(id_q);
				$("#questEditValue").val(value);
				$("#questEditParam").val("numb");
				document.editForm.submit();
			}


			function func_edit(id_q, param)
			{
				if (param == 'site')
				{
					$("#questEditWindowParam").val('title');
				}
				else
				{
					$("#questEditWindowParam").val(param);
				}
				$("#questEditWindowId").val(id_q);
				if (param == 'site')	{$("#questEditText").html("Название страницы");}
				if (param == 'title')	{$("#questEditText").html("Текст вопроса");}
				if (param == 'subtitle')	{$("#questEditText").html("Описание вопроса");}
				if (param == 'option1' || param == 'option2' || param == 'option3')	{$("#questEditText").html("Новое значение параметров");}
				$("#questEditWindowValue").html($("#"+param+id_q).html())
				$('#myModalEdit').modal('show');
			}

			function func_edit_quest_site(id_q)
			{
				$("#questEditSiteId").val(id_q);
				$("#questEditSiteTitle").html($("#title"+id_q).html())
				$('#myModalEditQuestSite').modal('show');
			}

			function newType()
			{
				$("#submitButton").prop( "disabled", false );
				type = $("#new_type option:selected").val();
				$("#option1_").css("display", "none");
				$("#option2_").css("display", "none");
				$("#option3_").css("display", "none");
				$("#create_quest_option_table").css("display", "none");
				if (type == "")
				{
					$("#option1_").css("display", "none");
					$("#option2_").css("display", "none");
					$("#option3_").css("display", "none");
					$("#submitButton").prop( "disabled", true );
				}
				if (type == 1) 
				{
					$("#option1_").slideToggle("slow");
					$("#option1_desc").html('Введите через запятую поля, из которых респондент выберет одно');
					$("#quest_desc").html('Выберите что-то одно из списка.');
					$("#create_quest_option_table").slideToggle("slow");
				}
				if (type == 2) 
				{
					$("#option1_").slideToggle("slow");
					$("#option1_desc").html('Введите через запятую поля, из которых респондент выберет несколько');
					$("#option3_").slideToggle("slow");
					$("#option3_desc").html('Укажите максимальное количество пунктов, которые могут быть выбраны (оставьте поле пустым, если такое ограничение не требуется)');
					$("#quest_desc").html('Можно выбрать что-то одно или сразу несколько.');
					$("#create_quest_option_table").slideToggle("slow");
				}
				if (type == 3) 
				{
					$("#quest_desc").html('Напишите свой ответ.');
					$("#create_quest_option_table").slideToggle("slow");
				}
				if (type == 4) 
				{
					$("#option1_").slideToggle("slow");
					$("#option1_desc").html('Укажите текст для начала шкалы');
					$("#option2_").slideToggle("slow");
					$("#option2_desc").html('Укажите текст для конца шкалы');
					$("#option3_").slideToggle("slow");
					$("#option3_desc").html('Укажите количество пунктов шкалы');
					$("#quest_desc").html('Укажите ваше ощущение в соответствие со шкалой.');
					$("#create_quest_option_table").slideToggle("slow");
				}
				if (type == 5) 
				{
					$("#option1_").slideToggle("slow");
					$("#option1_desc").html('Введите через запятую названия строк');
					$("#option2_").slideToggle("slow");
					$("#option2_desc").html('Введите через запятую названия столбцов');
					$("#quest_desc").html('Выберите для каждой строки наиболее подходящий столбец');
					$("#create_quest_option_table").slideToggle("slow");
				}

			}

			//Функция перехвата чакбоксов и формирования трёх строк:
			//1 строка: перечисление id страниц,
			//2 строка: текст-комментарий для перехода на страницы

			function func_create_type6()
			{
				var option1_text = ""
				var option2_text = ""
				for(var i=1; i <= <?php echo count($sites); ?>; i++)
				{
					if ($("#check_sites"+i).attr("checked"))
					{
						if (i != 1 && option1_text.length > 0)
						{
							option1_text = option1_text + ", ";
							option2_text = option2_text + ", ";
						}
						option1_text = option1_text + $("#check_siteid"+i).val();
						option2_text = option2_text + $("#check_sitedesc"+i).val();
					}
				}
				$("#check_siteoption1").val(option1_text);
				$("#check_siteoption2").val(option2_text);
				document.createFormSiteType6.submit();
			}
		</script>	
	</head>
	<body>
		<form action="<?= base_url() ?>forms_admin/quest_del/<?= $form_id ?>" method="post" name="delForm">
			<input type="hidden" name="c_id" id="questDelId">
		</form>

		<form action="<?= base_url() ?>forms_admin/quest_site_del/<?php echo $form_id;?>" method="post" name="delSiteForm">
			<input type="hidden" name="c_id" id="questDelSiteId">
		</form>
		
		<form action="<?php echo base_url();?>forms_admin/quest_edit/<?php echo $form_id;?>" method="post" name="editForm">
			<input type="hidden" name="c_id" id="questEditId">
			<input type="hidden" name="c_value" id="questEditValue">
			<input type="hidden" name="c_param" id="questEditParam">
		</form>

		<div id="myModalCode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание нового вопроса</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url(); ?>forms_admin/quest_create/<?php echo $form_id;?>" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Тип вопроса</td>
						<td align="left" width="60%">
							<SELECT NAME="f_type" id="new_type" onChange="newType();">
								<option value="">
								<option value="1">Выбор одного
								<option value="2">Выбор нескольких
								<option value="3">Текст
								<option value="4">Шкала
								<option value="5">Сетка
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Выбор страницы</td>
						<td align="left" width="60%">
							<select name="f_site">
								<?php 
								$j = 1;
								foreach ($sites as $key)
								{
									?> <option value="<?php echo $key['id']; ?>"><?php echo $j; ?>. <?php echo $key['title']; ?> <?php
									$j++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Заголовок вопроса</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="f_title" cols="40" rows="3"></textarea>
						</td>
					</tr>
				</table>
				<div id="option1_" style="display:none;">
					<table border="0" cellpadding="5" cellspacing="0" width="100%">
						<tr>
							<td align="right" width="40%">
								<div id="option1_desc"></div>
							</td>
							<td align="left" width="60%">
								<textarea class="inputbox" name="f_option1" cols="40" rows="3"></textarea>
							</td>
						</tr>
					</table>
				</div>
				<div id="option2_" style="display:none;">
					<table border="0" cellpadding="5" cellspacing="0" width="100%">
						<tr>
							<td align="right" width="40%">
								<div id="option2_desc"></div>
							</td>
							<td align="left" width="60%">
								<textarea class="inputbox" name="f_option2" cols="40" rows="3"></textarea>
							</td>
						</tr>
					</table>
				</div>
				<div id="option3_" style="display:none;">
					<table border="0" cellpadding="5" cellspacing="0" width="100%">
						<tr>
							<td align="right" width="40%">
								<div id="option3_desc"></div>
							</td>
							<td align="left" width="60%">
								<SELECT NAME="f_option3">
									<option value="0">
									<?php 
									for ($i=2;$i<11;$i++)
									{
										echo "<option value=$i>$i";	
									}
									?>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<table border="0" cellpadding="5" cellspacing="0" width="100%" id="create_quest_option_table">
					<tr>
						<td align="right" width="40%">Пояснение к выполнению</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="f_subtitle" cols="40" rows="3" id="quest_desc"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Вопрос является обязательным?</td>
						<td align="left" width="60%">
							<input type="checkbox" name="f_req">
						</td>
					</tr>
				</table>
			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:120px" type="submit" id="submitButton">Создать</button>
    			</form>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		
		<div id="myModalCreateSite" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание новой страницы</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url(); ?>forms_admin/site_create/<?php echo $form_id;?>" method="post" name="createFormSite" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Заголовок страницы</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="f_title" cols="40" rows="3"></textarea>
						</td>
					</tr>
				</table>
				
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" type="submit">Ок</button>
    			</form>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>


		<div id="myModalCreateSiteSelect" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание группы выбора страницы</b></h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url(); ?>forms_admin/quest_create/<?php echo $form_id;?>" method="post" name="createFormSiteType6" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%" colspan="2">Выбор страницы, на которую будет помещена группа</td>
						<td align="left" width="60%">
							<select name="f_site">
								<?php 
								$j = 1;
								foreach ($sites as $key)
								{
									?> <option value="<?php echo $key['id']; ?>"><?php echo $j; ?>. <?php echo $key['title']; ?> <?php
									$j++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							Выберите страницы, для которых будут созданы кнопки перехода:
						</td>
					</tr>
					<?php 
					$j = 1;
					foreach ($sites as $key)
					{
						?> 
						<tr>
							<td>
								<input type="checkbox" id="check_sites<?php echo $j; ?>" /> 
								<input type="hidden" name="site_id" id="check_siteid<?php echo $j; ?>" value="<?php echo $key['id']; ?>" />
							</td>
							<td>
								<?php echo $key['title']; ?>
							</td>
							<td>
								<input type="text" style="width:100%;height: 30px;line-height: 30px;" name="site_desc" id="check_sitedesc<?php echo $j; ?>" placeholder="Текст-пояснение" />
							</td>
						</tr>
						<?php
						$j++;
					}
					?>
				</table>
				<tr>
					<td align="right" colspan="2">Заголовок группы перехода</td>
					<td align="left" width="60%">
						<textarea class="inputbox" name="f_title" rows="3">Переход к следующей странице опроса</textarea>
					</td>
				</tr>
				<tr>
					<td align="right" colspan="2">Пояснение к переходу</td>
					<td align="left" width="60%">
						<textarea class="inputbox" name="f_subtitle" rows="3">Выберите позицию для перехода</textarea>
					</td>
				</tr>
				<input type="hidden" name="f_type" value="6">
				<input type="hidden" name="f_option1" value="" id="check_siteoption1">
				<input type="hidden" name="f_option2" value="" id="check_siteoption2">
				</form>					
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" onClick="func_create_type6()">Создать</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		
		<!--

		Редактирование параметров опроса

		!-->

		<div id="myModalEdit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3>Редактирование параметров вопроса</h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url(); ?>forms_admin/quest_edit/<?php echo $form_id;?>" method="post" name="createFormSite" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%"><span id="questEditText"></span></td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="c_value" rows="3" id="questEditWindowValue"></textarea>
						</td>
					</tr>
				</table>
				<input type="hidden" name="c_id" id="questEditWindowId">
				<input type="hidden" name="c_param" id="questEditWindowParam">
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" type="submit">Изменить</button>
    			</form>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<!--

		Окончание редактирования параметров опроса

		!-->

		<div id="myModalEditQuestSite" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3>Изменение страницы вопроса</h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url(); ?>forms_admin/quest_edit/<?php echo $form_id;?>" method="post" name="EditQuestSiteForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%"><span id="questEditSiteTitle"></span></td>
						<td align="left" width="60%">
							<select name="c_value">
								<?php 
								$j = 1;
								foreach ($sites as $key)
								{
									?> <option value="<?php echo $key['id']; ?>"><?php echo $j; ?>. <?php echo $key['title']; ?> <?php
									$j++;
								}
								?>
							</select>
						</td>
					</tr>
				</table>
				<input type="hidden" name="c_id" id="questEditSiteId">
				<input type="hidden" name="c_param" value="site">
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" type="submit">Изменить</button>
    			</form>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>
		
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>forms_admin">Управление опросами</a> <span class="divider">/</span></li>
  				<li class="active">Вопросы анкеты "<?php echo $form_name;?>"</li>
			</ul>
			<?php 

			$j = 1;
			foreach ($sites as $key2)
			{
				?>
				<h3>
					<?php echo $j; ?>. <span id="site<?php echo $key2['id']; ?>"><?php echo $key2['title']; ?> (ID <?php echo $key2['id']; ?>)</span> 
					<button class="btn" onClick="func_edit(<?php echo $key2['id']; ?>,'site')">Изменить</button>
					<button class="btn btn-danger" onClick="func_del_site(<?php echo $key2['id']; ?>)"><i class="icon-remove"></i> Удалить</button>
				</h3>
				<?php 
				$j++;
				if (count($quests[$key2['id']]) > 0)
				{
					?>
					<table class="sortable" id="groups" style="font-size:10px;">
						<thead>
							<tr>
								<td align="center" colspan="5"><b>Управление</b></td>
								<td align="center"><b>Вопрос</b></td>
								<td align="center"><b>Пояснение</b></td>
								<td align="center"><b>Тип</b></td>
								<td align="center"><b>Требуется</b></td>
								<td align="center"><b>Активность</b></td>
								<td align="center"><b>Свой ответ</b></td>
								<td align="center"><b>Параметр 1</b></td>
								<td align="center"><b>Параметр 2</b></td>
								<td align="center"><b>Параметр 3</b></td>
							</tr>
						</thead>
						<tbody>
						<?php
						$i = 1;
						foreach ($quests[$key2['id']] as $key)
						{
							$id_q = $key['id'];
							$plus = $key['numb'] + 1;
							$minus = $key['numb'] - 1;
							?>
							<tr>
								<td><?= $key['numb'] ?></td>
								<?php 
								if ($i == count($quests[$key2['id']]))
								{
									?>
									<td></td>
									<?php
								}
								else
								{
									?>
									<td><i class="icon-circle-arrow-down" onClick="func_edit_number(<?= $id_q.",".$plus ?>)"></i></td>
									<?php	
								}

								if ($i == 1)
								{
									?>
									<td></td>
									<?php
								}
								else
								{
									?>
									<td><i class="icon-circle-arrow-up" onClick="func_edit_number(<?= $id_q.",".$minus ?>)"></i></td>
									<?php	
								}
								?>
								<td>
									<div onClick="func_del(<?= $key['id'] ?>)"><i class="icon-remove"></i></div>
								</td>
								<td>
									<div onClick="func_edit_quest_site(<?= $key['id'] ?>)"><i class="icon-file"></i></div>
								</td>

								<td width="25%">
									<div onClick="func_edit(<?= $key['id'] ?>,'title')" id="title<?= $key['id'] ?>"><?= $key['title'] ?></div>
								</td>

								<td>
									<div onClick="func_edit(<?= $key['id'] ?>,'subtitle')" id="subtitle<?= $key['id'] ?>">
										<?= $key['subtitle'] ?>
									</div>
									
								</td>
								<?php
								switch ($key['type']) 
								{
									case 1:	$type="Выбор одного";	break;
									case 2:	$type="Выбор нескольких";	break;
									case 3:	$type="Текст";	break;
									case 4:	$type="Шкала";	break;
									case 5:	$type="Сетка";	break;
									case 6:	$type="Выбор страницы";	break;
									default:	$type="Неизвестный тип";
								}
								$req_type = ($key['required'] == 0 ? "Нет" : "Да");
								$active_name = ($key['active'] == 0 ? "<i class=\"icon-eye-close\"></i>" : "<i class=\"icon-eye-open\"></i>");

								//Если тип >= 3, то варианта "Своя версия" быть не может
								if ($key['type'] < 3)
								{
									$own_version = "<td align=center><div onClick=\"func_edit_own($id_q)\">".($key['own_version'] == 0 ? "Нет" : "Да")."</div></td>";
								}
								else
								{
									$own_version = "<td align=center bgcolor=black>&nbsp;</td>";
								}

								?>
							<td><?= $type ?></td>
							<td><div onClick="func_edit_required(<?php echo $id_q; ?>)"><?php echo $req_type; ?></div></td>
							<td><div onClick="func_edit_active(<?php echo $id_q; ?>)"><?php echo $active_name; ?></div></td>
							<?php echo $own_version; ?>
							<?php
							if ($key['type'] < 3)
							{
								?>
								<td colspan="3"><div onClick="func_edit(<?= $id_q ?>,'option1')" id="option1<?= $key['id'] ?>"><?= $key['option1'] ?></div></td>
								<?php
							}
							if ($key['type'] == 3)
							{
								?>
								<td colspan="3" bgcolor="black">&nbsp;</td>
								<?php
							}
							if ($key['type'] == 4)
							{
								?>
								<td><div onClick="func_edit(<?= $id_q; ?>,'option1')" id="option1<?php echo $key['id']; ?>"><?php echo $key['option1']; ?></div></td>
								<td><div onClick="func_edit(<?= $id_q; ?>,'option2')" id="option2<?php echo $key['id']; ?>"><?php echo $key['option2']; ?></div></td>
								<td><div onClick="func_edit(<?= $id_q; ?>,'option3')" id="option3<?php echo $key['id']; ?>"><?php echo $key['option3']; ?></div></td>
								<?php
							}
							if ($key['type'] == 5 || $key['type'] == 6)
							{
								?>
								<td><div onClick="func_edit(<?= $id_q ?>,'option1')" id="option1<?php echo $key['id']; ?>"><?php echo $key['option1']; ?></div></td>
								<td><div onClick="func_edit(<?= $id_q ?>,'option2')" id="option2<?php echo $key['id']; ?>"><?php echo $key['option2']; ?></div></td>
								<td bgcolor="black"></td>
								<?php
							}
							
							?>
								
							</tr>
							<?php

							$i = $i + 1;
						}
						?>
						</tbody>
					</table>
					<?php
				}
				else
				{
					?> 
					Вопросов на данной странице нет 
					<?php
				}
			}
			?>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<center>
				<div class="btn-group">
					<button style="width:206px;margin:30px 0 10px 0;" class="btn btn-primary" onClick="func_open_create_quest()">
						Добавить вопрос
					</button>
					<button style="width:206px;margin:30px 0 10px 0;" class="btn btn-primary" onClick="func_open_create_site()">
						Добавить страницу
					</button>
					<?php 
					if (count($sites) > 1)
					{
						?>
						<button style="width:206px;margin:30px 0 10px 0;" class="btn btn-primary" onClick="func_open_create_siteselect()">
							Кнопки выбора страницы
						</button>
						<?php
					}
					?>
				</div>
			</center>
		</div>
	</body>
</html>
?>