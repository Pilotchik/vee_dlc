<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.homeForm.submit();}
			function func_next()	{document.next.submit();}

			$(document).ready(function() { 
						$.viewInput = { '1' : $('#studentDiv'), };
						$('#studentDiv').hide();
						$('#guestSelect').change(function() { 
						$.each($.viewInput, function() { this.hide(); $('#fspoGroup').hide();$('#segrGroup').hide();}); 
						$.viewInput[$(this).val()].show(); 
						});

						$.viewInput2 = { '1' : $('#fspoGroup'), '2' :  $('#segrGroup'),};
						$('#fspoGroup').hide();
						$('#segrGroup').hide();
						$('#typeSelect').change(function() { 
							$.each($.viewInput2, function() { this.hide(); }); 
							$.viewInput2[$(this).val()].show(); 
						});
						
						});
		</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once "require_modal_metrika_noreg.php";?>
		<form action="<?php echo base_url();?>index.php" method="get" name="homeForm"></form>
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<center>
		<div id="root" style="margin:20px 0;">
			<h3>Дополнительные параметры учётной записи</h3>
			<br />
				<form action="<?php echo base_url();?>registr/vk_registr" method="post" name="next">
					<input type="hidden" name="uid" value="<?php echo $uid;?>">
					<input type="hidden" name="photo" value="<?php echo $photo;?>">
					<input type="hidden" name="hash" value="<?php echo $hash;?>">
						<center>
							<label>Тип регистрации:</label>
							<select class="dropdown" name="guest" id="guestSelect" style="width:200px;"> 
								<option value=0>Выберите...</option>
								<option value=1>Студент</option>
								<option value=0>Гость</option>
							</select>
							<div id="studentDiv">
								<label>Место обучения:</label>
								<select class="dropdown" name="type" id="typeSelect" style="width:200px;"> 
									<option value=0>Выберите...</option>
									<option value=1>ФСПО</option>
									<option value=2>Сегрис</option>
								</select>
							</div>
							<div id="fspoGroup">
								<label>№ группы: </label>
								<select  class="dropdown" id="fspo_list" name="fspo_group" style="width:200px;">
									<?php
									foreach ($fspo as $key)
									{
										$id_gr=$key['id'];
										$name_gr=$key['name_numb'];
										echo "<option value=$id_gr>$name_gr";
									}
									?>
								</select>
							</div>
							<div id="segrGroup">
								<label>№ группы: </label>
								<select class="dropdown" id="segrys_list" name="segrys_group" style="width:200px;">
								<?php
									foreach ($segrys as $key)
									{
										$id_gr=$key['id'];
										$name_gr=$key['name_numb'];
										$name_pl=$key['name_plosh'];
										echo "<option value=$id_gr>$name_pl: $name_gr";
									}?>
								</select>
							</div>
							<label>Имя</label>
							<input class="textfield" name="firstname" size="20" type="text" value="<?php echo $firstname;?>" style="width:200px;height:30px;text-align:center;">
							<label>Фамилия</label>
							<input class="textfield" name="lastname" size="20" type="text" value="<?php echo $lastname;?>" style="width:200px;height:30px;text-align:center;">
						</form>
						<br>
						<center>
						<div class="btn-group" data-toggle="buttons-radio" style="margin:15px 15px;">
  							<button type="button" class="btn btn-warning" onClick="func_nazad()" style="width:150px;">Отмена</button>
  							<button type="button" class="btn btn-success" onClick="func_next()" style="width:150px;">Регистрация</button>
						</div>
						</center>
					</div>
	</body>
</html>