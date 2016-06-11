<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
	
	<script type="text/javascript">
			$(document).ready(function() 
			{ 	
				$('.all').css("display", "none");
			});

			function func_step2()	{$("#step2").fadeIn(2500);}
			function func_step3()	{$("#step3").fadeIn(2500);}
			function func_step4()	{$("#step4").fadeIn(2500);}
			function func_step5()	{$("#step5").fadeIn(2500);}
	</script>
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?62"></script>
	<script type="text/javascript">
  			VK.init({apiId: 2849330, onlyWidgets: true});
	</script>
		
<div id="main" style="min-height:85%">
	<?php require_once(APPPATH.'views/require_main_menu_bs3.php');?>
			
		<ul class="breadcrumb">
			<li><a href="<?= base_url() ?>tutor">Помощь по работе со средой</a></li>
			<li class="active">Формирование корректного результата</li>
		</ul>

		<center>
			<div id="step1" style="width:80%;">
				1 этап: Студенты, в том числе и Вы, сдают тест, отвечая на вопросы.
				<br>
				<input type="button" style="width:206px;margin:20px 0 0 0;" class="btn btn-inverse" value="Понятно, дальше" onClick="func_step2()">
			</div>
			<div id="step2" style="width:80%;" class="all">
				<br />
				2 этап: Для всех вопросов вычисляется сложность и те вопросы, на которые ответило больше 90% или меньше 10% считаются некорректными.<br />
				<?php 
				$s=0;
				foreach ($results as $key)
				{
					$s+=$key['incorrect'];
				}
				if ($s>0)
				{
				?>
				Например, <?= $test['data'] ?> Вами был пройден тест <b>"<?= $test['name_razd'];?>"</b>. Для этого теста некорректными были признаны следующие вопросы:<br /><br />
				<table class="table" width="100%">
					<tr>
						<th>Текст вопроса</th>
					</tr>
					<?php
					foreach ($results as $key)
					{
						if ($key['incorrect'] == 1)
						{
							?>
							<tr>
								<td><?= $key['text'] ?></td>
							</tr>
							<?php
						}
					}
					?>
				</table>
				<?php 
				}
				?>
				<input type="button" style="width:206px;margin:20px 0 0 0;" class="btn btn-inverse" value="Так-так..." onClick="func_step3()">
			</div>
			<div id="step3" style="width:80%;" class="all">
				<br />
				3 этап: В зависимости от процента выполнения задания, для вопроса определяется сложность. Если вопрос выполнило от 70 до 90 процентов студентов, то ему присваивается вес 1, если от 50 до 70, то вес 2 и т.д.
				<br />
				<input type="button" style="width:206px;margin:20px 0 0 0;" class="btn btn-inverse" value="Ну и что?!..." onClick="func_step4()">
			</div>
			<div id="step4" style="width:80%;" class="all">
				<br />
				Например, для одного из Ваших тестов была определена сложность вопросов:<br /><br />
				<table class="table table-striped" width="100%">
					<thead>
						<tr>
							<th>Текст вопроса</th>
							<th>Сложность</th>
							<th>Правильность</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$summ_balls = 0;
						$summ_levels = 0;
						foreach ($results as $key)
						{
							if ($key['incorrect'] == 0)
							{
								?>
								<tr>
									<td><?= $key['text'] ?></td>
									<td><?= $key['level'] ?></td>
									<td><?= $key['true'] ?></td>
								</tr>
								<?php
								$summ_levels += $key['level'];
								$summ_balls += $key['true'] * $key['level'];
							}
						}
						?>
						<tr>
							<td align="right">Всего:</td>
							<td><b><?= $summ_levels ?></b></td>
							<td bgcolor="black">&nbsp;</td>
						</tr>
					</tbody>
				</table>
				<input type="button" style="width:206px;margin:20px 0 0 0;" class="btn btn-inverse" value="А дальше?" onClick="func_step5()">
			</div>
			<div id="step5" style="width:80%;" class="all">
				<br />
				Итак, всего можно было набрать <b><?= $summ_levels ?></b> баллов, а Вы набрали <b><?= round($summ_balls,2) ?></b>, что составляет <b><?= round(($summ_balls/$summ_levels)*100,3) ?>%</b>. Это и есть скорректированный результат.
				<br />
				<img src="<?= base_url() ?>images/corr_result.jpg" width="100%">
				<div id="vk_like2" style="margin:20px 0 0 0;"></div>
				<script type="text/javascript">
					VK.Widgets.Like("vk_like2", {type: "button", verb: 1, height: 24, pageTitle: 'Виртуальная образовательная среда', pageUrl:'http://exam.segrys.ru'});
				</script>
			</div>
			<br />
		</center>
	</div>

<?php require_once(APPPATH.'views/require_header.php');?>