<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)){?>
    <ul class="catalog-drop">
    <?
    $previousLevel = 0;
foreach($arResult as $arItem){?>

    <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel){?>
        <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
    <?}?>

    <?if ($arItem["IS_PARENT"]){?>

    <?if ($arItem["DEPTH_LEVEL"] == 1){?>
    <li><a href="<?=$arItem["LINK"]?>" class="catalog-drop-link <?=($arItem["SELECTED"] ? 'root-item-selected' : 'root-item' )?>">
        <div class="catalog-drop-link__icon">
            <svg class="icon-svg">
                <use xlink:href="#icon-menu" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
            </svg>
        </div>
        <span><?=$arItem["TEXT"]?></span>
    </a>
    <ul class="menu-uem-<?=str_replace('/', '', $arItem["LINK"])?>">
    <div class="catalog-drop__arrow"></div>
    <?} else {?>
    <li class="sub-item<?=($arItem["SELECTED"] ? ' item-selected' : '')?>"><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?></a>
    <ul class="menu-item-<?=str_replace(['/','%2C', '%20'], '', $arItem["LINK"])?>">
    <?}?>

    <?} else {?>

        <?if ($arItem["PERMISSION"] > "D"){?>
            <?if ($arItem["DEPTH_LEVEL"] == 1){?>
                <li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem[" SELECTED"]){?>root-item-selected
					<?} else {?>root-item
					<?}?>"><?=$arItem["TEXT"]?></a></li>
            <?} else {?>
                <li class="sub-item<?=($arItem["SELECTED"] ? ' item-selected' : '')?>"><a
                            href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            <?}?>
        <?} else {?>
            <?if ($arItem["DEPTH_LEVEL"] == 1){?>
                <li><a href="" class="<?=($arItem["SELECTED"] ? 'root-item-selected' : 'root-item')?>"
                       title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a>
                </li>
            <?} else {?>
                <li class="sub-item"><a href="" class="denied"
                                        title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a>
                </li>
            <?}?>
        <?}?>

    <?}?>

    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?}?>

    <?if ($previousLevel > 1){//close last item tags?>
        <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
    <?}?>

    </ul>

<?}?>