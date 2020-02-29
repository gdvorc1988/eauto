<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// check device type
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$mobile = strpos($_SERVER['HTTP_USER_AGENT'],"Mobile");
$symb = strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
$operam = strpos($_SERVER['HTTP_USER_AGENT'],"Opera M");
$htc = strpos($_SERVER['HTTP_USER_AGENT'],"HTC_");
$fennec = strpos($_SERVER['HTTP_USER_AGENT'],"Fennec/");
$winphone = strpos($_SERVER['HTTP_USER_AGENT'],"WindowsPhone");
$wp7 = strpos($_SERVER['HTTP_USER_AGENT'],"WP7");
$wp8 = strpos($_SERVER['HTTP_USER_AGENT'],"WP8");

$VISITOR_ID = $APPLICATION->get_cookie("MOBILE_VISITOR_MB");

if (($ipad || $iphone || $android || $palmpre || $ipod || $berry || $mobile || $symb || $operam || $htc || $fennec || $winphone || $wp7 || $wp8) &&
		empty($VISITOR_ID)) {
		// redirect to PDA-version
		$APPLICATION->set_cookie("MOBILE_VISITOR_MB", "MOBILE", time()+60*60);
		$page = $APPLICATION->GetCurPageParam("site-type=pda", array("site-type")); 
		LocalRedirect($page);
		exit();
}

IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);


// FAVORITES GOODS
if (!$USER->IsAuthorized()){
    $favorites = NULL;
	if (isset($_COOKIE["favorites"])){
		$favorites = explode(",", $_COOKIE["favorites"]);
		$favorites = array_diff($favorites, array(''));
	}
} else {
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
	$favorites = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
}

if (!is_bool($favorites)) {
	$TOTAL_FAVORITES = count($favorites);
} else {
	$TOTAL_FAVORITES = 0;
}

?>

<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">

<head>
    <title>
        <?$APPLICATION->ShowTitle()?>
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap&subset=cyrillic"
        rel="stylesheet">
    <? $APPLICATION->ShowHead(); ?>
	<script src="https://www.google.com/recaptcha/api.js?render=6LcOd90UAAAAAPzdpDR-wi50zXzU4XVkEZRQj_t4"></script>
</head>

<body>

	<div class="overlay"></div>
    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>
    <div class="wrapper">
        <div class="content">
            <header class="header">
                <div class="header-top">
                    <div class="header-top__inner inner">
                        <div class="header-contacts">
                            <a href="https://vk.com/exclusiveautosyk" class="header-contacts__item header-contacts__icon round-icon round-icon_small">
                                <svg class="icon-svg">
                                    <use xlink:href="#icon-vk" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                </svg>
                            </a>
                            <div class="header-contacts__item">
                                +7 (8212) 25-00-85
							</div>
							<div class="header-contacts__item">
                                sm@eauto.su
							</div>
                        </div>
                        <ul class="header-top-menu">
							<li class="header-top-menu__li"><a href="/brands/" class="header-top-menu__link">Бренды</a></li>
							<li class="header-top-menu__li"><a href="/about/" class="header-top-menu__link">О нас</a></li>
							<li class="header-top-menu__li"><a href="/contacts/" class="header-top-menu__link">Контакты</a></li>
							<li class="header-top-menu__li"><a href="/payment/" class="header-top-menu__link">Оплата</a></li>
							<li class="header-top-menu__li"><a href="/dostavka/" class="header-top-menu__link">Доставка</a></li>
							<li class="header-top-menu__li"><a href="/service/" class="header-top-menu__link">Услуги</a></li>
                            <li class="header-top-menu__li"><a href="/punkti-vidachi/" class="header-top-menu__link">Пункты выдачи</a></li>
                            <li class="header-top-menu__li"><a href="/news/" class="header-top-menu__link">Новости</a></li>
                        </ul>
                    </div>
                </div>
                <div class="header-bottom">
                    <div class="header-bottom__inner inner">
                        <a class="header-logo" href="<?=SITE_DIR?>">
                            <svg class="icon-svg">
                                <use xlink:href="#icon-logo" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                            </svg>
                        </a>

