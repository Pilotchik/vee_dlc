<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
<div id="main">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

	<ul class="breadcrumb">
		<li><a href="<?= base_url() ?>kat">Учебные материалы</a></li>
		<li class="active">Материалы по теме "<?= $theme_name ?>"</li>
	</ul>

	<table width="100%" class="table" style="margin-bottom:0px;">
		<?php
		foreach ($materials as $key2)
		{
			?>
			<tr>
				<td width=70% align=left style="line-height: 30px;">
					<div><?= $key2['name'] ?></div>
				</td>
				<?php
				$rs = (count($materials_themes[$key2['id']]) > 0 ? 2 : 1);
				?>
				<td align="center" rowspan="<?= $rs ?>" style="vertical-align:middle;">
					<a type="button" style="width:150px;margin:0 0 0 0;" class="btn btn-info" href="<?= base_url() ?>kat/view_content/<?= $key2['id'] ?>">Просмотр</a>
				</td>
			</tr>
			<?php 
			if (count($materials_themes[$key2['id']]) > 0)
			{
				?>
				<tr>
					<td>
						<?php
						$arr = array('default', 'primary', 'info', 'warning','danger', 'success');
						foreach($materials_themes[$key2['id']] as $key3)
						{
							$rand = rand(0,count($arr));
							?>
							<span class="label label-<?= $arr[$rand] ?>" style="font-size:80%"><?= $key3['name_th'] ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
	
</div>

<?php require_once(APPPATH.'views/require_header.php');?>