<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();/** @var array $arParams */
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
<div class="catalog-section">

	<?if (isset($arResult["ITEMS"]) && count($arResult["ITEMS"]) > 0){?>
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?><br />
    <?endif;?>
    <div class="products-grid">
        <?foreach($arResult["ITEMS"] as $cell=>$arElement){?>

        <?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));
		?>

        <div class="product-item product-item_4" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
            <div class="product-item__labels">
                <?if (count($arParams['LABEL_PROP'])>0){
					foreach ($arParams['LABEL_PROP'] as $lbPropCode){
						if (isset($arElement['PROPERTIES'][$lbPropCode]['VALUE']) && !empty($arElement['PROPERTIES'][$lbPropCode]['VALUE'])){
							if ($lbPropCode == 'NEW_PRODUCT'){?>
                <div class="product-item__label badge badge_blue"><?=$arElement['PROPERTIES'][$lbPropCode]['NAME']?>
                </div>
                <?}
							if ($lbPropCode == 'DISCOUNTS'){?>
                <div class="product-item__label badge badge_red"><?=$arElement['PROPERTIES'][$lbPropCode]['NAME']?>
                </div>
                <?}
						}
					}
            }?>
            </div>
            <a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="sc-item-box">
                <?if(is_array($arElement["PREVIEW_PICTURE"])){?>
                <img class="product-item__img" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>"
                    alt="<?=$arElement["PREVIEW_PICTURE"]["ALT"]?>"
                    title="<?=$arElement["PREVIEW_PICTURE"]["TITLE"]?>" />
                <?} elseif(is_array($arElement["DETAIL_PICTURE"])){?>
                <img class="product-item__img" src="<?=$arElement["DETAIL_PICTURE"]["SRC"]?>"
                    alt="<?=$arElement["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arElement["DETAIL_PICTURE"]["TITLE"]?>" />

                <?} else {?>
                <img class="product-item__img" src="<?=SITE_TEMPLATE_PATH?>/img/no-photo.jpg" alt="no-photo"
                    title="Фото временно отсутствует" />
                <?}?>
            </a>
            <div class="product-item__body">
            <div class="product-item__head">
                <div class="product-item__articul">
                    <?=(isset($arElement['PROPERTIES']['CML2_ARTICLE']['VALUE']) ? $arElement['PROPERTIES']['CML2_ARTICLE']['VALUE']: '')?>
                </div>
                <?=($arElement['PRODUCT']['QUANTITY'] == 0 ? '' : '<div class="product-item__stock">В наличии</div>')?>
            </div>
                <a class="product-item__title" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
                <div class="product-item__bottom">
                    <div class="product-item__price-current"><?=$arElement['ITEM_PRICES'][0]['PRINT_PRICE']?></div>
                    <div class="product-item__cart js-add-to-basket" data-prod-id="<?=$arElement['ID']?>">
                        <svg class="icon-svg">
                            <use xlink:href="#icon-product-cart" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <?}?>
    </div>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <div class="pagination">
        <?=$arResult["NAV_STRING"]?>
    </div>
    <?endif;?>
	<?} else {?>
			<p>В этой категории нет товаров.</p>
	<?}?>
</div>