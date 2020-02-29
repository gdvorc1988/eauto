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

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);
//$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';
if($arParams["SHOW_INPUT"] !== "N"):?>
<div class="header-search" id="<?echo $CONTAINER_ID?>">
	<form action="<?echo $arResult["FORM_ACTION"]?>" id="header-search-form">
		<input type="hidden" name="spell" value="1">
		<input type="text" class="input" name="q" id="<?echo $INPUT_ID?>" value="<?=htmlspecialcharsbx($_REQUEST["q"])?>" autocomplete="off">
			<div class="header-search__icon js-search-form-submit">
				<svg class="icon-svg">
					<use xlink:href="#icon-search" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
				</svg>
			</div>
	</form>
</div>
<?endif?>
<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>