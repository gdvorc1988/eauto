<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

CJSCore::Init(array('clipboard', 'fx'));

$APPLICATION->SetTitle("");

if (!empty($arResult['ERRORS']['FATAL']))
{
	$component = $this->__component;
	foreach($arResult['ERRORS']['FATAL'] as $code => $error)
	{
		if ($code !== $component::E_NOT_AUTHORIZED)
			ShowError($error);
	}
}
else
{
	$DELIVERY_ADDRESS = "";
	$DELIVERY_TYPE = "";
	
	if (isset($arResult["ORDER_PROPS"]))
	{
		foreach ($arResult["ORDER_PROPS"] as $property)
		{
			if ($arResult['SHIPMENT'][0]["DELIVERY_ID"] == 3) {
				if ($property["ID"] == 6) {
					$DELIVERY_ADDRESS .= $property["VALUE"];
				}
				if ($property["ID"] == 7) {
					$DELIVERY_ADDRESS .= ", ".$property["VALUE"];
				}
			}
			else if ($arResult['SHIPMENT'][0]["DELIVERY_ID"] == 2) {
				if ($property["ID"] == 24) {
					$DELIVERY_ADDRESS .= $property["VALUE"];
				}
				
			}
		}
	}
	?>

	<div class="block-inner">
		<div>
			<? if ($arParams['GUEST_MODE'] !== 'Y')
			{
				?>
				<div>
					<a href="<?= htmlspecialcharsbx($arResult["URL_TO_LIST"]) ?>">&larr; <?= Loc::getMessage('SPOD_RETURN_LIST_ORDERS') ?></a>
				</div>
				<?
			}
			?>

	<h2 class="order-detail-title">
		Заказ №<?=htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]);?>
	</h2>
	<div class="order-detail-row">
		Дата: <?=$arResult["DATE_INSERT_FORMATED"];?>
	</div>
	<div class="order-detail-row">
		Сумма: <?=$arResult["PRICE_FORMATED"]?>
	</div>

	<div class="order-detail-row">
		Способ получения: <span><?=$arResult['SHIPMENT'][0]["DELIVERY_NAME"]?></span>
	</div>
	<div class="order-detail-row">
		Адрес: <?=$DELIVERY_ADDRESS?>
	</div>
	<div class="order-detail-row">
		<?
		if (isset($arResult["ORDER_PROPS"]))
		{
			foreach ($arResult["ORDER_PROPS"] as $property)
			{
				if ($property["ID"] == 22 && $property["VALUE"] == "Y") {
					?>
						<div>Дополнительно: услуги установочного центра</div>
					<?
				}
			}
		}
		?>
	</div>

</div>
	<h2 class="order-detail-title">Товары в заказе</h2>
	<div class="order-list">
		<table>
			<tbody>
			<?
			foreach ($arResult['BASKET'] as $basketItem)
			{
				?>
				<tr>
					<td class="order-list__title" >
						<a class="link"
						   href="<?=$basketItem['DETAIL_PAGE_URL']?>"><?=htmlspecialcharsbx($basketItem['NAME'])?></a>
					</td>
					<td class="sale-order-detail-order-item-properties"><?=$basketItem['BASE_PRICE_FORMATED']?></td>
					<td class="sale-order-detail-order-item-properties">
						<?=$basketItem['QUANTITY']?>&nbsp;
						<?
						if (strlen($basketItem['MEASURE_NAME']))
						{
							echo htmlspecialcharsbx($basketItem['MEASURE_NAME']);
						}
						else
						{
							echo Loc::getMessage('SPOD_DEFAULT_MEASURE');
						}
						?>
					</td>
					<td class="order-list__price">
						Итого:&nbsp;&nbsp;<?=$basketItem['FORMATED_SUM']?>
					</td>
				</tr>
				<?
			}
			?>
			</tbody>
		</table>
	
	</div>
	</div>
<?
}
?>

