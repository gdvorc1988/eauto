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
$this->setFrameMode(true);
?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]){?>
	<?=$arResult["NAV_STRING"]?><br />
<?}?>
<?if (isset($arResult['ITEMS']) && count($arResult['ITEMS']) > 0){?>
    <div class="blog-items">
        <?foreach ($arResult['ITEMS'] as $arItems){?>
            <div class="blog-item">
                <a href="<?=$arItems['DETAIL_PAGE_URL']?>" title="<?=$arItems['NAME']?>">
                <?if (isset($arItems['PREVIEW_PICTURE']) && $arItems['PREVIEW_PICTURE'] != NULL){?>
                    <img src="<?=$arItems['PREVIEW_PICTURE']['SRC'];?>" alt="<?=$arItems['PREVIEW_PICTURE']['ALT']?>" class="blog-item__img">
                <?}?>
                <div class="blog-item__body">
                    <div class="blog-item__title"><?=$arItems['NAME']?></div>
                    <div class="blog-item__date"><?=FormatDate("d F Y", MakeTimeStamp($arItems['ACTIVE_FROM']) );?></div>
                </div>
                </a>
            </div>
        <?}?>
    </div>
<?}?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]){?>
	<br /><?=$arResult["NAV_STRING"]?>
<?}?>
</div>
