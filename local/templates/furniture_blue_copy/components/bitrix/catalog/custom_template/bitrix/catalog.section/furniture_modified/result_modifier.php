<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$arItem['PRICES']['PRICE']['PRINT_VALUE'] = number_format($arItem['PRICES']['PRICE']['PRINT_VALUE'], 0, '.', ' ');
	$arItem['PRICES']['PRICE']['PRINT_VALUE'] .= ' '.$arItem['PROPERTIES']['PRICECURRENCY']['VALUE_ENUM'];
	
	$arResult['ITEMS'][$key] = $arItem;
}

use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();

// Если нажата кнопка "Получить сотрудников" пишем параметр
if ($request->isPost() && !empty($request->get('getEmployeesList'))) {
  $arResult['SHOW_LIST'] = "Y";
} else {
  $arResult['SHOW_LIST'] = "N";
}
?>