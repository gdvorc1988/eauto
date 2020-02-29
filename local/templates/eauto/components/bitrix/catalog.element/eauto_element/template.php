<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */


?>
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb","eauto",Array(
			"START_FROM" => "0", 
			"PATH" => "", 
			"SITE_ID" => "s1" 
		)
);?>

<div class="product-content">
	<div class="product-body block">
		<div class="product-gallery">
		<?if (isset($arResult['DETAIL_PICTURE']['SRC'])){?>
			<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">
		<?} else {?>

		<?}?>
		</div>
		<div>
			<h1><?=$arResult['NAME']?></h1>
			<br>
			<div>
			<?=$arResult['DETAIL_TEXT']?>
			</div>
		</div>
	</div>
	<div class="product-info">
		<div class="product-info__labels">
			<?
					// labels
					if (count($arResult['ORIGINAL_PARAMETERS']['LABEL_PROP'])>0){
						foreach ($arResult['ORIGINAL_PARAMETERS']['LABEL_PROP'] as $lbPropCode){
							if (isset($arResult['PROPERTIES'][$lbPropCode]['VALUE']) && !empty($arResult['PROPERTIES'][$lbPropCode]['VALUE'])){
								if ($lbPropCode == 'NEW_PRODUCT'){?>
									<div class="product-info__label  ">
										<div class="badge badge_blue"><?=$arResult['PROPERTIES'][$lbPropCode]['NAME']?></div>
									</div>
								<?}
								if ($lbPropCode == 'DISCOUNTS'){?>
									<div class="product-info__label">
										<div class="badge badge_red"><?=$arResult['PROPERTIES'][$lbPropCode]['NAME']?></div>
									</div>
								<?}
							}
						}
			}?>
		</div>
		<div class="block">
			<div class="block-inner">

				<?if (isset($arResult['PRODUCT']['AVAILABLE']) && $arResult['PRODUCT']['AVAILABLE'] == "Y"){?>
					<div class="product-info__price">
					<?if (isset($arResult['ITEM_PRICES'][0]['PRINT_PRICE'])){?>
						<?=$arResult['ITEM_PRICES'][0]['PRINT_PRICE']?>
					<?}?>
					</div>

				<?}?>

				<div class="product-info__delivery <?=($arResult['PRODUCT']['QUANTITY'] == 0 ? '' : 'product-info__delivery_stock')?>"><?=($arResult['PRODUCT']['QUANTITY'] == 0 ? 'Под заказ' : 'В наличии')?></div>
                <?php if(current($arParams['PRICE_CODE']) !== 'BASE' && isset($arResult['PRICE']['BASE'])): ?>

                    <div class="base_price">
                        <?= Loc::getMessage('BASE_PRICE_PHR') ?> <?= $arResult['PRICE']['BASE'] ?> руб
                    </div>

                <?php endif; ?>
				<div class="product-meta">
					<?if (isset($arResult['ORIGINAL_PARAMETERS']['PROPERTY_CODE']) &&
							count($arResult['ORIGINAL_PARAMETERS']['PROPERTY_CODE']) > 0){
						foreach ($arResult['ORIGINAL_PARAMETERS']['PROPERTY_CODE'] as $code){
							if (array_key_exists($code, $arResult['PROPERTIES'])){
								$arProp = $arResult['PROPERTIES'][$code];

								if (empty($arProp['VALUE']) && empty($arProp['VALUE_ENUM'])) continue;

								if ($arProp['PROPERTY_TYPE'] == 'S'){?>
									<div class="product-meta__row">
										<span class="product-meta__col"><?=$arProp['NAME']?>:</span><span class="product-meta__col"><?=($arProp['VALUE'])?></span>
									</div>
								<?} else {?>
									<div class="product-meta__row">
									<span class="product-meta__col"><?=$arProp['NAME']?>:</span><span class="product-meta__col"><?=($arProp['VALUE_ENUM'])?></span>
									</div>
								<?}?>
								
							<?}
						}
					}
					?>
				</div>
			</div>
			<div class="block-separator"></div>
			<div class="block-inner">
				<div class="product-actions">
					<?if (isset($arResult['PRODUCT']['AVAILABLE']) && $arResult['PRODUCT']['AVAILABLE'] == "Y"){?>

							<div class="input-number">
								<input type="number" value="1" class="input-number__input js-prod-count-inp" id="prod<?=$arResult['ID']?>-quantity" min="1" <?/*max="<?=$arResult['PRODUCT']['QUANTITY']?>"*/?>>
								<div class="input-number__add js-amount-plus"></div>
								<div class="input-number__sub js-amount-minus"></div>
							</div>
							<div class="btn btn_red product-actions__btn js-add-to-basket" data-prod-id="<?=$arResult['ID']?>"><?=$arResult['ORIGINAL_PARAMETERS']['MESS_BTN_ADD_TO_BASKET']?></div>

						

					<?} else {?>
						<div class="product-not-available">Товара нет в наличии</div>
					<?}?>
				</div>
				<?if (isset($arResult['PRODUCT']['AVAILABLE']) && $arResult['PRODUCT']['AVAILABLE'] == "Y"){?>
				<div class="product-actions__one-click js-order-one-click" data-prod-id="<?=$arResult['ID']?>">
					<span class="product-actions__one-click-icon">
						<svg class="icon-svg"><use xlink:href="#icon-cart" xmlns:xlink="http://www.w3.org/1999/xlink"></use></svg>
					</span>
					<span>Купить в один клик</span> 
				</div>
				<?}?>
				<?
				// Favorites
				global $APPLICATION;

					if(!$USER->IsAuthorized()){
						$arFavorites = unserialize($APPLICATION->get_cookie("favorites"));
					} else {
						$idUser = $USER->GetID();
						$rsUser = CUser::GetByID($idUser);
						$arUser = $rsUser->Fetch();
						$arFavorites = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
					}
				?>
				<a href="javascript:void(0);" class="favor<?=(in_array($arResult['ID'],$arFavorites) ? ' active' : '')?>" data-item="<?=$arResult['ID']?>">
					<svg class="icon-svg">
						<use xlink:href="#icon-heart-white" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
					</svg>
					В избранное
				</a>
				
				<div class="button-action-msg"></div>
			</div>

		</div>

	</div>
