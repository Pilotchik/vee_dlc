<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="<?= base_url() ?>images/favi.png" type="image/x-icon">
		<title><?= (isset($title) ? $title : "ВОС");  ?></title>
		<script type="text/javascript" src="//vk.com/js/api/openapi.js?111"></script>
		<script type="text/javascript">
		  VK.init({apiId: 2849330, onlyWidgets: true});
		</script>
		<script type="text/javascript" src="<?= base_url() ?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/sorttable.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/hltable.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/ui.datepicker.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<link href="<?= base_url() ?>css/bootstrap3.min.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>css/styles.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?= base_url() ?>js/bootstrap3.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/bootstrap-typeahead.js"></script>
	</head>
	<body>
		<script> 
			$(window).load(function()
			{
				<?php if ($error!="") 
				{ ?> 
					$('#myModal').modal('show'); <?php 
				}?>
			});
				
		</script>
		<?php 
		if ($error != "") 
		{ 
			?>
				<div class="modal fade" id="myModalError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  				<div class="modal-dialog">
		    			<div class="modal-content">
		      				<div class="modal-header">
		        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        				<h4 class="modal-title">Информационное сообщение</h4>
		      				</div>
		      				<div class="modal-body">
		        				<p style="text-align: center;text-indent: 0px;"><?= $error ?></p>
		      				</div>
		      				<div class="modal-footer">
		        				<button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
		      				</div>
		    			</div><!-- /.modal-content -->
	  				</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
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