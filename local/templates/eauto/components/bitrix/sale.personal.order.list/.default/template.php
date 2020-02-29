<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if ($arResult['ORDERS']){?>
<div class="order-list">
	<table>
	<?foreach ($arResult['ORDERS'] as $key => $order){?>
		<tr>

                <td>
                    <a href="/personal/order/detail/<?=$order['ORDER']['ID']?>/">№ <?=$order['ORDER']['ID']?></a></td>
                <td><?= $order['ORDER']['DATE_INSERT'] ?></td>
                <td><?= $order['ORDER']['FORMATED_PRICE'] ?></td>
                <td><?
                    if (isset($order['SHIPMENT']) && count($order['SHIPMENT'])>0){
                        foreach ($order['SHIPMENT'] as $arShipment){?>
                            <?=$arShipment['DELIVERY_NAME']?>
                        <?}
                    }
                    ?></td>
                <!-- <td><?=$order['ORDER']['FORMATED_STATUS'] ?></td> -->
		</tr>
	<?}?>
	</table>
</div>
<?} else {?>
	<??>
<?}?>
<div class="pagination">
	<?=$arResult["NAV_STRING"]?>
</div>