<?
// Mobile version
if (SITE_TYPE == 'pda'){?>
&nbsp;
<?
// Show only for NOT Authorized users
global $USER;
if ($USER->IsAuthorized()){?>
	<div class="header-bottom-controls">
		<div class="header-bottom-controls__item">
			<a id="want" href="/personal/wishlist/">
				<span class="fv-count<?=($TOTAL_FAVORITES > 0 ? ' fv-count-active' : '')?>"><?=$TOTAL_FAVORITES?></span>
				<svg class="icon-svg">
					<use xlink:href="#icon-heart" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
				</svg>
			</a>
		</div>
		<div class="header-bottom-controls__item js-header-sign-b">
			<a href="/personal/orders/">
				<svg class="icon-svg">
					<use xlink:href="#icon-user" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
				</svg>
			</a>
		</div>
<?} else {?>
	<div class="header-bottom-controls">
		<div class="header-bottom-controls__item">
			<a id="want" href="/personal/wishlist/">
				<span class="fv-count<?=($TOTAL_FAVORITES > 0 ? ' fv-count-active' : '')?>"><?=$TOTAL_FAVORITES?></span>
				<svg class="icon-svg">
					<use xlink:href="#icon-heart" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
				</svg>
			</a>
		</div>
		<div class="header-bottom-controls__item js-header-sign-b">
			<svg class="icon-svg">
				<use xlink:href="#icon-user" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
			</svg>
		</div>
<?}?>
<?

// --- Desktop version ---

} else {?>
<?
	// top mobile menu
	$APPLICATION->IncludeComponent(
						"bitrix:menu", 
						"top_multilevel", 
						array(
							"COMPONENT_TEMPLATE" => "top_multilevel",
							"ROOT_MENU_TYPE" => "top",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_TIME" => "3600",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "3",
							"CHILD_MENU_TYPE" => "sub_sections",
							"USE_EXT" => "Y",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N",
							"COMPOSITE_FRAME_MODE" => "A",
							"COMPOSITE_FRAME_TYPE" => "AUTO"
						),
						false
					);?>
<?

// config in init.php
$arCurrentPrice = getCurrentPrice();


	// Search form
	$APPLICATION->IncludeComponent(
		"bitrix:search.title", 
		"search", 
		array(
			"NUM_CATEGORIES" => "1",
			"TOP_COUNT" => "5",
			"CHECK_DATES" => "N",
			"SHOW_OTHERS" => "Y",
			"PAGE" => SITE_DIR."search/",
			"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
			"CATEGORY_0" => array(
				0 => "iblock_catalog",
			),
			"CATEGORY_0_iblock_catalog" => array(
				0 => "8",
			),
			"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
			"SHOW_INPUT" => "Y",
			"INPUT_ID" => "title-search-input",
			"CONTAINER_ID" => "search",
			"COMPONENT_TEMPLATE" => "search",
			"ORDER" => "date",
			"USE_LANGUAGE_GUESS" => "Y",
			"TEMPLATE_THEME" => "blue",
			"PRICE_CODE" => array( $arCurrentPrice['PRICE_CODE'] ),
			"PRICE_VAT_INCLUDE" => "Y",
			"PREVIEW_TRUNCATE_LEN" => "",
			"SHOW_PREVIEW" => "Y",
			"CONVERT_CURRENCY" => "N"
		),
		false
	);?>
<?
// Show only for NOT Authorized users
global $USER;
if ($USER->IsAuthorized()){

	// get user data
	$rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();
	
	$sayHello = '';
	if (isset($arUser['NAME'])){
		$sayHello .= $arUser['NAME'];
	} else {
		$sayHello .= $arUser['LOGIN'];
	}
	?>
	
	<div class="header-bottom-controls">
		<div class="header-bottom-controls__item js-header-sign-b">
			<a href="/personal/orders/">
				<svg class="icon-svg">
					<use xlink:href="#icon-user" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
				</svg>
			</a>
			<div class="header-profile">
				<div class="header-profile__logout"><a href="javascript:void(0);" class="js-logout">Выйти</a></div>
				<a href="/personal/orders/" class="header-profile__title"><?=$sayHello?></a>
			</div>
		</div>
		<div class="header-bottom-controls__item">
			<a id="want" href="/personal/wishlist/">
				<span class="fv-count<?=($TOTAL_FAVORITES > 0 ? ' fv-count-active' : '')?>"><?=$TOTAL_FAVORITES?></span>
				<svg class="icon-svg">
					<use xlink:href="#icon-heart" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
				</svg>
			</a>
		</div>
<?} else {?>
	<div class="header-bottom-controls">
		<div class="header-bottom-controls__item js-header-sign-b">
			<svg class="icon-svg">
				<use xlink:href="#icon-user" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
			</svg>
		</div>
		<div class="header-bottom-controls__item">
			<a id="want" href="/personal/wishlist/">
				<span class="fv-count<?=($TOTAL_FAVORITES > 0 ? ' fv-count-active' : '')?>"><?=$TOTAL_FAVORITES?></span>
				<svg class="icon-svg">
					<use xlink:href="#icon-heart" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
				</svg>
			</a>
		</div>
<?}?>
<?}?>
                           
                            <div class="header-bottom-controls__item header-bottom-controls__item_basket">
                                <?
						$basketCount = 0;
						if (CModule::IncludeModule("sale")){
							
							// check count in basket
							$dbBasketItems = CSaleBasket::GetList(
															array(
																"NAME" => "ASC",
																"ID" => "ASC"
															),
															array(
																"FUSER_ID" => CSaleBasket::GetBasketUserID(),
																"LID" => SITE_ID,
																"ORDER_ID" => "NULL",
																"CAN_BUY" => "Y",
															),
															false,
															false,
															array("ID","QUANTITY")
														);

								$basketCount = 0;
								while ($arItem = $dbBasketItems->Fetch()){
									$basketCount = $basketCount + $arItem['QUANTITY'];
								}	
						}
					?>
                                <a href="/personal/cart/">
                                    <div class="basket-counter<?=($basketCount > 0 ? " basket-c-view" : "")?> js-basket-count">
                                        <?=$basketCount?></div>
                                    <svg class="icon-svg">
                                        <use xlink:href="#icon-cart" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                    </svg>
                                </a>
                            </div>
							
							<?if (SITE_TYPE == 'pda'){?>
<?
// top mobile menu
$APPLICATION->IncludeComponent(
					"bitrix:menu", 
					"top_mobile_menu", 
					array(
						"COMPONENT_TEMPLATE" => "top_mobile_menu",
						"ROOT_MENU_TYPE" => "top_mobile",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_TIME" => "3600",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MAX_LEVEL" => "3",
						"CHILD_MENU_TYPE" => "sub_sections",
						"USE_EXT" => "Y",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N",
						"COMPOSITE_FRAME_MODE" => "A",
						"COMPOSITE_FRAME_TYPE" => "AUTO"
					),
					false
				);
?>
							<?}?>
                        </div>
                    </div>
                </div>
                <!--endheader-->

            </header>

