<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<ul class="sidebar-menu">
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li class="sidebar-menu__li"><a href="<?=$arItem["LINK"]?>" class="sidebar-menu__link sidebar-menu__link_current"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li class="sidebar-menu__li"><a href="<?=$arItem["LINK"]?>" class="sidebar-menu__link"><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	
<?endforeach?>
</ul>
<?endif?>