<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");?><?$APPLICATION->IncludeComponent(
	"bitrix:main.auth.forgotpasswd",
	"eauto",
Array()
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>