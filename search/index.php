<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результаты поиска");
?><div class="content">
	<div class="inner">
		<div class="catalog-page">
			<div class="page-head">
				<h2 class="page-head__title"><?$APPLICATION->ShowTitle(false)?></h2>
			</div>
			 <?$APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	".default", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "25",
		"PATH_TO_USER_PROFILE" => "",
		"RATING_TYPE" => "",
		"RESTART" => "Y",
		"SHOW_ITEM_DATE_CHANGE" => "N",
		"SHOW_ITEM_TAGS" => "N",
		"SHOW_ORDER_BY" => "N",
		"SHOW_RATING" => "",
		"SHOW_TAGS_CLOUD" => "N",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "N",
		"arrFILTER" => array(
			0 => "iblock_catalog",
		),
		"arrFILTER_iblock_catalog" => array(
			0 => "8",
		),
		"arrFILTER_iblock_news" => array(
			0 => "all",
		),
		"arrFILTER_iblock_services" => array(
			0 => "all",
		),
		"arrFILTER_main" => array(
		),
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>