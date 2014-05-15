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
			if (confirm("Удалить связь? Связь архивируется и доступна только при просмотре статистики")) 
			{
				document.getElementById('q_id_del').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
				document.delForm.submit();	
			}
		}

		function func_edit_contribution(id_q)
		{
			name=prompt("Укажите вклад компетенции:");
			if (name!='null')
			{
				document.getElementById('q_id').innerHTML="<input type=hidden name=c_id value=\""+id_q+"\">";
				document.getElementById('q_value').innerHTML="<input type=hidden name=c_value value=\""+name+"\">";
				document.getElementById('q_param').innerHTML="<input type=hidden name=c_param value=contribution>";
				document.editForm.submit();
			}
		}
	</script>
	
	<form action="<?php echo base_url();?>comps_admin/vklad_del" method="post" name="delForm">
		<div id="q_id_del"></div>
	</form></td>
	
	<form action="<?php echo base_url();?>comps_admin/vklad_edit" method="post" name="editForm">
		<div id="q_id"></div>
		<div id="q_value"></div>
		<div id="q_param"></div>
	</form>

	<div id="main">

		<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>

		<ul class="breadcrumb">
			<li class="active">Менеджер связей между дисциплинами и компетенциями</li>
		</ul>

		<table class="sortable" id="groups" style="font-size:10px;">
				<thead>
					<tr>
						<td align="center" colspan="2" width="20%"><b>Компетенция</b></td>
						<td align="center" colspan="2" width="20%"><b>Дисциплина</b></td>
						<td align="center" colspan="2"><b>Вклад</b></td>
						<td align="center" colspan="3"><b>Эксперт</b></td>
						<td align="center"><b>Удаление</b></td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($all_contributions as $key)
				{
					$id_c=$key['id'];
					echo "<tr>";
					echo "<td align=center>".$comp[$id_c]['title']."</td>";
					echo "<td align=center>".$comp[$id_c]['description']."</td>";
					echo "<td align=center>".$disc[$id_c]['name_test']."</td>";
					echo "<td align=center>".$disc[$id_c]['kurs']." курс</td>";
					echo "<td align=center><div onClick=\"javascript: func_edit_contribution($id_c)\"><b>".$key['contribution']."</b></div></td>";
					echo "<td align=center>".$proz[$id_c]."%</td>";
					echo "<td align=center>".$expert[$id_c]."</td>";
					echo "<td align=center>".$key['date']."</td>";
					echo "<td align=center>".$key['description']."</td>";
					echo "<td align=center><div onClick=\"func_del($id_c)\"><span class=\"glyphicon glyphicon-remove\"></span></div></td>";
					echo "</tr>";
				}?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
			<div style="margin:10px auto;" class="btn btn-success" onClick="func_open_create_dsc()">
				Добавить связь
			</div>
		
			<div class="createDscForm" style="width:100%;display:none;margin:15px 0 0 0;">
				<h3>Описание связи</h3>
			<form action="<?= base_url() ?>comps_admin/vklad_create" method="post" name="createForm" autocomplete="off" enctype="multipart/form-data">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td align="right" width="20%">Дисциплина</td>
						<td align="left" width="80%">
							<SELECT NAME="c_disc">
								<?php
								foreach ($all_disciplines as $key) 
								{
									echo "<option value=".$key['id'].">".$key['name_test'];
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="20%">Компетенция</td>
						<td align="left" width="80%">
							<table class="sortable" id="groups" style="font-size:10px;width=100%">
								<tr>
									<td align="center">
										Выбор
									</td>
									<td align="center">
										Компетенция
								</tr>
								<?php
								foreach ($all_comps as $key) 
								{
									echo "<tr><td><input type=radio name=c_comp value=".$key['id']."></td><td>".$key['title'].". ".$key['description']."</td></tr>";
								}
								?>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right" width="20%">Вклад</td>
						<td align="left" width="80%">
							<SELECT NAME="c_vklad">
								<?php
								for($i=1;$i<=100;$i++) 
								{
									echo "<option value=$i>$i";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" width="20%">Комментарий (необязательно)</td>
						<td align="left" width="80%">
							<textarea class="inputbox" name="c_comm" cols="40" rows="3"></textarea>
						</td>
					</tr>
				</table>
			</form>
			<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-success" onClick="func_create()">
				<i class="icon-plus icon-white"></i> Добавить связь
			</div>
		</div>
	</div>

<?php require_once(APPPATH.'views/require_header.php');?>