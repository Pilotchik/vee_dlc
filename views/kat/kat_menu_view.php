<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	<ul class="breadcrumb">
		<li class="active">Учебные материалы</li>
	</ul>

	<!-- рекомендации -->
	<?php if (count($contents) > 0)
	{
		?>
		<div class="alert alert-warning fade in">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  			<strong>Рекомендации справочных материалов для наименее успешных тем</strong>
    		<?php 
			$i = 0;
			foreach($contents as $key)
			{
				?>
				<div class="panel-group" id="accordion" style="width:90%;margin-top:20px;">
		  			<div class="panel panel-default" style="border-color:#c09853;">
						<div class="panel-heading" style="background-color:#fcf8e3;color:#c09853;">
			  				<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse_rec<?= $i ?>">
				  					<?= $key['name'] ?>
								</a>
			  				</h4>
						</div>
						<div id="collapse_rec<?php echo $i;?>" class="panel-collapse collapse">
			  				<div class="panel-body">
			  					<p>Материалы для подготовки к сдаче тестов по теме "<?= $key['name'] ?>"
			  					<table width="100%" class="table" style="margin-bottom:0px;">
			  					<?php
								foreach ($key['materials'] as $key2) 
								{
									?>
									<tr class=info>
										<td width="70%" align="left" style="line-height: 30px;">
											<div><?= $key2['name'] ?></div>
										</td>
										<td align="center">
											<a type="button" style="width:150px;margin:0 0 0 0;text-indent: 0px;" class="btn btn-info" href="<?= base_url() ?>kat/view_content/<?= $key2['id'] ?>">Просмотр</a>
										</td>
									</tr>
									<?php
								}
							  	?>
							  	</table>
							</div>
						</div>
					</div>
		  		</div>
		  		<?php 
			$i++;
			} 
			?>
		</div>
		<?php
	}
	?>
	<!-- рекомендации -->

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
					foreach ($materials[$key['id']] as $key2)
					{
						?>
						<tr class=info>
							<td width=70% align=left style="line-height: 30px;">
								<div><?= $key2['name'] ?></div>
							</td>
							<td align=center>
								<a type="button" style="width:150px;margin:0 0 0 0;" class="btn btn-info" href="<?= base_url() ?>kat/view_content/<?= $key2['id'] ?>">Просмотр</a>
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