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

<a class="brand" href="<?php echo base_url()?>main/auth"><h2>Виртуальная Обучающая Среда</h2></a>
			<div id="navbar-example" class="navbar navbar-inverse ">
            	<div class="navbar-inner">
                	<div class="container" style="width: auto;">
                		<a class="brand" href="<?php echo base_url()?>main/auth"><i class="icon-user icon-white" style="margin:3px 0 0 0;"></i></a>
                  		<ul class="nav" role="navigation">
                    		<li class="dropdown">
                    			<a id="drop1" role="button" class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">Обучение <b class="caret"></b></a>
                      			<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                       				<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>attest">Тестирование</a></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>de">Электронные курсы</a></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>forms">Анкетирование</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>present">Презентации</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>kat">Справочные материалы</a></li>
                        		</ul>
                    		</li>
                    		<li>
                    			<a id="drop1" href="<?php echo base_url();?>private_site">Мои результаты</a>
                      		</li>
                    		<?php
                    		if($guest >= 2)
							         {
				       		       ?>
                    		<li class="dropdown">
                    			<a id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">Аналитика <b class="caret"></b></a>
                      			<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>results/view_last">Последние результаты</a></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>results">Результаты по дисциплинам</a></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>results/view_quests">Результаты по вопросам</a></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>results/view_groups">Результаты по группам</a></li>
                        			<li role="presentation" class="divider"></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>forms_admin/view_results">Результаты опросов</a></li>
                        			<li role="presentation" class="divider"></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>results/de">Результаты дистанционного обучения</a></li>
                        			<li role="presentation" class="divider"></li>
                        			<li class="dropdown-submenu">
                    					<a tabindex="-1">Статистика</a>
                    					<ul class="dropdown-menu">
                      						<li><a tabindex="-1" href="<?php echo base_url();?>stat">Статистика по тестам</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>stat/view_groups">Статистика по группам</a></li>
                      					</ul>
                  					</li>
                        			<li class="dropdown-submenu">
                    					<a tabindex="-1">Рейтинг</a>
                    					<ul class="dropdown-menu">
                      						<li><a tabindex="-1" href="<?php echo base_url();?>reyting/index/1/fspo">ФСПО</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>reyting/index/2/bk">НОУ "СЕГРИС-ИИТ". Базовый курс</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>reyting/index/2/spec">НОУ "СЕГРИС-ИИТ". Специализация</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>reyting/prepods">Рейтинг преподавателей</a></li>
                      					</ul>
                  					</li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>stat_site">Журнал системы</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>stat_site/read_messages">Сообщения пользователей</a></li>
                        	</ul>
                    		</li>
                    		<li class="dropdown">
                    			<a id="drop1" role="button" class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;">Преподаватель <b class="caret"></b></a>
                      			<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                       				<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>moder">Проверка ответов</a></li>
                       				<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>moder/my_cmpl">Результаты проверки ответов</a></li>
                        			<li role="presentation" class="divider"></li>
                        			<li class="dropdown-submenu">
                    					<a tabindex="-1">Управление учебными планами</a>
                    					<ul class="dropdown-menu">
                      						<li><a tabindex="-1" href="<?php echo base_url();?>plans/view/1">ФСПО</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>plans/view/2">НОУ "СЕГРИС-ИИТ"</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>plans/view/3">Универсальные</a></li>
                      					</ul>
                  					</li>
                        		<li class="dropdown-submenu">
                    					<a tabindex="-1" href="#">Управление тестами</a>
                    					<ul class="dropdown-menu">
                      					<li><a tabindex="-1" href="<?php echo base_url();?>tests/dest_view/fspo">ФСПО</a></li>
                      					<li><a tabindex="-1" href="<?php echo base_url();?>tests/target_tests/fspo">Назначение тестов группе</a></li>
                                <li><a tabindex="-1" href="<?php echo base_url();?>tests/dest_view/segrys">НОУ "СЕГРИС-ИИТ"</a></li>
                      					<li><a tabindex="-1" href="<?php echo base_url();?>tests/dest_view/psih">Универсальные</a></li>
                      				</ul>
                  					</li>
                        		<li role="presentation" class="divider"></li>
                        		<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>forms_admin">Управление опросами</a></li>
                        		<li class="dropdown-submenu">
                    				  <a tabindex="-1" href="#">Дистанционные курсы</a>
                    					<ul class="dropdown-menu">
                      						<li><a tabindex="-1" href="<?php echo base_url();?>de_admin/disc_view/fspo">ФСПО</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>de_admin/disc_view/segrys">НОУ "СЕГРИС-ИИТ"</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>de_admin/disc_view/psih">Универсальные</a></li>
                      					</ul>
                  					</li>
                        		<li class="dropdown-submenu">
                    					<a tabindex="-1" href="#">Дистанционные презентации</a>
                    					<ul class="dropdown-menu">
                      						<li><a tabindex="-1" href="<?php echo base_url();?>present_admin/present_menage">Управление показом</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>present_admin">Управление презентациями</a></li>
                      					</ul>
                  					</li>
                            <li role="presentation" class="divider"></li>
                            <li class="dropdown-submenu">
                              <a tabindex="-1" href="#">Управление справочными материалами</a>
                              <ul class="dropdown-menu">
                                <li><a tabindex="-1" href="<?php echo base_url();?>kat_admin/dest_view/fspo">ФСПО</a></li>
                                <li><a tabindex="-1" href="<?php echo base_url();?>kat_admin/dest_view/segrys">НОУ "СЕГРИС-ИИТ"</a></li>
                                <li><a tabindex="-1" href="<?php echo base_url();?>kat_admin/dest_view/psih">Универсальные</a></li>
                              </ul>
                            </li>
                            <li role="presentation" class="divider"></li>
                        			<li role="presentation" style="background-color:yellow;"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>tests/kods">Ключи тестов</a></li>
                       			</ul>
                    		</li>
                    		<?php
                    		}
                    		if ($guest > 2)
                    		{
                    		?>
                    		<li class="dropdown">
                    			<a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Администратор <b class="caret"></b></a>
                      			<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        			<li class="dropdown-submenu">
                    					<a tabindex="-1" href="#">Управление группами</a>
                    					<ul class="dropdown-menu">
                      						<li><a tabindex="-1" href="<?php echo base_url();?>groups/fspo">ФСПО</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>groups/segrys">НОУ "СЕГРИС-ИИТ"</a></li>
                      					</ul>
                  					</li>
                        			<li role="presentation" class="divider"></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>persons/personal">Управление персоналом</a></li>
                        			<li class="dropdown-submenu">
                    					<a tabindex="-1" href="#">Управление студентами</a>
                    					<ul class="dropdown-menu">
                      						<li><a tabindex="-1" href="<?php echo base_url();?>persons/perevod">Перевод студентов</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>persons/students_fspo">Студенты ФСПО</a></li>
                      						<li><a tabindex="-1" href="<?php echo base_url();?>persons/students_segrys">Студенты НОУ "СЕГРИС-ИИТ"</a></li>
                      					</ul>
                  					</li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>persons/guest">Гости системы</a></li>
                        			<li role="presentation" class="divider"></li>
                        			<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>persons/accounts">Аккаунты</a></li>
                        		</ul>
                    		</li>
                    		<?php
                    		}
                    		?>
                    	</ul>
                  		<ul class="nav pull-right">
                   			<?php
                        if($guest >= 2)
                        {
                          ?>
                          <li>
                            <form action="<?php echo base_url()?>results/all_user_results" method="post" name="searchUserForm"  autocomplete="off" style="margin:0 0;">
                              <input id="search_user" type="text" placeholder="Фамилия, имя или логин" name="name" style="height: 30px;min-width: 100%;margin-top:5px;margin-bottom:0px;font-size:14px" data-provide="typeahead" data-items="10" data-original-title="" title="">
                              <input id="hidden_user_id" type="hidden" name="user_id" value="">
                            </form>
                          </li>
                          <?php
                        }
                        ?>
                        <li>
                      			<a href="<?php echo base_url();?>main/deauth" id="drop3" role="button"><i class="icon-off icon-white"></i> Выход</a>
                    		</li>
                  		</ul>
                	</div>
              	</div>
            </div>