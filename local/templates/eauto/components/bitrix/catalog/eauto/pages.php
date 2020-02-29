<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->SetPageProperty("keywords", "автозвук, автосигнализации");
$APPLICATION->SetPageProperty("title", "Exclusive Auto - автозвук, автоэлектроника, охранные системы в Сыктывкаре. ЭксАвто Сыктывкар");
$APPLICATION->SetTitle("Автозвук, автоэлектроника, охранные системы в Сыктывкаре");

?><div class="inner__text">
	<div class="block-space"></div>
	<div class="content-sidebar">
	<?
	 $APPLICATION->IncludeComponent(
							"eauto:service.pages",
							"",
							Array(
								"IBLOCK_ID" => 9,
								"ELEMENT_CODE" => $arResult['VARIABLES']['SECTION_CODE_PATH'],
								"SEF_FOLDER" => "/"
							)
						);?>
	</div>
</div>