<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");


CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");


// config in init.php
$arPriceParam = getCurrentPrice();
$CATALOG_IB_ID = 8; // catalog iblock id
$ROBOT_USER_ID = 7; // user id for order

$arResult = array('status' => false);

global $USER;
$err = 0;
$arBasket = array();
$arMailData = array(
			'ORDER_LIST' => ''
		);

// user id
if ($USER->GetID())
	$USER_ID = IntVal($USER->GetID());
else
	$USER_ID = $ROBOT_USER_ID;


 // uniq basket user id
$FUSER_ID = CSaleBasket::GetBasketUserID();
$FUSER_ID = $FUSER_ID.rand(100,999);


// prod id check
if (isset($_REQUEST['PROD_ID']) && is_numeric($_REQUEST['PROD_ID'])){
	
	$PROD_ID = (int)$_REQUEST['PROD_ID'];

    $arFilterElements = array(
        "ID",
        "NAME",
        "PROPERTY_BRAND",
        "DETAIL_PAGE_URL",
        'CATALOG_GROUP_'.$arCurrentPrice['CATALOG_GROUP_ID']
    );

    if($arCurrentPrice['CATALOG_GROUP_ID']!= 1)
        $arFilterElements[] = 'CATALOG_GROUP_1';
	
	// get product items
	$res = CIBlockElement::getList(
						array('SORT' => 'ASC'),
						array(
							'ACTIVE' => 'Y',
							'IBLOCK_ID' => $CATALOG_IB_ID,
							'ID' => $PROD_ID
						),
						false,
						false,
                        $arFilterElements
					);

	if ($element = $res->getNext()){

        if($element['CATALOG_PRICE_'.$arCurrentPrice['CATALOG_GROUP_ID']])
            $price = $element['CATALOG_PRICE_'.$arCurrentPrice['CATALOG_GROUP_ID']];
        else
            $price = $element['CATALOG_PRICE_1'];

        $arMailData['ORDER_LIST'] .= $element['NAME'].' - '.$price.' руб. - 1 шт.<br>';

        $arMailData['PRICE'] = $price;

		$arBasket = array(
				"USER_ID" => $USER->GetID(),
				"PRODUCT_ID" => $PROD_ID,
				"QUANTITY" => 1,
				"LID" => LANG,
				"DELAY" => "N",
				"CAN_BUY" => "Y",
				"NAME" => $element['NAME'],
				//"CALLBACK_FUNC" => "MyBasketCallback",
				"MODULE" => "my_module",
				"NOTES" => "",
				//"ORDER_CALLBACK_FUNC" => "MyBasketOrderCallback",
				"DETAIL_PAGE_URL" => $element["DETAIL_PAGE_URL"],
				"FUSER_ID" => $FUSER_ID,
                'PRICE' => $price
			);
			

		$dbProductPrice = CPrice::GetList(
									array(),
									array(
										"CATALOG_GROUP_ID" => [$arPriceParam['CATALOG_GROUP_ID'], 1],
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

// amount
$QUANTITY = 1;
if (isset($_REQUEST['QUANTITY']) && is_numeric($_REQUEST['QUANTITY']) && $_REQUEST['QUANTITY'] > 0){
	$QUANTITY = (int)$_REQUEST['QUANTITY'];
}

// order prop check
if (isset($_REQUEST['PROP']) && !empty($_REQUEST['PROP'])){
	
	// sended user data
	$userData = array();
	parse_str($_REQUEST['PROP'], $userData);
	
	// get order props
	$db_props = CSaleOrderProps::GetList(
								array("SORT" => "ASC"),
								array(
									"PERSON_TYPE_ID" => 1,
									"USER_PROPS" => "Y"
								),
								false,
								false,
								array()
							);

	$arAddOrderProps = array();
	while ($arProps = $db_props->Fetch()){
		
		// if not empty value
		if (isset($userData[ "ORDER_PROP_".$arProps["ID"] ]) && !empty( $userData[ "ORDER_PROP_".$arProps["ID"] ] ) ){
			
			$arAddOrderProps[] = array(
							"ORDER_PROPS_ID" => $arProps['ID'],
							"NAME" => $arProps['NAME'],
							"CODE" => $arProps['CODE'],
							"VALUE" => $userData[ "ORDER_PROP_".$arProps["ID"] ]
						);
			
			// email for event
			if ($arProps['CODE'] == 'EMAIL'){
				$arMailData['EMAIL'] = $userData[ "ORDER_PROP_".$arProps["ID"] ];
			}
			
			// FIO for event
			if ($arProps['CODE'] == 'FIO'){
				$arMailData['FIO'] = $userData[ "ORDER_PROP_".$arProps["ID"] ];
			}

            if ($arProps['CODE'] == 'PHONE'){
                $arMailData['PHONE'] = $userData[ "ORDER_PROP_".$arProps["ID"] ];
            }

		} else {

			if ($arProps['CODE'] == 'ZIP'){
				$arAddOrderProps[] = array(
							"ORDER_PROPS_ID" => $arProps['ID'],
							"NAME" => $arProps['NAME'],
							"CODE" => $arProps['CODE'],
							"VALUE" => '11111'
						);
			} elseif ($arProps['CODE'] == 'LOCATION') {
				$arAddOrderProps[] = array(
							"ORDER_PROPS_ID" => $arProps['ID'],
							"NAME" => $arProps['NAME'],
							"CODE" => $arProps['CODE'],
							"VALUE" => 220
						);
			} elseif ($arProps['CODE'] == 'ADDRESS') {
				$arAddOrderProps[] = array(
							"ORDER_PROPS_ID" => $arProps['ID'],
							"NAME" => $arProps['NAME'],
							"CODE" => $arProps['CODE'],
							"VALUE" => '-'
						);
			} else {

				// check requied props
				if ($arProps['REQUIED'] == 'Y'){
					$err++;
					$arResult['msg'][] = array("type" => false, "text" => "Не заполнено поле ".$arProps["NAME"] );
				}

			}
			
		}
	}

} else {
	$err++;
	$arResult['msg'][] = array("type" => false, "text" => "Не переданы поля для заказа");
}




if ($err == 0){
	
	// clear old products in basket
	//CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());

	
	$addToBasked = CSaleBasket::Add($arBasket);
	//$addToBasked = Add2BasketByProductID( $PROD_ID, $QUANTITY );

	if ($addToBasked){
		
		
		// create order
		$arOrderFields = array(
					"LID" => LANG,
					"PERSON_TYPE_ID" => 1,
					"PAYED" => "N",
					"CANCELED" => "N",
					"STATUS_ID" => "N",
					"PRICE" => $arBasket['PRICE'],
					"CURRENCY" => $arBasket['CURRENCY'],
					"USER_ID" => $USER_ID,
					"USER_DESCRIPTION" => '',
					"COMMENTS" => 'Заказ в один клик',
				);

		$ORDER_ID = CSaleOrder::Add($arOrderFields);

		if ($ORDER_ID){
			
			// add prop relation to order
			foreach ($arAddOrderProps as $pkey => $ordProp){
				$ordProp['ORDER_ID'] = $ORDER_ID;
				CSaleOrderPropsValue::Add($ordProp);
			}


			// add prod relation to order
			CSaleBasket::OrderBasket($ORDER_ID, $FUSER_ID, SITE_ID);
			
			
			$arFields = Array(
					"ORDER_ID" => $ORDER_ID,
					"ORDER_DATE" => Date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT", SITE_ID))),
					"ORDER_USER" => $arMailData['FIO'],
					"PRICE" => $arMailData['PRICE'],
					"BCC" => COption::GetOptionString("sale", "order_email"),
					"EMAIL" => $arMailData['EMAIL'],
					"ORDER_LIST" => $arMailData['ORDER_LIST'],
					"SALE_EMAIL" => COption::GetOptionString("sale", "order_email"),
                    "PHONE" => $arMailData['PHONE']
				);
			
			$arResult['event'] = $arFields;
			$eventName = "SALE_NEW_ORDER";

			$event = new CEvent;
			$event->Send($eventName, SITE_ID, $arFields, "N");
			
			
			$arResult['status'] = true;
			$arResult['ORDER_ID'] = $ORDER_ID;
			
		} else {
			$err++;
			$arResult['msg'][] = array(
							"type" => false,
							"text" => "Не удалось оформить заказ. Обратитесь в службу тех. поддержки сайта"
						);
		}

		
		
		
	} else {
		$ex = $APPLICATION->GetException();
		$arResult['msg'][] = array("type" => false, "text" => $ex->GetString());
	}
}

echo json_encode($arResult);

?>