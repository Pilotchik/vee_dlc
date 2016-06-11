<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
	<script type="text/javascript">
		$(document).ready(function() 
		{ 	
			$('#root3').css("display", "none");
		});

		function func_edit_cancel() 
		{
			$('#root3').fadeOut("slow");
			$('#overlay').fadeOut('fast');
		}

		function func_view(id_p)	
		{
			$('#overlay').fadeIn('fast');
			$('#root3').fadeIn("slow");
			$('body,html').animate({scrollTop:0},500);
			$.post('<?= base_url() ?>comps_admin/view_popup_stud',{user_id:id_p},function(data,status)
			{
				if( status=='success')
				{
					$("#content").html(data);
				}
				else
				{
					alert('В процессе отправки произошла ошибка :(');
				}
			})
		}		

	</script>
	
	<div id="main">

		<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

		<ul class="breadcrumb">
			<li class="active">Компетентностные портреты пользователей</li>
		</ul>

		<!--Всплывающее окно с результатами студента -->
		<center>
			<div id="root3" style="top:100px;margin:0 0 0 -350px;width:700;z-index:100;">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()"><i class="icon-remove-sign icon-white"></i> Закрыть окно</div>
				<div id="content"></div>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_edit_cancel()"><i class="icon-remove-sign icon-white"></i> Закрыть окно</div>
			</div>
			<!-- Конец окна с результатами -->
			<div class="overlay" id="overlay" style="background-color:black;display:none;position:fixed;top:0px;bottom:0px;left:0px;right:0px;z-index:50;opacity:0.5;"></div>
		
		</center>
		
		<?php if ($error != "") { echo "<script type=\"text/javascript\">$(document).ready(function() {alert('$error')});</script>";}?>
		

			<table class="sortable" id="groups" style="font-size:10px;">
				<thead>
					<tr>
						<td align="center" width="90%"><b>Компетенция</b></td>
						<td align="center" width="10%"><b>Баллы</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach ($students as $key)
					{
						?>
						<tr>
							<td colspan="2">
								<div style="margin:0 auto;font-size:11px;" class="btn btn-primary" onclick="func_view(<?= $key['user_id'] ?>)">
									<?= $name[$key['user_id']] ?>
								</div>
							</td>
						</tr>
						<?php
						foreach ($comps[$key['user_id']] as $key2)
						{
							echo "<tr><td align=center>".$key2['name']."</td><td align=center>".round($key2['balls'],2)."%</td></tr>";
						}
					}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
		</div>
		

<?php require_once(APPPATH.'views/require_header.php');?>