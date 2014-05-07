<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#exampleRange').attachDatepicker({
			rangeSelect: true,
			yearRange: '2011:2015',
			firstDay: 1
			});
		});
		
		function func_filter()	{document.date_picker.submit();}
	</script>

	<div id="main">

		<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
	
		<ul class="breadcrumb">
			<li class="active">Модерирование вопросов пользователей</li>
		</ul>

		<p>Укажите диапазон дат</p>
		<table style="padding:0 0;">
			<tr>
				<td>
					<form style="margin:0 0 0 0;" action="<?= base_url() ?>tutor_admin" method="get" name="date_picker"  autocomplete="off">
						<input type="text" id="exampleRange" value="" name="range" style="text-align:center;height: 30;margin: 0 0;" />
					</form>
				</td>
				<td>
					<input type="button" style="width:206px;margin:0 0 0 0" class="btn btn-inverse" value="Фильтр" onClick="func_filter()">
				</td>
			</tr>
		</table>
		
		<table class="table table-stripped" style="margin:15px auto;" id="groups" width="100%">
			<thead>
				<tr>
					<th>Пользователь</th>
					<th>Вопрос</th>
					<th>Тип вопроса</b></td>
					<th>Дата</th>
					<th>Действие</th>
				</tr>
			</thead>
			<tbody>
					<?php
					if (count($messages)>0)
					{
						foreach ($messages as $key)
						{
							echo "<tr>
							<td>".$key['data']."</td>
							<td>".$users[$key['id']]."</td>
							<td>".$key['message']."</td>
							<td>".$key['uri_string']."</td>
							<td>".$to[$key['id']]."</td>
							</tr>";
						}
					}
					else
					{
						echo "<tr><td colspan=4>В выбранный Вами период сообщений зарегистрировано не было</td></tr>";
					}
					?>
				</tbody>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
            <br />
		</div>
	</body>
</html>