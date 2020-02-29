<?
//include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
define("HIDE_SIDEBAR", true);



$APPLICATION->SetTitle("Страница не найдена");?>
<div class="content">
<div class="inner">
	<div class="not-found">
		<div class="not-found__404">404</div>
		<div class="not-found__title">Страница не надена</div>
		<div class="">Вернитесь на <a href="<?=SITE_DIR?>" class="link">главную</a> или уточните адрес.</div>
	</div>
</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>