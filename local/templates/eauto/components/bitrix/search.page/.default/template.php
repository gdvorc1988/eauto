<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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



$arCurrentPrice = getCurrentPrice();


?>

		
		
		
<div class="search-page">
<form action="" method="get">
<?if (SITE_TYPE == 'pda'){?>
<div class="search-page__input">

<?if($arParams["USE_SUGGEST"] === "Y"){
	if(strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
	{
		$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
		$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
		$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
	}
	?>
	
	<?$APPLICATION->IncludeComponent(
		"bitrix:search.suggest.input",
		"",
		array(
			"NAME" => "q",
			"VALUE" => $arResult["REQUEST"]["~QUERY"],
			"INPUT_SIZE" => 40,
			"DROPDOWN_SIZE" => 10,
			"FILTER_MD5" => $arResult["FILTER_MD5"],
		),
		$component, array("HIDE_ICONS" => "Y")
	);?>
	
<?} else {?>
	<input type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
<?}?>

<?if($arParams["SHOW_WHERE"]){?>
	&nbsp;<select name="where">
	<option value=""><?=GetMessage("SEARCH_ALL")?></option>
	<?foreach($arResult["DROPDOWN"] as $key=>$value){?>
	<option value="<?=$key?>"<?if($arResult["REQUEST"]["WHERE"]==$key) echo " selected"?>><?=$value?></option>
	<?}?>
	</select>
<?}?>
	
	<?/*<input type="submit" value="<?=GetMessage("SEARCH_GO")?>" />*/?>
	<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />

	<div class="header-search__icon js-sform-submit">
		<svg class="icon-svg">
			<use xlink:href="#icon-search" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
	</div>
</div>
<?}?>
<?if($arParams["SHOW_WHEN"]){?>
	<script>
	var switch_search_params = function()
	{
		var sp = document.getElementById('search_params');
		var flag;
		var i;

		if(sp.style.display == 'none')
		{
			flag = false;
			sp.style.display = 'block'
		}
		else
		{
			flag = true;
			sp.style.display = 'none';
		}

		var from = document.getElementsByName('from');
		for(i = 0; i < from.length; i++)
			if(from[i].type.toLowerCase() == 'text')
				from[i].disabled = flag;

		var to = document.getElementsByName('to');
		for(i = 0; i < to.length; i++)
			if(to[i].type.toLowerCase() == 'text')
				to[i].disabled = flag;

		return false;
	}
	</script>
	<br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
	<div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
		<?$APPLICATION->IncludeComponent(
			'bitrix:main.calendar',
			'',
			array(
				'SHOW_INPUT' => 'Y',
				'INPUT_NAME' => 'from',
				'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
				'INPUT_NAME_FINISH' => 'to',
				'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
				'INPUT_ADDITIONAL_ATTR' => 'size="10"',
			),
			null,
			array('HIDE_ICONS' => 'Y')
		);?>
	</div>
<?}?>
</form><br />

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])){
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
}?>

<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false){?>
<?} elseif($arResult["ERROR_CODE"]!=0){?>
	<p>Список пуст...</p>

<?} elseif(count($arResult["SEARCH"])>0){?>
	
	<p class="sort-by-param">
	<?if($arResult["REQUEST"]["HOW"]=="d"){?>
		<a href="<?=$arResult["URL"]?>&amp;how=r<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_RANK")?></a>&nbsp;|&nbsp;<b><?=GetMessage("SEARCH_SORTED_BY_DATE")?></b>
	<?} else {?>
		<b><?=GetMessage("SEARCH_SORTED_BY_RANK")?></b>&nbsp;|&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_DATE")?></a>
	<?}?>
	</p>
	
	<?if($arParams["DISPLAY_TOP_PAGER"] != "N"){?>
		<div class="pagination">
			<?=$arResult["NAV_STRING"]?>
		</div>
	<?}?>
	

	<div class="products-grid">
	<?foreach($arResult["SEARCH"] as $arItem){
		$grab = GetIBlockElement($arItem["ITEM_ID"]);
		?>
		
		<div class="product-item product-item_5">
			<div class="product-item__labels">
				
				<?if (isset($grab['PROPERTIES']['NEW_PRODUCT']) && !empty($grab['PROPERTIES']['NEW_PRODUCT']['VALUE'])){?>
					<div class="product-item__label badge badge_blue"><?=$grab['PROPERTIES']['NEW_PRODUCT']['NAME']?></div>
				<?}
				
				if (isset($grab['PROPERTIES']['DISCOUNTS']) && !empty($grab['PROPERTIES']['DISCOUNTS']['VALUE'])){?>
					<div class="product-item__label badge badge_red"><?=$grab['PROPERTIES']['DISCOUNTS']['NAME']?></div>
				<?}?>
			</div>
			<a href="<?=$arItem["URL"]?>" class="sc-item-box">
				
				<?if ($grab['PREVIEW_PICTURE'] > 0){
					$image_prw = CFile::GetPath($grab["PREVIEW_PICTURE"]);
					?>
					<img class="product-item__img" src="<?=$image_prw?>"/>
				<?} elseif($grab["DETAIL_PICTURE"] > 0){
					$image_det = CFile::GetPath($grab["DETAIL_PICTURE"]);
					?>
						<img class="product-item__img" src="<?=$image_det?>"/>
				<?} else {?>
					<img class="product-item__img" src="<?=SITE_TEMPLATE_PATH?>/img/no-photo.jpg" alt="no-photo" title="Фото временно отсутствует" />
				<?}?>
			</a>
			<div class="product-item__body">
				<div class="product-item__head">
					<div class="product-item__articul">
						<?=(isset($grab['PROPERTIES']['CML2_ARTICLE']['VALUE']) ? $grab['PROPERTIES']['CML2_ARTICLE']['VALUE']: '')?>
					</div>
					<?=($grab['QUANTITY'] > 0 ? '' : '<div class="product-item__stock">В наличии</div>')?>
				</div>
				<a class="product-item__title" href="<?=$arItem["URL"]?>"><?=$arItem["TITLE_FORMATED"]?></a>
				<div class="product-item__bottom">
					<?if (isset($arItem['PRICE'])){?>
						<div class="product-item__price-current"><?=CurrencyFormat($arItem['PRICE'], $arItem['CURRENCY'])?></div>
					<?}?>
					<div class="product-item__cart js-add-to-basket" data-prod-id="<?=$arItem['ITEM_ID']?>">
						<svg class="icon-svg">
							<use xlink:href="#icon-product-cart" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
						</svg>
					</div>
	
				</div>
			</div>
		</div>
	
	<?}?>
	</div>
	
	<div class="pagination">
	<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
	</div>

	
	
<?} else {?>
	<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
<?}?>
</div>