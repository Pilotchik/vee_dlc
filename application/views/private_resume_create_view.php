<html>
	<head>
		<title>Система тестирования</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/hltable.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('#root3').css("display", "none");
			}
			);

			var moder = 0;
			var image = 0;

			var error = 0;

			function setModerate()
			{
				if (moder == 0) 
				{
					moder = 1;$('#save_button').css({"visibility":"visible"});
				} 
				else 
				{
					moder = 0;$('#save_button').css({"visibility":"hidden"});
				}
			}

			function addImage()
			{
				if (image == 0) 
				{
					image = 1;
					postAjax(4,1,0,0,0,0);
				} 
				else 
				{
					image = 0;
					postAjax(4,0,0,0,0,0);
				}
			}

			function postAjax(step,param1,param2,param3,param4,param5)
			{
				$.post('<?php echo base_url();?>private_site/resume_create',{step:step,param_1:param1,param_2:param2,param_3:param3,param_4:param4,param_5:param5},function(data,status){
				if( status!='success' )
				{
        			alert('В процессе автосохранения произошла ошибка :(');
        			error = 1;
				}
				else
				{
					eval('var obj='+data);
					if (obj.answer==0)
					{
						alert('Введённые данные не сохранились');
						error = 1;
					}
				}
				})
				return error;
			}

			function nextStep(nomer)
			{
				$('body,html').animate({scrollTop:0},500);
				if (nomer == 1)
				{
					middlename = $("#user_middlename").val();
					phone = $("#user_phone").val();
					mail = $("#user_mail").val();
					<?php 
					if ($user_info['birthday'] == "")
					{
					?>
					month = $("#user_birth_month option:selected").html();
					month = month.slice(0, -1) + 'я ';
					month = month.toLowerCase();
					user_birth = $("#user_birth_day option:selected").val() + ' ' + month + $("#user_birth_year option:selected").html();
					<?php 
					}
					else
					{
						echo "user_birth = '".$user_info['birthday']."';";
					}
					?>
					state = $("#user_state option:selected").val();
					if ((middlename!='') && (phone!='') && (mail!=''))
					{
						error = postAjax(1,middlename,phone,mail,user_birth,state);
					}
					else
					{
						alert('Заполнены не все поля');
						error = 1;
					}
				}
				if (nomer == 4)
				{
					postAjax(5,0,0,0,0,0);
					$('div').fadeOut(1000);
					$('#root3').fadeIn(1000, redirectPage);
				}
				if (error == 0)
				{
					$('#block'+nomer).css({"visibility":"hidden"})
					$('#save_button').css({"visibility":"hidden"});
					progress=(nomer/4)*100;
					progress=Math.round(progress);
					$('.bar').css({"width": progress+"%"})
					if (progress==100)
					{
						$('div').fadeOut(1000);
						$('#root3').fadeIn(1000,function(){document.testForm.submit();});
					}
					nomer++
					$('#block'+nomer).css({"visibility":"visible"})
				}
			}

			function redirectPage() 	{document.resumeForm.submit();}

			var skill_d = [];
			
			<?php
				$i = 0;
				foreach ($skills as $key)
				{
					echo "skill_d[".$key['id']."] = [];
					";
					$j=1;
					echo "skill_d[".$key['id']."][0]='Не могу определить';
					";
					foreach ($skill_description[$key['id']] as $key2)
					{
						echo "skill_d[".$key['id']."][$j]='".$key2['description']."';
						";
						$j++;
					}
					
					echo "$(function() {
    						$(\"#slider$i\").slider({
    							";
    							if (isset($user_skill[$key['id']]))
    							{
    								echo "value:".$user_skill[$key['id']].",";
    							}
    							else
    							{
    								echo "value:1,";
    							}								
								echo "min: 1,max:6,step: 1,slide: function( event, ui ) {
									value = ui.value - 1;
									";
									//Здесь код отправки
									echo "$('#slider$i')";?>.css({"background":"#ccff00"});
									skill_id=<?php echo $key['id'];?>;
									<?php echo "$('#skill_desc$i').html(skill_d[".$key['id']."][value]);
									"; ?>
									postAjax(2,skill_id,value,0,0,0);
							<?php echo "}
						    });
					  	});";
					$i++;
				}
			?>

			function func_create_portfolio()
			{
				port_name = $("#port_name").val();
				port_desc = $("#port_desc").val();
				port_url = $("#port_url").val();
				port_begin = $("#port_begin_month option:selected").html()+' '+$("#port_begin_year option:selected").html();
				port_end = $("#port_end_month option:selected").html()+' '+$("#port_end_year option:selected").html();
				//alert(port_name+' '+port_desc+' '+port_url+' '+port_begin+' '+port_end);
				if (port_name!="" && port_desc!="")
				{
					postAjax(3,port_name,port_desc,port_url,port_begin,port_end);	
					alert('Информация о проекте добавлена');
					$("#port_name").html('');
					$("#port_desc").html('');
					$("#port_url").html('');
				}
				else
				{
					alert('Заполнены не все поля');
				}
			}

			function func_del(port_id)
			{
				$('.port'+port_id).slideToggle("slow");
				//Запрос на удаление
				$.post('<?php echo base_url();?>private_site/portfolio_del',{id:port_id},function(data,status){
				if( status!='success' )	{alert('В процессе удаления произошла ошибка :(');}
				else {eval('var obj='+data);	if (obj.answer==0)	{	alert('Введённые данные не сохранились');} else {alert('Проект удалён');}}})
			}

		</script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link href="<?php echo base_url()?>css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require_once "require_modal_metrika.php";?>
		<form style="margin:0 0 0 0;" action="<?php echo base_url();?>private_site/resume" method="post" name="resumeForm"></form>
		<div id="root3">
			<center>
				<br />
				<h1>Пожалуйста, подождите...</h1>
				<br /><br />
				Происходит обработка данных. Процесс может занять некоторое время.
				<br /><br />
			</center>
		</div>
		<center>
			<div id="root" style="width:900;margin:20px 0 0 0;">
				<h1>Создание резюме</h1>
				<div class="progress progress-info progress-striped active" style="margin:10px 0 0 0;">
					<div class="bar" style="width: 0%;"></div>
				</div>
			</div>
			<div id="block1" style="visibility:visible;width:100%;z-index:100;margin:20px 0 0 0;position:absolute;top:120px;">
				<div id="root" style="width:900;margin:0 0 0 0;">
					<H3>Шаг1. Личная информация</h3>
					<table id="groups" class="sortable" style="font-size:12px;width:70%">
						<thead>
							<tr>
								<td align="center" width="30%"><b>Параметр</b></td>
								<td align="center" width="70%"><b>Значение</b></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Имя</td>
								<td>
									<?php echo $user_info['firstname'];?>
								</td>
							</tr>
							<tr>
								<td>Отчество</td>
								<td>
									<input type="text" id="user_middlename" value="<?php echo $user_info['middlename'];?>">
								</td>
							</tr>
							<tr>
								<td>Фамилия</td>
								<td>
									<?php echo $user_info['lastname'];?>
								</td>
							</tr>
							<tr>
								<td>Место проживания</td>
								<td>
									<select id="user_state">
										<option value="0">Скрыто</option>
										<option value="1">Санкт-Петербург</option>
										<option value="2">Ленинградская область</option>
										<option value="3">За границей Ленинградской области</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Дата рождения</td>
								<td>
									<?php 
									if ($user_info['birthday'] == "")
									{
									?>
										<select id="user_birth_day">
											<?php
												for ($i=1;$i<32;$i++)
												{
													echo "<option value=$i>$i</option>";
												}
											?>
										</select>
										<select id="user_birth_month">
											<option value="1">Январь</option>
											<option value="2">Февраль</option>
											<option value="3">Март</option>
											<option value="4">Апрель</option>
											<option value="5">Май</option>
											<option value="6">Июнь</option>
											<option value="7">Июль</option>
											<option value="8">Август</option>
											<option value="9">Сентябрь</option>
											<option value="10">Октябрь</option>
											<option value="11">Ноябрь</option>
											<option value="12">Декабрь</option>
										</select>
										<select id="user_birth_year">
											<?php
												for ($i=1950;$i<2010;$i++)
												{
													echo "<option value=$i>$i</option>";
												}
											?>
										</select>
									<?php
									}
									else
									{
										echo $user_info['birthday'];
									}
									?>
								</td>
							</tr>
							<tr>
								<td>Tелефон для связи</td>
								<td>
									<input type="text" id="user_phone" value="<?php echo $user_info['phone'];?>">
								</td>
							</tr>
							<tr>
								<td>Электронная почта</td>
								<td>
									<input type="text" id="user_mail" value="<?php if ($user_info['mail_adr'] == "") {echo $user_info['mail'];} else {echo $user_info['mail_adr'];}?>">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p><input type="checkbox" id="user_moderate" onclick="setModerate()">Отмечая это поле, я выражаю свое согласие с тем, что администрация единой системы тестирования студентов имеет право распоряжаться предоставленной информацией, согласно Законодательства и условиями использования сайта</p>
								</td>
							</tr>
						</tbody>
					</table>
				<div style="width:206px;margin:20px 0 0 0;visibility:hidden" class="btn btn-success" onClick="nextStep(1)" id="save_button">
					<i class=\"icon-ok icon-white\"></i> Сохранить
				</div>
			</div>
		</div>
		<div id="block2" style="visibility:hidden;width:100%;z-index:80;margin:20px 0 0 0;position:absolute;top:120px;">
			<div id="root" style="width:900;margin:0 0 0 0;">
				<H3>Шаг2. Карта навыков</h3>
				<table id="groups" class="sortable" style="font-size:11px;width:70%">
					<thead>
						<tr>
							<td align="center" width="15%"><b>Навык</b></td>
							<td align="center" colspan="2"><b>Уровень</b></td>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 0;
						foreach ($skills as $key)
						{
							$skill_id=$key['id'];
							echo "<tr><td align=center rowspan=2><b>".$key['name']."</b></td><td width=20%>";
							if (isset($user_skill[$key['id']]))
							{
								echo "Было: ".$user_skill[$key['id']]." из 5";
							}
							else
							{
								echo "Не могу определить";	
							}
							echo "</td><td align=center><div id=\"slider$i\" ";
							if (isset($user_skill[$key['id']]))
    						{
								echo "style=background:#ccff00";
							}
							echo "></div></td></tr>
							<tr><td colspan=2><div id=\"skill_desc$i\"></div></td></tr>";
							$i++;
						}
						?>
					</tbody>
				</table>
				<div style="width:206px;margin:20px 0 0 0;" class="btn btn-success" onClick="nextStep(2)">
					<i class=\"icon-ok icon-white\"></i> Далее
				</div>
			</div>
		</div>
		<div id="block3" style="visibility:hidden;width:100%;z-index:80;margin:20px 0 0 0;position:absolute;top:120px;">
			<div id="root" style="width:900;margin:0 0 0 0;">
				<H3>Шаг3. Портфолио и опыт</h3>
			</div>
			<div id="portfolios">
			<?php
			if (count($portfolios) == 0)
			{
				?>
					<div id="root" style="width:900;margin:20px 0 0 0;" class="first_message">
						<center>Вы пока не указали ни одной работы, надо это как-то исправлять.</center>
					</div>
				<?php
			}
			else
			{
				foreach ($portfolios as $key)
				{
					echo "<div id=\"root\" style=\"width:900;margin:20px 0 0 0;\" class=port".$key['id'].">
						<h3>".$key['name']."</h3><div onClick=\"javascript: func_del(".$key['id'].")\"> <i class=\"icon-remove\"></i></div>
						<p>".$key['description']."</p>
						<p>".$key['url']."</p>
						<p>Дата начала: ".$key['date_begin']."</p>
						<p>Дата окончания: ".$key['date_end']."</p>
					</div>";
				}
			}
			?>
			</div>
			<div id="root" style="width:900;margin:20px 0 0 0;">
				<H3>Добавить работу или проект</h3>
				<table id="groups" class="sortable" style="font-size:12px;width:70%">
						<thead>
							<tr>
								<td align="center" width="30%"><b>Параметр</b></td>
								<td align="center" width="70%"><b>Значение</b></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Название проекта или работы</td>
								<td>
									<textarea cols="50" rows="2" id="port_name"></textarea>
								</td>
							</tr>
							<tr>
								<td>Описание</td>
								<td>
									<textarea cols="50" rows="3" id="port_desc"></textarea>
								</td>
							</tr>
							<tr>
								<td>Ссылка на сайт (если есть)</td>
								<td>
									<textarea cols="50" rows="3" id="port_url"></textarea>
								</td>
							</tr>
							<tr>
								<td>Дата начала</td>
								<td>
									<select id="port_begin_month">
										<option value="1">Январь</option>
										<option value="2">Февраль</option>
										<option value="3">Март</option>
										<option value="4">Апрель</option>
										<option value="5">Май</option>
										<option value="6">Июнь</option>
										<option value="7">Июль</option>
										<option value="8">Август</option>
										<option value="9">Сентябрь</option>
										<option value="10">Октябрь</option>
										<option value="11">Ноябрь</option>
										<option value="12">Декабрь</option>
									</select>
									<select id="port_begin_year">
									<?php
										for ($i=2000;$i<2014;$i++)
										{
											echo "<option value=$i>$i</option>";
										}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Дата окончания (реальная или планируемая)</td>
								<td>
									<select id="port_end_month">
										<option value="1">Январь</option>
										<option value="2">Февраль</option>
										<option value="3">Март</option>
										<option value="4">Апрель</option>
										<option value="5">Май</option>
										<option value="6">Июнь</option>
										<option value="7">Июль</option>
										<option value="8">Август</option>
										<option value="9">Сентябрь</option>
										<option value="10">Октябрь</option>
										<option value="11">Ноябрь</option>
										<option value="12">Декабрь</option>
									</select>
									<select id="port_end_year">
									<?php
										for ($i=2000;$i<2020;$i++)
										{
											echo "<option value=$i>$i</option>";
										}
									?>
									</select>
								</td>
							</tr>
							
						</tbody>
					</table>
				<div style="width:206px;margin:10px 0 10px 0;" class="btn btn-inverse" onClick="javascript: func_create_portfolio()">
					<i class="icon-plus icon-white"></i> Добавить проект
				</div>
			</div>
			<div id="root" style="width:900;margin:20px 0 0 0;">
				<div style="width:206px;margin:20px 0 0 0;" class="btn btn-success" onClick="nextStep(3)">
					<i class=\"icon-ok icon-white\"></i> Далее
				</div>
			</div>
		</div>
		<div id="block4" style="visibility:hidden;width:100%;z-index:80;margin:20px 0 0 0;position:absolute;top:120px;">
			<div id="root" style="width:900;margin:0 0 0 0;">
				<H3>Шаг 4. Компетентностный портрет</h3>
					<?php
					if (count($comp_name)==0)
					{
						echo "<center>Компетентностный портрет для Вас, увы, пока не составлен</center>";
					}
					else
					{
						echo "<table class=\"sortable\" border=\"1\" id=\"groups\" width=\"100%\" style=\"font-size:11px;\">
							<tr>
								<td align=\"center\"><b>#</b></td>
								<td align=\"center\" width=90%><b>Компетенция</b></td>
								<td align=\"center\"><b>Баллы</b></td>
							</tr>";
							$i = 1;
							foreach ($comps as $key)
							{
								echo "<tr><td align=center>$i</td>
								<td align=center>".$comp_name[$key['id']]."</td>
								<td align=center>".$comp_ball[$key['id']]."</td></tr>";
								$i++;
							}
							echo "</table><br>
							<center><input style=\"width:25px;margin:0 0 0 0;\" type=\"checkbox\" id=\"comp_image\" onclick=\"addImage()\">Включить в резюме мой компетентностный портрет</center>";
					}
					?>
				<div style="width:206px;margin:20px 0 0 0;" class="btn btn-success" onClick="nextStep(4)">
					<i class=\"icon-ok icon-white\"></i> Завершить
				</div>
			</div>
		</div>
		</center>
	</body>
</html>