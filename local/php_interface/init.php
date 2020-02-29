<?php

// define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/init-log.txt");
// AddMessage2Log("Вызов функции", "main");

// switch site template type
if (isset ($_GET['site-type'])){

	switch ($_GET['site-type']) {
		case 'pda':
			setcookie('site_type', 'pda', time()+3600*24*30,'/');
			define('SITE_TYPE','pda');
		break;
		default:
			setcookie('site_type', 'original', time()+3600*24*30,'/');
			define('SITE_TYPE','original');
	}

} else {

	$checkType='';
	if (isset($_COOKIE['site_type']))
		$checkType = $_COOKIE['site_type'];

	switch ($checkType) {
		case 'pda':
			define('SITE_TYPE','pda');
		break;
		default:
			define('SITE_TYPE','original');
	}

}


//define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/init-log.txt"); // путь к файлу-лога
// AddMessage2Log("Code: ".$arFields["CODE"], "main"); // запись в файл лога

// element & section code before update
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "updElement"); // перед обновлением элемента
AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", "updElement"); // перед обновлением раздела

function updElement(&$arFields){

	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'import'){
		unset($arFields['CODE']);
	} elseif ($arFields["CODE"] == "" && !empty($_REQUEST["bxajaxid"])){
		$arParams = array(
						"max_len" => "60", // обрезаем символьный код до 60 символов
						"change_case" => "L", // приводим к нижнему регистру
						"replace_space" => "-", // меняем пробелы на тире
						"replace_other" => "-", // меняем плохие символы на тире
						"delete_repeat_replace" => "true", // удаляем повторяющиеся тире
						"use_google" => "false", // отключаем использование google
					);
		$arFields["CODE"] = Cutil::translit($arFields["NAME"], "ru", $arParams);
	}
}

// price id for customers
function getCurrentPrice(){

	// price id for users
	$param = array(
				'default' => array(
						'PRICE_CODE' => 'BASE',
						'CATALOG_GROUP_ID' => 1,
						'USER_GROUP_ID' => ''
					),
				'opt2' => array(
						'PRICE_CODE' => 'opt2',
						'CATALOG_GROUP_ID' => 2,						
						'USER_GROUP_ID' => 10
					),
				'opt3' => array(
						'PRICE_CODE' => 'opt3',
						'CATALOG_GROUP_ID' => 3,
						'USER_GROUP_ID' => 11
					),
				'stp3' => array(
						'PRICE_CODE' => 'stp3',
						'CATALOG_GROUP_ID' => 4,
						'USER_GROUP_ID' => 12
					)
				);

	global $USER;

	if (in_array($param['opt2']['USER_GROUP_ID'], $USER->GetUserGroupArray())){
		return $param['opt2'];
	} elseif (in_array($param['opt3']['USER_GROUP_ID'], $USER->GetUserGroupArray())){
		return $param['opt3'];
	} elseif (in_array($param['stp3']['USER_GROUP_ID'], $USER->GetUserGroupArray())){
		return $param['stp3'];
	} else {
		return $param['default'];
	}
}

AddEventHandler("sale", "OnOrderNewSendEmail", "ModifyOrderSaleMails");
function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)
{

    return false;

}

?>