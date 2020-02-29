<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (!isset($arParams['IBLOCK_ID']) or empty($arParams['IBLOCK_ID'])) return;
if (!isset($arParams['ELEMENT_CODE']) or empty($arParams['ELEMENT_CODE'])) return;


if (\Bitrix\Main\Loader::includeModule('iblock')) {

   $res = CIBlockElement::getList(
							array('SORT' => 'ASC'),
							array(
								'ACTIVE' => 'Y',
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								//'CODE' => $arParams['ELEMENT_CODE']
							),
							false,
							array(),
							array('ID','NAME','DETAIL_PAGE_URL','CODE','PROPERTY_SHOW_IN_MENU','DETAIL_TEXT')
						);

	$arResult['MENU'] = array();
	while ($row = $res->getNext()) {

		$isActive = "N";

		if ( $row['CODE'] == $arParams['ELEMENT_CODE'] ){
			$arResult['PAGE'] = $row;
			$isActive = "Y";
		}

		if ($row['PROPERTY_SHOW_IN_MENU_VALUE'] != NULL)
			$arResult['MENU'][$row['ID']] = array(
						'TITLE' => $row['NAME'],
						'LINK' => $row['DETAIL_PAGE_URL'],
						'IS_ACTIVE' => $isActive
					);

	}
	
	if (!isset($arResult['PAGE'])){
		LocalRedirect("/404.php", "404 Not Found");
		die;
	}

}



$this->IncludeComponentTemplate();
?>