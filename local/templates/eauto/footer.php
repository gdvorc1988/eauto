</div>
<!-- end .content -->
<div class="footer">
    <div class="footer-top">
        <div class="inner">
            <div class="footer-top-inner">
                <div class="footer-col footer-col_contacts">
                    <h3 class="footer-col__title">Exclusive Auto</h3>
                    <div class="footer-col__item half-opacity">
                        Специализированные магазины розничной и&nbsp;оптовой торговли автомобильной электроники и
                        автомобильных аксессуаров</div>
                    <div class="footer-col__item">
                        <div>ООО «ЭксАвто»</div>
                        <div class="half-opacity">ИНН 1121022762</div>
                        <div class="half-opacity">ОГРН 1131121001109</div>
                    </div>
                    <div class="footer-col__item">
                        +7 (8212) 25-00-85<br>
                        sm@eauto.su
                    </div>
                </div>
                <div class="footer-col">
                    <h3 class="footer-col__title">Каталог</h3>
                    <ul class="footer-menu">
                        <li class="footer-menu__li">
                            <a href="/acustika/" class="footer-menu__link">Акустика</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/sabs/" class="footer-menu__link">Сабвуферы</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/signalizacii/" class="footer-menu__link">Автосигнализации</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/videoregistratory/" class="footer-menu__link">Видеорегистраторы</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/shumoizolacia/" class="footer-menu__link">Шумоизоляция</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/usiliteli-i-aksy/usiliteli/" class="footer-menu__link">Усилители</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/radary/" class="footer-menu__link">Радар-детекторы</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-col__title">Компания</h3>
                    <ul class="footer-menu">
                        <li class="footer-menu__li">
                            <a href="/punkti-vidachi/" class="footer-menu__link">Пункты выдачи</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/payment/" class="footer-menu__link">Оплата</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/dostavka/" class="footer-menu__link">Доставка</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/service/" class="footer-menu__link">Услуги</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/about/" class="footer-menu__link">О нас</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/news/" class="footer-menu__link">Новости</a>
                        </li>
                        <li class="footer-menu__li">
                            <a href="/contacts/" class="footer-menu__link">Контакты</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-col__title">Следуйте за нами</h3>
                    <a href="https://vk.com/exclusiveautosyk" class="round-icon">
                        <svg class="icon-svg">
                            <use xlink:href="#icon-vk" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="footer-bottom">
        <div class="inner">
            <div class="footer-inner">
                <div class="copyright">Все права защищены. 2012-2019 © Exclusive Auto</div>
            </div>
        </div>
    </div>
</div>
</div>
<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
   "AREA_FILE_SHOW" => "file",
   "PATH" => "/local/templates/eauto/icons.php",
   "EDIT_TEMPLATE" => ""
   ),
   false
);?>

<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
   "AREA_FILE_SHOW" => "file",
   "PATH" => "/local/templates/eauto/metrika.php",
   "EDIT_TEMPLATE" => ""
   ),
   false
);?>

</script><script src="//code.jivosite.com/widget.js" jv-id="UoTmBCQoQS" async></script>

</body>
<?

// CURRENT PAGE DIR
global $APPLICATION;
$cur_dir = $APPLICATION->GetCurDir();

?>
<script src="<?=SITE_TEMPLATE_PATH?>/js/modernizr.js"></script> <!-- Modernizr -->
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-3.2.1.min.js"></script>

<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.menu-aim.js"></script> <!-- menu aim -->

<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/main.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/menu.js"></script>
<?
global $USER; // include only for NOT Authorized users
if (!$USER->IsAuthorized()){?>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/auth.js"></script>
<?}?>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/catalog.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/basket.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/page-limit-dropdown.js"></script>
<?if ($cur_dir == '/personal/order/make/'){?>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/order-form.js"></script>
<?}?>

</html>