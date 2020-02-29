<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)){?>
<div class="p-mob-menu">
<?foreach($arResult as $arItem){
	if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) continue;?>
	<?if($arItem["SELECTED"]){?>
		<div class="p-mob-menu__item">
			<a href="<?=$arItem["LINK"]?>" class="p-mob-menu__active"><?=$arItem["TEXT"]?></a>
		</div>
	<?} else {?>
		<div class="p-mob-menu__item">
			<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
		</div>
	<?}?>
<?}?>
</div>
<?}?>