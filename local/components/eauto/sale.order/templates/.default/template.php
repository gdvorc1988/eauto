<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>
<?if (count($arResult['ORDER_PROPS']) > 0){?>
<form class="form-order">
<input type="hidden" name="user_id" value="<?=$arResult['USER_ID']?>" id="user_id">
<?	// ---- CONTACT INFORMATION ------ ?>
<div class="block">
	<div class="block-inner typography">
		<h1>Контактная информация</h1>
		<?foreach ($arResult['ORDER_PROPS'] as $arItems){
			if (!in_array ($arItems['CODE'], array("FIO","EMAIL","PHONE"))) continue;?>
			<div class="order__input">
				<?if ($arItems["TYPE"]=="TEXT") {?>
					<label class="label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label><br>
					<input type="text" class="input" size="<?=( (IntVal($arItems["SIZE1"]) > 0) ? $arItems["SIZE1"] : 30)?>" maxlength="250" value="<?=htmlspecialchars($arItems["DEFAULT_VALUE"])?>" name="ORDER_PROP_<?=$arItems["ID"]?>" id="prop_<?=$arItems['ID']?>">
				<?}?>
			</div>
		<?}?>
	</div>
</div><!--end block-->

<br><br>
<? // ----- DELIVERY METHODS --------------- ?>
<div class="block">
	<div class="block-inner typography">
		<h1>Способ получения</h1>
		<div class="delivery-inputs">
			<?
			$i=0;
			foreach($arResult['DELIVERY'] as $arDlv){
				$i++;
				?>
				<input type="radio" name="delivery_id" value="<?=$arDlv['ID']?>" id="delivery_<?=$arDlv['ID']?>"<?=($i == 1 ? " checked" : "")?> class="js-dlv-checkbox option-radio">
				<label for="delivery_<?=$arDlv['ID']?>" class="option-radio-label"><?=$arDlv['NAME']?></label>
			<?}?>
		</div>
<?
	// tab: shop list
?>
<div class="dlv-prop js-dlv-prop" id="dlvp_<?=$arParams['PICKUP_DELIVERY_ID']?>">
<?foreach ($arResult['ORDER_PROPS'] as $arItems){
		if (!in_array ($arItems['CODE'], array("SHOP"))) continue;?>
		<div class="order__radio">
			<p class="ORDER_PROP_<?=$arItems["ID"]?>_ttl"><?=$arItems["DESCRIPTION"]?></p>
		<?if ($arItems['VARIANTS']){
			foreach ($arItems['VARIANTS'] as $vars){?>
				<input type="radio" id="prop_<?=$arItems["ID"]?>_<?=$vars['ID']?>" class="option-radio" name="ORDER_PROP_<?=$arItems["ID"]?>" value="<?=$vars["VALUE"]?>"<?=(($vars["VALUE"]==$arItems["DEFAULT_VALUE"])?" checked":"")?>><label class="option-radio-label" for="prop_<?=$arItems["ID"]?>_<?=$vars['ID']?>"><?=htmlspecialchars($vars["NAME"])?></label><br>
			<?}
		}?>
		</div>
<?}?>
</div>
<?
	// tab: delivery params
?>
<div class="dlv-prop js-dlv-prop dlvp-active" id="dlvp_<?=$arParams['COURIER_DELIVERY_ID']?>">
	<?foreach ($arResult['ORDER_PROPS'] as $arItems){
		if (!in_array ($arItems['CODE'], array("ZIP","LOCATION","ADDRESS"))) continue;
		?>
		<?if ($arItems["TYPE"]=="CHECKBOX"){?>
			<div class="order__input">
				<input type="checkbox" class="inputcheckbox" id="prop_<?=$arItems['ID']?>" name="ORDER_PROP_<?=$arItems["ID"]?>" value="Y"<?=(($arItems["DEFAULT_VALUE"]=="Y")?" checked":"")?>>
				<label class="label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label><br>
			</div>
		<?} elseif ($arItems["TYPE"]=="TEXT") {?>

			<div class="order__input">
				<label class="label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label><br>
				<input type="text" class="input" size="<?=( (IntVal($arItems["SIZE1"]) > 0) ? $arItems["SIZE1"] : 30)?>" maxlength="250" value="<?=htmlspecialchars($arItems["DEFAULT_VALUE"])?>" name="ORDER_PROP_<?=$arItems["ID"]?>" id="prop_<?=$arItems['ID']?>">
			</div>

		<?} elseif ($arItems["TYPE"]=="SELECT"){?>
			<div class="order__input">
				<label class="label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label><br>
				<select class="select" name="ORDER_PROP_<?=$arItems["ID"]?>" size="<?=((IntVal($arItems["SIZE1"])>0)?$arItems["SIZE1"]:1)?>" id="prop_<?=$arItems['ID']?>">
					<?if ($arItems['VARIANTS']){
						foreach ($arItems['VARIANTS'] as $vars){?>
							<option value="<?=$vars["VALUE"]?>"<?=(($vars["VALUE"]==$arItems["DEFAULT_VALUE"])?" selected":"")?>><?=htmlspecialchars($vars["NAME"])?></option>
						<?}
					}?>
				</select>
			</div>
		  <?} elseif ($arItems["TYPE"]=="MULTISELECT"){?>
		  
			<div class="order__input">
				<label class="label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label><br>
				<select multiple name="ORDER_PROP_<?=$arItems["ID"]?>[]" size="<?=((IntVal($arItems["SIZE1"])>0)?$arItems["SIZE1"]:5)?>" id="prop_<?=$arItems['ID']?>">
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
			</div>
			
		<?} elseif ($arItems["TYPE"]=="TEXTAREA"){?>

			<div class="order__input_wide">

				<label class="label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label><br>

				<textarea class="textarea" id="prop_<?=$arItems['ID']?>" rows="<?=((IntVal($arItems["SIZE2"])>0)?$arItems["SIZE2"]:4)?>" cols="<?=((IntVal($arItems["SIZE1"])>0)?$arItems["SIZE1"]:40)?>" name="ORDER_PROP_<?=$arItems["ID"]?>"><?=htmlspecialchars($arItems["DEFAULT_VALUE"])?></textarea>

			</div>

		<?} elseif ($arItems["TYPE"]=="LOCATION"){?>
			<div class="order__input">
				
				<label class="label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?>:</label>			
				
				<?$APPLICATION->IncludeComponent(
					"bitrix:sale.location.selector.steps",
					"eauto",
					Array(
						"COMPONENT_TEMPLATE" => "eauto",
						"ID" => "22",
						"CODE" => "",
						"INPUT_NAME" => "LOCATION",
						"PROVIDE_LINK_BY" => "id",
						"JSCONTROL_GLOBAL_ID" => "",
						"JS_CALLBACK" => "",
						"FILTER_BY_SITE" => "Y",
						"SHOW_DEFAULT_LOCATIONS" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "36000000",
						"FILTER_SITE_ID" => "s1",
						"PRECACHE_LAST_LEVEL" => "N",
						"PRESELECT_TREE_TRUNK" => "N",
						"DISABLE_KEYBOARD_INPUT" => "N",
						"INITIALIZE_BY_GLOBAL_EVENT" => "",
						"SUPPRESS_ERRORS" => "N"
					)
				);?>
				<?/*
				<select id="prop_<?=$arItems['ID']?>" name="ORDER_PROP_<?=$arItems["ID"]?>">
				<?if ($arItems['VARIANTS']){
					foreach ($arItems['VARIANTS'] as $vars){
						if (empty($vars["CITY_NAME"])) continue;
						?>
						<option value="<?=$vars["ID"]?>"<?=((IntVal($vars["ID"])==IntVal($arItems["DEFAULT_VALUE"]))?" selected":"")?>><?=htmlspecialchars($vars["COUNTRY_NAME"]." - ".$vars["CITY_NAME"])?></option>
					<?}
				}?>
				</select>*/?>
			</div>
		<?} elseif ($arItems["TYPE"]=="RADIO"){?>
			<div class="order__input_wide">
				<p><?=$arItems["NAME"]?></p>
			<?if ($arItems['VARIANTS']){
				foreach ($arItems['VARIANTS'] as $vars){?>
					<input type="radio" name="ORDER_PROP_<?=$arItems["ID"]?>" id="prop_<?=$arItems["ID"]?>_<?=$vars["ID"]?>" value="<?=$vars["VALUE"]?>"<?=(($vars["VALUE"]==$arItems["DEFAULT_VALUE"])?" checked":"")?>><label for="prop_<?=$arItems["ID"]?>_<?=$vars["ID"]?>"><?=htmlspecialchars($vars["NAME"])?></label><br>
				<?}
			}?>
			</div>
		<?}?>

		
	<?}?>
	</div>
	
	<div class="order__msg"></div>
	
	</div>
</div><!--end block-->

    <br><br>
    <div class="block">
        <div class="block-inner typography">
            <h1>Дополнительная информация</h1>
<?foreach ($arResult['ORDER_PROPS'] as $arItems){
	if (!in_array($arItems['CODE'], array("Installation_service")))
		continue;

		if ($arItems["TYPE"]=="CHECKBOX"){?>
			<div class="install__input">
				<input type="checkbox" class="f-checkbox" id="prop_<?=$arItems['ID']?>" name="ORDER_PROP_<?=$arItems["ID"]?>" value="N"<?=(($arItems["DEFAULT_VALUE"]=="Y")?" checked":"")?>>
				
				<label class="label f-label" for="prop_<?=$arItems['ID']?>" data-requied="<?=$arItems["REQUIED"]?>"><?=$arItems["NAME"]?><?=($arItems["REQUIED"]=="Y" ? "<span>*</span>" : "")?></label>
			</div>
		<?}
}?>


            <div class="order__input_wide">
                <label for="COMMENTS" data-requied="N" class="label">Комментарий к заказу:</label>
                <textarea name="COMMENTS" id="COMMENTS" class="textarea"></textarea>
            </div>
        </div>
    </div>
	<br>
	<br>

	<input type="button" name="confirm" value="Оформить заказ" class="btn btn_red js-confirm-order">

</form>
<?}?>