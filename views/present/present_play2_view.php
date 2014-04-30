<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">

		<title>ВОС.<?= $present_name ?></title>

		<link rel="shortcut icon" href="<?= base_url() ?>images/favi.png" type="image/x-icon">

		<meta name="description" content="<?= $present_name ?>">
		<meta name="author" content="Кудрявцев Александр">

		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<link rel="stylesheet" href="<?= base_url() ?>css/reveal/reveal.min.css">
		<link rel="stylesheet" href="<?= base_url() ?>css/reveal/theme/simple.css" id="theme">

		<!-- For syntax highlighting -->
		<link rel="stylesheet" href="http://www.tinymce.com/presentation/lib/css/zenburn.css">

		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
	</head>

	<body>

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

		<div class="reveal default center">

			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">

			<?php
			foreach($present_slides as $key) 
			{
				?>
				<section class="slide">
					<?php
					if (count($subslides[$key['id']]) > 0)
					{
						?>
						<section>
							<?= $key['content'] ?>
							<a href="http://www.tinymce.com/presentation/index.html#" class="image navigate-down">
								<img src="<?= base_url(); ?>images/arrow.png" width="120" style="border: 0; background: none; box-shadow: none;">
							</a>
						</section>
						<?php
						foreach($subslides[$key['id']] as $key2)
						{
							?>
							<section>
								<?= $key2['content'] ?>	
							</section>
							<?php
						}
					}
					else
					{
						?>
						<?= $key['content'] ?>
						<?php
					}
      				?>
    			</section>
    			<?php
			}
			?>

		</div>
		<div class="progress" style="display: block;"><span style="width: 758.8888888888889px;"></span></div><aside class="controls" style="display: block;"><div class="navigate-left enabled"></div><div class="navigate-right enabled"></div><div class="navigate-up"></div><div class="navigate-down"></div></aside><div class="state-background"></div><div class="pause-overlay"></div></div>

		<script src="<?= base_url() ?>js/reveal/head.min.js"></script>
		<script src="<?= base_url() ?>js/reveal/reveal.min.js"></script>

		<script>

			// Full list of configuration options available here:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,

				theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
				transition: Reveal.getQueryHash().transition || 'default', // default/cube/page/concave/zoom/linear/fade/none

				// Optional libraries used to extend on reveal.js
				dependencies: [
					{ src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
					{ src: 'plugin/markdown/showdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
					{ src: 'plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } }
				]
			});

		</script>
		<script type="text/javascript" src="<?= base_url() ?>js/reveal/highlight.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/reveal/notes.js"></script>


		<div class="share-reveal" style="position: absolute; top: 14px; left: 50%; margin-left: -70px; z-index: 20;">
			<a href="<?= base_url() ?>present" style="color: #fff; font-family: Helvetica; padding: 4px 8px; border: 2px solid #fff; text-decoration: none; font-size: 12px; margin-right: 15px; position: relative; top: 6px;">Список презентаций</a>
		</div>	

</body></html>