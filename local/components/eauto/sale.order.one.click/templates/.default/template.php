<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

?>
<div class="one-click-order">
<?if (count($arResult['ITEMS']) > 0){?>
	<form>
	<div class="one-click-order__ttl">Укажите ваши данные</div>
	<div class="one-click-order__msg"></div>

	<div class="one-click-order__close js-ocl-close">
		<svg class="icon-svg close-white">
			<use xlink:href="#icon-close-white" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
		<svg class="icon-svg close-black">
			<use xlink:href="#icon-close" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
	</div>

	<?foreach ($arResult['ITEMS'] as $arItems){
		if (!in_array ($arItems['CODE'], array("FIO","EMAIL","PHONE"))) continue;
		?>
		<div class="one-click-order__input">
		<label class="label" for="ocl_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label><br>

		<?if ($arItems["TYPE"]=="CHECKBOX"){?>
			<input type="checkbox" class="inputcheckbox" id="ocl_<?=$arItems['ID']?>" name="ORDER_PROP_<?=$arItems["ID"]?>" value="Y"<?=(($arItems["DEFAULT_VALUE"]=="Y")?" checked":"")?>>
		<?} elseif ($arItems["TYPE"]=="TEXT") {?>
			<input type="text" class="input" size="<?=( (IntVal($arItems["SIZE1"]) > 0) ? $arItems["SIZE1"] : 30)?>" maxlength="250" value="<?=htmlspecialchars($arItems["DEFAULT_VALUE"])?>" name="ORDER_PROP_<?=$arItems["ID"]?>" id="ocl_<?=$arItems['ID']?>">
		<?} elseif ($arItems["TYPE"]=="SELECT"){?>
			<select name="ORDER_PROP_<?=$arItems["ID"]?>" size="<?=((IntVal($arItems["SIZE1"])>0)?$arItems["SIZE1"]:1)?>" id="ocl_<?=$arItems['ID']?>">
				<?if ($arItems['VARIANTS']){
					foreach ($arItems['VARIANTS'] as $vars){?>
						<option value="<?=$vars["VALUE"]?>"<?=(($vars["VALUE"]==$arItems["DEFAULT_VALUE"])?" selected":"")?>><?=htmlspecialchars($vars["NAME"])?></option>
					<?}
				}?>
			</select>
		  <?} elseif ($arItems["TYPE"]=="MULTISELECT"){?>
			<select multiple name="ORDER_PROP_<?=$arItems["ID"]?>[]" size="<?=((IntVal($arItems["SIZE1"])>0)?$arItems["SIZE1"]:5)?>" id="ocl_<?=$arItems['ID']?>">
			<?
				$arDefVal = Split(",", $arItems["DEFAULT_VALUE"]);
				for ($i = 0; $i<count($arDefVal); $i++)
					$arDefVal[$i] = Trim($arDefVal[$i]);

			if ($arItems['VARIANTS']){
				foreach ($arItems['VARIANTS'] as $vars){?>
					<option value="<?=$vars["VALUE"]?>"<?=(in_array($vars["VALUE"], $arDefVal)?" selected":"")?>><?=htmlspecialchars($vars["NAME"])?></option>
				<?}
			}?>
			</select>
		<?} elseif ($arItems["TYPE"]=="TEXTAREA"){?>
			<textarea id="ocl_<?=$arItems['ID']?>" rows="<?=((IntVal($arItems["SIZE2"])>0)?$arItems["SIZE2"]:4)?>" cols="<?=((IntVal($arItems["SIZE1"])>0)?$arItems["SIZE1"]:40)?>" name="ORDER_PROP_<?=$arItems["ID"]?>"><?=htmlspecialchars($arItems["DEFAULT_VALUE"])?></textarea>
		<?} elseif ($arItems["TYPE"]=="LOCATION"){?>
			<select id="ocl_<?=$arItems['ID']?>" name="ORDER_PROP_<?=$arItems["ID"]?>">
			<?if ($arItems['VARIANTS']){
				foreach ($arItems['VARIANTS'] as $vars){
					if (empty($vars["CITY_NAME"])) continue;
					?>
					<option value="<?=$vars["ID"]?>"<?=((IntVal($vars["ID"])==IntVal($arItems["DEFAULT_VALUE"]))?" selected":"")?>><?=htmlspecialchars($vars["COUNTRY_NAME"]." - ".$vars["CITY_NAME"])?></option>
				<?}
			}?>
			</select>
		<?} elseif ($arItems["TYPE"]=="RADIO"){?>
			<?if ($arItems['VARIANTS']){
				foreach ($arItems['VARIANTS'] as $vars){?>
					<input type="radio" name="ORDER_PROP_<?=$arItems["ID"]?>" value="<?=$vars["VALUE"]?>"<?=(($vars["VALUE"]==$arItems["DEFAULT_VALUE"])?" checked":"")?>><?=htmlspecialchars($vars["NAME"])?><br>
				<?}
			}?>
		<?}

		if (strlen($arItems["DESCRIPTION"]) > 0){
			echo "<br><small>".$arItems["DESCRIPTION"]."</small>";
		}?><br>
		</div>
	<?}?>
	<div class="one-click-order__input">
		<input type="button" name="confirm" value="Оформить" class="btn btn_red btn_block js-ocl-confirm-order">
	</div>
	</form>
<?}?>
</div>