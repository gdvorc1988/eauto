<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//$APPLICATION->AddHeadString('<link href="'.$APPLICATION->GetCurDir().'"style.css";  type="text/css" rel="stylesheet" />',true)
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs($APPLICATION->GetCurDir() . "/js/util.js");
Asset::getInstance()->addJs($APPLICATION->GetCurDir() . "/js/main.js");

?>
<input type="checkbox" id="hmt" class="mobile-menu__ticker">
<label for="hmt" class="catalog-drop-link">
    <div class="catalog-drop-link__icon">
        <svg class="icon-svg">
            <use xlink:href="#icon-menu" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
        </svg>
    </div>
    <span>Каталог товаров</span>
</label>

<div class="mobile-menu__box">
<?
//echo '<pre>'; print_r ( $arResult ); echo '</pre>';
if (!empty($arResult)){?>
	<ul class="cd-accordion cd-accordion--animated margin-top-lg margin-bottom-lg">
	<?
		$previousLevel = 0;
		$i=0;
		foreach($arResult as $arItem){
			$i++;
			?>
		
		<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel){?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
		<?}?>
		
		<?if ($arItem["IS_PARENT"]){?>
			<?if ($arItem["DEPTH_LEVEL"] == 1){?>
				<li class="cd-accordion__item cd-accordion__item--has-children">
				<input class="cd-accordion__input" type="checkbox" name="group-<?=$i?>" id="group-<?=$i?>">
				<label class="cd-accordion__label cd-accordion__label--icon-folder" for="group-<?=$i?>"><span><?=$arItem['TEXT']?></span></label>
				<ul class="cd-accordion__sub cd-accordion__sub--l<?=$arItem['DEPTH_LEVEL']?>">
			<?} else {?>
				<li class="cd-accordion__item cd-accordion__item--has-children">
					<input class="cd-accordion__input" type="checkbox" name="sub-group-<?=$i?>" id="sub-group-<?=$i?>">
					<label class="cd-accordion__label cd-accordion__label--icon-folder" for="sub-group-<?=$i?>"><span><?=$arItem['TEXT']?></span></label>
					<ul class="cd-accordion__sub cd-accordion__sub--l<?=$arItem['DEPTH_LEVEL']?>">
			<?}?>
		<?} else {?>
			<?if ($arItem["DEPTH_LEVEL"] == 1){?>
				<li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="<?=$arItem["LINK"]?>"><span><?=$arItem['TEXT']?></span></a></li>
			<?} else {?>
				<li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="<?=$arItem["LINK"]?>"><span><?=$arItem['TEXT']?></span></a></li>
			<?}?>
		<?}?>
		<?
			$previousLevel = $arItem["DEPTH_LEVEL"];
		}?>
		<? //close last item tags
		if ($previousLevel > 1){?>
			<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
		<?}?>
	</ul>
<?}?>
</div>