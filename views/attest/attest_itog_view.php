<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.nazad.submit();}

			function func_ozenka(ozenka)
			{
				var result_id = <?php echo $result_id;?>;
				$.post('<?php echo base_url();?>attest/result_opinion',{resultid:result_id,opinion:ozenka},
					function(data,status){
					if( status!='success' )
					{
        				alert('В процессе автосохранения произошла ошибка :(');
					}
					else
					{
						eval('var obj='+data);
						if (obj.answer==1)
						{
							$('.opinion').css({"display":"none"})
							$('.spasibo').css({"display":"block"})
						}
					}})
			}
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
			table{font-size:12;}
		</style>
	</head>
	<body>
		<form action="<?php echo base_url();?>main/auth" method="get" name="nazad"></form>
		<?php require_once(APPPATH.'views/require_modal_metrika.php');?>
		<center>
		<div id="root" style="width:700;margin:20px 0 10px 0;">
			<br />
			<h3>Результаты теста</h3>
			<br />
			<table class="sortable" id="groups" width="70%">
				<tr>
					<td align="center">
						<b>Правильных ответов</b>
					</td>
					<td align="center">
						<b>Ответов дано</b>
					</td>
					<td align="center">
						<b>Всего заданий</b>
					</td>
				</tr>
				<tr>
					<td align="center">
						<?php echo $true_cnt;?>
					</td>
					<td align="center">
						<?php echo $dano;?>
					</td>
					<td align="center">
						<?php echo $true_all;?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<b>Результат</b>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<?php echo $abs;?>%
					</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<i>Оценка будет выставлена преподавателем</i>
					</td>
				</tr>
			</table>
			<script type="text/javascript">
				highlightTableRows("groups","hoverRow","clickedRow",false);
			</script>
		</div>
		<div id="root" style="width:700;margin:20px 0 10px 0;">
			<div class="opinion">
				<center><h4>Оцените ваш результат:</h4>
				<div class="btn-group">
					<div style="width:250px;margin:10px 0 10px 0;" class="btn btn-danger" onClick="javascript: func_ozenka(1)">
						<i class="icon-thumbs-down"></i> Я заслуживаю большего!
					</div>
					<div style="width:250px;margin:10px 0 10px 0;" class="btn btn-success" onClick="javascript: func_ozenka(2)">
						<i class="icon-thumbs-up"></i> Отличный результат!
					</div>
				</div>
				</center>
			</div>
			<div class="spasibo" style="display:none;">
				<center><i>Спасибо, мы обязательно учтём Ваше  мнение</i></center>
			</div>
		</div>
		<div id="root" style="width:700;margin:20px 0 10px 0;">
			<div style="width:206px;margin:20px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
				<i class="icon-home icon-white"></i> Главное меню
			</div>
		</div>
	</body>
</html>