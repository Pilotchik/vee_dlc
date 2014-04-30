<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
	<script type="text/javascript">
		$(document).ready(function() 
		{ 	
			$('#main_note_ID').html($('#note_1').html());
		});

		var cur_h = 0;
		var max_h = <?= count($present_slides) ?>;
		var cur_v = 0;

		function postAjax(cmd)
		{
			var cmd = parseInt(cmd);
			if (cmd == 1 && cur_h < max_h)	{cur_h++;cur_v = 0;$('#cmd_status').html('Вперёд')}
			if (cmd == 2 && cur_h > 0)		{cur_h--;cur_v = 0;$('#cmd_status').html('Назад')}
			if (cmd == 3 && cur_v > 0)		{cur_v--;$('#cmd_status').html('Вверх')}
			if (cmd == 4)					{cur_v++;$('#cmd_status').html('Вниз')}
			$('#main_note_ID').html($('#note_'+cur_h).html());
			$.post ('<?= base_url() ?>present_admin/change_slide',{index_h:cur_h,index_v:cur_v,present_id:<?= $present_id ?>},function(data,status){
			if( status!='success' )	{alert('В процессе передачи команды произошла ошибка :(');}
			else{eval('var obj='+data);	if (obj.answer==0)	{alert('Ответ не сохранился');} else {console.log('ok');}}});
		}
						
	</script>

	<div id="main">
		<h3>Управление презентацией "<?= $present_name ?>"</h3>
		Предыдущая команда: <span id="cmd_status"></span>
		<div class="row" style="text-align:center;margin:15px auto;">
			<div class="col-sm-12">
				<button href="#" class="btn btn-primary btn-lg btn-block" style="height: 80;" onClick="postAjax(3)">
					<span class="glyphicon glyphicon-chevron-up"></span>
				</button>
			</div>
		</div>
		<div class="row" style="text-align:center;margin:15px auto;">
			<div class="col-xs-4 col-sm-4">
				<button href="#" class="btn btn-primary btn-lg btn-block" style="height: 80;" onClick="postAjax(2)">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</button>
			</div>
			<div class="col-xs-4 col-sm-4">
				<button href="#" class="btn btn-default btn-lg btn-block" style="height: 80;" onClick="postAjax(5)">
					<span class="glyphicon glyphicon-pause"></span>
				</button>
			</div>
			<div class="col-xs-4 col-sm-4">
				<button href="#" class="btn btn-primary btn-lg btn-block" style="height: 80;" onClick="postAjax(1)">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</button>
			</div>
		</div>
		<div class="row" style="text-align:center;margin:15px auto;">
			<div class="col-sm-12">
				<button href="#" class="btn btn-primary btn-lg btn-block" style="height: 80;" onClick="postAjax(4)">
					<span class="glyphicon glyphicon-chevron-down"></span>
				</button>
			</div>
		</div>
		<div class="row" style="margin:15px auto;">
			<div class="col-sm-12" id="main_note_ID" style="font-size:28px;line-height:30px;margin:30px auto;"></div>
			<div class="col-sm-12">
				<a href="<?= base_url()?>present" class="btn btn-lg btn-default btn-block">
					<span class="glyphicon glyphicon-chevron-left"></span> Назад
				</a>
			</div>
		</div>
		<?php
		$i = 0;
		foreach ($present_slides as $key)
		{
			?>
			<div id="note_<?= $i ?>" style="display:none;"><?= $key['slide'] ?>. <?= $key['text'] ?></div>
			<?php
			$i++;
		}
		?>
	</body>
</html>