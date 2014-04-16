<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name='yandex-verification' content='64c4e59c92f692ff' />
		<link rel="shortcut icon" href="<?= base_url() ?>images/favi.png" type="image/x-icon">
		<title>ВОС</title>
		<meta name="robots" content="index, follow" />
		<meta name="keywords" content="Институт, Информационных, Технологий, Сегрис, образование, обучение, школьникам, студентам, курсы, компьютеры, компьютерные курсы, ИИТ Сегрис, непрерывное образование, итмо, дистанционные технологии" />
		<meta name="description" content="Единая система тестирования" />
		<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?105"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript">VK.init({apiId: 2849330, onlyWidgets: true});</script>
		<script type="text/javascript">
			function func_reg()			{document.regForm.submit();}
		</script>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-8057488-6']);
			_gaq.push(['_trackPageview']);
			(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		<script type="text/javascript">VK.init({apiId: 2849330});</script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap3.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once "require_modal_metrika_noreg3.php";?>
		<form action="<?php echo base_url()?>registr" method="get" name="regForm"></form>
		<div class="modal fade" id="myModalAuth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Параметры учётной записи</h4>
							</div>
							<div class="modal-body">
								<form action="<?php echo base_url()?>main/auth" method="post" name="adminForm" autocomplete="off" style="margin:0 0;">
						<div class="form-group">
								<label for="exampleInputEmail1">Email или логин</label>
								<input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Введите email">
							</div>
						 <div class="form-group">
								<label for="exampleInputPassword1">Пароль</label>
								<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
							</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success">Далее</button>
								</form>
								<button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
							</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div id="root" class="main" style="width:90%;margin:10px auto;">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-8">
					<div class="jumbotron">
						<div class="row">
							<div class="col-xs-6 col-md-4">
								<img src="<?= base_url() ?>images/vos2.png" width="200px;">
							</div>
							<div class="col-xs-12 col-md-8">
								<h1 style="font-size:50px;">Виртуальная Обучающая Среда</h1>
								<p style="text-indent:0px;">Среда для студентов факультета среднего профессионального образования НИУ ИТМО.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-4">
					<div class="jumbotron" style="min-height:260px;width:100%;min-width:300px;">
						<div style="width: 210px; margin: 0 auto;background-color: #eee;">
							<button class="btn btn-success" style="width:200px; margin-bottom:10px; " data-toggle="modal" data-target="#myModalAuth">
								Войти в систему
							</button>
							<button class="btn btn-warning" style="width:200px;margin-bottom:10px; " onclick="javascript: func_reg()">
								Регистрация
							</button>
							<div id="vk_auth"></div>
							<script type="text/javascript">VK.Widgets.Auth("vk_auth", {width: "200px", authUrl: 'http://exam.segrys.ru/registr/vk'});</script>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row" style="margin: 10px;">
					<h3>Наши работы</h3>
					<p style="text-indent:0px;">Скоро будут опубликованы здесь.</p>
					
					<h3>Наша цель</h3>
					<p style="text-indent:0px;">Образовательный процесс должен быть максимально объективен и прозрачен для всех его участников. 
					Максимально доходчиво делиться разработками объективизации обучения - вот для чего создан информационный портал!</p>
					
					<h3>Мы</h3>
					<p style="text-indent:0px;">ФСПО НИУ ИТМО</p>

					<div class="panel panel-success">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="http://exam.segrys.ru/main/deauth#collapseOne">
									Вебконференции на основе TeamViewer
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse">
							<div class="panel-body">
								<iframe src="https://go.teamviewer.com/v9/flash.aspx?tid=m&amp;lng=ru" width="100%" height="600" align="middle">
						    		Ваш браузер не поддерживает плавающие фреймы!
 								</iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php require_once "require_header.php";?>
