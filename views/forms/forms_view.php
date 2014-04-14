<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	<ul class="breadcrumb">
		<li class="active">Опросы</li>
	</ul>
	<script>

	function goToResults()
	{
		$('#all_forms').slideToggle("slow");
		$('#preload').slideToggle("slow");
	}
	</script>
	<div id="preload" style="display:none;">
		<center>
			<br />
			<h1>Пожалуйста, подождите...</h1>
			<img src="<?= base_url() ?>images/preload.gif" style="margin:10 auto;margin-bottom:20px;">
			<br>
			Происходит обработка данных. Процесс может занять некоторое время.
			<br /><br />
		</center>
	</div>
	<div id="all_forms">
			<?php 
			if (count($open_forms) > 0)
			{
				?>
				<h3>Активные опросы</h3>
				<div class="row">
				<?php
				foreach ($open_forms as $key)
				{
					?>
					<div class="col-sm-6 col-md-6">
					<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title"><?= $key['title'] ?></h4>
							</div>
							<div  id="form<?= $key['id'] ?>" class="panel-collapse collapse in"> 
  							<div class="panel-body">
  								<?= $key['description'] ?>
    							
						  	</div>
						  	<ul class="list-group">
								<li class="list-group-item">Количество респондентов: <span class="label label-success"><?= $count_resp[$key['id']] ?></span></li>
								<li class="list-group-item">Тип опроса: <span class="label label-info"><?= ($key['access'] == 0 ? 'Анонимный' : 'Открытый') ?></span></li>
								<?php
								if ($resp_status[$key['id']] == "" || $resp_status[$key['id']] == 0)
								{
									?>
									<li class="list-group-item">
										<form action="<?= base_url() ?>forms/play_form/<?= $key['id'] ?>" method="get" name="edit<?= $key['id'] ?>" style="text-align: right;margin: 0 auto;">
											<input style="width:250px;margin:0 0 0 0;" class="btn btn-primary" type="submit" value="Пройти анкетирование">
										</form>
									</li>
									<?php
								}
								else
								{
									$time = date("d.m.Y", $resp_status[$key['id']]);
									?>
									<li class="list-group-item">Опрос был пройден <?= $time ?></li>
									<?php
									if ($count_resp[$key['id']] > 0 && $key['public_res'] == 1)
									{
										?>
										<li class="list-group-item">
										<form action="<?= base_url() ?>forms/view_one_result/<?= $key['id'] ?>" method="get" style="text-align: right;margin: 0 auto;">
											<input style="width:120px;margin:0 auto;" class="btn btn-primary" type="submit" value="Результаты" onClick="goToResults()">
										</form>
										</li>
										<?php
									}
									else
									{
										?>
										<li class="list-group-item">Ответы респондентов обрабатываются и совсем скоро мы опубликуем результаты!</li>
										<?php
									}
								}
								?>
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
				echo "Доступных опросов пока нет. Следите за новостями.";
			}
			?>
			<br />
			<?php
			if (count($archive_forms) > 0)
			{
				?>
				<h3>Архив</h3>
				<div class="row">
				<?php
				foreach ($archive_forms as $key)
				{
					?>
					<div class="col-sm-6 col-md-6">
					<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title"><?= $key['title'] ?></h4>
							</div>
							<div  id="form<?= $key['id'] ?>" class="panel-collapse collapse in"> 
  							<div class="panel-body">
  								<?= $key['description'] ?>
    							
						  	</div>
						  	<ul class="list-group">
								<li class="list-group-item">Количество респондентов: <span class="label label-success"><?= $count_resp[$key['id']] ?></span></li>
								<li class="list-group-item">Тип опроса: <span class="label label-info"><?= ($key['access'] == 0 ? 'Анонимный' : 'Открытый') ?></span></li>
								<?php
								if ($resp_status[$key['id']] == "" || $resp_status[$key['id']] == 0)
								{
									?>
									<li class="list-group-item">Вы не проходили этот опрос</li>
									<?php
								}
								else
								{
									$time = date("d.m.Y", $resp_status[$key['id']]);
									?>
									<li class="list-group-item">Опрос был пройден Вами <?= $time ?></li>
									<?php
								}
								if ($key['public_res'] == 1)
								{
									?>
									<li class="list-group-item">
										<form action="<?= base_url() ?>forms/view_one_result/<?= $key['id'] ?>" method="get" style="text-align: right;margin: 0 auto;">
											<input style="width:120px;margin:0 auto;" class="btn btn-primary" type="submit" value="Результаты" onClick="goToResults()">
										</form>
									</li>
									<?php
								}
								else
								{
									?>
									<li class="list-group-item">Ответы респондентов обрабатываются и совсем скоро мы опубликуем результаты!</li>
									<?php
								}
								?>
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
				echo "Доступных опросов пока нет. Следите за новостями.";
			}
			?>
			</div>
		</div>
	</body>
</html>