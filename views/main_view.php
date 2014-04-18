<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<title>ВОС</title>
		<link rel="shortcut icon" href="<?= base_url() ?>images/favi.png" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="Институт, Информационных, Технологий, Сегрис, образование, обучение, школьникам, студентам, курсы, компьютеры, компьютерные курсы, ИИТ Сегрис, непрерывное образование, итмо, дистанционные технологии" />
		<meta name="description" content="Виртуальная обучающая среда" />
		<!-- One CSS file that rules them all -->
		<link href="<?= base_url() ?>css/main.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
		<!--[if lt IE 9]>
		  <script src="js/html5shiv.js"></script>
		<![endif]-->
		<meta name="description" content="Виртуальная Обучающая среда" />
		<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?111"></script>
		<script type="text/javascript">VK.init({apiId: 2849330});</script>
		<script type="text/javascript" src="<?= base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-8057488-6']);
			_gaq.push(['_trackPageview']);
			(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();


			function auth_open()
			{
				$("#myModalAuth").modal('show');
				$('#myModalAuth').on('shown.bs.modal', function () {
  					VK.Widgets.Auth("vk_auth", {width: "250px", authUrl: 'http://exam.segrys.ru/registr/vk'});
				});
			}
		</script>
		
	</head>
  
	
	<!-- Scrollspy set in the body -->
	<body id="home" data-spy="scroll" data-target=".main-nav" data-offset="73" style="zoom: 0.8;background:none;">
	
	<?php require_once "require_modal_metrika_noreg3.php";?>
	
		<div class="modal fade" id="myModalReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Регистрация</h4>
					</div>
					<div class="modal-body" style="background-color:white;overflow: auto;">
						<script>
						$(document).ready(function() {
							$("#regCompleteButton").prop( "disabled", true);
							$('#regEmail').on('input',function() {
								postAjax()
								return true;});
						});

						function postAjax()
						{
							var log = $('#regEmail').val();
							console.log(log);
							$.post ('<?= base_url() ?>registr/check_mail',{login:log},
								function(data,status)
								{
									if( status=='success' )
									{
			        					eval('var obj='+data);
								        if(obj.auth==true)
										{
			        					    $("#regCompleteButton").prop( "disabled", false);
			        					    $('.help-block').html("");
			        					}
										else
								        {   
								        	$("#regCompleteButton").prop( "disabled", true);
											$('.help-block').html("Такой логин существует или введён некорректный адрес");
										}
								    }
								    else
								    {
			        					alert('В процессе отправки произошла ошибка :(');
			    					}
								})
							}
						
						function func_student()
						{
							$("#regTypeSelect").hide("fast");
							$("#regUniverSelect").show(1);
						}

						function func_guest()
						{
							$("#regTypeSelect").hide("fast");
							$(".regRequiredFields").show(1);
							$("#regGuest").val(0);
							$("#regType").val(0);
						}

						function func_ifmo()
						{
							$("#regUniverSelect").hide("fast");
							$(".regRequiredFields").show(1);
							$("#regFSPOGroup").show(1);
							$("#regGuest").val(1);
							$("#regType").val(1);
						}

						function func_segr()
						{
							$("#regUniverSelect").hide("fast");
							$(".regRequiredFields").show(1);
							$("#regSegrysGroup").show(1);
							$("#regGuest").val(1);
							$("#regType").val(2);
						}

						</script>
						<div class="row" style="width:100%;margin:10px auto;text-align:center" id="regTypeSelect">
  							<button type="button" class="btn btn-primary col-sm-2" onClick="func_student()" style="width:35%">Студент</button>
  							<label class="col-sm-2" style="width:30%;font-size: 20px;padding-top: 5px;height:40px;">или</label>
  							<button type="button" class="btn btn-primary col-sm-2" onClick="func_guest()" style="width:35%">Гость</button>
						</div>
					
						<div class="row" style="width:100%;margin:10px auto;text-align:center;display:none;" id="regUniverSelect">
  							<button type="button" class="btn btn-primary col-sm-2" onClick="func_ifmo()" style="width:35%">ФСПО</button>
  							<label class="col-sm-2" style="width:30%;font-size: 20px;padding-top: 5px;height:40px;">или</label>
  							<button type="button" class="btn btn-primary col-sm-2" onClick="func_segr()" style="width:35%">НОУ "СЕГРИС-ИИТ"</button>
						</div>

						<form action="<?= base_url() ?>registr/create_person" method="post" name="regForm" autocomplete="off">
						
							<input type="hidden" name="guest" id="regGuest">
							<input type="hidden" name="type" id="regType">

							<div class="form-group regRequiredFields" style="display:none;">
    							<label class="col-sm-2 control-label">Фамилия</label>
    							<div class="col-sm-10">
      								<input type="text" class="form-control" placeholder="Ваша фамилия" name="lastname">
    							</div>
  							</div>

  							<div class="form-group  regRequiredFields" style="display:none;">
    							<label class="col-sm-2 control-label">Имя</label>
    							<div class="col-sm-10">
      								<input type="text" class="form-control" placeholder="Ваше имя" name="firstname">
    							</div>
  							</div>

  							<div class="form-group  regRequiredFields" style="display:none;">
    							<label class="col-sm-2 control-label">Email</label>
    							<div class="col-sm-10">
      								<input type="email" class="form-control" id="regEmail" placeholder="Адрес электронной почты" name="login">
    							</div>
    							<p class="help-block"></p>
  							</div>

  							<div class="form-group  regRequiredFields" style="display:none;">
    							<label class="col-sm-2 control-label">Пароль</label>
    							<div class="col-sm-10">
      								<input type="password" class="form-control" placeholder="Пароль" name="pass">
    							</div>
  							</div>
							
							<div class="form-group" id="regSegrysGroup" style="display:none;">
								<label class="col-sm-2 control-label">Группа</label>
								<div class="col-sm-10">
									<select name="segrys_group" class="form-control input-lg">
									<?php
									foreach ($segrys as $key)
									{
										?>
										<option value="<?=$key['id'] ?>"><?= $key['name_plosh'] ?>: <?= $key['name_numb'] ?></option>
										<?php
									}
									?>
									</select>
								</div>
							</div>
					
							<div class="form-group" id="regFSPOGroup" style="display:none;">
								<label class="col-sm-2 control-label">Группа</label>
								<div class="col-sm-10">
									<select name="fspo_group" class="form-control">
										<?php
										foreach ($fspo as $key)
										{
											?>
											<option value="<?=$key['id'] ?>"><?= $key['name_numb'] ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
									
					</div>	
					<div class="modal-footer">
						<button type="submit" class="btn btn-success" id="regCompleteButton">Зарегистрироваться</button>
						</form>
						<button type="button"  class="btn btn-danger" data-dismiss="modal">Отмена</button>
						
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade in" id="myModalAuth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content" style="background-color: white;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Параметры учётной записи</h4>
					</div>
					<div class="modal-body" style="background-color:white;overflow: auto;">
						<form action="<?php echo base_url()?>main/auth" method="post" name="adminForm" autocomplete="off" style="margin:0 0;">
						<div class="form-group">
							<label for="exampleInputEmail1">Email или логин</label>
							<input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Введите email">
						</div>
						 <div class="form-group">
							<label for="exampleInputPassword1">Пароль</label>
							<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
						</div>
						<div id="vk_auth" style="margin: 0 auto;"></div>
						<script type="text/javascript"></script>
							
					</div>
						
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Далее</button>
						</form>
						<button type="button"  class="btn btn-danger" data-dismiss="modal">Отмена</button>
						
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	<!--///////////////////////////////////////// PARALLAX BACKGROUND ////////////////////////////////////////-->

	<!-- image is set in the CSS as a background image -->
	<div id="parallax"></div>

	<!--///////////////////////////////////////// end PARALLAX BACKGROUND ////////////////////////////////////////-->


	
	<!--/////////////////////////////////////// NAVIGATION BAR ////////////////////////////////////////-->

	<section id="header">

		<nav class="navbar navbar-fixed-top" role="navigation">

			<div class="navbar-inner">
				<div class="container">

					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#navigation"></button>

					<!-- Logo goes here - replace the image with your -->
					<a href="<?php echo base_url()?>" class="navbar-brand"><img src="<?= base_url() ?>images/logo.png" alt="ВОС"></a>


					<div class="collapse navbar-collapse main-nav" id="navigation">


						<ul class="nav pull-right">

							<!-- Menu items go here -->
							<li class="active hidden"><a href="#home">Главная</a></li>
							<li><a href="#features">Возможности</a></li>
							<li><a href="#info">Особенности</a></li>
							<li><a href="#testimonials">О нас</a></li>
							<li><a href="https://github.com/Pilotchik/vee_dlc" target="blank">Мы на GitHub</a></li>
							<!-- If you want sub-menu items, do them like this
							<li>
								<ul>
								  <li><a href="#">Item 1</a></li>
								  <li><a href="#">Item 2</a></li>
								</ul>
							</li> 
							You just need to delete these comment lines -->
						</ul>

					</div><!-- /nav-collapse -->
				</div><!-- /container -->
			</div><!-- /navbar-inner -->
		</nav>

	</section>

	<!--//////////////////////////////////////// end NAVIGATION BAR ////////////////////////////////////////-->

	

	<!--/////////////////////////////////////// HERO SECTION ////////////////////////////////////////-->

	<section id="hero">

		<div class="container">
			<div class="row">

				<div class="col-md-12 intro" style="color: white; font-size: 20px;">
					<img src="<?= base_url() ?>images/logo.png" alt="Вирутальная обучающая среда" width="170px">
					<p class="lead" ><h1>Виртуальная Обучающая Среда</h1>Среда для студентов факультета среднего профессионального образования НИУ ИТМО</p>
					<button  class="btn btn-hg btn-primary" data-toggle="modal" onClick="auth_open()">
						Войти в систему
					</button>
					<button class="btn btn-hg btn-inverse inline" data-toggle="modal" data-target="#myModalReg">
						Регистрация
					</button>

				</div>
			</div><!-- /row -->
		</div><!-- /container -->

	</section>

	<!--///////////////////////////////////////////////// end HERO SECTION ////////////////////////////////////////-->



	<!--/////////////////////////////////////// FEATURES SECTION ////////////////////////////////////////-->

	<section id="features">

		<div class="container">

			<header>
				<h1>Наши возможности</h1>
				<center>
					<span class="lead" style="color: gray;">В среде много функциональных возможностей, но есть ключевые...</span>
				</center>
			</header>

			<div class="row">
				
				<!-- Feature Item 1 -->
				<div class="col-md-4 text-center">
					<h4>Тестирование</h4>
					<div class="feature-icon">
						<img src="<?= base_url() ?>images/icons/clipboard.svg" alt="" />
					</div>
					<p>Стандартное тестирование с 7 типами вопросов, а также возможность проверки результатов в ручном режиме</p>
				</div>

				<!-- Feature Item 2 -->
				<div class="col-md-4 text-center">
					<h4>Анкетирование</h4>
					<div class="feature-icon">
						<img src="<?= base_url() ?>images/icons/retina.svg" alt="" />
					</div>
					<p>6 типов вопросов для нелинейных и стандартных опросов с расширенными возможностями статистической визуализации</p>
				</div>

				<!-- Feature Item 3 -->
				<div class="col-md-4 text-center">
					<h4>Дистанционное обучение</h4>
					<div class="feature-icon">
						<img src="<?= base_url() ?>images/icons/book.svg" alt="" />
					</div>
					<p>Электронные курсы с возможностью подключения медиа-контента, тестов и опросов</p>
				</div>

			</div><!-- /row -->
		</div><!-- /container -->

	</section>

	<!--/////////////////////////////////////// end FEATURES SECTION ////////////////////////////////////////-->



   


	<!--/////////////////////////////////////// INFO SECTION ////////////////////////////////////////-->

	<section id="info">

	   
		<div class="info-section-gray" id="slideshow">
			
			<div class="container">
				<div class="row">   

					<div class="col-md-6">

						<!--////////// CAROUSEL SLIDER //////////-->

						<!-- declaring the carousel slides -->
						<div id="myCarousel" class="carousel slide">
							<ol class="carousel-indicators">
								<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
								<li data-target="#myCarousel" data-slide-to="1"></li>
							</ol>

							<!-- The carousel items themselves -->
							<div class="carousel-inner">
							
								<!--////////// Carousel Item 1 //////////-->
								<div class="active item gallery-popup">
									<a href="<?= base_url() ?>images/quality.png"><img src="<?= base_url() ?>images/quality.png" alt="placeholder image" class="img-responsive"></a>
								</div>
								<div class="item gallery-popup">
									<a href="<?= base_url() ?>images/corr_result.jpg"><img src="<?= base_url() ?>images/corr_result.jpg" alt="placeholder image" class="img-responsive"></a>
								</div>
								<!--////////// end of Carousel Item 1 //////////-->
						  
							</div>

						  <!-- Carousel navigation arrows -->
						  <a class="carousel-control left" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
						  <a class="carousel-control right" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
						</div>

					</div>
					<!--////////// end of CAROUSEL SLIDER //////////-->

					
					<div class="col-md-6">
						<h3>Аналитика</h3>
						<p class="lead">Анализ и статистическая обработка данных.</p>
						<p>Для формирования тестовых наборов, способных максимально точно определить уровень знаний, можно воспользоваться методами квалиметрической экспертизы, которые мы применяем в ВОС</p>
					   <a href="" class="btn btn-hg btn-primary">Подробнее</a>
					</div> 
								   
				</div><!-- /row -->
			</div><!-- /container -->

		</div><!-- /info-section-gray -->

		 <!--/////////// Info section alternates with white and gray backgrounds. Let's start with a white! //////////-->
		<div class="info-section-white">

			<div class="container">
				<div class="row">

					<div class="col-md-6 pull-right gallery-popup">
						<a href="<?= base_url() ?>images/api.png"><img src="<?= base_url() ?>images/api.png" alt="placeholder image" class="img-responsive"></a>
					</div> 

					<div class="col-md-6 pull-left">
						<h3>API</h3>

						<p class="lead">Аппартно-програмный интерфейс взаимодействия модулей с виртуальной обучающей среды</p>

						 <p>Для взаимодействия с виртуальной обучающей средой сторонних ресурсов можно использовать ВОС.API</p>

						<p>Хотите больше узнать о нашем API? </p>
						<a href="" class="btn btn-hg btn-primary">Вам сюда!</a>
					</div> 

				</div><!-- /row -->
			</div><!-- /container -->

		</div><!-- /info-section-white -->
		
		<!--/////////// And here's the gray background section! //////////-->
		
	</section>

	<!--/////////////////////////////////////// end INFO SECTION ////////////////////////////////////////-->



	<!--/////////////////////////////////////// TESTIMONIALS SECTION ////////////////////////////////////////-->

	<section id="testimonials">

		<div class="container">
			<div class="row">

				<!--////////// Another Carousel Slider //////////-->
				<div id="testimonials-slider" class="carousel slide">
					<ol class="carousel-indicators">
						<li data-target="#testimonials-slider" data-slide-to="0" class="active"></li>
						<li data-target="#testimonials-slider" data-slide-to="1"></li>
						<li data-target="#testimonials-slider" data-slide-to="2"></li>
						<li data-target="#testimonials-slider" data-slide-to="3"></li>
						<li data-target="#testimonials-slider" data-slide-to="4"></li>
						<li data-target="#testimonials-slider" data-slide-to="5"></li>
						<li data-target="#testimonials-slider" data-slide-to="6"></li>
						<li data-target="#testimonials-slider" data-slide-to="7"></li>
					</ol>
					
					<!-- Carousel items -->
					<div class="carousel-inner">
					
						<!-- Testimonial 1 -->
						<div class="active item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/dude.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Кудрявцев Александр</p>
								<cite>Back-end</cite>
							</div>

						</div>

						<!-- Testimonial 2 -->
						<div class="item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/girl.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Жиглова Екатерина</p>
								<cite>Аналитический модуль, front-end, идейный вдохновитель</cite>
							</div>

						</div>
					   
						<!-- Testimonial 3 -->
						<div class="item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/dude.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Шарабанов Даниил</p>
								<cite>Модуль модерируемого тестирования</cite>
							</div>

						</div>
						<!-- Testimonial 4 -->
						<div class="item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/dude.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Афанасьев Никита</p>
								<cite>Модуль анкетирования</cite>
							</div>

						</div>
						<!-- Testimonial 5 -->
						<div class="item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/dude.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Королёв Владимир</p>
								<cite>Идейный вдохновитель</cite>
							</div>

						</div>
						<!-- Testimonial 6 -->
						<div class="item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/dude.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Малышев Кирилл</p>
								<cite>Модуль компетентностного анализа обучения</cite>
							</div>

						</div>
						<!-- Testimonial 7 -->
						<div class="item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/dude.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Слабкий Андрей</p>
								<cite>API и Front-End</cite>
							</div>

						</div>
						<!-- Testimonial 8 -->
						<div class="item">

							<div class="col-md-2 col-md-offset-1">

								<div class="quote-icon">
									<img src="<?= base_url() ?>images/icons/dude.svg" alt="" />
								</div>
							</div>

							<div class="col-md-8">
								<p class="lead">Янсон Константин</p>
								<cite>Техническое обеспечение</cite>
							</div>

						</div>

					</div>
					
					<!-- Carousel navigation arrows -->
					<a class="carousel-control left" href="#testimonials-slider" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
					<a class="carousel-control right" href="#testimonials-slider" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
				<!--////////// end of Carousel Slider //////////-->

			</div><!-- /row -->
		</div><!-- /container -->

	</section>

	<!--/////////////////////////////////////// end TESTIMONIALS SECTION ////////////////////////////////////////-->

	<!--//////////////////////////////////////// FOOTER SECTION ////////////////////////////////////////-->
	<?php //require_once "require_header.php"; ?>
	<section id="footer">
		<div class="bottom-menu-inverse">

			<div class="container">

				<div class="row">
					<div class="col-md-6">
						<p>LMS. Версия 3.1. НИУ ИТМО ФСПО. 2008 - 2014</p>
					</div>
				</div>
			
			</div><!-- /row -->
		</div><!-- /container -->

	</section>

	<!--//////////////////////////////////////// end FOOTER SECTION ////////////////////////////////////////-->



	<!--//////////////////////////////////////// JAVASCRIPT LOAD ////////////////////////////////////////-->

	<!-- Feel free to remove the scripts you are not going to use -->
	<script src="<?= base_url() ?>js/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="<?= base_url() ?>js/jquery.ui.touch-punch.min.js"></script>
	<script src="<?= base_url() ?>js/bootstrap3.min.js"></script>
	<script src="<?= base_url() ?>js/jquery.isotope.min.js"></script>
	<script src="<?= base_url() ?>js/jquery.magnific-popup.js"></script>
	<script src="<?= base_url() ?>js/jquery.fitvids.min.js"></script>
	<script src="<?= base_url() ?>js/jquery.tweet.js"></script>
	<!--<script src="<?= base_url() ?>js/bootstrap-select.js"></script>-->
	<script src="<?= base_url() ?>js/bootstrap-switch.js"></script>
	<script src="<?= base_url() ?>js/flatui-checkbox.js"></script>
	<script src="<?= base_url() ?>js/flatui-radio.js"></script>
	<script src="<?= base_url() ?>js/jquery.tagsinput.js"></script>
	<script src="<?= base_url() ?>js/jquery.placeholder.js"></script>
	<script src="<?= base_url() ?>js/custom.js"></script>

	<!--//////////////////////////////////////// end JAVASCRIPT LOAD ////////////////////////////////////////-->

  </body>
</html>
