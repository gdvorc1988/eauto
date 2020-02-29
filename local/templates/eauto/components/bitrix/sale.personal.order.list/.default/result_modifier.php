<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if ($arResult['ORDERS']){
	foreach ($arResult['ORDERS'] as $key => $order){
		$arStatus = CSaleStatus::GetByID( $order['ORDER']['STATUS_ID'] );
		$arResult['ORDERS'][$key]['ORDER']['FORMATED_STATUS'] = $arStatus['NAME'];
	}
}
?>