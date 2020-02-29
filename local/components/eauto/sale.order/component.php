<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();


if (!isset($arParams['PATH_TO_BASKET']))
	$arParams['PATH_TO_BASKET'] = "/personal/cart/";

if (!isset($arParams['PERSON_TYPE_ID']))
	$arParams['PERSON_TYPE_ID'] = 1;

if (!isset($arParams['PICKUP_DELIVERY_ID']))
	$arParams['PICKUP_DELIVERY_ID'] = 2;

if (!isset($arParams['COURIER_DELIVERY_ID']))
	$arParams['COURIER_DELIVERY_ID'] = 3;

global $USER;
$arResult['USER_ID'] = NULL;
$arResult['DF'] = array();

if ($USER->IsAuthorized()){

	$arResult['USER_ID'] = $USER->GetID();

	// Get User Data
	$rsUser = CUser::GetByID( $arResult['USER_ID'] );
	if ($arUser = $rsUser->Fetch()){

		// FIO
		$arResult['DF']['FIO'] = (!empty($arUser['LAST_NAME']) ? $arUser['LAST_NAME'].' ' : '');
		$arResult['DF']['FIO'] .= (!empty($arUser['NAME']) ? $arUser['NAME'] : '');

		// EMAIL
		$arResult['DF']['EMAIL'] = (!empty($arUser['EMAIL']) ? $arUser['EMAIL'] : '');

		// PERSONAL_PHONE
		$arResult['DF']['PHONE'] = (!empty($arUser['PERSONAL_PHONE']) ? $arUser['PERSONAL_PHONE'] : '');

	}
}


$templateType = '';
if (isset($_REQUEST['ORDER_ID'])){

	// order result
	$templateType = 'order_result';
	$ORDER_ID = (int)$_REQUEST['ORDER_ID'];
	
	// get order detail
	$arOrder = CSaleOrder::GetByID( $ORDER_ID );
	
	if ($arOrder){

		$arResult["MSG"][] = "<p>Ваш заказ <b>№{$ORDER_ID}</b> от {$arOrder["DATE_INSERT"]} успешно создан!</p>";
		
		if ($arOrder['USER_ID'] == $USER->GetID()){
			$arResult["MSG"][] = "<p>Вы можете следить за выполнением своего заказа в <a href=\"{$arParams['PATH_TO_PERSONAL']}\">персональном разделе сайта</a>. Обратите внимание, что для входа в этот раздел вам необходимо будет ввести логин и пароль пользователя сайта.</p>";
		}
		
	} else {
		$arResult["MSG"][] = "<p>Заказ №{$ORDER_ID} не найден.</p>";
	}

} else {

	// get order fileds
	$templateType = 'template';
	
	// BASKET ITEMS
	$arBasketItems = array();
	$dbBasketItems = CSaleBasket::GetList(
										array(
											"NAME" => "ASC",
											"ID" => "ASC"
										),
										array(
											"FUSER_ID" => CSaleBasket::GetBasketUserID(),
											"LID" => SITE_ID,
											"ORDER_ID" => "NULL",
											"CAN_BUY" => "Y"
										),
										false,
										false,
										array("ID","CALLBACK_FUNC","MODULE","PRODUCT_ID","QUANTITY","DELAY","CAN_BUY","PRICE")
									);

	while ($arItems = $dbBasketItems->Fetch()){
		$arBasketItems[] = $arItems;
	}

	if (count($arBasketItems) == 0){
		CSaleBasket::DeleteAll( CSaleBasket::GetBasketUserID() );
		LocalRedirect( $arParams['PATH_TO_BASKET'] );
		exit();
	}

	// ORDER PROP
	$db_props = CSaleOrderProps::GetList(
								array("SORT" => "ASC"),
								array(
									"PERSON_TYPE_ID" => $arParams['PERSON_TYPE_ID'],
									"USER_PROPS" => "Y"
								),
								false,
								false,
								array()
							);

	$arResult['ORDER_PROPS'] = array();
	while ($arProps = $db_props->Fetch()){

		$arResult['ORDER_PROPS'][$arProps['ID']] = $arProps;

		if (array_key_exists($arProps['CODE'], $arResult['DF'])){
			$arResult['ORDER_PROPS'][$arProps['ID']]['DEFAULT_VALUE'] = $arResult['DF'][ $arProps['CODE'] ];
		}

		if ($arProps["TYPE"]=="SELECT" or
			$arProps["TYPE"]=="MULTISELECT" or 
			$arProps["TYPE"]=="RADIO"){

			$db_vars = CSaleOrderPropsVariant::GetList(
													($by="SORT"),
													($order="ASC"),
													Array("ORDER_PROPS_ID"=>$arProps["ID"])
												);
			while ($vars = $db_vars->Fetch()){
				$arResult['ORDER_PROPS'][$arProps['ID']]['VARIANTS'][] = $vars;
			}

		} elseif ($arProps["TYPE"]=="LOCATION"){

			$db_vars = CSaleLocation::GetList(
									Array("SORT"=>"ASC", "COUNTRY_NAME_LANG"=>"ASC", "CITY_NAME_LANG"=>"ASC"),
									array(),
									LANGUAGE_ID
								);

				 while ($vars = $db_vars->Fetch()){
					$arResult['ORDER_PROPS'][$arProps['ID']]['VARIANTS'][] = $vars;
				 }
		}

	}
	

	// DELIVERY SERVICES
	$db_dtype = CSaleDelivery::GetList(
									array(
										"SORT" => "ASC",
										"NAME" => "ASC"
									),
									array(
										"LID" => SITE_ID,
										"ACTIVE" => "Y"
									),
									false,
									false,
									array()
								);
	$arResult['DELIVERY'] = array();
	while ($ar_dtype = $db_dtype->Fetch()){
		$arResult['DELIVERY'][] = $ar_dtype;
	}
	
	
	
	//echo '<pre>'; print_r ( $arResult ); echo '</pre>';

}
$this->IncludeComponentTemplate($templateType);
?>