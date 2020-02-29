<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

$arResult['status'] = false;
$err = 0;

// captcha

if (isset($_REQUEST['token']) && isset($_REQUEST['action'])) {
    $captcha_token = $_REQUEST['token'];
    $captcha_action = $_REQUEST['action'];
} else {
    die('Капча работает некорректно. Обратитесь к администратору!');
}
 
$url = 'https://www.google.com/recaptcha/api/siteverify';
$params = [
    'secret' => '6LcOd90UAAAAAK3d-_newK_Col1UUDUg5ugPHha_',
    'response' => $captcha_token
];
 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
$response = curl_exec($ch);
if(!empty($response)) $decoded_response = json_decode($response);
 
$success = $decoded_response && $decoded_response->success && $decoded_response->action == $captcha_action && $decoded_response->score > 0.5;
    
if (!$success) {
	//echo json_encode($decoded_response);
	exit;
}

// end captcha


global $USER;
if ($USER->IsAuthorized()){
	$err++;
	$arResult['msg'][] = 'Вы уже авторизованы в системе';
}

if (isset($_REQUEST['user_name']) && !empty($_REQUEST['user_name'])){

	$arName = explode(" ", $_REQUEST['user_name']);
	
	// name
	if (isset($arName[0]))
		$userName = $arName[0];

	// last name
	if (isset($arName[1]))
		$userLastname = $arName[1];
	
} else {
	$err++;
	$arResult['msg'][] = 'Вы не указали Ваше имя';
}

if (isset($_REQUEST['email']) && !empty($_REQUEST['email']) && filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)){
	$userEmail = $_REQUEST['email'];
} else {
	$err++;
	$arResult['msg'][] = 'Вы не указали ваш Email';
}

if (isset($_REQUEST['password']) && !empty($_REQUEST['password'])){
	$userPassword = $_REQUEST['password'];
} else {
	$err++;
	$arResult['msg'][] = 'Вы не указали пароль';
}


if ($err == 0){

	if (!is_object($USER))
		$USER = new CUser;
	
	// disable check standart captcha
	COption::SetOptionString("main","captcha_registration","N");

	// register user
	$arRegResult = $USER->Register($userEmail, $userName, $userLastname, $userPassword, $userPassword, $userEmail);

	COption::SetOptionString("main","captcha_registration","Y");


	// if register true
	if (isset($arRegResult['TYPE']) && $arRegResult['TYPE'] == 'OK'){
		
		// auth user
		$USER ->Authorize($arRegResult['ID']);
		$arResult['status'] = true;

	} else {
		// if login error
		$arResult['status'] = false;
		if (isset($arRegResult['MESSAGE']))
			$arResult['msg'][] = $arRegResult['MESSAGE'];
	}
}


echo json_encode($arResult);
?>