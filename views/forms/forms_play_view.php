<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-popover.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
				$(function() {
				$('.what1').popover({
				placement: "top",
				trigger: "click",
				html: true
				});
				});


			}
			);

			var req = [];
			var sdan = [];
			var quest_value = [];

			function func_ok(site_numb,type)	
			{
				var k = 0;
				for (var i in req[site_numb]) 
				{
				    if (sdan.indexOf(req[site_numb][i])>=0) {k++;}
				}
				if (k==req[site_numb].length)
				{
					if (type == 'end')
					{
						$('#myModalConfirm').modal('show');
					}
					else
					{
						return 1;
					}
				}
				else
				{
					$('#modal_message').html('Не все обязательные вопросы были выполнены!');
					$('#myModalAlert').modal('show');
					//alert("Не все обязательные вопросы были выполнены!");
					for (var i in req[site_numb]) 
					{
				   		if (sdan.indexOf(req[site_numb][i])<0) 
				   		{
				   			$('.rootid').eq(req[site_numb][i]).css({"background":"#eedc82"});
				   		}
					}
					return 0;
				}
			}

			function sendForm()
			{
				document.testForm.submit();
			}
			
			function postAjax(id_q,value,nomer)
			{
				if (!(nomer in sdan)) {sdan.push(nomer);}
				var nom = parseInt(nomer);
				str='input[name='+nomer+'_'+value+']';
				str_class=nomer+'_class';
				if($(str).prop("checked"))
				{
					quest_value[nomer].push(value);
					if (quest_value[nomer].length > max_args[nomer])
					{
						alert('Вы выбрали слишком много пунктов');
						//Заблокировать все чекбоксы
						$(str).removeAttr('checked');
						$(str_class).attr('disabled', 'disabled');
						quest_value[nomer].splice(quest_value[nomer].indexOf(value), 1);
					}
					else
					{
						//Заблокировать конкретный чекбокс
						//$(str).attr('disabled', 'disabled');
						$('.rootid').eq(nom).css({"background":"#6b8e23"});
						var quest_id=id_q;
						$.post ('<?= base_url() ?>forms/autosave',{id_q:quest_id,val:value,val2:0,form_id:<?= $form_id ?>},function(data,status){
						if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
						else {eval('var obj='+data); if (obj.answer==0)	{alert('Ответ не сохранился');}	}})
					}
				}
				else
				{
					//удалить значение из массива
					quest_value[nomer].splice(quest_value[nomer].indexOf(value), 1);
					//удалить значение из БД
					$.post ('<?= base_url() ?>forms/autosave2',{id_q:id_q,val:value,form_id:<?= $form_id ?>},function(data,status){
					if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
					else {eval('var obj='+data); if (obj.answer==0)	{alert('Ответ не сохранился');}	}})
					//если оказалось, что массив стал пустым, то удалить номер вопроса из массива сданных sdan
					if (quest_value[nomer].length == 0)
					{
						sdan.splice(sdan.indexOf(nomer), 1);
						$('.rootid').eq(nom).css({"background":"white"});
					}
				}
				console.log(sdan);
			}

			function postAjax_radio(id_q,value,nomer)
			{
				sdan.push(nomer);
				var nom = parseInt(nomer);
				$('.rootid').eq(nom).css({"background":"#6b8e23"});
				var quest_id=id_q;
				$.post ('<?php echo base_url();?>forms/autosave',{id_q:quest_id,val:value,val2:0,form_id:<?php echo $form_id; ?>},function(data,status){
				if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
				else{eval('var obj='+data);	if (obj.answer==0)	{alert('Ответ не сохранился');}}})
			}

			function postAjax2(id_q,value,nomer)
			{
				sdan.push(nomer);
				str='.rad'+nomer;
				$(str).removeAttr("checked");
				var nom = parseInt(nomer);
				$('.rootid').eq(nom).css({"background":"#6b8e23"});
				value=$(value).val();
				var quest_id=id_q;
				$.post ('<?php echo base_url();?>forms/autosave',{id_q:quest_id,val:value,val2:0,form_id:<?php echo $form_id; ?>},function(data,status){
				if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
				else
				{
					eval('var obj='+data);
					if (obj.answer==0)
					{
						alert('Ответ не сохранился');
					}
				}
				})
			}

			function postAjax3(id_q,strk,stlb,nomer)
			{
				sdan.push(nomer);
				var nom = parseInt(nomer);
				$('.rootid').eq(nom).css({"background":"#6b8e23"});
				var quest_id=id_q;
				$.post ('<?php echo base_url();?>forms/autosave',{id_q:quest_id,val:strk,val2:stlb,form_id:<?php echo $form_id; ?>},function(data,status){
				if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
				else
				{
					eval('var obj='+data);
					if (obj.answer==0)
					{
						alert('Ответ не сохранился');
					}
				}
				})
			}

			function next_site(curr_id,next_id,site_numb)
			{
				//Проверить, на все ли обязательные вопросы конкретной страницы ответил пользователь
				if (func_ok(site_numb) == 1)
				{
					//Скрыть текущую страницу
					$("#site"+curr_id).css("display", "none");
					//Отобразить следующую
					$("#site"+next_id).slideToggle("slow");
				}
			}

			var max_args = [];

			<?php
				$i = 0;
				foreach ($sites as $key2) 
				{
					foreach($quests[$key2['id']] as $key)
					{
						if ($key['type'] == 4)
						{
							echo "$(function() {
    						$( \"#slider$i\" ).slider({
								value:1,
								min: 1,
      							max:".$key['option3'].",
								step: 1,
								slide: function( event, ui ) {";?>
									sdan.push(<?php echo $i; ?>);
									var nom = parseInt(<?php echo $i; ?>);
									$('.rootid').eq(nom).css({"background":"#6b8e23"});
									var quest_id=<?php echo $key['id'];?>;
									$.post ('<?php echo base_url();?>forms/autosave',{id_q:quest_id,val:ui.value,val2:0,form_id:<?php echo $form_id; ?>},function(data,status){
										if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
										else	{eval('var obj='+data);	if (obj.answer==0)	{alert('Ответ не сохранился');}}})
							<?php echo "}
						    });
					  		});";
						}

						echo "max_args[$i] = 100; quest_value[$i] = [];";

						if ($key['type'] == 2 && $key['option3']!= 0)
						{
							echo "max_args[$i] = ".$key['option3']."; ";
						}

						$i++;
					}
				}
			?>


			function func_remove_tr(tr_id,req_status,table_id)
			{
				if (req_status == 1)
				{
					if ($("#"+table_id+" tr").size()>2)
					{
						$("#"+tr_id).remove();
					}
				}
				else
				{
					$("#"+tr_id).remove();
				}
			}

			function closePopover()
			{
				$('.what1').popover('hide');
			}

			//Функция обработки SELECT`а и отправки данных в БД
			function fix_grid_pop(i,k,j,oz)
			{
				//Добавление вопроса в список сданных (для проверки его обязательности)
				sdan.push(i);
				//Изменение цвета фона вопроса
				$('.rootid').eq(i).css({"background":"#6b8e23"});
				//Получить id вопроса
				var quest_id = $("#quest_id_"+i).html();
				//Отправить данные в БД
				$.post ('<?php echo base_url();?>forms/autosave',{id_q:quest_id,val:k,val2:j,form_id:<?= $form_id ?>,val3:oz},function(data,status){
				if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
				else	{eval('var obj='+data);	if (obj.answer==0)	{alert('Ответ не сохранился');}}
				})
				id = i+"_"+k+"_"+j;
				$("#a_"+id).html('<span style="cursor:pointer;font-weight: bold;font-size: 14px;">'+oz+'</span>');
				$('.what1').popover('hide');
			}

		</script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			input {width:20px;}
		</style>
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<!-- Модальное окно с сообщениями -->
				<div id="myModalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 					<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    					<h3 id="myModalLabel">Подтверждение</h3>
  					</div>
  					<div class="modal-body">
  						<p>Вы уверены, что хотите завершить анкетирование?</p>
  					</div>
  					<div class="modal-footer">
    					<button class="btn btn-success" style="width:100px" onClick="sendForm()">Да</button>
    					<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  					</div>
				</div>

				<div id="myModalAlert" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 					<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    					<h3 id="myModalLabel">Внимание!</h3>
  					</div>
  					<div class="modal-body">
  						<p><div id="modal_message"></div></p>
  					</div>
  					<div class="modal-footer">
    					<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  					</div>
				</div>
		<!--Конец модального окна -->
		<center>
		<div id="root" style="width:90%;margin:30px 0 10px 0;">
			<h3><?= $form_name ?></h3>
		</div>
		<form autocomplete="off" action="<?php echo base_url();?>forms/form_itog/<?php echo $form_id;?>" method="post" name="testForm" id="testFormId"></form>
		<?php
		$site_numb = 0;
		//Создать JS массив req с количеством требуемых вопросов на странице
		?>
		<script>
			var req = new Array(<?= count($sites) ?>);
		</script>
		<?php	
		//Номер вопроса	
		$i = 0;
		foreach ($sites as $key2) 
		{
			//Объявить массив для обязательных вопросов страницы в массиве обязательных вопросов опроса
			?>
			<script>
				req[<?= $site_numb ?>] = [];
			</script>
			<?php
			//Если страница не является первой, то при загрузке опроса не отображать её контент
			$style = ($site_numb == 0 ? " " : "display:none;");
			?>
			<div style="margin-bottom:30px;<?= $style ?>"; id="site<?= $key2['id'] ?>">
				<div id="root" style="width:90%;margin:30px 0 10px 0;">
					<h3><?= $key2['title'] ?></h3>
				</div>
				<?php
				//status_type6 = статус наличия на странице выбора перехода на другую страницу
				//если этот статус будет равен 0 после цикла по вопросам, то отображать форму завершения опроса
				$status_type6 = 0;
				//Число вопросов на странице
				$chislo_vopr = count($quests[$key2['id']]);
				//просмотр всех вопросов страницы
				foreach($quests[$key2['id']] as $key)
				{
					//Номер вопроса по порядку
					$nom=$i+1;
					//Если вопрос является обязательным, то добавить его в JS-массив
					$req = "";
					if ($key['required'] == 1)
					{
						$req="<span class=\"label label-important\">*</span>";
						?>
						<script>
							req[<?= $site_numb ?>].push(<?= $i ?>);
						</script>
						<?php
					}
					?>
					<center>
					<div id="root" class="rootid" style="width:90%;margin:10px 0 0 0;">
						<?php 
						if ($key['type'] != 6)
						{
							?>
							<h4>Вопрос №<?= $nom ?> <?= $req ?></h4>
							<?php
						}
						?>
						<h3><?= $key['title'] ?></h3>
						<span style="display:none;" id="quest_id_<?= $i ?>"><?= $key['id'] ?></span>
						<div class="alert" style="margin:5px 0 5px 0;"><?= $key['subtitle'] ?></div>
					<?php
					if ($key['type'] == 1)
					{
						//Массив элементов (разбиение строки по запятой и пробелу)
						$arr_elem = explode(", ",$key['option1']);
						?>
						<table style="font-size:12px;">
						<?php
						for($k=0;$k<count($arr_elem);$k++)
						{
							?>
							<tr>
								<td align="right">
									<input type="radio" name="q<?= $nom ?>" value="<?= $k ?>" class="rad<?= $i ?>" onClick="postAjax_radio(<?= $key['id'] ?>,<?= $k ?>,<?= $i ?>)">
								</td>
								<td align="left">
									<?= $arr_elem[$k] ?>
								</td>
							</tr>
							<?php
						}
						//Если предусмотрена возможность указания собственной версии
						if ($key['own_version'] == 1)
						{
							?>
							<tr>
								<td align="right">
									Или укажите свой вариант:
								</td>
								<td align="left">
									<input type="text" id="text<?= $key['id'] ?>" style="width:200px;" onChange="postAjax2(<?= $key['id'] ?>, text<?= $key['id'] ?>, <?= $i ?>)">
								</td>
							</tr>
							<?php
						}
						?>
						</table>
						<?php
					}
					if ($key['type'] == 2)
					{
						$arr_elem = explode(", ",$key['option1']);
						?>
						<table style="font-size:12px;">
						<?php
						for($k=0;$k<count($arr_elem);$k++)
						{
							echo "<tr><td align=right><input type=checkbox name=".$i."_"."$k class=".$i."_class onClick=postAjax(".$key['id'].",$k,$i)></td><td align=left>".$arr_elem[$k]."</td></tr>";
						}
						if ($key['own_version']==1)
						{
							echo "<tr><td align=right>Или укажите свой вариант:</td><td align=left><input type=text id=text".$key['id']." style=\"width:200px;\" onChange=postAjax2(".$key['id'].",text".$key['id'].",$i)></td></tr>";
						}
						?>
						</table>
						<?php
					}
					if ($key['type'] == 3)
					{
						?>
						<textarea rows="3" id="text<?= $key['id'] ?>" onChange="postAjax2(<?= $key['id'] ?>,text<?= $key['id'] ?>,<?= $i ?>)" style="width:400px;"></textarea>
						<?php
					}
					if ($key['type'] == 4)
					{
						?>
						<table width="100%"" style="font-size:12px;"">
							<tr>
								<td align="center" width="20%"><?= $key['option1'] ?></td>
								<td width="60%" align="center"><div id="slider<?= $i ?>"></div></td>
								<td align="center"><?= $key['option2'] ?></td>
							</tr>
						</table>
						<?php
					}
					//Сетка с радиокнопками-переключателями
					if ($key['type'] == 5)
					{
						$arr_elem_str = explode(", ",$key['option1']);
						$arr_elem_stlb = explode(", ",$key['option2']);
						?>
						<table class="sortable" id="table_<?= $i ?>" style="font-size:10px;width=100%">
							<tr>
								<td>&nbsp;</td>
						<?php
						for ($k=0;$k<count($arr_elem_stlb);$k++)
						{
							echo "<td>".$arr_elem_stlb[$k]."</td>";
						}
						?>
						<td>Не оценить</td>
						</tr>
						<?php
						for ($k=0;$k<count($arr_elem_str);$k++)
						{
							?>
							<tr id="tr_<?= $i ?>_<?= $k ?>">
								<td><?= $arr_elem_str[$k] ?></td>
							<?php
							for ($j=0;$j<count($arr_elem_stlb);$j++)
							{
								?>
								<td>
									<input type="radio" name="<?= $i ?>er<?= $k ?>" value="<?= $k ?>" onClick="postAjax3(<?= $key['id'] ?>,<?= $k ?>,<?= $j ?>,<?= $i ?>)">
								</td>
								<?php
							}
							?>
							<td><div onClick="func_remove_tr('tr_<?= $i ?>_<?= $k ?>',<?= $key['required'] ?>,'table_<?= $i ?>')" style="cursor:pointer;"><i class="icon-remove"></i></div></td>
							</tr>
							<?php
						}
						?></table><?php
					}
					//Сетка с селекторами в ячейках
					if ($key['type'] == 7)
					{
						//Получение массива строк таблицы
						$arr_elem_str = explode(", ",$key['option1']);
						//Получение массива столбцов
						$arr_elem_stlb = explode(", ",$key['option2']);
						//Получение степени соответствия
						$step = $key['option3'];
						?>
						<table class="sortable" id="table_<?= $i ?>" style="font-size:10px;width=100%">
							<tr>
								<td>&nbsp;</td>
								<?php
								for ($k=0;$k<count($arr_elem_stlb);$k++)
								{
									?>
									<td><?= $arr_elem_stlb[$k] ?></td>
									<?php
								}
								?>
								<td>Не оценить</td>
							</tr>
							<?php
							for ($k=0;$k<count($arr_elem_str);$k++)
							{
								?>
								<tr id="tr_<?= $i ?>_<?= $k ?>">
									<td><?= $arr_elem_str[$k] ?></td>
									<?php
									for ($j=0;$j<count($arr_elem_stlb);$j++)
									{
										?>
										<td id="td_<?= $i ?>_<?= $k ?>_<?= $j ?>">
											<?php
											$popover_body = "";
											for ($oz = 0;$oz <= $step; $oz++)
											{
												//$popover_body = $popover_body."<button class='btn btn-small' onClick='fix_grid_pop(".$i."_".$k."_".$j.",".$oz.")'>".$oz."</button>";
												$popover_body = $popover_body."<button class='btn btn-small' onClick='fix_grid_pop($i,$k,$j,$oz)'>".$oz."</button>";
											}
											?>
											<a class="what1" style="cursor:pointer;" data-toggle="popover" data-placement="bottom" data-content="
											Оценка: <div class=btn-group data-toggle=buttons-radio>
												<button class='btn btn-small' onClick='closePopover()'>?</button>
												<?= $popover_body ?>
											</div>" title="" data-original-title="<?= $arr_elem_str[$k] ?>. <?= $arr_elem_stlb[$j] ?>" id="a_<?= $i ?>_<?= $k ?>_<?= $j ?>"><i class="icon-question-sign"></i></a>
										</td>
										<?php
									}
									?>
									<td>
										<div onClick="func_remove_tr('tr_<?= $i ?>_<?= $k ?>',<?= $key['required'] ?>,'table_<?= $i ?>')" style="cursor:pointer;"><i class="icon-remove"></i></div>
									</td>
								</tr>
								<?php
							}
							?>
						</table>
						<?php
					}
					if ($key['type'] == 6)
					{
						$status_type6++;
						$arr_elem_id = explode(", ",$key['option1']);
						$arr_elem_str = explode(", ",$key['option2']);
						for ($k=0;$k<count($arr_elem_id);$k++)
						{
							?>
							<input type="button" style="width:350px;margin:10px 0 10px 0;" class="btn btn-primary" value="<?= $arr_elem_str[$k] ?>" onClick="next_site(<?= $key2['id'] ?>, <?= $arr_elem_id[$k] ?>, <?= $site_numb ?>)"><br>
							<?php
						}
					}
					?>
					<br />
					</div>
					<?php
					$i++;
				}
				//Если на странице не было вопросов типа 6 (выбор страницы), то добавить окончание опроса
				if ($status_type6 == 0)
				{
					?>
					<center>
					<div id="root" style="width:90%;margin:10px 0 0 0;">
						<input type="button" style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" value="Завершить" onClick="javascript: func_ok(<?= $site_numb ?>,'end')">
					</div>
					</center>
					<?php
				}
				?>
			</div>
			<!-- конец страницы -->
			<?php
			$site_numb++;
		}
		?>
		
	</body>
</html>