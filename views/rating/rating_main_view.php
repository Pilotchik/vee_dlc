<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

	<ul class="breadcrumb">
		<li class="active">Общий рейтинг <?= $type_r_name ?></li>
	</ul>

	<table class="table table-hover table-bordered" id="groups" style="font-size:12px;width:80%;margin:10 auto;margin-top: 20px;">
		<thead style="font-size:14px;">
			<tr>
				<td align="center" colspan="2"><b>Фамилия Имя</b></td>
				<td align="center"><b>Номер группы</b></td>
				<td colspan="3"><b>Рейтинг</b></td>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($top_index as $key) 
			{
				?>
				<tr>
					<td width="5%">
						<?= $i ?>
						<?= ($i == 1 ? "<span class=\"glyphicon glyphicon-tower\" style=\"font-size:16px;\"></span>" : "") ?>
					</td>
					<td><?= $key['lastname'] ?> <?= $key['firstname'] ?></td>
					<td><?= $key['name_numb'] ?></td>
					<td><b><?= $key['isrz'] ?></b></td>
					<?php 
					if (count($top_users[$key['id']]) > 1)
					{
						$residual = $top_users[$key['id']][count($top_users[$key['id']]) - 1]['reyt'] - $top_users[$key['id']][count($top_users[$key['id']]) - 2]['reyt'];
						if ($residual > 0)
						{
							?>
							<td align="center" style="font-size:16px;" class="success"><span class="glyphicon glyphicon-chevron-up"></span></td>
							<td align="center" style="font-size:16px;" class="success">+ <?= $residual ?>
							<?php
						}
						elseif ($residual < 0)
						{
							?>
							<td align="center" style="font-size:16px;" class="danger"><span class="glyphicon glyphicon-chevron-down"></span></td>
							<td align="center" style="font-size:16px;" class="danger"><?= $residual ?>
							<?php
						}
						else
						{
							?><td align="center" style="font-size:16px;" class="info" colspan="2"><span class="glyphicon glyphicon-thumbs-up"></span><?php
						}
					}
					else
					{
						?><td align="center" style="font-size:16px;" class="info" colspan="2"><span class="glyphicon glyphicon-thumbs-up"></span><?php
					}
					?>
					</td>
				</tr>
				<?php
				$i++;
			}
			?>
		</tbody>
	</table>
</div>

<?php require_once(APPPATH.'views/require_header.php');?>