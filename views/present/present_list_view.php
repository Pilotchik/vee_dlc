<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	
	<style>
		form {margin:0 0 0 0;}
	</style>
	<script type="text/javascript">
		function func_open_create_dsc()	{$('#myModalCreate').modal('show');}
		
		function func_del(id_q)
		{
			$('#del_title').html($('#title_'+id_q).html());
			$('#del_id').val(id_q);
			$('#myModalDel').modal('show');
		}

		function func_edit(id_q)
		{
			$('#edit_title').val($('#title_'+id_q).html());
			$('#edit_desc').html($('#desc_'+id_q).html());
			$('#edit_id').val(id_q);
			$('#myModalEdit').modal('show');
		}
	</script>

	<div class="modal fade" id="myModalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Удаление презентации</h4>
	    		</div>
	    		<div class="modal-body">
	    			<p style="text-align: center;text-indent: 0px;">Вы уверены, что хотите удалить презентацию <b>"<span id="del_title"></span>"</b></p>
					<form action="<?= base_url() ?>present_admin/present_del" method="post" role="form">
						<input type="hidden" id="del_id" value="" name="c_id">
	      		</div>
	      		<div class="modal-footer">
	      			<button class="btn btn-danger" type="submit">Удалить</button>
	      			</form>
	        		<button type="button" class="btn" data-dismiss="modal">Отмена</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="myModalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content" style="width: 650;">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Создание презентации</h4>
	    		</div>
	    		<div class="modal-body">
	    			<form action="<?= base_url() ?>present_admin/present_create" method="post">
						<div class="form-group">
    						<label>Название презентации</label>
    						<input type="text" class="form-control" placeholder="Введите название презентации" name="f_title">
  						</div>
  						<div class="form-group">
    						<label>Описание презентации</label>
    						<textarea class="form-control" rows="2" name="f_description"></textarea>
  						</div>
  						<div class="form-group">
    						<label>Выберите тип переходов между слайдами:</label>
    						<table width="100%">
    							<tr>
    								<td width="25%">
			  							<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="default" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/default.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="concave" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/concave.png">
			  								</label>
										</div>
									</td>
								
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="fade" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/fade.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="linear" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/linear.png">
			  								</label>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="form-group">
    						<label>Выберите стиль слайдов:</label>
    						<table width="100%">
    							<tr>
    								<td width="25%">
			  							<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="beige" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/beige.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="moon" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/moon.png">
			  								</label>
										</div>
									</td>
								
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="simple" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/simple.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="sky" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/sky.png">
			  								</label>
										</div>
									</td>
								</tr>
							</table>
						</div>
	      		</div>
	      		<div class="modal-footer">
	      			<button class="btn btn-success" type="submit">Создать</button>
	      			</form>
	        		<button type="button" class="btn" data-dismiss="modal">Отмена</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
	    	<div class="modal-content" style="width: 650;">
	    		<div class="modal-header">
	    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    			<h4 class="modal-title">Изменение параметров презентации</h4>
	    		</div>
	    		<div class="modal-body">
	    			<form action="<?= base_url() ?>present_admin/present_edit" method="post">
						<div class="form-group">
    						<label>Название презентации</label>
    						<input type="text" class="form-control" placeholder="Введите название презентации" name="f_title" id="edit_title">
  						</div>
  						<div class="form-group">
    						<label>Параметры публикации</label>
    						<select class="form-control" name="f_status">
    							<option value="0">Презентация скрыта</option>
    							<option value="1">Презентация опубликована</option>
    						</select>
  						</div>
  						<div class="form-group">
    						<label>Описание презентации</label>
    						<textarea class="form-control" rows="2" name="f_description" id="edit_desc"></textarea>
  						</div>
  						<div class="form-group">
    						<label>Выберите тип переходов между слайдами:</label>
    						<table width="100%">
    							<tr>
    								<td width="25%">
			  							<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="default" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/default.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="concave" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/concave.png">
			  								</label>
										</div>
									</td>
								
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="fade" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/fade.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_transition" value="linear" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/linear.png">
			  								</label>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="form-group">
    						<label>Выберите стиль слайдов:</label>
    						<table width="100%">
    							<tr>
    								<td width="25%">
			  							<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="beige" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/beige.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="moon" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/moon.png">
			  								</label>
										</div>
									</td>
								
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="simple" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/simple.png">
			  								</label>
										</div>
									</td>
									<td width="25%">
										<div class="radio">
			  								<label>
			    								<input type="radio" name="f_theme" value="sky" style="margin-top: 50;width: 20px;height: 20px;margin-right: 10px;">
			    								<img src="<?= base_url() ?>images/reveal/sky.png">
			  								</label>
										</div>
									</td>
								</tr>
							</table>
						</div>
	      		</div>
	      		<input type="hidden" name="f_id" value="" id="edit_id">
	      		<div class="modal-footer">
	      			<button class="btn btn-success" type="submit">Изменить</button>
	      			</form>
	        		<button type="button" class="btn" data-dismiss="modal">Отмена</button>
	      		</div>
	 		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<ul class="breadcrumb">
  		<li class="active">Презентации</li>
	</ul>

	<button class="btn btn-success btn-lg" onClick="func_open_create_dsc()">
		<span class="glyphicon glyphicon-plus"></span> Создать презентацию
	</button>

	<h3>Доступные презентации</h3>

	<?php
	if (count($presents_nmy) > 0)
	{
		?>
		<div class="row">
			<?php
			foreach ($presents_nmy as $key)
			{
				?>
				<div class="col-sm-6 col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4><?= $key['present_name'] ?></h4>
						</div>
						<div class="panel-collapse collapse in"> 
							<div class="panel-body">
								<?= $key['description'] ?>
							</div>
							<ul class="list-group">
								<li class="list-group-item">Автор: <b><?= $author[$key['id']] ?></b></li>
								<li class="list-group-item">Дата создания: <b><?= $key['date'] ?></b></li>
								<li class="list-group-item" style="text-align:right;">
									<div class="btn-group">
										<!--	
										<form action="<?= base_url() ?>present/play/<?= $key['id'] ?>" method="get">
											<input style="width:90px;margin:0 0 0 0;font-size:10px;" class="btn btn-inverse" type="submit" value="Проектор">
											</form>
										-->
										<a href="<?= base_url() ?>present/play/<?= $key['id'] ?>?theme=<?= $key['theme'] ?>&transition=<?= $key['transition'] ?>" class="btn btn-success"><span class="glyphicon glyphicon-play"></span> Просмотр</a>
										<?php
										if ($this->session->userdata('guest') > 1)
										{
											?>
											<a href="<?= base_url() ?>present_admin/present_view/<?= $key['id'] ?>" class="btn btn-info"><span class="glyphicon glyphicon-plane"></span> Управление</a>
											<?php
										}
										?>
									</div>
								</li>

							</ul>
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
		?>
		Презентаций пока нет
		<?php
	}
	?>

	<h3  style="margin-top:20px;">Мои презентации</h3>
	<div class="row">
	<?php
	if (count($presents_my) > 0)
	{
		foreach ($presents_my as $key)
		{
			?>
			<div class="col-sm-6 col-md-6" style="min-height: 430px;">
				<div class="panel panel-primary">
					<div class="panel-heading" style="background-color:#34495e">
						<h4 id="title_<?= $key['id'] ?>"><?= $key['present_name'] ?></h4>
					</div>
					<div class="panel-collapse collapse in"> 
						<div class="panel-body" onClick="func_edit(<?= $key['id'] ?>,'description')" id="desc_<?= $key['id'] ?>"><?= $key['description'] ?></div>
						<ul class="list-group">
							<li class="list-group-item">Дата создания: <b><?= $key['date'] ?></b></li>
							<li class="list-group-item">Опубликовано: <span onClick="func_edit(<?= $key['id'] ?>,'public_status')" style="font-size:20px;" class="glyphicon glyphicon-<?= ($key['public_status'] != 0 ? "ok" : "remove"); ?>"></span></li>
							<li class="list-group-item">
								<img src="<?= base_url() ?>images/reveal/<?= $key['theme'] ?>.png">
								<img src="<?= base_url() ?>images/reveal/<?= $key['transition'] ?>.png">
							</li>

							<li class="list-group-item" style="text-align:right;">
								<div class="btn-group">
									<a href="<?= base_url() ?>present/play/<?= $key['id'] ?>?theme=<?= $key['theme'] ?>&transition=<?= $key['transition'] ?>" class="btn btn-success"><span class="glyphicon glyphicon-play"></span> Просмотр</a>
									<?php
										if ($this->session->userdata('guest') > 1)
										{
											?>
											<a href="<?= base_url() ?>present_admin/present_view/<?= $key['id'] ?>" class="btn btn-default"><span class="glyphicon glyphicon-plane"></span> Управление</a>
											<?php
										}
										?>
									<a href="<?= base_url() ?>present_admin/slides_view/<?= $key['id'] ?>" class="btn btn-info">Управление слайдами</a>
									<a onClick="func_edit(<?= $key['id'] ?>)" class="btn btn-warning" style="padding: 9px 12px;"> <span class="glyphicon glyphicon-pencil"></span></a>
									<a onClick="func_del(<?= $key['id'] ?>)" class="btn btn-danger" style="padding: 9px 12px;"><span class="glyphicon glyphicon-remove"></span></a>
								</div>
							</li>

						</ul>
					</div>
				</div>
			</div>
			<?php
		}
	}
	else
	{
		?>
		Моих презентаций пока нет
		<?php
	}
	?>
	</div>
</div>

<?php require_once(APPPATH.'views/require_header.php');?>