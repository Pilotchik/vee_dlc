<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

	<ol class="breadcrumb">
  		<li class="active">Материалы. Соответствие темам</li>
	</ol>


<script>
	function show_edit_window(id_q)
	{
		$("#editModal").modal('show');
		$("#inputId").val(id_q);
		$("#inputName").val($("#name"+id_q).html());
		$("#inputContent").val($("#content"+id_q).html());
	}
		function show_edit_themes(id_q)
		{
		$("#editAccordanceModal").modal('show');
		$("#inputIdAccordance").val(id_q);
		$("#idTheme").val(id_q);
		$("#inputNameTheme").val($("#name"+id_q).html());
		}

		function show_delete_confirm(id_q)
		{
			$("#deleteThemesModal").modal('show');
			$("#inputIdDelete").val(id_q);
		}
	
</script>

<div class="modal fade" id="editModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Редактирование параметров материала</h4>
	  		</div>
	  		<div class="modal-body">
				<form action="<?php echo base_url();?>kat_admin/edit_material" method="post">
					<div class="form-group">
    					<label>Название</label>
	    				<input type="text" name="edit_name" class="form-control" id="inputName">
    				</div>
    				<div class="form-group">
    					<label>Контент</label>
	    				<textarea id="inputContent" name="edit_content" class="form-control"></textarea>
    				</div>
    				<input type="hidden" name="edit_id" id="inputId">
	  		</div>
	  <div class="modal-footer">
		<button type="submit" class="btn btn-primary">Изменить</button>
		</form>
		<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<div class="modal fade" id="deleteThemesModal">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Вы действительно хотите удалить этот материал?</h4>
	  			</div>
	  			<div class="modal-body">
					<form action="<?php echo base_url();?>kat_admin/delete_material" method="post">
    					<input type="hidden" name="delete_id" id="inputIdDelete">
    					<button type="submit" class="btn btn-primary">Да, удалить</button>
    					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
					</form>
	  			</div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<?php echo $error; ?>

<table class="table stripped">
	<tr>
		<td>Название</td>
		<td>Контент</td>
		<td>Дата создания</td>
		<td>Активность</td>
		<td colspan="3">Редактирование</td>
	</tr>
	<?php
	foreach ($materials as $key)
	{
		?>
		<tr>
			<td><span id="name<?php echo $key['id'];?>"><?php echo $key['name'];?></span></td>
			<td><span id="content<?php echo $key['id'];?>"><?php echo $key['content'];?></span></td>
			<td><?php echo $key['date'];?></td>
			<td><?php echo $key['active'];?></td>
			<td><button class="btn btn-success" onClick="show_edit_window(<?php echo $key['id'];?>)"><span class="glyphicon glyphicon-pencil"></span></button></td>
			<td>
				<form action="<?php echo base_url();?>kat_admin/edit_according/<?php echo $key['id']; ?>" method="post">
					<button type = "submit" class="btn btn-success"><span class="glyphicon glyphicon-list-alt"></span></button>
				</form>
			</td>
			<td><button class="btn btn-danger" onClick="show_delete_confirm(<?php echo $key['id'];?>)"><span class="glyphicon glyphicon-remove"></span></button></td>
		</tr>
		<?php
	}

	?>
</table>

</div>

<?php require_once(APPPATH.'views/require_header.php');?>