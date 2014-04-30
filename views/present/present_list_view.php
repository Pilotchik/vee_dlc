<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	<ul class="breadcrumb">
  		<li class="active">Доступные презентации</li>
	</ul>

	<?php
	if (count($presents) > 0)
	{
		?>
		<div class="row">
			<?php
			foreach ($presents as $key)
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
										<a href="<?= base_url() ?>present/play2/<?= $key['id'] ?>?theme=<?= $key['theme'] ?>&transition=<?= $key['transition'] ?>" class="btn btn-success"><span class="glyphicon glyphicon-play"></span> Просмотр</a>
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
	<br>
</div>

<?php require_once(APPPATH.'views/require_header.php');?>