<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arResult['SEO_DESCRIPTION'] && $arResult['SEO_TITLE'])
{
    $APPLICATION->SetPageProperty("description", $arResult['SEO_DESCRIPTION']);

    $APPLICATION->SetPageProperty("title", $arResult['SEO_TITLE'] );
}