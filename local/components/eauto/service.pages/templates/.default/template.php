<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$APPLICATION->SetPageProperty("keywords", $arResult['PAGE']['NAME']);
$APPLICATION->SetPageProperty("title", $arResult['PAGE']['NAME']." / Exclusive Auto - автозвук, автоэлектроника, охранные системы в Сыктывкаре. ЭксАвто Сыктывкар");
$APPLICATION->SetTitle($arResult['PAGE']['NAME']." - Автозвук, автоэлектроника, охранные системы в Сыктывкаре");
?>
<?if (isset($arResult['MENU']) && count($arResult['MENU'])>0){?>
<div class="content-sidebar__sidebar">
	<div class="block">
		<ul class="sidebar-menu">
		<?foreach ($arResult['MENU'] as $menu){?>
			<li class="sidebar-menu__li"><a href="<?=$menu['LINK']?>" class="sidebar-menu__link<?=($menu['IS_ACTIVE'] == 'Y' ? ' sidebar-menu__link_current':'')?>"><?=$menu['TITLE']?></a></li>
		<?}?>
		</ul>
	</div>
</div>
<?}?>
<div class="content-sidebar__content">
	<div class="block">
		<div class="block-inner typography">
			<?if (isset($arResult['PAGE'])){?>
				 <h1><?=$arResult['PAGE']['NAME']?></h1>
				<?=$arResult['PAGE']['DETAIL_TEXT']?>
			<?}?>
			
		</div>
	</div>
</div>