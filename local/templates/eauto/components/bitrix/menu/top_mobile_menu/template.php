<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="cd-dropdown-wrapper">
	<a class="cd-dropdown-trigger" href="#0">
		<div class="header-bottom-controls__item header-bottom-controls__item_menu">
			<svg class="icon-svg">
				<use xlink:href="#icon-menu" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
			</svg>
		</div>		
	</a>
	<nav class="cd-dropdown">
		<a href="#0" class="cd-close">Закрыть</a>
		<?if(!empty($arResult)){?>
			<ul class="cd-dropdown-content">
				<li>
					<form class="cd-search" action="/search">
						<input type="search" placeholder="Поиск..." name="q">
					</form>
				</li>
				<?
				$previousLevel = 0;
				$i=0;
				foreach($arResult as $arItem){
					$i++;
					?>
				
				<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel){?>
				<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
				<?}?>
				
				<?if ($arItem["IS_PARENT"]){?>
					<?if ($arItem["DEPTH_LEVEL"] == 1){?>
						<li class="has-children">
							<a href="#"><?=$arItem['TEXT']?></a>
							<ul class="cd-secondary-dropdown is-hidden">
								<li class="go-back"><a href="#0">Назад</a></li>
					<?} else {?>
							<li class="has-children">
								<a href="<?=$arItem["LINK"]?>"><?=$arItem['TEXT']?></a>
								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Назад</a></li>
					<?}?>
				<?} else {?>
					<?if ($arItem["DEPTH_LEVEL"] == 1){?>
						<li><a href="<?=$arItem["LINK"]?>"><?=$arItem['TEXT']?></a></li>
					<?} else {?>
						<li><a href="<?=$arItem["LINK"]?>"><?=$arItem['TEXT']?></a></li>
					<?}?>
				<?}?>
				<?
					$previousLevel = $arItem["DEPTH_LEVEL"];
				}?>
				<? //close last item tags
				if ($previousLevel > 1){?>
					<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
				<?}?>
			</ul>
		<?}?>
	</nav> <!-- .cd-dropdown -->
</div> <!-- .cd-dropdown-wrapper -->