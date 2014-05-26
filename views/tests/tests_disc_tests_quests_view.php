<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
			});

			function func_open_create_dsc()
			{
				$(".createDscForm").slideToggle("slow");
				var height= $(".createDscForm").height()+$("#main").height()+$(".table_big").height()+50; 
				$("html,body").animate({"scrollTop":height},"slow");
			}

			function func_open_dubl_dsc()
			{
				$(".dublDscForm").slideToggle("slow");
				var height= $(".dublDscForm").height()+$("#main").height()+$(".table_big").height()+50; 
				$("html,body").animate({"scrollTop":height},"slow");
			}

			function func_open_balance_dsc()
			{
				$(".balanceDscForm").slideToggle("slow");
				var height= $(".balanceDscForm").height()+$("#main").height()+$(".table_big").height()+50; 
				$("html,body").animate({"scrollTop":height},"slow");
			}


			function func_create()	{document.createForm.submit();}
			function func_dubl()	{document.dublForm.submit();}

			function func_del(id_q)
			{
				if (confirm("Удалить вопрос? Вопрос архивируется и доступен только при просмотре статистики")) 
				{
					document.getElementById('q_id_del').innerHTML="<input type=hidden name=q_id value=\""+id_q+"\">";
					document.delForm.submit();	
				}
			}

			function func_edit_active(id_q)
			{
				name=prompt("Активность вопроса: 0 - вопрос не виден студенту, 1 - виден");
				if (name!='null')
				{
					document.getElementById('q_id').innerHTML="<input type=hidden name=q_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=q_value value=\""+name+"\">";
					document.getElementById('q_param').innerHTML="<input type=hidden name=q_param value=active>";
					document.editForm.submit();
				}
			}

			function func_edit_text(id_q)
			{
				$('#myModalConfirm').modal('show');
				$('#text_param').html('Введите новый текст вопроса')
				document.getElementById('q_id').innerHTML="<input type=hidden name=q_id value=\""+id_q+"\">";
				$('#q_value_text').val($('#text'+id_q).html());
				document.getElementById('q_param').innerHTML="<input type=hidden name=q_param value=text>";
			}

			function send_editForm()	{document.editForm.submit();}

			function func_edit_theme(id_q)
			{
				$('#overlay').fadeIn('fast');
				$('#root3').fadeIn("slow");
				$('body,html').animate({scrollTop:0},500);
				document.getElementById('q_id_div').innerHTML="<input type=hidden id=q_id_theme value=\""+id_q+"\">";
			}

			function func_edit_theme_2() 
			{
 				name = $("#new_theme option:selected").val();
 				id_q = $("#q_id_theme").attr("value");
 				if (id_q>0)
 				{
 					document.getElementById('q_id').innerHTML="<input type=hidden name=q_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=q_value value=\""+name+"\">";
					document.getElementById('q_param').innerHTML="<input type=hidden name=q_param value=theme_id>";
					document.editForm.submit();
 				}
  			}

			function func_edit_cancel() 
			{
				$('#root3').fadeOut("slow");
				$('#overlay').fadeOut('fast');
			}

			function func_edit_number(id_q)
			{
				name=prompt("Укажите номер вопроса:");
				if (name!='null')
				{
					document.getElementById('q_id').innerHTML="<input type=hidden name=q_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=q_value value=\""+name+"\">";
					document.getElementById('q_param').innerHTML="<input type=hidden name=q_param value=number>";
					document.editForm.submit();
				}
			}

			function func_edit_var(id_q)
			{
				name=prompt("Укажите вариант вопроса:");
				if (name!='null')
				{
					document.getElementById('q_id').innerHTML="<input type=hidden name=q_id value=\""+id_q+"\">";
					document.getElementById('q_value').innerHTML="<input type=hidden name=q_value value=\""+name+"\">";
					document.getElementById('q_param').innerHTML="<input type=hidden name=q_param value=variant>";
					document.editForm.submit();
				}
			}

			function createVariants()
			{
				//Количество вариантов ответа
				quest_kol = $("#q_kol_a").val();
				quest_type = $("#q_type").val();
				$('#q_variants_title').html('');
				$('#q_variants_content').html('');
				$('.q_kol_class').fadeOut("fast");
				//если требуется указать количество
				if (quest_type == 1 || quest_type == 2 || quest_type == 4)
				{
					$('.q_kol_class').fadeIn("fast");
				}
				//выбор одного
				if (quest_type == 1 && quest_kol > 0)
				{
					$('#q_variants_title').html('Укажите один верный ответ');
					for (i = 1;i <= quest_kol; i++)
					{
						$('#q_variants_content').append('<textarea name=ans['+i+'] rows=\"2\" style=\"width:300px;margin-right:10px\"></textarea><input type=\"radio\" name=\"true_a[1]\" VALUE='+i+'><br />');
					}
				}
				//выбор нескольких
				if (quest_type == 2 && quest_kol > 0)
				{
					$('#q_variants_title').html('Укажите верные ответы');
					for (i = 1;i <= quest_kol; i++)
					{
						$('#q_variants_content').append('<textarea name=ans['+i+'] rows=\"2\" style=\"width:300px;margin-right:10px\"></textarea><input type=\"checkbox\" name=true_a['+i+']><br />');
					}
				}
				//ввод слов
				if (quest_type == 3)
				{
					$('#q_variants_title').html('Правильный ответ');
					$('#q_variants_content').html('<input type=\"text\" name=\"ans[1]\" style=\"height: 30px;line-height: 30px;\">');
				}
				//Укажите соответствие
				if (quest_type == 4 && quest_kol > 0)
				{
					$('#q_variants_title').html('Укажите соответствие, а программа сама перемешает варианты');
					for (i = 1;i <= quest_kol; i++)
					{
						$('#q_variants_content').append('<b>'+i+'</b>. Тексту <textarea name=quest_t['+i+'] rows=2 style=\"width:150px;margin-right:10px\"></textarea> соответствует текст: <textarea name=ans['+i+'] rows=2 style=\"width:150px;margin-right:10px\"></textarea><br />');
					}
				}
				//модерируемый ответ
				if (quest_type == 5)
				{
					$('#q_variants_content').html('Вопрос будет модерироваться. Правильность ответа определит преподаватель <input type=\"hidden\" name=\"ans[1]\" value=\"1\">');
				}
				//числовой диапазон
				if (quest_type == 6)
				{
					$('#q_variants_title').html('Введите диапазон, в котором должен быть определён ответ (дробные числа вводятся через <b>точку</b>)');
					$('#q_variants_content').html('от <input type=\"text\" name=\"ans[1]\" style=\"height: 30px;font-size: 14px;text-align: center;margin: 5px 10px;\"> до <input type=text name=ans[2]  style=\"height: 30px;font-size: 14px;text-align: center;margin: 5px 10px;\">');
				}
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>tests/quest_del/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="delForm">
			<div id="q_id_del"></div>
		</form></td>
		
		<div id="myModalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение параметров</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param"></div></p>
  				<form action="<?php echo base_url();?>tests/quest_edit/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="editForm">
					<textarea id="q_value_text" name="q_value" style="min-width:100%" rows="4"></textarea>
					<div id="q_value"></div>
					<div id="q_id"></div>
					<div id="q_param"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_editForm()">Ок</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<!-- Начало окна с темами -->
		<div id="root3" style="top:100px;margin:0 0 0 -250px;z-index:100;">
			<h1>Выбор темы</h1>
				<table>
					<tr>
						<td align="right" width="40%">Тема</td>
						<td align="left" width="60%">
							<div id="q_id_div"></div>
							<SELECT NAME="new_theme" id="new_theme" onChange="func_edit_theme_2();">
								<option value="0">Без темы</option>
								<?php
								foreach ($themes as $key)
								{
									$id_th=$key['id_theme'];
									$name_theme=$key['name_th'];
									echo "<option value=$id_th>$name_theme";
								}
								?>
							</select>
						</td>
					</tr>
				</table>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()"><i class="icon-remove-sign icon-white"></i> Закрыть окно</div>
		</div>
		<!-- Конец окна с темами -->

		<div class="overlay" id="overlay" style="background-color:black;display:none;position:fixed;top:0px;bottom:0px;left:0px;right:0px;z-index:50;opacity:0.5;"></div>

		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>tests/dest_view/<?php echo $dest;?>">Управление тестами. Дисциплины</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>tests/disc_view/<?php echo $dest."/".$id_disc;?>">Тесты дисциплины "<?php echo $disciplin[0]['name_test'];?>"</a> <span class="divider">/</span></li>
  				<li class="active">Вопросы теста "<?php echo $razdel[0]['name_razd'];?>"</li>
			</ul>
			<table class="sortable" id="groups" style="font-size:10px;">
				<thead>
					<tr>
						<td align="center"><b>#</b></td>
						<td align="center"><b>ID</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Тема</b></td>
						<td align="center"><b>Тип</b></td>
						<td align="center"><b>Актив</b></td>
						<td align="center"><b>Цена</b></td>
						<td align="center"><b>Номер</b></td>
						<td align="center"><b>Вариант</b></td>
						<td align="center" colspan="2"><b>Действия</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				$ch=1;
				foreach ($questions as $key)
				{
					$id_q=$key['id'];
					echo "<tr>";
					echo "<td>$ch</td>";
					echo "<td>".$key['id']."</td>";
					$ch++;
					$text_q=$key['text'];
					echo "<td><center>
					<div onClick=func_edit_text($id_q) id=text$id_q>$text_q</div>
					</center></td>";
					echo "<td><center><div onClick=\"javascript: func_edit_theme($id_q)\">".$key['name_th']."</div></center></td>";
					$type=$key['type'];
					switch ($type)
					{
						case '1': $type_name="Закрытый.Один"; break;
						case '2': $type_name="Закрытый.Много"; break;
						case '3': $type_name="Открытый.Текст"; break;
						case '4': $type_name="Открытый.Соответствие"; break;
						case '5': $type_name="Модерация"; break;
						case '6': $type_name="Числовой диапазон"; break;
						default: $type_name="Закрытый.Один"; break;
					}
					echo "<td>$type_name</td>";
					$active=$key['active'];
					if ($active==0) {$active_name="<i class=\"icon-eye-close\"></i>";} else {$active_name="<i class=\"icon-eye-open\"></i>";}
					echo "<td><center>
					<div onClick=\"javascript: func_edit_active($id_q)\">$active_name</div>
					</center></td>";
					if ($key['level']==0)
					{
						echo "<td ><center>Брак</center></td>";
					}
					else
					{
						echo "<td><center>
						<div>".$key['level']."</div>
						</center></td>";
					}
					echo "<td><center>
					<div onClick=\"javascript: func_edit_number($id_q)\"><b>".$key['number']."</b></div>
					</center></td>";
					echo "<td><center>
					<div onClick=\"javascript: func_edit_var($id_q)\">".$key['variant']."</div>
					</center></td>";
					echo "<td><center>
					<form action=\"";
					echo base_url();
					echo "tests/answers_view/$dest/$id_disc/$id_test/$id_q\" method=\"post\" name=\"edit$id_q\">
						<input style=\"width:90px;margin:0 0 0 0;font-size:10px;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Просмотр\">
					</form></td>";
					echo "<td><center>
					<div onClick=\"javascript: func_del($id_q)\">
						<i class=\"icon-remove\"></i>
					</div>
					</center></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
			<center>
			<?php 
			if (count($themes)>0)
			{
				?>
				<div class="btn-group">
					<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-info" onClick="javascript: func_open_balance_dsc()">
						<i class="icon-signal icon-white"></i> Баланс сложности
					</div>
					<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_open_create_dsc()">
						<i class="icon-plus icon-white"></i> Новый вопрос
					</div>
					<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_open_dubl_dsc()">
						<i class="icon-th-list icon-white"></i> Старый вопрос
					</div>
				</div>
				<?php
			}
			else
			{
				echo "Вопрос не может быть создан, так как в учебном плане не указано ни одной темы (Администрирование -> Менеджер учебных планов).<br />";
			}
			?>
		</div>
		<div id="root" class="createDscForm" style="width:90%;display:none;margin:15px auto;">
			<h1>Добавить вопрос</h1>
			<form action="<?php echo base_url()?>tests/create_quest/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Текст вопроса</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="q_text" rows="5" style="width:500px"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Тема</td>
						<td align="left" width="60%">
							<SELECT NAME="q_theme">
								<?php
								foreach ($themes as $key)
								{
									$id_th=$key['id_theme'];
									$name_theme=$key['name_th'];
									echo "<option value=$id_th>$name_theme";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Вариант</td>
						<td align="left" width="60%">
							<SELECT NAME="q_var">
								<OPTION VALUE="1">1
								<OPTION VALUE="2">2
								<OPTION VALUE="3">3
								<OPTION VALUE="4">4
								<OPTION VALUE="5">5
								<OPTION VALUE="6">6
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Изображение (если есть)</td>
						<td align="left" width="60%">
							<input type="file" name="userfile" size="20" />
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Тип вопроса</td>
						<td align="left" width="60%">
							<SELECT NAME="q_type" id="q_type" onChange="createVariants()">
								<OPTION VALUE="0">Выберите тип вопроса:
								<OPTION VALUE="1">Один ответ на выбор
								<OPTION VALUE="2">Несколько ответов
								<OPTION VALUE="3">Ввод слова
								<OPTION VALUE="4">Соответствие
								<OPTION VALUE="5">Проверяемое задание
								<OPTION VALUE="6">Числовой диапазон
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%"><div class="q_kol_class" style="display:none;">Количество ответов</div></td>
						<td align="left" width="60%">
							<div class="q_kol_class" style="display:none;">
								<SELECT NAME="q_kol_a" id="q_kol_a" onChange="createVariants()">
									<OPTION VALUE="0" selected>
									<OPTION VALUE="2">2
									<OPTION VALUE="3">3
									<OPTION VALUE="4">4
									<OPTION VALUE="5">5
									<OPTION VALUE="6">6
									<OPTION VALUE="7">7
									<OPTION VALUE="8">8
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><div id="q_variants_title"></div></td>
						<td align="left"><div id="q_variants_content"></div></td>
					</tr>
				</table>
			</form>
			<center>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="func_create()">
					<i class="icon-plus icon-white"></i> Добавить вопрос
				</div>
			</center>
		</div>
		<div id="root" class="dublDscForm" style="width:1100;display:none;margin:15px 0 0 0;">
			<form action="<?php echo base_url()?>tests/duplicate_quest/<?php echo $dest."/".$id_disc."/".$id_test?>" method="post" name="dublForm" autocomplete="off" enctype="multipart/form-data">
			<table class="sortable" id="groups23" style="font-size:10px;width:100%">
				<thead>
					<tr>
						<td align="center"><b>Выбор</b></td>
						<td align="center"><b>ID</b></td>
						<td align="center"><b>Вопрос</b></td>
						<td align="center"><b>Тема</b></td>
						<td align="center"><b>Цена</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($all_quests as $key)
				{
					echo "<tr>
					<td><INPUT style=\"width:20px;margin-left:5px;margin:0 0 0 0;\" TYPE=checkbox NAME=dubl_q[".$key['id']."]></td>
					<td>".$key['id']."</td>
					<td>".$key['text']."</td>
					<td>".$key['name_th']."</td>
					<td>".$key['level']."</td></tr>";
				}
				?>
				</tbody>
			</table>
			</form>
			<center>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_dubl()">
				<i class="icon-plus icon-white"></i> Скопировать вопросы
			</div>
			</center>
		</div>
		<div id="root" class="balanceDscForm" style="width:1100;display:none;margin:15px 0 0 0;">
			<?php
			foreach ($vars as $key)
			{
				echo "<h1>".$key['variant']." вариант</h1>";
				?>
				<table class="sortable" id="groups23" style="font-size:10px;width:100%">
					<thead>
						<tr>
							<td align="center" width=10%><b>Цена</b></td>
							<td align="center" width=10%><b>Количество</b></td>
							<td align="center" width=10% colspan=2><b>Процент</b></td>
						</tr>
					</thead>
					<tbody>
					<?php
					for($i=0;$i<5;$i++)
					{
					echo "<tr>
							<td>$i</td>
							<td>".$vars_array[$key['variant']]['abs'][$i]."</td>
							<td width=10%>".$vars_array[$key['variant']]['otn'][$i]."%</td>
							<td>
								<div class=\"progress";
								if ($i == 0)
								{
									echo " progress-danger";
								}
								echo "\">
									<div class=\"bar\" style=\"width: ".$vars_array[$key['variant']]['otn'][$i]."%;\"></div>
								</div>
							</td>
						</tr>";
					}
					?>
					</tbody>
				</table>
				<br/>
				<?php
			}
			?>
		</div>
	</body>
</html>