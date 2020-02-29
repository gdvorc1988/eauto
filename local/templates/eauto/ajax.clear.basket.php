<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");

$arResult['deleted_count'] = 0;

// delete single prod from basket
if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'single' &&
	isset($_REQUEST['basket_item_id']) && is_numeric($_REQUEST['basket_item_id'])){
	
	$res = CSaleBasket::GetList(array(),
									array(
										'FUSER_ID' => CSaleBasket::GetBasketUserID(),
										'LID' => SITE_ID,
										'ORDER_ID' => 'null',
										'DELAY' => 'N',
										'CAN_BUY' => 'Y',
										'ID' => (int)$_REQUEST['basket_item_id']
									)
								);
	if ($row = $res->fetch()){
		if ( CSaleBasket::Delete($row['ID']) ){
			$arResult['deleted_count']++;
		}
	}
}

// clear all prod
if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'all'){

	$res = CSaleBasket::GetList(array(),
									array(
										'FUSER_ID' => CSaleBasket::GetBasketUserID(),
										'LID' => SITE_ID,
										'ORDER_ID' => 'null',
										'DELAY' => 'N',
										'CAN_BUY' => 'Y'
									)
								);

	while ($row = $res->fetch()){
		if ( CSaleBasket::Delete($row['ID']) ){
			$arResult['deleted_count']++;
		}
	}
}

echo json_encode($arResult);
?>