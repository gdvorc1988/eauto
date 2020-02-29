<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if (!empty($arResult["errorMessage"]))
{
	if (!is_array($arResult["errorMessage"]))
	{
		ShowError($arResult["errorMessage"]);
	}
	else
	{
		foreach ($arResult["errorMessage"] as $errorMessage)
		{
			ShowError($errorMessage);
		}
	}
}
else
{
	$wrapperId = rand(0, 10000);

	?>
	<div class="bx-sopc" id="bx-sopc<?=$wrapperId?>">
		<div>
			<div>
				<div class="change-payment__pp">
					<div class="change-payment__inner-row">
						<div class="change-payment__inner-row-body">
							<div class="change-payment__payment">
								<div class="change-payment__payment-title">
									<?
									$paymentSubTitle = Loc::getMessage('SOPC_TPL_BILL')." ".Loc::getMessage('SOPC_TPL_NUMBER_SIGN').$arResult['PAYMENT']['ACCOUNT_NUMBER'];
									if(isset($arResult['PAYMENT']['DATE_BILL']))
									{
										$paymentSubTitle .= " ".Loc::getMessage('SOPC_TPL_FROM_DATE')." ".$arResult['PAYMENT']['DATE_BILL']->format("d.m.Y");
									}
									$paymentSubTitle .=",";
									echo $paymentSubTitle;
									?>
									<span class="change-payment__payment-title-element"><?=htmlspecialcharsbx($arResult['PAYMENT']['PAY_SYSTEM_NAME'])?></span>
									<?
									if ($arResult['PAYMENT']['PAID'] === 'Y')
									{
										?>
										<span class="change-payment__status-success"><?=Loc::getMessage('SOPC_TPL_PAID')?></span>
										<?
									}
									elseif ($arResult['IS_ALLOW_PAY'] == 'N')
									{
										?>
										<span class="change-payment__status-restricted"><?=Loc::getMessage('SOPC_TPL_RESTRICTED_PAID')?></span>
										<?
									}
									else
									{
										?>
										<span class="change-payment__status-alert"><?=Loc::getMessage('SOPC_TPL_NOTPAID')?></span>
										<?
									}
									?>
								</div>
								<div class="change-payment__payment-price">
									<span class="change-payment__payment-element"><?=Loc::getMessage('SOPC_TPL_SUM_TO_PAID')?>:</span>

									<span class="change-payment__payment-number"><?=SaleFormatCurrency($arResult['PAYMENT']["SUM"], $arResult['PAYMENT']["CURRENCY"])?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="change-payment__pp-list">
						<?
						foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem)
						{
							?>
							<div class="change-payment__pp-company">
								<div class="change-payment__pp-company-graf-container">
									<input type="hidden"
										class="change-payment__pp-company-hidden"
										name="PAY_SYSTEM_ID"
										value="<?=$paySystem['ID']?>"
										<?= ($key == 0) ? "checked='checked'" :""?>
									>
									<?
									if (empty($paySystem['LOGOTIP']))
										$paySystem['LOGOTIP'] = '/bitrix/images/sale/nopaysystem.gif';

									?>
									<div class="change-payment__pp-company-image"
										style="background: url(<?=htmlspecialcharsbx($paySystem['LOGOTIP'])?>) 0 0 no-repeat;">
									</div>
									<div class="change-payment__pp-company-smalltitle">
										<?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?>
									</div>
								</div>
							</div>
							<?
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"accountNumber" => $arParams['ACCOUNT_NUMBER'],
		"paymentNumber" => $arParams['PAYMENT_NUMBER'],
		"inner" => $arParams['ALLOW_INNER'],
		"onlyInnerFull" => $arParams['ONLY_INNER_FULL'],
		"refreshPrices" => $arParams['REFRESH_PRICES'],
		"pathToPayment" => $arParams['PATH_TO_PAYMENT'],
		"wrapperId" => $wrapperId
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		var sc = new BX.Sale.OrderPaymentChange(<?=$javascriptParams?>);
	</script>
	<?
}

