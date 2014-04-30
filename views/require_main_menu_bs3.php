<?php $guest = $this->session->userdata('guest'); ?>
<?php
if($guest >= 2)
{
  ?>
  <script data-original-title="" title="">
  $(function(){
	$("#search_user").typeahead({
	  //источник данных
	  source: function (query, process) 
	  {
		return $.post('<?php echo base_url()?>main/finduser', {'name':query}, 
		function (response) {
		  var data = new Array();
		  //преобразовываем данные из json в массив
		  $.each(response, function(i, name)
		  {
			data.push(name['id']+'_'+name['lastname']+' '+name['firstname']+': '+name['login']);
		  })
		  return process(data);
		},'json');
	  }
		  //источник данных
		  //вывод данных в выпадающем списке
		  , highlighter: function(item) {var parts = item.split('_');parts.shift();return parts.join('_');}
		  //действие, выполняемое при выборе елемента из списка
		  , updater: function(item) {
					 var parts = item.split('_');
					 var id = parts.shift();
					 var name = parts.shift();
					 $('#hidden_user_id').val(id);
					 document.searchUserForm.submit();
				   }
		  //действие, выполняемое при выборе елемента из списка
	})
  })
  </script>
  <?php
}
?>

<nav class="navbar navbar-inverse" role="navigation">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="<?= base_url() ?>main/auth">ВОС</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">Обучение <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?= base_url() ?>attest">Тестирование</a></li>
						<li><a href="<?= base_url() ?>de">Электронные курсы</a></li>
						<li><a href="<?= base_url() ?>forms">Анкетирование</a></li>
						<li><a href="<?= base_url() ?>present">Презентации</a></li>
						<li><a href="<?= base_url() ?>kat">Справочные материалы</a></li>
					</ul>
				</li>
				<li><a href="<?php echo base_url();?>private_site">Мои результаты</a></li>
				<?php
				if($guest >= 2)
				{
					?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">Аналитика <b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">Результаты тестов</li>
							<li><a href="<?= base_url() ?>results/view_last">Последние результаты</a></li>
							<li><a href="<?= base_url() ?>results">Результаты по дисциплинам</a></li>
							<li><a href="<?= base_url() ?>results/view_quests">Результаты по вопросам</a></li>
							<li><a href="<?= base_url() ?>results/view_groups">Результаты по группам</a></li>
							<li class="dropdown-header">Опросы</li>
							<li><a href="<?= base_url() ?>forms_admin/view_results">Статистика по опросам</a></li>
							<li class="dropdown-header">Дистанционное обучение</li>
							<li><a href="<?= base_url() ?>results/de">Результаты дистанционного обучения</a></li>
							<li class="dropdown-header">Статистика тестов</li>
							<li><a href="<?= base_url() ?>stat">Статистика по тестам</a></li>
							<li><a href="<?= base_url() ?>stat/view_groups">Статистика по группам</a></li>
							<!--
							<li class="dropdown-header">Рейтинг</li>
							<li><a href="<?= base_url() ?>reyting/index/1/fspo">Рейтинг ФСПО</a></li>
							<li><a href="<?= base_url() ?>reyting/index/2/bk">НОУ "СЕГРИС-ИИТ". Базовый курс</a></li>
							<li><a tabindex="-1" href="<?php echo base_url();?>reyting/index/2/spec">НОУ "СЕГРИС-ИИТ". Специализация</a></li>
							<li><a tabindex="-1" href="<?php echo base_url();?>reyting/prepods">Рейтинг преподавателей</a></li>
							-->
							<li class="dropdown-header">Служебная аналитика</li>
							<li><a href="<?= base_url() ?>stat_site">Журнал системы</a></li>
							<li><a href="<?= base_url() ?>stat_site/read_messages">Сообщения пользователей</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">Управление <b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">Модерируемые тесты</li>
							<li><a href="<?= base_url() ?>moder">Проверка ответов</a></li>
							<li><a href="<?= base_url() ?>moder/my_cmpl">Результаты проверки ответов</a></li>
							<li class="dropdown-header">Управление учебными планами</li>
							<li><a href="<?= base_url() ?>plans/view/1">Учебные планы ФСПО</a></li>
							<li><a href="<?= base_url() ?>plans/view/2">Учебные планы НОУ "СЕГРИС-ИИТ"</a></li>
							<li><a href="<?= base_url() ?>plans/view/3">Универсальные учебные планы</a></li>
							<li class="dropdown-header">Управление тестами</li>
							<li><a href="<?= base_url() ?>tests/dest_view/fspo">Тесты ФСПО</a></li>
							<!--
							<li><a href="<?= base_url() ?>tests/target_tests/fspo">Назначение тестов группе</a></li>
							-->
							<li><a href="<?= base_url() ?>tests/dest_view/segrys">Тесты НОУ "СЕГРИС-ИИТ"</a></li>
							<li><a href="<?= base_url() ?>tests/dest_view/psih">Универсальные тесты</a></li>
							<li class="dropdown-header">Управление опросами</li>
							<li><a href="<?= base_url() ?>forms_admin">Управление опросами</a></li>
							<li class="dropdown-header">Дистанционные курсы</li>
							<li><a href="<?= base_url() ?>de_admin/disc_view/fspo">Курсы ФСПО</a></li>
							<li><a href="<?= base_url() ?>de_admin/disc_view/segrys">Курсы НОУ "СЕГРИС-ИИТ"</a></li>
							<li><a href="<?= base_url() ?>de_admin/disc_view/psih">Универсальные курсы</a></li>
							<li class="dropdown-header">Электронные презентации</li>
							<li><a href="<?= base_url() ?>present_admin">Управление презентациями</a></li>
							<li class="dropdown-header">Справочные материалы</li>
							<li><a href="<?= base_url() ?>kat_admin/dest_view/fspo">Справочные материалы ФСПО</a></li>
							<li><a href="<?= base_url() ?>kat_admin/dest_view/segrys">Справочные материалы НОУ "СЕГРИС-ИИТ"</a></li>
							<li><a href="<?= base_url() ?>kat_admin/dest_view/psih">Универсальные справочные материалы</a></li>
							<li><a href="<?= base_url() ?>kat_admin/view_materials">Редактирования соответствия</a></li>
							<li class="divider"></li>
							<li style="background-color:yellow;"><a href="<?= base_url();?>tests/kods">Ключи тестов</a></li>
						</ul>
					</li>
					<?php
				}
				if ($guest > 2)
				{
					?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">Администрирование <b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">Управление группами</li>
							<li><a href="<?= base_url() ?>groups/fspo">Группы ФСПО</a></li>
							<li><a href="<?= base_url() ?>groups/segrys">Группы НОУ "СЕГРИС-ИИТ"</a></li>
							<li class="dropdown-header">Персонал</li>
							<li><a href="<?= base_url() ?>persons/personal">Управление персоналом</a></li>
							<li class="dropdown-header">Управление студентами</li>
							<li><a href="<?= base_url() ?>persons/perevod">Перевод студентов</a></li>
							<li><a href="<?= base_url() ?>persons/students_fspo">Студенты ФСПО</a></li>
							<li><a href="<?= base_url() ?>persons/students_segrys">Студенты НОУ "СЕГРИС-ИИТ"</a></li>
							<li><a href="<?= base_url() ?>persons/guest">Гости системы</a></li>
							<li role="presentation" class="divider"></li>
							<li><a href="<?= base_url() ?>persons/accounts">Аккаунты</a></li>
						</ul>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
			if($guest > 2)
			{
				?>
		  		<form class="navbar-form navbar-left" role="search" action="<?php echo base_url()?>results/all_user_results" method="post" name="searchUserForm"  autocomplete="off" style="margin:0 0;">
					<div class="form-group">
						<input id="search_user" type="text" placeholder="Фамилия, имя или логин" name="name" style="width:200px;height: 30px;min-width: 100%;margin-top:10px;margin-bottom:0px;font-size:14px" data-provide="typeahead" data-items="10" data-original-title="" title=""  class="form-control">
				  		<input id="hidden_user_id" type="hidden" name="user_id" value="">
				  	</div>
				</form>
				<?php
			}
			?>
		  	<ul class="nav navbar-nav navbar-right">
		  		<li><a href="<?= base_url() ?>main/deauth"><span class="glyphicon glyphicon-off"></span> Выход</a></li>
		  	</ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>