<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

$arResult['status'] = false;
$err = 0;

global $USER;
if ($USER->IsAuthorized()){

	// for logout from system
	if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == true){
		$arResult['status'] = true;
		$USER->Logout();
	} else {
		$err++;
		$arResult['msg'][] = 'Вы уже авторизованы в системе';
	}

} else {

	if (isset($_REQUEST['login']) && !empty($_REQUEST['login'])){
		$userLogin = $_REQUEST['login'];
	} else {
		$err++;
		$arResult['msg'][] = 'Не указан логин';
	}
	
	if (isset($_REQUEST['password']) && !empty($_REQUEST['password'])){
		$userPassword = $_REQUEST['password'];
	} else {
		$err++;
		$arResult['msg'][] = 'Не указан пароль';
	}
	
	
	if ($err == 0){
	
		if (!is_object($USER))
			$USER = new CUser;
	
		// auth by login & password
		$arAuthResult = $USER->Login($userLogin, $userPassword, "Y");
		$APPLICATION->arAuthResult = $arAuthResult;
	
		// if login true
		if ($arAuthResult === true){
			$arResult['status'] = true;
		} else {
			// if login error
			$arResult['status'] = false;
			if (isset($arAuthResult['MESSAGE']))
				$arResult['msg'][] = $arAuthResult['MESSAGE'];
		}
	
	}

}

echo json_encode($arResult);
?>