<div class="add-prod-modal">
	<div class="add-pr-ttl">Товар добавлен в корзину!</div>
	<a href="/personal/cart/">Перейти к корзине (<span class="js-count-in-basket">0</span>)</a> | <a href="#" class="js-prod-modal-close">Продолжить покупки</a></a>
</div>

<?
// show only for NOT Authorized users
if (!$USER->IsAuthorized()){?>
<div class="sign-form-modal js-sign-modal-form">
	
	<div class="sign-form-modal__tab_nav js-sign-tabs">
		<a href="#js-modal-tab-sign" class="tab_nav_active">Войти</a><a href="#js-modal-tab-reg">Регистрация</a>
		<div class="js-sign-form-close">
			<svg class="icon-svg close-white">
				<use xlink:href="#icon-close-white" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
			</svg>
			<svg class="icon-svg close-black">
				<use xlink:href="#icon-close" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
			</svg>
		</div>
		<!--<input type="button" name="sign-form-close" class="js-sign-form-close" value="x">-->
	</div>

	<!--sign-->
	<div class="sign-form-modal__tab_sign js-modal-tab js-acc-tab-active" id="js-modal-tab-sign">
		<div class="sign-form-modal__input js-mod-inp">
			<label for="js-sign-login" class="label">Email</label>
			<input type="text" name="login" id="js-sign-login" class="input">
			<?/*<div class="sign-form-modal__input_req">*</div>
			<div class="js-help_block"></div>*/?>
		</div>
		<div class="sign-form-modal__input js-mod-inp">
			<label for="js-sign-password">Пароль</label><br>
			<input type="password" name="password" id="js-sign-password" class="input">
			<?/*<div class="sign-form-modal__input_req">*</div>
			<div class="js-help_block"></div>*/?>
		</div>
		<div class="sign-form-modal__input">
			<input type="button" name="sign" value="Вход" id="js-modal-sign-btn" class="btn btn_red">
		</div>
		<div class="sign-form-modal__bottom_lnk">
			<a href="/auth/forgot/" class="sign-form-modal__forgot">Забыли пароль?</a>
		</div>
	</div>

	<!--register-->
	<div class="sign-form-modal__tab_reg js-modal-tab" id="js-modal-tab-reg">
		<input type="hidden" name="token" id="token">
        <input type="hidden" name="action" id="action">
		<div class="sign-form-modal__input js-mod-inp">
			<label for="js-reg-name">Имя</label><br>
			<input type="text" name="person-name" id="js-reg-name" class="input">
			<?/*<div class="sign-form-modal__input_req">*</div>
			<div class="js-help_block"></div>*/?>
		</div>
		<div class="sign-form-modal__input js-mod-inp">
			<label for="js-reg-email">Email</label><br>
			<input type="text" name="email" id="js-reg-email" class="input">
			<?/*<div class="sign-form-modal__input_req">*</div>
			<div class="js-help_block"></div>*/?>
		</div>
<!--		<div class="sign-form-modal__input js-mod-inp">-->
<!--			<label for="js-reg-login">Логин</label><br>-->
<!--			<input type="text" name="login" id="js-reg-login" class="input">-->
<!--			--><?///*<div class="sign-form-modal__input_req">*</div>
//			<div class="js-help_block"></div>*/?>
<!--		</div>-->
		<div class="sign-form-modal__input js-mod-inp">
			<label for="js-reg-password">Пароль</label><br>
			<input type="password" name="Пароль" id="js-reg-password" class="input">
			<?/*<div class="sign-form-modal__input_req">*</div>
			<div class="js-help_block"></div>*/?>
		</div>
		<div class="sign-form-modal__input js-mod-inp">
			<input type="checkbox" name="reg-agree" id="js-reg-agree" class="reg-agree-option">
			<label for="js-reg-agree" class="reg-agree-label">Принимаю условия пользовательского соглашения</label>
			<div class="js-help_block"></div>
		</div>
		<div class="sign-form-modal__input">
			<input type="button" name="register" value="Регистрация" id="js-modal-register-btn" class="btn btn_red">
		</div>
	</div>	
</div>
<?}?>
<?
// order one click form
$APPLICATION->IncludeComponent("eauto:sale.order.one.click", ".default", array(), false);
?>