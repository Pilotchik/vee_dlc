<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');	?>
	<script type="text/javascript">
		function func_create(key,id_test)
		{
			$('#test_id').html("<input type=hidden name=test_id value=\""+id_test+"\">");
			if (key==1)
			{
				$('#myModalCode').modal('show');
				$('#name_text').html($('#name'+id_test).html());
				$('#test_key').html("<center><input type=text size=10 name=test_key autocomplete=off class=form-control style=\"height: 30px;text-align: center;font-size: 16;width:50%\"></center>");
			}
			else
			{
				$('#test_key').html("<input type=hidden name=test_key value=0>");
				send_form();
			}
		}

		function send_form()	{document.goForm.submit();}
	
	</script>

	<div class="modal fade" id="myModalCode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Доступ к тесту <b>"<span id="name_text"></span>"</b></h4>
				</div>
				<div class="modal-body">
					<p>Введите ключ для доступа к тесту:</p>
					<form action="<?php echo base_url();?>attest/play_test" method="post" name="goForm">
						<div id="test_id"></div>
						<div id="test_key"></div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success" style="width:100px" onClick="send_form()">Начать</button>
					<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<ul class="breadcrumb">
		<li class="active">Дисциплины и тесты</li>
	</ul>


	<div class="panel-group" id="accordion">

		<?php
		$i = 1;
		foreach ($disciplines as $key)
		{
			?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>" style="font-size: 18;">
							<?= $key['name_test'] ?>
						</a>
			  		</h4>
				</div>

				<div id="collapse<?= $i;?>" class="panel-collapse collapse">
					<table width="100%" class="table" style="margin-bottom:0px;">
						<?php
						foreach ($disc[$key['id']]['tests_uncompleted'] as $key2)
						{
							?>
							<tr class="info">
								<td width="70%" align="left" style="line-height: 30px;">
									<div id="name<?= $key2['id'] ?>"><?= $key2['name_razd'] ?></div>
								</td>
								<td align="center">
									<?php
									if ($key2['kod'] != 0)
									{
										?>
										<input type="button" style="width:200px;margin:0 0 0 0;" class="btn btn-warning" value="Сдать" onClick="javascript: func_create(1,<?= $key2['id'] ?>)">
										<?php
									}
									else
									{
										?>
										<input type="button" style="width:200px;margin:0 0 0 0;" class="btn btn-warning" value="Сдать" onClick="javascript: func_create(0,<?= $key2['id'] ?>)">
										<?php 
									}
									?>
								</td>
							</tr>
							<?php
						}
						
						foreach ($disc[$key['id']]['tests_completed'] as $key2)
						{
							$id_dsc=$key2['id'];
							?>
							<tr class="success">
								<td align="left" width="70%" style="line-height: 30px;"><?= $key2['name_razd'] ?></td>
								<td align="center">
									<?php
									if ($key2['stud_view'] == '1')
									{
										?>
										<form style="margin:0 auto;" action="<?= base_url() ?>private_site/view_stud_result/<?= $key2['res_id'] ?>" method="post">
											<input type="hidden" name="test_name" value="<?= $key2['name_razd'] ?>">
											<input type="submit" style="width:200px;margin:0 auto;" class="btn btn-primary" value="Просмотр результатов">
										</form>
										<?php
									}
									else
									{
										?>
										Просмотр результатов закрыт
										<?php
									}
									?>
								</td>
							</tr>
							<?php
						}
						?>
					</table>
				</div>
			</div>
			<?php 
			$i++;
		}
		?>
	</div>

</div>

<?php require_once(APPPATH.'views/require_header.php');?>