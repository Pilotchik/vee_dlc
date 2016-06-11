<html>
	<head>
		<title>Система тестирования. Администрирование. Лекции курса</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/tinymce/tiny_mce.js"></script>
		<script type="text/javascript">
			function func_open_create_dsc()
			{
				$('#myModalCreate').modal('show');
			}

			function func_create()	{document.createForm.submit();}

			function func_del(id_q)
			{
				if (confirm("Удалить лекцию?")) 
				{
					document.getElementById('q_id_del').innerHTML="<input type=hidden name=q_id value=\""+id_q+"\">";
					document.delForm.submit();	
				}
			}

			function func_edit(id_q,type)
			{
				text = '';
				$('#myModalConfirm').modal('show');
				switch (type) 
				{
					case 'name': text = 'Введите новое название лекции'; $('#q_value_text').val($('#text'+id_q).html()); break;
					case 'active': text = '0 - лекцию не увидят студенты, 1 - лекция будет в списке доступных для изучения'; break;
					case 'comment': text = 'Введите новый текст комментария (необходим для администрирования)'; $('#q_value_text').val($('#comm'+id_q).html()); break;
					case 'tags': text = 'Введите ключевые понятия лекции, по которым лекцию будет проще найти'; $('#q_value_text').val($('#tags'+id_q).html()); break;
				}
				$('#text_param').html(text);
				$('#q_id').html("<input type=hidden name=q_id value=\""+id_q+"\">");
				$('#q_param').html("<input type=hidden name=q_param value=\""+type+"\">");
			}

			function func_view_content(id_q)
			{
				text1 = '<textarea id="elm2" name="q_value" style="height:100%">';
				id_q = String(id_q);
				switch (id_q) 
				{
					<?php
					foreach ($lections as $key)
					{
						$element = htmlspecialchars($key['content']);
						$element = preg_replace("/\r?\n/", "\\n", addslashes($element));
						echo "case '".$key['id']."': text = '".$element."'; break;"; 
					}
					?>
				}
				text = text1 + text + '</textarea>';
				$('#q_value_text2').html(text);
				$('#text_param2').html('Изменение параметров контента');
				$('#q_id2').html("<input type=hidden name=q_id value=\""+id_q+"\">");
				$('#q_param2').html("<input type=hidden name=q_param value=content>");
				tinyMCE.init({
				mode : "textareas",
				language : "ru",
				mode : "exact",
       			elements : "elm2",
       			auto_focus : "elm2",
       			theme : "advanced",
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,wordcount,advlist,autosave,visualblocks,images",

				// Theme options
				theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,|,print,|,fullscreen",
				theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,|,nonbreaking,pagebreak,visualblocks,images",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// Example content CSS (should be your site CSS)
				content_css : "<?php echo base_url()?>css/content.css",

				});
				$('#myModalContent').modal('show');
			}

			function showWYSIWIG()
			{
				$('#Docs').hide('fast');
				$('#WYSIWIG').show('slow');
			}

			function showDocs()
			{
				$('#WYSIWIG').hide('fast');
				$('#Docs').show('slow');
			}

			function send_editForm()	{document.editForm.submit();}
			function send_editForm2()	{document.editForm2.submit();}

			function func_edit_test(id_q)
			{
				selected_test = $('#test'+id_q).html();
				text = '<select name="q_value"><option value=0>Без теста</option>';
				<?php
				foreach($tests as $key)
				{
					echo "text = text + '<option value = ".$key['id'].">".$key['name_razd']."</option>';";
				}
				?>
				text = text + '</select>';
				$('#q_value3').html(text);
				$('#q_id3').html("<input type=hidden name=q_id value=\""+id_q+"\">");
				$('#q_param3').html("<input type=hidden name=q_param value=test_id>");
				$('#myModalTest').modal('show');
			}

			function func_edit_number(id_q,new_number)
			{
				$('#q_id4').html("<input type=hidden name=q_id value=\""+id_q+"\">");
				$('#q_param4').html("<input type=hidden name=q_param value=\"number\">");
				$('#q_value4').html("<input type=hidden name=q_value value=\""+new_number+"\">");
				document.editForm4.submit();
			}

			function send_editForm3()	{document.editForm3.submit();}
		</script>
		<script>
			tinyMCE.init({
			mode : "exact",
       		elements : "elm1",
       		language : "ru",
       		auto_focus : "elm1",
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,wordcount,advlist,autosave,visualblocks,images",

			// Theme options
			theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,|,print,|,fullscreen",
			theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,|,nonbreaking,pagebreak,visualblocks,images",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "<?php echo base_url()?>css/content.css",

			});
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<form action="<?php echo base_url();?>de_admin/lection_del/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="delForm">
			<div id="q_id_del"></div>
		</form></td>

		<form action="<?php echo base_url();?>de_admin/lection_edit/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="editForm4">
			<div id="q_value4"></div>
			<div id="q_id4"></div>
			<div id="q_param4"></div>
		</form>
		
		<div id="myModalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение параметров</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param"></div></p>
  				<form action="<?php echo base_url();?>de_admin/lection_edit/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="editForm">
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

		<div id="myModalContent" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:900px;margin-left: -450px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение контента лекции</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param2"></div></p>
  				<form action="<?php echo base_url();?>de_admin/lection_edit/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="editForm2">
					<div id="q_value_text2" style="min-width:100%;min-height:500px" rows="4"></div>
					<div id="q_value2"></div>
					<div id="q_id2"></div>
					<div id="q_param2"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_editForm2()">Ок</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<div id="myModalTest" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение теста для лекции</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param3"></div></p>
  				<form action="<?php echo base_url();?>de_admin/lection_edit/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="editForm3">
					<div id="q_value_text3" style="min-width:100%" rows="4"></div>
					<div id="q_value3"></div>
					<div id="q_id3"></div>
					<div id="q_param3"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" onClick="send_editForm3()">Изменить</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<div id="myModalCreate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:900px;margin-left: -450px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание новой лекции</h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>de_admin/lection_create/<?php echo $dest."/".$id_disc."/".$id_test;?>" method="post" name="createForm" autocomplete="off">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название лекции</td>
						<td align="left" width="60%">
							<input class="inputbox" name="lection_name" size="100" type="text" style="width: 400px;height: 30px;text-align: center;">
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Комментарий</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="comment" cols="40" rows="5"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Ключевые термины лекции (через запятую)</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="tags" cols="40" rows="5"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Необходим ли тест после изучения материала? Если тест ещё не создан, этот параметр можно будет изменить позже.</td>
						<td align="left" width="60%">
							<select name="test_id">
								<option value="0">Пока без теста</option>
								<?php
								foreach ($tests as $key)
								{
									echo "<option value=".$key['id'].">".$key['name_razd']."</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Тип контента:</td>
						<td align="left">
							<label class="radio"><input type="radio" name="type" value="0" onClick="showWYSIWIG()">Текст с графикой и видео</label>
							<label class="radio"><input type="radio" name="type" value="1" onClick="showDocs()">Презентация Google Docs</label>
						</td>
					</tr>
					<tr>
						<td colspan="2" width="100%">
						<div style="display: none;" id="WYSIWIG">
							<textarea id="elm1" name="area" style="height:100%; width:100%;min-width:100%;"></textarea>
						</div>
						<div style="display: none;" id="Docs">
							<textarea name="area_docs" style="height:100%; width:100%;min-width:100%;" placeholder="Вставьте код презентации Google Docs"></textarea>
						</div>
						</td>
					</tr>
				</table>
			</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" onClick="func_create()">Создать</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li><a href="<?php echo base_url();?>de_admin/disc_view/<?php echo $dest;?>">Управление ЭК. Дисциплины</a> <span class="divider">/</span></li>
  				<li><a href="<?php echo base_url();?>de_admin/courses_view/<?php echo $dest."/".$id_disc;?>"><?php echo $disciplin[0]['name_test'];?></a> <span class="divider">/</span></li>
  				<li class="active">Лекции учебного курса "<?php echo $course;?>"</li>
			</ul>
			<table class="sortable" id="groups" style="font-size:10px;">
				<thead>
					<tr>
						<td align="center" colspan="3"><b>#</b></td>
						<td align="center"><b>Название</b></td>
						<td align="center"><b>Теги</b></td>
						<td align="center"><b>Актив</b></td>
						<td align="center"><b>Комментарий</b></td>
						<td align="center"><b>Контент</b></td>
						<td align="center"><b>Тест</b></td>
						<td align="center"><b>Дата</b></td>
						<td align="center"><b>Удалить</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				$ch=1;
				foreach ($lections as $key)
				{
					$id_q=$key['id'];
					$plus = $key['number'] + 1;
					$minus = $key['number'] - 1;
					echo "<tr>
					<td>".$key['number']."</td>
					<td><i class=\"icon-circle-arrow-up\" onClick=\"func_edit_number($id_q,$plus)\"></i></td>
					<td><i class=\"icon-circle-arrow-down\" onClick=\"func_edit_number($id_q,$minus)\"></i></td>";
					$text_q = $key['name'];
					echo "<td align=center>
						<div onClick=func_edit($id_q,'name') id=text$id_q>$text_q</div>
					</td>
					<td align=center><div onClick=\"javascript: func_edit($id_q,'tags')\"
						";
						if ($key['tags'] != "") {echo " id=tags$id_q>".$key['tags'];} else {echo "><i class=\"icon-plus\"></i>";}
					echo "</div>
					</td>";
					if ($key['active'] == 0) {$active_name="<i class=\"icon-eye-close\"></i>";} else {$active_name="<i class=\"icon-eye-open\"></i>";}
					echo "<td align=center>
						<div onClick=\"javascript: func_edit($id_q,'active')\">$active_name</div>
					</td>
					<td align=center>
						<div onClick=\"javascript: func_edit($id_q,'comment')\"";
						if ($key['comment'] != "") {echo " id=comm$id_q>".$key['comment'];} else {echo "><i class=\"icon-plus\"></i>";}
						echo "</div>
					</td>
					<td align=center>
						<div onClick=\"javascript: func_view_content($id_q)\"><i class=\"icon-book\"></i></div>
					</td>
					<td align=center>
						<div id=test$id_q style=\"display:none\">".$key['test_id']."</div>
						<div onClick=\"javascript: func_edit_test($id_q)\">";
					if ($key['test_id'] == 0)
					{
						echo "<i class=\"icon-plus\"></i>";
					}
					else
					{
						echo $test_name[$key['id']];
					}
					echo "</div>
					</td>
					<td>".$key['data']."</td>
					<td align=center>
						<div onClick=\"javascript: func_del($id_q)\"><i class=\"icon-remove\"></i></div>
					</td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<br />
			<center>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_open_create_dsc()">
				<i class="icon-plus icon-white"></i> Новая лекция
			</div>
			</center>
		</div>
	</body>
</html>