<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

	<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content"  style="width: 680px;">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Изменение параметров слайда</h4>
	    		</div>
	    		<div class="modal-body">
		    		<p><div id="text_param"></div></p>
	  				<form action="<?= base_url() ?>present_admin/slide_edit/<?= $present_id ?>" method="post" name="editForm">
						<textarea id="q_value_text" name="q_value" style="min-width:100%" rows="4"></textarea>
						<input type="hidden" name="q_id" value="" id="edit_id">
						<input type="hidden" name="q_param" value="" id="edit_param">
	      		</div>
	      		<div class="modal-footer">
	      			<button class="btn" type="submit">Изменить</button>
	      			</form>
	        		<button type="button" class="btn" data-dismiss="modal">Отмена</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script type="text/javascript" src="<?php echo base_url()?>js/tinymce/tiny_mce.js"></script>

	<div class="modal fade" id="myModalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content" style="width: 680px;">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Создание слайда</h4>
	    		</div>
	    		<div class="modal-body">
		    		<form action="<?= base_url()?>present_admin/slide_create/<?= $present_id ?>" method="post" name="createForm" autocomplete="off">
						<div class="form-group">
    						<label>Заметка к слайду</label>
    						<textarea class="form-control" rows="2" name="f_text"></textarea>
  						</div>
						<textarea id="elm1" name="f_content" style="height:100%; width:100%;min-width:100%;"></textarea>
	      		</div>
	      		<input type="hidden" name="f_main_slide" value="" id="create_main_id">
	      		<div class="modal-footer">
	      			<button class="btn" type="submit">Создать</button>
	      			</form>
	        		<button type="button" class="btn" data-dismiss="modal">Отмена</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

		<form action="<?php echo base_url();?>present_admin/slide_del/<?= $present_id ?>" method="post" name="delForm">
			<div id="q_id_del"></div>
		</form></td>
		
	<style>
		form {margin:0 0 0 0;}
	</style>

	<script type="text/javascript">

		tinyMCE.init({
		mode : "exact",
   		elements : "elm1",
   		language : "en",
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
		//content_css : "<?= base_url() ?>css/reveal/theme/<?= $present_theme ?>.css",

		});
		

		function func_open_create_dsc(id_main)		
		{
			$('#create_main_id').val(id_main);
			$('#myModalCreate').modal('show');
		}
		
		function func_del(id_q)
		{
			if (confirm("Удалить слайд? Слайд архивируется и его сможет восстановить администратор системы")) 
			{
				document.getElementById('q_id_del').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
				document.delForm.submit();	
			}
		}

		function func_edit(id_q,type)
		{
			$('#myModalConfirm').modal('show');
			if (type == 'content')
			{
				$('#q_value_text').html($('#content_'+id_q).html());
				tinyMCE.init({
				language : "en",
				mode : "exact",
       			elements : "q_value_text",
       			auto_focus : "q_value_text",
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

				//content_css : "<?= base_url() ?>css/reveal/theme/<?= $present_theme ?>.css",

				});
			}
			if (type == 'text') 
			{
				$('#text_param').html('Введите новый текст слайда');
				$('#q_value_text').val($('#text_'+id_q).html());
			}
			if (type == 'image') {$('#text_param').html('Введите новую ссылку на изображение слайда');}
			if (type == 'slide') 
			{
				$('#text_param').html('Введите новый порядковый номер слайда');
				$('#q_value_text').html($('#slide_'+id_q).html());
			}
			$('#edit_id').val(id_q);
			$('#edit_param').val(type);
		}
	</script>
		
	<ul class="breadcrumb">
		<li><a href="<?= base_url() ?>present_admin">Управление презентациями</a></li>
		<li class="active">Слайды презентации "<?= $present_name ?>"</li>
	</ul>

	<?php
	if (count($present_slides) > 0)
	{
		foreach ($present_slides as $key)
		{
			?>
				<div class="panel panel-primary">
  					<div class="panel-heading">
  						Слайд <span class="label label-success" onClick="func_edit(<?= $key['id']?>,'slide')" id="slide_<?= $key['id']?>"><?= $key['slide'] ?></span>
  					</div>
  					<div class="panel-body">
    					<p onClick="func_edit(<?= $key['id']?>,'text')" id="text_<?= $key['id']?>"><?= $key['text'] ?></p>
  					</div>
  					<ul class="list-group">
  						<li class="list-group-item" onClick="func_edit(<?= $key['id']?>,'content')" id="content_<?= $key['id']?>"><?= $key['content'] ?></li>
  						<!-- Добавить подслайды-->
  						<?php
  						if (count($subslides[$key['id']]) > 0)
  						{
  							?>
  							<div class="row" style="margin:10px;">
  								<?php
  								foreach ($subslides[$key['id']] as $key2)
  								{
									?>
									<div class="col-sm-6 col-md-6">
										<div class="panel panel-info">
  											<div class="panel-heading">
  												Слайд <span class="label label-success" onClick="func_edit(<?= $key2['id']?>,'slide')" id="slide_<?= $key2['id']?>"><?= $key2['slide'] ?></span>
  											</div>
  											<div class="panel-body">
    											<p onClick="func_edit(<?= $key2['id']?>,'text')" id="text_<?= $key2['id']?>"><?= $key2['text'] ?></p>
						  					</div>
  											<ul class="list-group">
  												<li class="list-group-item" onClick="func_edit(<?= $key2['id']?>,'content')" id="content_<?= $key2['id']?>"><?= $key2['content'] ?></li>
  												<li class="list-group-item" style="text-align:right;">
													<a onClick="func_del(<?= $key2['id'] ?>)" class="btn btn-danger" style="padding: 12px 12px;"><span class="glyphicon glyphicon-remove"></span></a>
												</li>
											</ul>
										</div>
									</div>
									<?php
								}
								?>
  							</div>
  							<?php
  						}
  						?>
  						<li class="list-group-item" style="text-align:right;">
							<div class="btn-group">
								<a onClick="func_open_create_dsc(<?= $key['id'] ?>)" class="btn btn-success" style="padding: 9px 12px;">Добавить подслайд</a>
								<a onClick="func_del(<?= $key['id'] ?>)" class="btn btn-danger" style="padding: 12px 12px;"><span class="glyphicon glyphicon-remove"></span></a>
							</div>
						</li>
					</ul>
				</div>
				<?php 
			}
	}
	else
	{
		?>
		В этой презентации пока ещё нет ни одного слайда
		<?php
	}
	?>

	<div id="row" style="text-align:center;width:100%;margin:20px auto;">
		<button class="btn btn-success btn-lg" onClick="func_open_create_dsc(0)">
			<span class="glyphicon glyphicon-plus"></span> Добавить слайд
		</button>
	</div>
</div>

<?php require_once(APPPATH.'views/require_header.php');?>