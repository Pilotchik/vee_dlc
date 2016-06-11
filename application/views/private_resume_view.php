<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			function func_nazad()	{document.nazad.submit();}
			function func_restart()	{document.restartForm.submit();}
			function func_view_resume() {document.publicForm.submit();}

			function func_public(status) 
			{
				$.post('<?php echo base_url();?>private_site/publicstatus_change',{status_pole:status},function(data,status){
				if( status!='success' )
				{alert('В процессе автосохранения произошла ошибка :(');}
				else
				{	eval('var obj='+data);
					if (obj.answer==0)
					{	alert('Введённые данные не сохранились');}}})
				$('#public_button').css({'visibility':'hidden'});
				if (status == 0)
				{
					$('#public').css({'visibility':'visible'});
					$('#private').css({'visibility':'hidden'});
				}
				else
				{
					$('#private').css({'visibility':'visible'});
					$('#public').css({'visibility':'hidden'});	
				}
			}
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.jqplot.min.css" />
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once "require_modal_metrika.php";?>
		<center>
		<form action="<?php echo base_url();?>main/auth" method="post" name="nazad"></form>
		<form action="<?php echo base_url();?>private_site/resume/966" method="post" name="restartForm"></form>
		<form action="<?php echo base_url();?>resume/<?php echo $user_id;?>" method="post" name="publicForm"></form>
		<div id="root" style="width:1000;margin:20px 0 0 0;">
			<h1><?php echo $user_info['firstname']." ".$user_info['middlename']." ".$user_info['lastname'];?></h1>
			<div id="public_button">
				<?php
					if ($public_status==0)
					{
						?>
						<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-danger"  onClick="javascript: func_public(1)">
							<i class="icon-pencil icon-white"></i> Опубликовать результаты
						</div>
						<?php
					}
					else
					{
						$public = "Результаты опубликованы";
						?>
							<div class="btn-group">
								<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse"  onClick="javascript: func_view_resume()">
									<i class="icon-eye-open icon-white"></i> Просмотр
								</div>
								<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-danger"  onClick="javascript: func_public(0)">
									<i class="icon-eye-close icon-white"></i> Скрыть результаты
								</div>
							</div>
						<?php
					}
				?>
			</div>
			<div id="public" style="visibility:hidden;">
				<div style="width:206px;" class="btn btn-danger"  onClick="javascript: func_public(1)">
					<i class="icon-pencil icon-white"></i> Опубликовать результаты
				</div>
			</div>
			<div id="private" style="visibility:hidden;">
				<div class="btn-group">
					<div style="width:206px;" class="btn btn-inverse"  onClick="javascript: func_view_resume()">
						<i class="icon-eye-open icon-white"></i> Просмотр
					</div>
					<div style="width:206px;" class="btn btn-danger"  onClick="javascript: func_public(0)">
						<i class="icon-eye-close icon-white"></i> Скрыть результаты
					</div>
				</div>
			</div>
			<center>Дата формирования резюме: <?php echo $user_info['resume_date'];?></center>
			<H3>Личная информация</h3>
				<table id="groups" class="sortable" style="font-size:12px;width:100%">
					<thead>
						<tr>
							<td align="center" width="30%"><b>Параметр</b></td>
							<td align="center" width="70%"><b>Значение</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Место проживания</td>
							<td>
								<?php 
								switch ($user_info['state']) 
								{
									case 0:	echo "Скрыто";	break;
									case 1: echo "Санкт-Петербург";	break;
									case 2:	echo "Ленинградская область";	break;
									case 3:	echo "За границей Ленинградской области";	break;
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Дата рождения</td>
							<td><?php echo $user_info['birthday'];?></td>
						</tr>
						<tr>
							<td>Tелефон для связи</td>
							<td><?php echo $user_info['phone'];?></td>
						</tr>
						<tr>
							<td>Электронная почта</td>
							<td><?php echo $user_info['mail_adr'];?></td>
						</tr>
					</tbody>
				</table>
				<?php 
				if (count($skills)>0)
				{
					?>
					<H3>Карта навыков</h3>
					<table id="groups" class="sortable" style="font-size:11px;width:100%">
						<thead>
							<tr>
								<td align="center" width="15%"><b>Навык</b></td>
								<td align="center" width="60%"><b>Уровень</b></td>
								<td align="center"><b>Описание</b></td>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ($skills as $key)
							{
								echo "<tr><td align=center><b>".$skill_name[$key['id']]."</b></td><td>";
								$proz=round(($key['balls']/5)*100);
								echo "<div class=\"progress\" style=\"margin:0 0 0 0;\">
									<div class=\"bar\" style=\"width: $proz%;\"></div>
									</div></td><td align=center>".$skill_description[$key['id']]."</td></tr>";
							}
							?>
						</tbody>
					</table>
					<?php 
				}
				if (count($portfolios)>0)
				{
					?>
					<H3>Опыт работы</h3>
					<table id="groups" class="sortable" style="font-size:11px;width:100%">
						<thead>
							<tr>
								<td align="center"><b>Название проекта</b></td>
								<td align="center"><b>Описание</b></td>
								<td align="center"><b>Ссылка</b></td>
								<td align="center"><b>Дата начала</b></td>
								<td align="center"><b>Дата окончания</b></td>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ($portfolios as $key)
						{
							echo "<tr><td align=center>".$key['name']."</td>
							<td align=center>".$key['description']."</td>
							<td align=center>".$key['url']."</td>
							<td align=center>Дата начала: ".$key['date_begin']."</td>
							<td align=center>Дата окончания: ".$key['date_end']."</td></tr>";
						}?>
						</tbody>
					</table>
				<?php
				}

				if (count($comp_name)>0)
				{
					?>
					<H3>Компетентностный портрет</h3>
					<?php
					if ($user_info['comp_image'] == 1)
					{
						?>
						<table class="sortable" id="groups" width="100%" style="font-size:11px;">
							<tr>
								<td align="center" width=30%><b>Компетенция</b></td>
								<td align="center" colspan="2"><b>Баллы</b></td>
							</tr>
							<?php
							foreach ($comps as $key)
							{
								echo "<tr>
									<td align=center>".$comp_name[$key['id']]."</td>
									<td align=center width=10%>".$comp_ball[$key['id']]."%</td>
									<td><div class=\"progress\" style=\"margin:0 0 0 0;\">
									<div class=\"bar\" style=\"width: ".$comp_ball[$key['id']]."%;\"></div>
									</div></td></tr>";
							}?>
						</table>
						
					<?php
					}
					else
					{
						echo "Пользователь предпочёл не прикреплять компетентностный портрет к резюме";
					}
				}
				?>
		</div>
		<div id="root" style="width:1000;margin:20px 0 0 0;">
			<div class="btn-group">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-danger"  onClick="javascript: func_restart()">
					<i class="icon-pencil icon-white"></i> Редактировать
				</div>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
					<i class="icon-home icon-white"></i> Главное меню
				</div>
			</div>
		</div>
	</center>
	</body>
</html>