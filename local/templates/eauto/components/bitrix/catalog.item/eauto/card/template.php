<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>

<?
CModule::IncludeModule("catalog");
$res = CIBlockElement::GetByID(319);
if($ar_res = $res->GetNext())
echo $ar_res['NAME']; 
?>

<div class="product-item">
    <a class="product-item__imagewrap" href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>"
        data-entity="image-wrapper">
        <img class="product-item__image" src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="">
        <?
		if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
		{
			?>
        <div class="product-item__discount <?=$discountPositionClass?>" id="<?=$itemIds['DSC_PERC']?>"
            <?=($price['PERCENT'] > 0 ? '' : 'style="display: none;"')?>>
            <span><?=-$price['PERCENT']?>%</span>
        </div>
        <?
		}

		if ($item['LABEL'])
		{
			?>
        <div class="product-item-label-text <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>">
            <?
				if (!empty($item['LABEL_ARRAY_VALUE']))
				{
					foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value)
					{
						?>
            <div<?=(!isset($item['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '')?>>
                <span title="<?=$value?>"><?=$value?></span>
        </div>
        <?
					}
				}
				?>
</div>
<?
		}
		?>


</a>

</span>

<?
	if (!empty($item['DISPLAY_PROPERTIES']))
	{
		?>
		<?
						foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty)
						{
							if (($displayProperty['NAME'] == "Артикул")) {
							?>
		<div class="product-item__articul">
			<?= $displayProperty['DISPLAY_VALUE'] ?>
		</div>

		<?		}
	} ?>


<?
	}
	?>
<div class="product-item__title">
    <? if ($itemHasDetailUrl): ?>



    <div>
        <? endif; ?>
        <?=$productTitle?>
        <? if ($itemHasDetailUrl): ?>
    </div>
    <? endif; ?>
</div>
<?
	if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
	{
		foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
		{
			switch ($blockName)
			{
				case 'price': ?>
<div class="product-item__price-container" data-entity="price-block">

    <span class="product-item__price-current" id="<?=$itemIds['PRICE']?>">
        <?
							if (!empty($price))
							{
								if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers)
								{
									echo Loc::getMessage(
										'CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE',
										array(
											'#PRICE#' => $price['PRINT_RATIO_PRICE'],
											'#VALUE#' => $measureRatio,
											'#UNIT#' => $minOffer['ITEM_MEASURE']['TITLE']
										)
									);
								}
								else
								{
									echo $price['PRINT_RATIO_PRICE'];
								}
							}
							?>
    </span>
    <?
						if ($arParams['SHOW_OLD_PRICE'] === 'Y')
						{
							?>
    <span class="product-item__price-old" id="<?=$itemIds['PRICE_OLD']?>">
        <?=$price['PRINT_RATIO_BASE_PRICE']?>
    </span>&nbsp;
    <?
						}
						?>
</div>
<?
					break;

			}
		}
	}

	if (
		$arParams['DISPLAY_COMPARE']
		&& (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
	)
	{
		?>
<div class="product-item-compare-container">
    <div class="product-item-compare">
        <div class="checkbox">
            <label id="<?=$itemIds['COMPARE_LINK']?>">
                <input type="checkbox" data-entity="compare-checkbox">
                <span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
            </label>
        </div>
    </div>
</div>
<?
	}
	?>
</div>