<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/tinymce/tiny_mce.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
		<script type="text/javascript">
			function func_edit(mat_id)
			{
				$('#myModalEdit').modal('show');
				$('#text_param').html("Введите новое название материала \""+$('#name'+mat_id).html()+"\"");
				$('#mat_id').html("<input type=hidden name=mat_id value=\""+mat_id+"\">");
				$('#mat_param').html("<input type=hidden name=mat_param value=\"name\">");
			}

			function func_create(disc_id)		
			{
				$('#disc_id_div').html("<input type=hidden name=disc_id value=\""+disc_id+"\">");
				$('#myModalCreate').modal('show');
			}
			function create_form()	{document.createForm.submit();}

			function func_del(mat_id)
			{
				$('#myModalDel').modal('show');
				$('#text_param2').html("Вы действительно хотите удалить материал "+$('#name'+mat_id).html()+"?");
				$('#mat_id2').html("<input type=hidden name=mat_id value=\""+mat_id+"\">");
				$('#mat_param2').html("<input type=hidden name=mat_param value=\"del\">");
				$('#mat_value2').html("<input type=hidden name=mat_value value=1>");
			}

			function send_form()	{document.editForm.submit();}
			function send_form2()	{document.editForm2.submit();}
		</script>
	</head>
	<body>
		<form action="<?php echo base_url();?>kat/view_content" method="post" name="goForm">
			<div id="test_id"></div>
		</form>

		<div id="myModalEdit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Изменение параметров</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param"></div></p>
  				<form action="<?php echo base_url();?>kat_admin/mat_edit/<?php echo $dest;?>" method="post" name="editForm">
					<center>
						<input type="text" name="mat_value" style="width:200px;height:30px;text-align:center;">
					</center>
					<div id="mat_id"></div>
					<div id="mat_param"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_form()">Ок</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<div id="myModalDel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Удаление</h3>
  			</div>
  			<div class="modal-body">
  				<p><div id="text_param2"></div></p>
  				<form action="<?php echo base_url();?>kat_admin/mat_edit/<?php echo $dest;?>" method="post" name="editForm2">
					<div id="mat_value2"></div>
					<div id="mat_id2"></div>
					<div id="mat_param2"></div>
				</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-danger" style="width:100px" onClick="send_form2()">Ок</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

		<div id="myModalCreate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:900px;margin-left: -450px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Создание нового материала для лекции</h3>
  			</div>
  			<div class="modal-body">
  				<form action="<?php echo base_url()?>kat_admin/mat_create/<?php echo $dest;?>" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<div id="disc_id_div"></div>
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Название материала</td>
						<td align="left" width="60%">
							<input class="inputbox" name="mat_name" size="100" type="text" style="width: 400px;height: 30px;text-align: center;">
						</td>
					</tr>
					<tr>
							<td align="right">Файл (если есть). Максимальный размер файла - 40 Мб. Разрешённые форматы: gif, jpg, png, doc, ppt,xls, pdf, txt, rtf, xlsx, docx, pptx, zip, rar</td>
							<td align="left">
								<input type="file" name="userfile" size="20" />
							</td>
						</tr>
					<tr>
						<td colspan="2" width="100%">
							<textarea id="elm1" name="area" style="height:100%; width:100%;min-width:100%;"></textarea>
						</td>
					</tr>
				</table>
			</form>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" onClick="create_form()">Создать</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>
		
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Управление справочными материалами</li>
			</ul>
			<div class="accordion" id="accordion2">
  				<?php
  				$i = 1;
  				foreach ($disciplines as $key)
				{
					$disc_id = $key['id'];
					?>
  					<div class="accordion-group">
    					<div class="accordion-heading" style="background-color: rgb(235, 232, 232);">
      						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i;?>" style="font-size: 18;">
        						<i class="icon-arrow-down"></i> <?php echo $key['name_test']; ?>
      						</a>
    					</div>
    					<div id="collapse<?php echo $i;?>" class="accordion-body collapse">
      						<div class="accordion-inner" style="padding: 0px 0px;">
        						<table width="100%" class="table" style="margin-bottom:0px;">
        						<?php
								foreach ($materials[$key['id']] as $key2)
								{
									$id_mat = $key2['id'];
									echo "
									<tr class=info>
										<td width=70% align=left style=\"line-height: 30px;\">
											<div id=\"name$id_mat\">".$key2['name']."</div>
										</td>";
										?>
										<td align="center">
											<div onClick="func_edit(<?php echo $id_mat;?>)" style="margin: 10px 0 0 0;"><i class="icon-pencil"></i></div>
										</td>
										<td align="center">
											<div onClick="func_del(<?php echo $id_mat;?>)" style="margin: 10px 0 0 0;"><i class="icon-remove"></i></div>
										</td>
									</tr>
										<?php
								}
								?>
									<tr>
										<td colspan="2" align="right">
											<div style="width:30%;margin:5px 0 0 65%;" class="btn btn-info" onClick="javascript: func_create(<?php echo $disc_id;?>)">
												<i class="icon-plus icon-white"></i> Добавить новые материалы
											</div>
										</td>
									</tr>
								</table>
							</div>
    					</div>
  					</div>
  					<?php 
  					$i++;
  				}
  				?>
			</div>
			<br />
		</div>
	</body>
</html>