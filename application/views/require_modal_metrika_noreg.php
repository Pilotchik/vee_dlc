<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap.min.js"></script>
			<script> 
				$(window).load(function(){<?php if ($error!="") { ?> $('#myModal').modal('show'); <?php }?>});
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