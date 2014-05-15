<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>

	<script type="text/javascript">
		$(document).ready(function() 
		{ 	
			$('#root3').css("display", "none");
		});

		function func_open_create_dsc()
		{
			$(".createDscForm").slideToggle("slow");
			var height= $(".createDscForm").height()+$("root").height()+$(".table_big").height()+50; 
			$("html,body").animate({"scrollTop":height},"slow");
		}

		function func_create()
		{
			document.createForm.submit();	
		}

		function func_del(id_q)
		{
			if (confirm("Удалить компетенцию? Компетенция архивируется и доступна только при просмотре статистики")) 
			{
				document.getElementById('q_id_del').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
				document.delForm.submit();	
			}
		}

		function func_edit_active(id_q)
		{
			name=prompt("Активность компетенции: 0 - компетенция не будет использоваться, 1 - будет");
			if (name!='null')
			{
				document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
				document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
				document.getElementById('q_param').innerHTML="<input type=hidden name=c_param value=active>";
				document.editForm.submit();
			}
		}

		function func_edit_text(id_q)
		{
			name=prompt("Введите новое название компетенции:");
			if (name!='null')
			{
				document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
				document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
				document.getElementById('q_param').innerHTML="<input type=hidden name=c_param value=title>";
				document.editForm.submit();
			}
		}

		function func_edit_desc(id_q)
		{
			name=prompt("Введите новое описание:");
			if (name!='null')
			{
				document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
				document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
				document.getElementById('q_param').innerHTML="<input type=hidden name=c_param value=description>";
				document.editForm.submit();
			}
		}
	</script>

		
	<form action="<?= base_url() ?>comps_admin/comps_del" method="post" name="delForm">
		<div id="q_id_del"></div>
	</form></td>
	
	<form action="<?= base_url() ?>comps_admin/comps_edit" method="post" name="editForm">
		<div id="q_id"></div>
		<div id="q_value"></div>
		<div id="q_param"></div>
	</form>

	<div id="main">

		<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

		<ul class="breadcrumb">
			<li class="active">Управление компетенциями</li>
		</ul>

		<table class="table" style="font-size:10px;">
				<thead>
					<tr>
						<td align="center"><b>Тип</b></td>
						<td align="center" width=10%><b>Код</b></td>
						<td align="center" width=40%><b>Описание</b></td>
						<td align="center"><b>Вид профессиональной деятельности</b></td>
						<td align="center"><b>Активность</b></td>
						<td align="center"><b>Удаление</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($all_comps as $key)
				{
					$id_c=$key['id'];
					echo "<tr>";
					if ($key['type'] == 0)
					{
						echo "<td align=center>Общая</td>";	
					}
					else
					{
						echo "<td align=center>Профессиональная</td>";	
					}
					echo "<td align=center><div onClick=\"javascript: func_edit_text($id_c)\">".$key['title']."</div></td>";
					echo "<td align=center><div onClick=\"javascript: func_edit_desc($id_c)\">".$key['description']."</div></td>";
					if ($key['type'] == 0)
					{
						echo "<td align=center>&nbsp;</td>";	
					}
					else
					{
						echo "<td align=center>".$key['prof_activity']."</td>";
					}
					if ($key['active']==0) 
					{
						$active_name = "<span class=\"glyphicon glyphicon-eye-close\"></span>";
					} 
					else 
					{
						$active_name = "<span class=\"glyphicon glyphicon-ok\"></span>";
					}
					?>
					<td><div onClick="func_edit_active(<?= $id_c ?>)"><?= $active_name ?></div></td>
					<td><div onClick="func_del(<?= $id_c ?>)"><span class="glyphicon glyphicon-remove"></span></div></td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			
			<div style="margin:10px 0 10px 0;" class="btn btn-success btn-lg" onClick="func_open_create_dsc()">
				Добавить компетенцию
			</div>
		
		<div class="createDscForm" style="width:100%;display:none;margin:15px 0 0 0;">
			<h3>Добавить компетенцию</h3>
			<form action="<?php echo base_url()?>comps_admin/comps_create" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="40%">Тип компетенции</td>
						<td align="left" width="60%">
							<SELECT NAME="c_type">
								<option value="0">Общая
								<option value="1">Профессиональная
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Код компетенции</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="c_title" cols="60" rows="3"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Описание компетенции</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="c_desc" cols="60" rows="3"></textarea>
						</td>
					</tr>
					<tr>
						<td align="right" width="40%">Вид профессиональной деятельности (только для профессиональных компетенций)</td>
						<td align="left" width="60%">
							<textarea class="inputbox" name="c_prof" cols="60" rows="3"></textarea>
						</td>
					</tr>
				</table>
			</form>
			<div style="margin:10px 0 10px 0;" class="btn btn-success" onClick="func_create()">
				Добавить компетенцию
			</div>
		</div>
	</div>
		
<?php require_once(APPPATH.'views/require_header.php');?>