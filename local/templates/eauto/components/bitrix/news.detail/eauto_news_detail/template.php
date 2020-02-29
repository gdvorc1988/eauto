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



<div class="article-page">
	
	<div class="article-content">

	<div class="article-meta">
		<div class="article-meta__item"><a href="/news/" class="link">Новости</a></div>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
			<div class="article-meta__item">
				<?=FormatDate("d F Y", MakeTimeStamp($arResult['DISPLAY_ACTIVE_FROM']) );?>
			</div>
		<?endif;?>		
	</div>
	
	<h1 class="article-content__title"><?=$arResult['NAME']?></h1>
	
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img
			class="detail_picture"
			border="0"
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
	<?endif?>
	<div class="article-content__text">
		<?echo $arResult["DETAIL_TEXT"];?>
	</div>
	</div>
</div>