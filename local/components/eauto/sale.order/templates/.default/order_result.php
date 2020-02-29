<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?if (isset($arResult["MSG"])){
	foreach ($arResult["MSG"] as $msg){
		echo $msg;
	}
}?>