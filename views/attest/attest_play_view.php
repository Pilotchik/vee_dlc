<?php require_once(APPPATH.'views/require_modal_metrika_bs3.php');?>
	<script src="<?= base_url() ?>js/jquery.colorbox.js"></script>
	<link rel="stylesheet" href="<?= base_url() ?>css/colorbox.css"/>
	<script type="text/javascript">
		$(document).ready(function() 
		{ 	
			$('#root3').css("display", "none");
			$('.reason').css("display", "none");
			<?php 
			foreach($quests as $key) 
			{
				?>
				$(".photo<?= $key['id'] ?>").colorbox({rel:'photo<?= $key['id'] ?>'});
				<?php
			}
			?>
		});

		function func_ok()	
		{
			if (confirm("Вы уверены, что хотите завершить тест?")) 
			{
				$('div').fadeOut(1000);
				$('#root3').fadeIn(1000, redirectPage);
			}
		}
			
		function redirectPage() {document.testForm.submit();}

		var tlong1=<?php 
		if ($time_save==0) 
		{
			echo "60*$time_long+5-($tim-$begin_t);";
		} 
		else 
		{
		echo "$time_save;";
		}?> 
		
		var tlong2=tlong1*1000;

		processTimer();
		
		function processTimer()
		{
			if (tlong1 > 0) 
			{
				setTimeout("processTimer()",1000);
				tlong1--;
			} 
			var limit_div = parseInt(tlong1/60); // минуты
			var limit_mod = tlong1 - limit_div*60; // секунды

			// строка с оставшимся временем
			limit_str = "&nbsp;&nbsp;";
			if (limit_div < 10) limit_str = limit_str + "0";
			limit_str = limit_str + limit_div + ":";
			if (limit_mod < 10) limit_str = limit_str + "0";
			limit_str = limit_str + limit_mod + "&nbsp;&nbsp;";

			// вывод времени
			el_timer = document.getElementById("time_str");
			if (el_timer) el_timer.innerHTML = limit_str;
		}
	
		function postAjax(id_q,ans_id)
		{
			var quest_id=id_q;
			var answer_id=ans_id;
			$.post ('<?php echo base_url();?>attest/autosave',{id_q:quest_id,time_s:tlong1,idrazd:<?php echo $id_test; ?>,ans_id:answer_id},function(data,status){
			if( status!='success' )	{alert('В процессе автосохранения произошла ошибка :(');}
			else
			{
				eval('var obj='+data);
				if (obj.answer==0)
				{
					alert('Ответ не сохранился');
				}
			}
			})
		}

		function postAjax2(id_q,id_name,type)
		{
			var quest_id=id_q;
			var val=document.getElementById(id_name).value;
			$.post ('<?php echo base_url();?>attest/autosave',{id_q:quest_id,true_q:val,time_s:tlong1,idrazd:<?php echo $id_test; ?>,type_q:type},function(data,status){
			if( status!='success' )
			{
				alert('В процессе автосохранения произошла ошибка :(');
			}
			else
			{
				eval('var obj='+data);
				if (obj.answer==0)
				{
					alert('Ответ не сохранился');
				}
			}
			})
		}

		function postAjax3(id_q,val,id_name,ans_id)
		{
			var quest_id=id_q;
			var answer_id=ans_id;
			var check1=document.getElementById(id_name).checked;
			if (check1==true)
			{
				check1=1;
			}
			else 
			{
				check1=0;
			}
			$.post ('<?php echo base_url();?>attest/autosave',{id_q:quest_id,true_q:val,check:check1,time_s:tlong1,idrazd:<?php echo $id_test;?>,type_q:'2',ans_id:answer_id},function(data,status){
			if( status!='success' )
			{
				alert('В процессе автосохранения произошла ошибка :(');
			}
			else
			{
				eval('var obj='+data);
				if (obj.answer==0)
				{
					alert('Ответ не сохранился');
				}
			}
			})
		}

		function postAjax4(id_q,val,id_name,ans_id)
		{
			var quest_id=id_q;
			var answer_id=ans_id;
			check1=val;
			var vas=document.getElementById(id_name).value;
			vas=encodeURIComponent(vas);
			$.post ('<?php echo base_url();?>attest/autosave',{id_q:quest_id,true_q:vas,check:check1,time_s:tlong1,idrazd:<?php echo $id_test; ?>,type_q:'4',ans_id:answer_id},function(data,status){
			if( status!='success' )
			{
				alert('В процессе автосохранения произошла ошибка :(');
			}
			else
			{
				eval('var obj='+data);
				if (obj.answer==0)
				{
					alert('Ответ не сохранился');
				}
			}
			})
		}

		function func_corr_form(numb)			
		{
			$(".reason").eq(numb).slideToggle("slow");
		}

		function func_quest_corr(numb,id_q,type)
		{
			$.post('<?php echo base_url();?>attest/corr_quest',{id_q:id_q,type:type},
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
						$('.warning').eq(numb).css({"display":"none"})
					}
				}})
		}

		$(document).ready(function()
		{
			$("#second_num").html(second_num);//выводим вторую цифру счетчика
			if (tlong2>0)
			{
				setTimeout(function() {func_dis()}, tlong2);
			}
			else
			{
				func_dis();
			}
		}
		)

		setInterval(
			function()
			{
				$.post ('<?= base_url() ?>attest/timesave',{time_s:tlong1,idrazd:<?= $id_test ?>},function(data,status)
				{
					if( status!='success' )
					{
						alert('В процессе автосохранения произошла ошибка :(');
					}	
				}
				);
			},50000);
		
		function func_dis()
		{
			alert('Время истекло');
			document.testForm.submit();
		}

	</script>

	<form autocomplete="off" action="<?= base_url() ?>attest/test_itog/<?= $id_test ?>" method="get" name="testForm" id="testFormId">
		<input type="hidden" name="lection_id" value="<?= $lection_id ?>">
	</form>
	
	<div id="root3">
		<center>
			<br />
			<h1>Пожалуйста, подождите...</h1>
			<br /><br />
			Происходит обработка данных. Процесс может занять некоторое время.
			<br /><br />
		</center>
	</div>

	<div id="root" style="width:90%;margin:10px auto;padding:20px;font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;">
		<div class="row">
			<div class="col-xs-6 col-md-3">
				<h2 style="text-align:left"><?= $name_test ?></h2>
			</div>
			<div class="col-xs-6 col-md-3"></div>
			<div class="col-xs-6 col-md-3" style="text-align:center;">
				<small>Оставшееся время:</small><h2 id="time_str"></h2>
			</div>
			<div class="col-xs-6 col-md-3" style="text-align:center;">
				<small>Отложенных вопросов:</small><h2 id="second_num">0</h2>
			</div>
		</div>
		
		<div class="progress progress-striped" style="margin:10px 0 0 0;">
			<div class="progress-bar progress-bar-success bar"></div>
		</div>
		<div style="width:100%;text-align:right;">
			<input type="button" style="width:206px;margin:20px;" class="btn btn-warning btn-lg" value="Завершить" onClick="func_ok()">
		</div>
		
		<?php
		$i = 0;
		$n_id = 0;
		foreach($quests as $key) 
		{
			$nom = $i+1;
			$dis = ($i == 0 ? "block" : "none");
			?>
			<div id="block<?= $nom ?>"  class="quest" style="margin-top:5px;display:<?= $dis ?>;width:100%;z-index:<?= $nom ?>;padding:5px">
				<h4><i>Вопрос №<?= $nom ?> из <?= $chislo_vopr ?></i></h4>
				<blockquote style="border-left-width: 10px;">
					<p style="text-indent:0px;text-justify:none;"><?= $key['text'] ?></p>
					<?php
					if (strlen($key['image']) > 5) 
					{
						?>
						<a class="photo<?= $key['id'] ?>" href="<?= base_url() ?>images/<?= $key['image'] ?>" title="<?= $key['text'] ?>">
							<img src="<?= base_url() ?>images/<?= $key['image'] ?>" width="250">
						</a>
						<?php
					}
					?>
					<footer>
						
					</footer>
				</blockquote>
				<table width="100%">
				<?php
				$id_q = $key['id'];
				$type = $key['type'];
				
				$numbe = 1;				
				foreach ($answers[$key['id']] as $key2) 
				{
					$text = $key2['text'];
					$ans_id = $key2['id'];
					//Выбор одного
					if ($key['type'] == 1)
					{
						$text_q = ($key2['image'] == "0" ? $key2['text'] : "<img src=\".images/".$key2['image']."\">");
						?>
						<tr>
							<td align="right" style="width:25px;">
								<input style="-webkit-appearance: radio;width: 20px;height: 30px;margin:2px" type="radio" name="true_q[<?= $key['id'] ?>][0]" onClick="postAjax('<?= $key['id'] ?>','<?= $key2['id'] ?>')">
							</td>
							<td align="left" style="padding-left: 10px;">
								<?= $text_q ?>
							</td>
						</tr>
						<?php
					}
					//Выбор нескольких
					if ($key['type'] == 2)
					{
						$text_q = ($key2['image'] == "0" ? $key2['text'] : "<img src=\".images/".$key2['image']."\">");
						?>
						<tr>
							<td align="right" style="width:25px;">
								<input style="-webkit-appearance: checkbox;width: 20px;height: 30px;margin:2px" type="checkbox" name="true_q[<?= $key['id'] ?>][<?= $key2['id'] ?>]" id="sub<?= $n_id ?>" onClick="postAjax3('<?= $key['id'] ?>','<?= $numbe ?>','sub<?= $n_id ?>','<?= $key2['id'] ?>')">
							</td>
							<td align="left" style="padding-left: 10px;">
								<?= $text_q ?>
							</td>
						</tr>
						<?php
					}
					//Ввод текста
					if ($key['type'] == 3)
					{
						?>
						<tr>
							<td align="center">
								<input type="text" id="sub<?= $n_id ?>" class="form-control" name="true_q[<?= $key['id'] ?>][0]" style="width:206px;height: 30px;font-size: 14px;text-align: center;margin: 5px 10px;" onChange="postAjax2('<?= $key['id'] ?>','sub<?= $n_id ?>','3')">
							</td>
						</tr>
						<?php
					}
					//Соответствие
					if ($key['type'] == 4)
					{
						?>
						<tr>
							<td align="left">
								<?= $key2['quest_t'] ?>
							</td>
							<td>
								<input type="text" style="width:40px" class="form-control" id="sub<?= $n_id ?>" onChange="postAjax4('<?= $key['id'] ?>','<?= $numbe ?>','sub<?= $n_id ?>','<?= $key2['id'] ?>')"> <?= $key2['text'] ?>
							</td>
						</tr>
						<?php
					}
					//Проверяемое задание
					if ($key['type'] == 5)
					{
						?>
						<tr>
							<td>
								<textarea style="width:100%" rows="3" class="form-control" id="sub<?= $n_id ?>" name="true_q[<?= $key['id'] ?>][0]" onChange="postAjax2('<?= $key['id'] ?>','sub<?= $n_id ?>','5')"></textarea>
							</td>
						</tr>
						<?php
					}
					//Числовое значение в диапазоне
					if ($type == 6)
					{
						?>
						<tr>
							<td align="center">Введите число (дробные числа вводятся через <b>точку</b>):</td>
						</tr>
						<tr>
							<td align="center">
								<input type="text" id="sub<?= $n_id ?>" name="true_q[<?= $key['id'] ?>][0]" style="width:206px;height: 30px;font-size: 14px;text-align: center;margin: 5px 10px;" onChange="postAjax2('<?= $key['id'] ?>','sub<?= $n_id ?>','3')">
							</td>
						</tr>
						<?php
					}
					$n_id++;
					$numbe++;
				}
				?>
				</table>
				<div class="btn-group" style="margin:20px auto;">
					<div style="width:206px;" class="btn btn-warning" onClick="skipQuest(<?= $nom ?>)">
						<span class="glyphicon glyphicon-time"></span> Отложить вопрос
					</div>
					<div style="width:206px" class="btn btn-success" onClick="getQuest(<?= $nom ?>)">
						<span class="glyphicon glyphicon-ok"></span> Ответ готов
					</div>
				</div>
				<div class="warning" style="margin:0px auto;">
					<div style="width:390px;margin:10px 0 5px 0;" class="btn btn-sm btn-default" onClick="func_corr_form(<?= $i ?>)">
						Я считаю вопрос некорректным
					</div>
					<div class="reason">
						<div class="btn-group">
							<div style="width:130px;margin:0 0 10px 0;" class="btn btn-sm btn-default" onClick="func_quest_corr(<?= $i ?>,<?= $key['id'] ?>,1)">
								Мы не проходили
							</div>
							<div style="width:130px;margin:0 0 10px 0;" class="btn btn-sm btn-warning" onClick="func_quest_corr(<?= $i ?>,<?= $key['id'] ?>,2)">
								Ошибка в задании
							</div>
							<div style="width:130px;margin:0 0 10px 0;" class="btn btn-sm btn-info" onClick="func_quest_corr(<?= $i ?>,<?= $key['id'] ?>,3)">
								Мне он не нравится
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			$i++;
		}
		
		$i = 1;
		$mass_quest = "";
		foreach ($quests as $key)
		{
			$mass_quest=$mass_quest.$i.",";
			$i++;
		}
		$mass_quest=substr($mass_quest, 0, -1);
		$all = $i-1;
		?>
		<script type="text/javascript" language="javascript">
			var arr = [<?= $mass_quest ?>]
			var curr_index = 0;
			var all = <?= $all ?>;
			var compl = 0;
			var ocher = [];

			function getQuest(nomer)
			{
				$('#block'+arr[curr_index]).fadeOut("fast");
				curr_index=curr_index+1
				var temp=arr[curr_index]-1
				$('.quest').eq(temp).css({"display":"none"})
				$('.quest').eq(temp).fadeIn("slow");
				compl++;
				progress=(compl/all)*100;
				progress=Math.round(progress);
				$('.bar').css({"width": progress+"%"})
				if (ocher.indexOf(nomer)>=0) {timer(0)}
				if (progress==100)
				{
					$('div').fadeOut(1000);
					$('#root3').fadeIn(1000,function(){document.testForm.submit();});
				}
			}

			function skipQuest(nomer)
			{
				arr.push(nomer)
				if (ocher.indexOf(nomer)<0)
				{
					ocher.push(nomer);
					timer(1)
				}
				var temp=nomer-1
				$('.quest').eq(temp).css({"display":"none"})
				$('.quest').eq(temp).css({"background":"#fcdd76"});
				curr_index=curr_index+1
				var temp=arr[curr_index]-1
				$('.quest').eq(temp).fadeIn("slow");
			}

			var second_num=0;

			function timer(oper)
			{
				if (oper) {second_num++} else {second_num--}
				if (second_num<0) {second_num=0}
				if (second_num==0) 
				{
					$('.stek').css({display:'none'});
				}
				if (second_num==1)
				{
					$('.stek').fadeIn();	
				}

				$("#second_num").animate({top: "50px", opacity: 0.0}, 100)
				.animate({top: "-50px"}, 200, function(){$(this).html(second_num);})
				.animate({top: "0px", opacity: 1}, 100)
				.animate({top: "0px"} , 200);
			}
		</script>
		</center>
	</body>
</html>