</div>

	<?if ($arParams['USE_COMMENTS'] === 'Y'){?>
<div class="product-comments block">
	<?
				
							
	$componentCommentsParams = array(
								'ELEMENT_ID' => $arResult['ID'],
								'ELEMENT_CODE' => '',
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
								'URL_TO_COMMENT' => '',
								'WIDTH' => '',
								'COMMENTS_COUNT' => '5',
								'BLOG_USE' => $arParams['BLOG_USE'],
								'FB_USE' => $arParams['FB_USE'],
								'FB_APP_ID' => $arParams['FB_APP_ID'],
								'VK_USE' => $arParams['VK_USE'],
								'VK_API_ID' => $arParams['VK_API_ID'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'BLOG_TITLE' => '',
								'BLOG_URL' => $arParams['BLOG_URL'],
								'PATH_TO_SMILE' => '',
								'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
								'AJAX_POST' => 'Y',
								'SHOW_SPAM' => 'Y',
								'SHOW_RATING' => 'N',
								'FB_TITLE' => '',
								'FB_USER_ADMIN_ID' => '',
								'FB_COLORSCHEME' => 'light',
								'FB_ORDER_BY' => 'reverse_time',
								'VK_TITLE' => '',
								'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
							);
							if(isset($arParams["USER_CONSENT"]))
								$componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
							if(isset($arParams["USER_CONSENT_ID"]))
								$componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
							if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
								$componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
							if(isset($arParams["USER_CONSENT_IS_LOADED"]))
								$componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
							$APPLICATION->IncludeComponent(
								'bitrix:catalog.comments',
								'',
								$componentCommentsParams,
								$component,
								array('HIDE_ICONS' => 'Y')
							);

	?>
</div>
	<?}?>
	


<div class="page-head">
	<h2 class="page-head__title">Похожие товары</h2>
</div>
<?
global $arrFilter;
$arrFilter = Array(
		//"PROPERTY_NEW_PRODUCT_VALUE" => 'Да'
		"IBLOCK_SECTION_ID" => $arResult['IBLOCK_SECTION_ID'],
		"!=ID" => $arResult['ID']
	);
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"eauto",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/cart/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPARE_PATH" => "",
		"COMPATIBLE_MODE" => "N",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_COMPARE" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "8",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_TYPE_ID" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array("NEW_PRODUCT","DISCOUNTS"),
		"LABEL_PROP_MOBILE" => array(),
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(0=>"COLOR_REF",1=>"SIZES_SHOES",2=>"SIZES_CLOTHES",),
		"OFFERS_FIELD_CODE" => array(0=>"",1=>"",),
		"OFFERS_PROPERTY_CODE" => array(0=>"COLOR_REF",1=>"SIZES_SHOES",2=>"SIZES_CLOTHES",3=>"",),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "desc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(0=>"COLOR_REF",1=>"SIZES_SHOES",2=>"SIZES_CLOTHES",),
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "round",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "5",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("BASE"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => "",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(0=>"NEWPRODUCT",1=>"",),
		"PROPERTY_CODE_MOBILE" => array(0=>"ARTNUMBER",),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("",""),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "site",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);?>
