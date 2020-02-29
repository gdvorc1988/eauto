<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="basket-checkout-block basket-checkout-block-btn">
		<button class="btn btn_red {{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
			data-entity="basket-checkout-button">
			<?=Loc::getMessage('SBB_ORDER')?>
		</button>
		<input type="button" name="clear_all" id="clear_all_basket" class="btn clear-btn" value="Очистить корзину">
	</div>
	<div class="basket-checkout-block basket-checkout-block-total">
		<div class="basket-checkout-block-total-inner">
			<div class="basket-checkout-block-total-title">
			<span><?=Loc::getMessage('SBB_TOTAL')?>:</span>
			<span class="basket-coupon-block-total-price-current" data-entity="basket-total-price">
				{{{PRICE_FORMATED}}}
			</span>
			</div>
			<div class="basket-checkout-block-total-description">
				{{#WEIGHT_FORMATED}}
					<?=Loc::getMessage('SBB_WEIGHT')?>: {{{WEIGHT_FORMATED}}}
					{{#SHOW_VAT}}<br>{{/SHOW_VAT}}
				{{/WEIGHT_FORMATED}}
				{{#SHOW_VAT}}
					<?=Loc::getMessage('SBB_VAT')?>: {{{VAT_SUM_FORMATED}}}
				{{/SHOW_VAT}}
			</div>
		</div>
	</div>

<?/*
	<div class="basket-checkout-block basket-checkout-block-total-price">
		<div class="basket-checkout-block-total-price-inner">
			{{#DISCOUNT_PRICE_FORMATED}}
				<div class="basket-coupon-block-total-price-old">
					{{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}
				</div>
			{{/DISCOUNT_PRICE_FORMATED}}

			

			{{#DISCOUNT_PRICE_FORMATED}}
				<div class="basket-coupon-block-total-price-difference">
					<?=Loc::getMessage('SBB_BASKET_ITEM_ECONOMY')?>
					<span style="white-space: nowrap;">{{{DISCOUNT_PRICE_FORMATED}}}</span>
				</div>
			{{/DISCOUNT_PRICE_FORMATED}}
		</div>
	</div>*/?>



</script>