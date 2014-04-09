<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<div id="main">
			<?php require_once(APPPATH.'views/require_main_menu.php');?>
			<ul class="breadcrumb">
  				<li class="active">Опросы</li>
			</ul>
			<?php 
			if (count($open_forms) > 0)
			{
				?>
				<h3>Доступные опросы</h3>
				<table class="sortable" id="groups">
					<thead>
						<tr>
							<td align="center"><b>Опрос</b></td>
							<td align="center"><b>Тип прохождения</b></td>
							<td align="center"><b>Описание</b></td>
							<td align="center"><b>Количество респондентов</b></td>
							<td align="center"><b>Статус</b></td>
							<td align="center"><b>Результаты</b></td>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ($open_forms as $key)
					{
						$id_form=$key['id'];
						if ($resp_status[$id_form]==0)
						{
							echo "<td><form style=\"margin:0 0 0 0;\" action=\"".base_url()."forms/play_form/$id_form\" method=\"get\" name=\"edit$id_form\">
							<input style=\"width:250px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"".$key['title']."\">
							</form>
							</td>";
						}
						else
						{
							echo "<td>".$key['title']."</td>";
						}
						echo "<td>".($key['access'] == 0 ? 'Анонимный' : 'Открытый')."</td>";
						echo "<td>".$key['description']."</td>";
						echo "<td>".$count_resp[$id_form]."</td>";
						if ($resp_status[$id_form]=="" || $resp_status[$id_form]==0)
						{
							echo "<td colspan=2>Опрос ещё не был пройден</td>";
						}
						else
						{
							$time = date("Y-m-d H:i", $resp_status[$id_form]);
							echo "<td>Опрос был пройден ".$time."</td>";
							if ($count_resp[$id_form]>0 && $key['public_res']==1)
							{
								echo "<td><form style=\"margin:0 0 0 0;\" action=\"".base_url()."forms/view_one_result/$id_form\" method=\"get\" name=\"edit$id_form\">
								<input style=\"width:100px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Результаты\">
								</form>
								</td>";
							}
							else
							{
								echo "<td>Результаты недоступны</td>";
							}
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
							echo "<td><form style=\"margin:0 0 0 0;\" action=\"".base_url()."forms/view_one_result/$id_form\" method=\"get\">
							<input style=\"width:100px;margin:0 0 0 0;\" class=\"btn btn-inverse\" type=\"submit\" value=\"Результаты\">
							</form>
							</td>";
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
	</body>
</html>