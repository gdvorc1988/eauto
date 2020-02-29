<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");

IncludeTemplateLangFile(__FILE__);

global $USER;

$arResult = array();
$err = 0;
$ROBOT_USER_ID = 7; // user id for order
$arMailData = array(
			'ORDER_LIST' => ''
		);

// user id
if ($USER->GetID()){
	$USER_ID = IntVal($USER->GetID());
} else {
	$USER_ID = $ROBOT_USER_ID;
}


// select prod from basket
$arBasketItems = array();
$dbBasketItems = CSaleBasket::GetList(
									array(
										"NAME" => "ASC",
										"ID" => "ASC"
									),
									array(
										"FUSER_ID" => CSaleBasket::GetBasketUserID(),
										"LID" => SITE_ID,
										"ORDER_ID" => "NULL"
									),
									false,
									false,
									array("ID","NAME","CALLBACK_FUNC","MODULE","PRODUCT_ID","QUANTITY","DELAY","CAN_BUY","PRICE")
								);

$TOTAL_PRICE = 0;
while ($arItems = $dbBasketItems->Fetch()){
	$arBasketItems[] = $arItems;
	$TOTAL_PRICE += $arItems['QUANTITY'] * $arItems['PRICE'];
	$arMailData['ORDER_LIST'] .= $arItems['NAME'].' - '.$arItems['PRICE'].' Руб. -'.$arItems['QUANTITY'].' шт.<br>';
}

if (count($arBasketItems) == 0){
	$err++;
	$arResult['msg'][] = array("type" => false, "text" => "В корзине нет товаров!" );
}


$delType = $adress = '';

if($_REQUEST['DELIVERY_ID'] == 3)
{
    $delType = 'Доставка';
}elseif($_REQUEST['DELIVERY_ID'] == 2){

    $delType = 'Самовывоз';

}

if(!empty($_REQUEST['PROP']['ORDER_PROP_24']))
{
    $resPropByID = CSaleOrderPropsVariant::GetByValue(
        24,
        $_REQUEST['PROP']['ORDER_PROP_24']
    );
    $adress = $resPropByID['NAME'];
}else{
    $adress = $_REQUEST['PROP']['ORDER_PROP_7'];
}

// order prop check
if (isset($_REQUEST['PROP']) && !empty($_REQUEST['PROP'])){
	
	// sended user data
	$userData = $_REQUEST['PROP'];
	//parse_str($_REQUEST['PROP'], $userData);
	
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
							//"ORDER_ID" => $ORDER_ID,
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

			// check requied props
			if ($arProps['REQUIED'] == 'Y'){
				$err++;
				$arResult['msg'][] = array("type" => false, "text" => "Не заполнено поле ".$arProps["NAME"] );
			}
		}
	}

} else {
	$err++;
	$arResult['msg'][] = array("type" => false, "text" => "Не переданы поля для заказа");
}



if ($err == 0){

		// create order
		$arOrderFields = array(
					"LID" => LANG,
					"PERSON_TYPE_ID" => 1,
					"PAYED" => "N",
					"CANCELED" => "N",
					"STATUS_ID" => "N",
					"PRICE" => $TOTAL_PRICE,
					"CURRENCY" => "RUB",
					"USER_ID" => $USER_ID,
					"USER_DESCRIPTION" => (isset($_REQUEST['COMMENTS']) ? htmlspecialchars($_REQUEST['COMMENTS']) : ''),
					"COMMENTS" => '',
					"DELIVERY_ID" => (isset($_REQUEST['DELIVERY_ID']) ? (int)$_REQUEST['DELIVERY_ID'] : 0),
				);

		$ORDER_ID = CSaleOrder::Add($arOrderFields);

		if ($ORDER_ID){
			
			// add prop relation to order
			foreach ($arAddOrderProps as $pkey => $ordProp){
				$ordProp['ORDER_ID'] = $ORDER_ID;
				CSaleOrderPropsValue::Add($ordProp);
			}

		
			// add prod relation to order
			CSaleBasket::OrderBasket($ORDER_ID, CSaleBasket::GetBasketUserID(), SITE_ID);
			
			
			
			
			$cs_loc = CSaleLocation::GetByID($arParams['LOCATION_ID']);
			
			$arFields = Array(
					"ORDER_ID" => $ORDER_ID,
					"ORDER_DATE" => Date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT", SITE_ID))),
					"ORDER_USER" => $arMailData['FIO'],
					"PRICE" => $TOTAL_PRICE,
					"BCC" => COption::GetOptionString("sale", "order_email"),
					"EMAIL" => $arMailData['EMAIL'],
					"ORDER_LIST" => $arMailData['ORDER_LIST'],
					"SALE_EMAIL" => COption::GetOptionString("sale", "order_email"),
                    'PHONE' => $arMailData['PHONE'],
                    'DEL_TYPE' => ($delType ? GetMessage('DEL_TYPE').$delType : ''),
                    'ADRESS' => ($adress ? GetMessage('ADRESS').$adress :''),
                    'COMMENTS' => ($_REQUEST['COMMENTS'] ? GetMessage('COMMENTS').$_REQUEST['COMMENTS'] : ''),
                    'USE_ADD_SERIVCE' => (
                        $_REQUEST['PROP']['ORDER_PROP_22'] ?
                        GetMessage('USE_ADD_SERIVCE').($_REQUEST['PROP']['ORDER_PROP_22'] == 'Y' ? 'Да' : 'Нет' ) :
                        '')
            );

			$arResult['event'] = $arFields;
			$eventName = "SALE_NEW_ORDER";

			$event = new CEvent;
			$event->Send($eventName, SITE_ID, $arFields, "N");
			
			$arResult['url'] = '/personal/order/make/?ORDER_ID='.$ORDER_ID;
			$arResult['status'] = true;
		
		} else {
			$err++;
			$arResult['msg'][] = array(
							"type" => false,
							"text" => "Не удалось оформить заказ. Обратитесь в службу тех. поддержки сайта"
						);
		}

		
}

echo json_encode($arResult);
?>