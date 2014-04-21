<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

<script>
	function show_delete_confirm(id_q)
		{
			$("#deleteThemesModal").modal('show');
			$("#inputIdDelete").val(id_q);
		}
</script>

<div class="modal fade" id="deleteThemesModal">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Вы действительно хотите удалить это соответствие?</h4>
	  			</div>
	  			<div class="modal-body">
					<form action="<?php echo base_url();?>kat_admin/delete_accordance/<?php echo $id_mat; ?>" method="post">
    					<input type="hidden" name="delete_id" id="inputIdDelete">
    					<button type="submit" class="btn btn-primary">Да, удалить</button>
    					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
					</form>
	  			</div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<ol class="breadcrumb">
  	<li><a href="<?= base_url() ?>kat_admin/view_materials">Материалы. Соответствие темам</a></li>
  	<li class="active"><?= $currentmat[0]['name'] ?></li>
</ol>

<div class="form-group">
		<h4 class="modal-title">Задать соответствие материала теме</h4>
	  	<div class="form-group">
				<form action="<?php echo base_url();?>kat_admin/edit_accordance" method="post">
					<div class="form-group">
    					<label>Текущий материал </label>
	    				<input type="text" name="edit_name" class="form-control" value = "<?= $currentmat[0]['name'] ?>" disabled>
	    				<label>Соответствует теме</label>
	    				<select class="form-control" name="sel_theme">
	    				<?php 
	    					foreach ($themeslist as $key)
	    					{
	    				?>		
					  		<option value=<?php echo $key['id_theme'];?>><?php echo $key['name_th'];?></option>
					  		<!-- -->
								<?php
									}
								?>
							</select>
					
						<label>На (Количество проценттов)</label>
						<input type="text" name="accordance_percents" class="form-control" placeholder="Соотношение в %">
    				</div>
    				<input type="hidden" name="id_mat" value = "<?php echo $currentmat[0]['id']?>">
	  		
		<button type="submit" class="btn btn-primary">Установить соответствие</button>
		</form>
		<form action="<?php echo base_url();?>kat_admin/view_materials">
			<button type="submit"  class="btn btn-default">Отмена</button>
		</form>
		</div>

		<!-- Таблица вывода уже имеющихся соответствий -->

		<h4 class="modal-title">У материала уже имеются следующие соответсвия</h4>
			<table class = "table">
			<tr>
				<td>Идентификатор</td>
				<td>Тема</td>
				<td>Степень соответствия (%)</td>
				<td>Удаление соответствия</td>
			</tr>
			<?php
			foreach($accordances as $key)
			{	

			?>
				<tr>
					<td><?php echo $key['id'];?></td>
					<td><?php echo $key['name_th'] ?></td>
					<td><?php echo $key['balls'] ?></td>
					<td><button class="btn btn-danger" onClick="show_delete_confirm(<?php echo $key['id'];?>)"><span class="glyphicon glyphicon-remove"></span></button></td>
				</tr>
			<?php
		}
		?>	

			</table>
</div>

</div>


<?php require_once(APPPATH.'views/require_header.php');?>