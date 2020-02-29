<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");


CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");

// config in init.php
$arPriceParam = getCurrentPrice();
$CATALOG_IB_ID = 8;

$arResult = array('status' => false);

global $USER;
$err = 0;
$arBasket = array();

$arParam['GROUP'] = [];

// amount
$QUANTITY = 1;
if (isset($_REQUEST['QUANTITY']) && is_numeric($_REQUEST['QUANTITY']) && $_REQUEST['QUANTITY'] > 0){
	$QUANTITY = (int)$_REQUEST['QUANTITY'];
}

// prod id check
if (isset($_REQUEST['PROD_ID']) && is_numeric($_REQUEST['PROD_ID'])){
	
	$PROD_ID = (int)$_REQUEST['PROD_ID'];
	
	// get element
	$res = CIBlockElement::getList(
						array('SORT' => 'ASC'),
						array(
							'ACTIVE' => 'Y',
							'IBLOCK_ID' => $CATALOG_IB_ID,
							'ID' => $PROD_ID
						),
						false,
						false,
						array("ID","NAME","PROPERTY_BRAND","DETAIL_PAGE_URL")
					);

	if ($element = $res->getNext()){

		$arBasket = array(
				"USER_ID" => $USER->GetID(),
				"PRODUCT_ID" => $PROD_ID,
				"QUANTITY" => $QUANTITY,
				"LID" => LANG,
				"DELAY" => "N",
				"CAN_BUY" => "Y",
				"NAME" => $element['NAME'],
				//"CALLBACK_FUNC" => "MyBasketCallback",
				"MODULE" => "my_module",
				"NOTES" => "",
				//"ORDER_CALLBACK_FUNC" => "MyBasketOrderCallback",
				"DETAIL_PAGE_URL" => $element["DETAIL_PAGE_URL"]
			);

		if($arPriceParam['CATALOG_GROUP_ID'] !== '1')
        {
            $arParam['GROUP'][] = $arPriceParam['CATALOG_GROUP_ID'];
            $arParam['GROUP'][] = 1;
        }else{
            $arParam['GROUP'][] = $arPriceParam['CATALOG_GROUP_ID'];
        }

		$dbProductPrice = CPrice::GetList(
						array(
						    'PRICE' => 'ASC'
                        ),
						array(
							"CATALOG_GROUP_ID" =>  $arParam['GROUP'],
							"PRODUCT_ID" => $PROD_ID
							),
						false,
						false,
						array()
					);
	
		if ($arPrice = $dbProductPrice->Fetch()){
			$arBasket['PRODUCT_PRICE_ID'] = $arPrice['ID'];
			$arBasket['PRICE'] = $arPrice['PRICE'];
			$arBasket['BASE_PRICE'] = $arPrice['PRICE'];
			$arBasket['CURRENCY'] = $arPrice['CURRENCY'];
		} else {
			$err++;
			$arResult['msg'][] = array("type" => false, "text" => "Не удалось получить цену для добавления в корзину.");
		}

	} else {
		$err++;
		$arResult['msg'][] = array("type" => false, "text" => "Элемент не найден.");
	}

} else {
	$err++;
	$arResult['msg'][] = array("type" => false, "text" => "Не передан ID товара");
}



if ($err == 0){
	
	// add to basket
	//$arResult['log'] = $arBasket;
	
	$addToBasked = CSaleBasket::Add($arBasket);
	//$addToBasked = Add2BasketByProductID( $PROD_ID, $QUANTITY );

	if ($addToBasked){
		
		// check count in basket
		$dbBasketItems = CSaleBasket::GetList(
										array(
											"NAME" => "ASC",
											"ID" => "ASC"
										),
										array(
											"FUSER_ID" => CSaleBasket::GetBasketUserID(),
											"LID" => SITE_ID,
											"ORDER_ID" => "NULL",
											"CAN_BUY" => "Y",
										),
										false,
										false,
										array("ID","QUANTITY")
									);

		$arResult['count'] = 0; 
		while ($arItem = $dbBasketItems->Fetch()){
			$arResult['count'] = $arResult['count'] + $arItem['QUANTITY'];
		}

		$arResult['status'] = true;
	} else {
		$ex = $APPLICATION->GetException();
		$arResult['msg'][] = array("type" => false, "text" => $ex->GetString());
	}
}

echo json_encode($arResult);

?>