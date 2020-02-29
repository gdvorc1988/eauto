<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("sale");


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

$arResult['ITEMS'] = array();
while ($arProps = $db_props->Fetch()){

	$arResult['ITEMS'][$arProps['ID']] = $arProps;

	if ($arProps["TYPE"]=="SELECT" or
			$arProps["TYPE"]=="MULTISELECT" or 
			$arProps["TYPE"]=="RADIO"){

		$db_vars = CSaleOrderPropsVariant::GetList(
												($by="SORT"),
												($order="ASC"),
												Array("ORDER_PROPS_ID"=>$arProps["ID"])
											);
		while ($vars = $db_vars->Fetch()){
			$arResult['ITEMS'][$arProps['ID']]['VARIANTS'][] = $vars;
		}

	} elseif ($arProps["TYPE"]=="LOCATION"){
		$db_vars = CSaleLocation::GetList(
								Array("SORT"=>"ASC", "COUNTRY_NAME_LANG"=>"ASC", "CITY_NAME_LANG"=>"ASC"),
								array(),
								LANGUAGE_ID
							);
			 while ($vars = $db_vars->Fetch()){
				$arResult['ITEMS'][$arProps['ID']]['VARIANTS'][] = $vars;
			 }
	}

}

$this->IncludeComponentTemplate();
?>