<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

// favorites
global $APPLICATION;

$arResult['action'] = NULL;
if ($_GET['id']){
	
	// if not auth
	if (!$USER->IsAuthorized()) {
		
		$arElements = array();
		if (isset($_COOKIE["favorites"])){
			$arElements = explode(",", $_COOKIE["favorites"]);
			$arElements = array_diff($arElements, array(''));
		}
		
		if(!in_array($_GET['id'], $arElements))	{
			$arElements[] = $_GET['id'];
			$arResult['action'] = 1;
		} else {
			$key = array_search($_GET['id'], $arElements);
			unset($arElements[$key]);
			$arResult['action'] = 2;
		}
		$arResult['favorites'] = implode(',',$arElements);

	} else {

		$idUser = $USER->GetID();
		$rsUser = CUser::GetByID($idUser);
		$arUser = $rsUser->Fetch();
		$arElements = $arUser['UF_FAVORITES'];

		if (!in_array($_GET['id'], $arElements)){
			$arElements[] = $_GET['id'];
			$arResult['action'] = 1;
		} else {
			$key = array_search($_GET['id'], $arElements);
			unset($arElements[$key]);
			$arResult['action'] = 2;
		}

		$USER->Update($idUser, Array("UF_FAVORITES" => $arElements ));
	}
}

echo json_encode($arResult);

?>