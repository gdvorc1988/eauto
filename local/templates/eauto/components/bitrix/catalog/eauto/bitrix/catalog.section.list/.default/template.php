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
<div class="products-grid">
<?if (isset($arResult['SECTIONS']) && count($arResult['SECTIONS']) > 0){?>
	<?foreach ($arResult['SECTIONS'] as $arSection){?>
		<div class="product-item product-item_5">
			<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="sc-item-box">
				<?if (isset($arSection['PICTURE']) && is_array($arSection['PICTURE'])){?>
					<img
						class="product-item__img"
						src="<?=$arSection["PICTURE"]["SRC"]?>"
						title="<?=$arSection["NAME"]?>" />
				<?} else {?>
					<img
						class="product-item__img"
						src="<?=SITE_TEMPLATE_PATH?>/img/no-photo.jpg"
						alt="no-photo"
						title="Фото временно отсутствует" />
				<?}?>
			</a>
			<a class="product-item__title" href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
		</div>
	<?}?>
<?}?>
</div>