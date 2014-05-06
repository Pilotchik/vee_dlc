<table style="margin:10px auto;margin-top:20px;">
	<tr>
		<td align="center" valign="middle">
			<small style="color:white">LMS. Версия 3.1. НИУ ИТМО ФСПО. 2008 - 2014 </small>
		</td>
		<td width="40px" align="center">
			<!--LiveInternet counter-->
			<script type="text/javascript">
			<!--
			document.write("<a href='http://www.liveinternet.ru/click' "+
			"target=_blank><img src='//counter.yadro.ru/hit?t45.3;r"+
			escape(document.referrer)+((typeof(screen)=="undefined")?"":
			";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
			screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
			";"+Math.random()+
			"' alt='' title='LiveInternet' "+
			"border='0' width='15' height='15'><\/a>")
			//-->
			</script><!--/LiveInternet-->
		</td>
	</tr>
</table>
<div style="width:300px;margin:0 auto;display: flex;margin-bottom:10px;">
	<a data-toggle="modal" data-target="#creditsModal" style="color:white;margin:0 auto;cursor:pointer;text-decoration:none;">Авторы и разработчики <b class="caret" style="border-top:white 4px solid;"></b></a>
	<a href="<?= base_url() ?>tutor" style="color:white;margin:0 auto;cursor:pointer;text-decoration:none;">Помощь <b class="caret" style="border-top:white 4px solid;"></b></a>
</div>

<script>
	$(function() {
    $('body').tooltip({
        selector: "[rel=tooltip]", // можете использовать любой селектор
        placement: "top" 
    });
	});
</script>

<div class="modal fade" id="creditsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Авторы и разработчики</h4>
			</div>
			<div class="modal-body">
				<table width="90%" style="margin:0 auto;" cellpadding="5">
					<tr>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Модуль анкетирования">Афанасьев Никита</span>
						</td>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Аналитический модуль, тесты, Front-End, идейный вдохновитель">Жиглова Екатерина</span> <span class="glyphicon glyphicon-star" rel="tooltip" data-toggle="tooltip" data-placement="top" title="За многолетнюю работу"></span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Идейный вдохновитель">Королёв Владимир</span>
						</td>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="HTML-вёрстка"><a href="http://vk.com/pilotchik">Кудрявцев Александр</a></span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Модули компетентностного анализа обучения">Малышев Кирилл</span>
						</td>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Техническое обеспечение">Янсон Константин</span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="API и Front-End">Слабкий Андрей</span>
						</td>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Модуль модерируемого тестирования">Шарабанов Даниил</span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Каталогизация и рекомендации справочных материалов">Никитин Герман</span>
						</td>
						<td align="center">
							<span rel="tooltip" data-toggle="tooltip" data-placement="top" title="Рейтинг пользователей">Волхонов Денис</span>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">
							<a href="https://github.com/Pilotchik/vee_dlc" target="blank">Мы на GitHub</a>
						</td>
					</tr>
				</table>

			</div>
			<div class="modal-footer">
				<div class="btn">
					<div id="vk_like"></div>
				</div>
				<script type="text/javascript">
					VK.Widgets.Like("vk_like", {type: "mini", height: 24});
				</script>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Спасибо!</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>