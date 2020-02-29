<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

?>

<div class="bx_profile">
	<?
	ShowError($arResult["strProfileError"]);

	if ($arResult['DATA_SAVED'] == 'Y')
	{
		ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'));
	}

	?>
	<form method="post" name="form1" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data" role="form">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
		<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
		<div class="main-profile-block-shown" id="user_div_reg">
			<?/*<div class="main-profile-block-date-info">
				<?
				if($arResult["ID"]>0)
				{
					if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
					{
						?>
						<div>
							<strong><?=Loc::getMessage('LAST_UPDATE')?></strong>
							<strong><?=$arResult["arUser"]["TIMESTAMP_X"]?></strong>
						</div>
						<?
					}

					if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
					{
						?>
						<div>
							<strong><?=Loc::getMessage('LAST_LOGIN')?></strong>
							<strong><?=$arResult["arUser"]["LAST_LOGIN"]?></strong>
						</div>
						<?
					}
				}
				?>
			</div>*/?>

			<div>
				<div>
					<?
					if (!in_array(LANGUAGE_ID,array('ru', 'ua')))
					{
						?>
						<div>
							<div class="align-items-center">
								<div class="form-group">
									<label class="label" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
									<input class="input" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
								</div>
							</div>
						</div>
						<?
					}
					?>
					<div class="profile-inp">
						<label class="label" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
						<div >
							<input class="input" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>" />
						</div>
					</div>

					<div class="profile-inp">
						<label class="label" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
						<div >
							<input class="input" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
						</div>
					</div>
					<div class="profile-inp">
						<label class="label" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
						<div >
							<input class="input" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
						</div>
					</div>
					<div class="profile-inp">
						<label class="label" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
						<div >
							<input class="input" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" />
						</div>
					</div>
					<?
					if ($arResult['CAN_EDIT_PASSWORD'])
					{
						?>
						<div class="profile-inp">
							<label class="label" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
							<div >
								<input class=" input bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
							</div>
						</div>
						<div class="profile-inp">
							<label class="label main-profile-password" for="main-profile-password-confirm">
								<?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?>
							</label>
							<div >
								<input class="input" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
								<small id="emailHelp" class="form-text text-muted"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></small>
							</div>
						</div>
						<?
					}
					?>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col">
				<input type="submit" class="btn btn_red" name="save" value="<?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
			</div>
		</div>

	</form>
	<?/*
	<div class="col-sm-12 main-profile-social-block">
		<?
		if ($arResult["SOCSERV_ENABLED"])
		{
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
				"SHOW_PROFILES" => "Y",
				"ALLOW_DELETE" => "Y"
			),
				false
			);
		}
		?>
	</div>
	*/
	?>
	<div class="clearfix"></div>
	<script>
		BX.Sale.PrivateProfileComponent.init();
	</script>
</div>