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
				<?php
				foreach ($open_forms as $key)
				{
					?>
					<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">
    							<a data-toggle="collapse" data-parent="#accordion" href="#form<?= $key['id'] ?>">
      								<?= $key['title'] ?>
    							</a>
  							</h4>
							</div>
							<div  id="form<?= $key['id'] ?>" class="panel-collapse collapse"> 
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
										<form action="<?= base_url() ?>forms/play_form/<?= $key['id'] ?>" method="get" name="edit<?= $key['id'] ?>">
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
										<form action="<?= base_url() ?>forms/view_one_result/<?= $key['id'] ?>" method="get">
											<input style="width:250px;margin-left:15px;margin-top:10px;" class="btn btn-primary" type="submit" value="Результаты" onClick="goToResults()">
										</form>
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
					<?php
				}
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
				<table class="sortable" id="groups">
					<thead>
						<tr>
							<td align="center"><b>Опрос</b></td>
							<td align="center"><b>Тип прохождения</b></td>
							<td align="center"><b>Описание</b></td>
							<td align="center"><b>Количество респондентов</b></td>
							<td align="center" colspan="2"><b>Результаты</b></td>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ($archive_forms as $key)
					{
						$id_form=$key['id'];
						echo "<td>".$key['title']."</td>
						<td>".($key['access'] == 0 ? 'Анонимный' : 'Открытый')."</td>
						<td>".$key['description']."</td>
						<td>".$count_resp[$id_form]."</td>";
						if ($resp_status[$id_form] == "" || $resp_status[$id_form] == 0)
						{
							echo "<td>Опрос не был Вами пройден</td>";
						}
						else
						{
							$time = date("Y-m-d H:i", $resp_status[$id_form]);
							echo "<td>Опрос был пройден ".$time."</td>";
						}
						if ($key['public_res']==1)
						{
							?>
							<td>
								<form style="margin:0 0 0 0;" action="<?= base_url() ?>forms/view_one_result/<?= $id_form ?>" method="get">
									<input style="width:100px;margin:0 0 0 0;" class="btn btn-inverse" type="submit" value="Результаты" onClick="goToResults()">
								</form>
							</td>
							<?php
						}
						else
						{
							echo "<td>Результаты недоступны</td>";
						}
						echo "</tr>";
					}?>
					</tbody>
				</table>
				<script type="text/javascript">
					highlightTableRows("groups","hoverRow","clickedRow",false);
				</script>
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