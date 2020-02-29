<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

// echo '<pre>'; print_r($arResult); echo '</pre>';

//delayed function must return a string
if(empty($arResult))
    return "";

$strReturn = '';

$strReturn .= '<div class="breadcrumbs">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    $nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="bx_breadcrumb_'.($index+1).'"' : '');
    $child = ($index > 0? ' itemprop="child"' : '');
    $arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');
    if($index==0 && $arResult[0]['TITLE'] !== 'Каталог' ){
        $strReturn .= '
			<a href="/katalog" class="breadcrumbs__item" >Каталог</a>';
    }
    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
    {

        if($itemSize-$index<=4){
            $strReturn .= '
				<a href="'.$arResult[$index]["LINK"].'" class="breadcrumbs__item">'.$title.'</a>';
        }
    }
    elseif($title !== 'Каталог')
    {
        $strReturn .= '
			<div class="breadcrumbs__item">'.$title.'</div>';
    }
}

$strReturn .= '</div>';

return $strReturn;
