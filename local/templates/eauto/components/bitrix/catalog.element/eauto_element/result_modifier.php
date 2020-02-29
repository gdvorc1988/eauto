<?php
if(count($arParams['PRICE_CODE']) > 1 && $arResult['ITEM_PRICES'][0]['PRICE_TYPE_ID']!= 1)
{
    $basePrice = CPrice::GetBasePrice($arResult['ID']);
    $arResult['PRICE']['BASE'] = $basePrice['PRICE'];
    unset($basePrice);
}
