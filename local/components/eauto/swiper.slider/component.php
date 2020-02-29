<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (!isset($arParams['TYPE_SID']) or empty($arParams['TYPE_SID']))
	$arParams['TYPE_SID'] = 'MAIN';

$arFilter = array(
	'TYPE_SID' => $arParams['TYPE_SID'],
	'ACTIVE' => 'Y'
);


$rsBanners = \CAdvBanner::GetList($by, $order, $arFilter,$is_filtered, 'N');

$arResult['ITEMS'] = array();
if ($rsBanners){
	while($arBanner = $rsBanners->Fetch()){
		if ($arBanner['IMAGE_ID'] > 0){
			$arBanner['PICTURE'] = CFile::GetPath($arBanner["IMAGE_ID"]);
			$arResult['ITEMS'][] = $arBanner;
		}		
	}
}


$this->IncludeComponentTemplate();
?>