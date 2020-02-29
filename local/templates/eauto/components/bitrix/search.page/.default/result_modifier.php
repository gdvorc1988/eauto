<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");


// funct from init.php
$arPriceParam = getCurrentPrice();

foreach($arResult["SEARCH"] as $key => $arItem){
	
	if ($arItem['MODULE_ID'] == 'iblock' && $arItem['ITEM_ID'] > 0){

		$dbProductPrice = CPrice::GetList(
									array(),
									array(
										"CATALOG_GROUP_ID" => $arPriceParam['CATALOG_GROUP_ID'],
										"PRODUCT_ID" => $arItem['ITEM_ID']
									),
									false,
									false,
									array("PRICE","CURRENCY")
								);
	
			if ($arPrice = $dbProductPrice->Fetch()){
				$arResult["SEARCH"][$key]['PRICE'] = $arPrice['PRICE'];
				$arResult["SEARCH"][$key]['CURRENCY'] = $arPrice['CURRENCY'];
			}
	}

}
?>