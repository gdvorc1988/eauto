<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;


if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
	else
		$arFilter = array();

	if (count($arFilter) > 0)
	{
		$obCache = new CPHPCache();
		if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
		{
			$arCurSection = $obCache->GetVars();
		}
		elseif ($obCache->StartDataCache())
		{
			$arCurSection = array();
			if (Loader::includeModule("iblock"))
			{
				$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID","NAME"));

				if(defined("BX_COMP_MANAGED_CACHE"))
				{
					global $CACHE_MANAGER;
					$CACHE_MANAGER->StartTagCache("/iblock/catalog");

					if ($arCurSection = $dbRes->Fetch())
						$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

					$CACHE_MANAGER->EndTagCache();
				}
				else
				{
					if(!$arCurSection = $dbRes->Fetch())
						$arCurSection = array();
				}
			}
			$obCache->EndDataCache($arCurSection);
		}
	}
	else
	{
		$arCurSection = array();
	}

}

// show elements - true, false - show subsections list
$showElements = true;
if (isset($arCurSection['ID'])){
		
	$APPLICATION->SetTitle($arCurSection['NAME']);

		// select subsections count 
		$intCount = CIBlockSection::GetCount(
											array(
												'IBLOCK_ID' => $arParams["IBLOCK_ID"],
												'SECTION_ID' => $arCurSection['ID']
											)
										);
		if ($intCount > 0){
			$showElements = false;
		}

} else {

	// if current section not found & is not root section
	if ($arResult['VARIABLES']['SECTION_CODE_PATH'] == 'katalog'){
		$showElements = false;
	} else {
		LocalRedirect("/404.php", "404 Not Found");
		die;
	}

}

if ($showElements == true){
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_elements.php");
} else {
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_list.php");
}

?>