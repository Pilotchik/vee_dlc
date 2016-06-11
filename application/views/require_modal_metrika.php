<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap.min.js"></script>
			<link rel="icon" href="/favicon.ico" type="image/x-icon" />
			<script> 
				$(window).load(function()
					{
						<?php if ($error!="") 
							{ ?> 
								$('#myModal').modal('show'); <?php 
							}?>
					});
				
				function view_modal()	{$('#ModalMessage').modal('show');}

				function send_message_feedback()
				{
					postAjax_mail();
					$('#ModalMessage').modal('hide');
				}

				function postAjax_mail()
				{
					var msg = $("#mail").val();
					var uri = $("#uri_div").val();
					var to = $("#my_select :selected").val();
					$.post ('<?php echo base_url();?>main/add_message',{message:msg,uri_str:uri,to:to},
					function(data,status)
					{
						if( status != 'success')
						{
        					alert('В процессе отправки произошла ошибка :(');
    					}
					})
				}

			</script>
			<?php if ($error!="") 
			{ 
				?>
				<!-- Модальное окно с ошибкой -->
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 					<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    					<h3 id="myModalLabel">Информационное сообщение</h3>
  					</div>
  					<div class="modal-body">
  						<p><?php echo $error;?></p>
  					</div>
  					<div class="modal-footer">
    					<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  					</div>
				</div>
				<!--Конец модального окна -->
				<?php 
			}
			?>
			<!-- окно для вызова сообщения -->
			<!--
			<div class="btn btn-primary btn-block btn-primary" type="button" style="vertical-align:middle;height:30;width:250;position:fixed;left: 77.2%;bottom: 0px;z-index:1111;cursor:pointer;box-shadow:5px;border-radius:10px 0 0 0; " onClick="view_modal();">
    			Связаться с преподавателем
			</div>
			-->
			<div id="ModalMessage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;margin-left: -350px;">
 			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    			<h3 id="myModalLabel">Связь с преподавателем</h3>
  			</div>
  			<div class="modal-body">
  				<p>Напишите Ваш вопрос, отзыв, пожелание или предложение:</p>
  					<textarea id="mail" name="q_value" style="min-width:100%" rows="4"></textarea>
					<input type="hidden" id="uri_div" value="<?php print_r($this->uri->uri_string);?>">
				<p>Кому: </p>
					<select name="sel_prepod" id="my_select">
						<option value=0>Всем</option>
						<option value="212">Королёв Владимир Владимирович</option>
						<option value="1060">Кудрявцев Александр Николаевич</option>
						<?php
						//$prepods = prepods_list();
						/*
						foreach($prepods as $key)
						{
							echo "<option value=".$key['id'].">".$key['lastname']." ".$key['firstname']."</option>";
						}
						*/
						?>
					</select>
  			</div>
  			<div class="modal-footer">
    			<button class="btn btn-success" style="width:100px" onClick="send_message_feedback()">Отправить</button>
    			<button class="btn" style="width:100px" data-dismiss="modal" aria-hidden="true">Закрыть</button>
  			</div>
		</div>

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