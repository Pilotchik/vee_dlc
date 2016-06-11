<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript" src="//vk.com/js/api/openapi.js?62"></script>
		<script type="text/javascript">
  			VK.init({apiId: 2849330, onlyWidgets: true});
		</script>
		<script type="text/javascript">
			function func_nazad()	{document.nazad.submit();}
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery.jqplot.min.css" />
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<center>
		<!-- Yandex.Metrika counter -->
			<div style="display:none;">
				<script type="text/javascript">
				(function(w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter11384695 = new Ya.Metrika({id:11384695, enableAll: true, webvisor:true}); } catch(e) { } }); })(window, "yandex_metrika_callbacks");</script>
			</div>
			<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
			<noscript>
				<div>
					<img src="//mc.yandex.ru/watch/11384695" style="position:absolute; left:-9999px;" alt="" />
				</div>
			</noscript>
		<!-- /Yandex.Metrika counter -->
		<form action="<?php echo base_url();?>" method="post" name="nazad"></form>
		<div id="root" style="width:1000;margin:20px 0 0 0;">
			<h1><?php echo $user_info['firstname']." ".$user_info['middlename']." ".$user_info['lastname'];?></h1>
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
			<div id="vk_like" style="margin:20px 0 0 0;"></div>
			<?php $url="'http://exam.segrys.ru/resume/$user_id'";?>
			<script type="text/javascript">
				VK.Widgets.Like("vk_like", {type: "button", verb: 0, height: 24, pageTitle: 'Резюме в единой системе интернет-тестирования НИУ ИТМО ФСПО', pageUrl:<?php echo $url;?>,pageDescription: 'Я составил резюме в Единой Системе Тестирования студентов НИУ ИТМО ФСПО! Ура!:)'});
			</script>
		</div>
		<div id="root" style="width:1000;margin:20px 0 0 0;">
			<div class="btn-group">
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_nazad()">
					<i class="icon-home icon-white"></i> Система тестирования
				</div>
			</div>
		</div>
	</center>
	</body>
</html>