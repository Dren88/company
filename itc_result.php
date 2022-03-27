<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$cache_id = $arResult['IBLOCK_ID'] . $arResult['ID'];

//Данные раздела
$arSection = array();
$obCache = new CPHPCache();
if ($obCache->InitCache(360000, $cache_id . "section", '/product/section')) {
    $arSection = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $arSelect = Array("ID", "NAME");
    $arFilter = Array('IBLOCK_ID' => $arResult['IBLOCK_ID'], "ACTIVE" => "Y", 'ID' => $arResult['IBLOCK_SECTION_ID']);
    $res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
    while ($ar_fields = $res->GetNext()) {
        $arSection = array(
            'ID' => $ar_fields['ID'],
            'NAME' => $ar_fields['NAME'],
        );
    }

    $obCache->EndDataCache($arSection);
}

//Акции
$obCache = new CPHPCache();
if ($obCache->InitCache(360000, $cache_id . "action", '/product/action')) {
    $arSales = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $arSelect = array(
        "ID",
        "NAME",
        "DETAIL_PAGE_URL",
        "PROPERTY_DESC",
        "PROPERTY_DESC_IMAGE",
        "PROPERTY_DATE",
        "PROPERTY_FOR_ALL",
    );
    $arFilter = array("IBLOCK_ID" => 27, "ACTIVE" => "Y", "PROPERTY_FOR_ALL" => $arSection['ID']);
    $res = CIBlockElement::GetList(array('ID' => desc), $arFilter, false, false, $arSelect);
    while ($ar_fields = $res->GetNext()) {
        $arSales[] = array(
            'DATE' => $ar_fields['PROPERTY_DATE_VALUE'],
            'TITLE' => $ar_fields['NAME'],
            'TEXT' => $ar_fields['PROPERTY_DESC_VALUE']['TEXT'],
            'URL' => $ar_fields['DETAIL_PAGE_URL'],
            'IMG' => CFile::GetPath($ar_fields['PROPERTY_DESC_IMAGE_VALUE']),
        );
    }
    $obCache->EndDataCache($arSales);
}

//Доп лицензии
$obCache = new CPHPCache();
if ($obCache->InitCache(360000, $cache_id . "licenses", '/product/licenses')) {
    $arLicenses = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {

    if ($arResult["IBLOCK_SECTION_ID"] == 38) {
        $arSelect = Array("ID", "NAME", "PROPERTY_PRICE");
        $arFilter = array("IBLOCK_ID" => 17, "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
        while ($ar_fields = $res->GetNext()) {
            $arLicenses[] = array(
                'NAME' => $ar_fields['NAME'],
                'PRICE' => $ar_fields['PROPERTY_PRICE_VALUE']
            );
        }
    }

    $obCache->EndDataCache($arLicenses);
}

//Клиенты
$obCache = new CPHPCache();
if ($obCache->InitCache(360000, $cache_id . "clients", '/product/clients')) {
    $arClients = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    if (!empty($arResult["PROPERTIES"]["WORK_ON"]["VALUE"]) && count($arResult["PROPERTIES"]["WORK_ON"]["VALUE"]) > 0) {
        $clientIds = Array();
        foreach ($arResult["PROPERTIES"]["WORK_ON"]["VALUE"] as $arItem) {
            array_push($clientIds, $arItem);
        }
        $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE");
        $arFilter = Array("IBLOCK_ID" => 20, "ACTIVE" => "Y", "ID" => $clientIds);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while ($ar_fields = $res->GetNext()) {
            if (empty($ar_fields['PREVIEW_PICTURE'])) continue;
            $arClients[] = array(
                'NAME' => $ar_fields['NAME'],
                'URL' => $ar_fields['PROPERTY_CLIENT_URL_VALUE'],
                'IMG' => CFile::ResizeImageGet($ar_fields["PREVIEW_PICTURE"], array('width' => 300, 'height' => 300), BX_RESIZE_IMAGE_PROPORTIONAL, true)
            );
        }

    }
    $obCache->EndDataCache($arClients);
}

//Аналогичные продукты и услуги
$obCache = new CPHPCache();
if ($obCache->InitCache(360000, $cache_id . "products", '/product/products')) {
    $arProducts = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    if (!empty($arResult["PROPERTIES"]["PRODUCTS"]["VALUE"]) && count($arResult["PROPERTIES"]["PRODUCTS"]["VALUE"]) > 0) {
        $productsIds = Array();
        foreach ($arResult["PROPERTIES"]["PRODUCTS"]["VALUE"] as $arItem) {
            array_push($productsIds, $arItem);
        }
        $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", 'DETAIL_PAGE_URL');
        $arFilter = Array("ACTIVE" => "Y", "ID" => $productsIds);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while ($ar_fields = $res->GetNext()) {
            $arProducts[] = array(
                'NAME' => $ar_fields['NAME'],
                'URL' => $ar_fields['DETAIL_PAGE_URL'],
                'IMG' => CFile::GetPath($ar_fields["PREVIEW_PICTURE"])
            );
        }

    }
    $obCache->EndDataCache($arProducts);
}

//Версии продукта
$arProductVersoins = array();
$obCache = new CPHPCache();
if ($obCache->InitCache(360000, $cache_id . "version", '/product/version')) {
    $arProductVersoins = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $arSelect = Array("ID", "NAME", "PROPERTY_PRICE", 'PROPERTY_OLD_PRICE');
    $arFilter = Array('IBLOCK_ID' => 31, "ACTIVE" => "Y", "PROPERTY_PRODUCT" => IntVal($arResult['ID']), 'SECTION_ID' => 79);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ar_fields = $res->GetNext()) {
        $arProductVersoins[] = array(
            'NAME' => $ar_fields['NAME'],
            'PRICE' => $ar_fields['PROPERTY_PRICE_VALUE'],
            'OLD_PRICE' => $ar_fields['PROPERTY_OLD_PRICE_VALUE']
        );
    }

    $obCache->EndDataCache($arProductVersoins);
}

//Варианты поставок
$arProductVariants = array();
$obCache = new CPHPCache();
if ($obCache->InitCache(360000, $cache_id . "variant", '/product/variant')) {
    $arProductVariants = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $arSelect = Array("ID", "NAME", "PROPERTY_PRICE", 'PROPERTY_OLD_PRICE', 'PROPERTY_TIME');
    $arFilter = Array('IBLOCK_ID' => 31, "ACTIVE" => "Y", "PROPERTY_PRODUCT" => IntVal($arResult['ID']), 'SECTION_ID' => 80);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ar_fields = $res->GetNext()) {
        $arProductVariants[] = array(
            'NAME' => $ar_fields['NAME'],
            'PRICE' => $ar_fields['PROPERTY_PRICE_VALUE'],
            'OLD_PRICE' => $ar_fields['PROPERTY_OLD_PRICE_VALUE'],
            'TIME' => $ar_fields['PROPERTY_TIME_VALUE']
        );
    }

    $obCache->EndDataCache($arProductVariants);
}

$arSelect = Array("ID", "NAME", 'PREVIEW_TEXT');
$arFilter = Array('IBLOCK_ID' => 44, 'ID' => $arResult['PROPERTIES']['PRODUCT_SERVICE']['VALUE'], "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while ($ar_fields = $res->GetNext()) {
    $arProduct[] = array(
        'NAME' => $ar_fields['NAME'],
        'PREVIEW_TEXT' => $ar_fields['PREVIEW_TEXT'],
        'ID' => $ar_fields['ID']
    );
}
$arResult['PRODUCT_LIST'] = $arProduct;

//
$arResult['SALES'] = $arSales;
$arResult['LICENCES'] = $arLicenses;
$arResult['CLIENTS'] = $arClients;
$arResult['PRODUCTS'] = $arProducts;
$arResult['PRODUCT_VERSIONS'] = $arProductVersoins;
$arResult['PRODUCT_VARIANTS'] = $arProductVariants;
$arResult['SECTION_INFO'] = $arSection;

unset($arSales);
unset($arLicenses);
unset($arClients);
unset($arProducts);
unset($arProductVersoins);
unset($arProductVariants);
unset($arSection);
?>

<div class="alert">Нельзя редактировать собственные комментарии через 12 часов после их публикации</div>

<span class="timeman-background" id="timeman-background" style="">Нельзя редактировать собственные комментарии через 12 часов после их публикации</span>

<span class="timeman-not-closed-block">
    <span class="timeman-not-cl-icon"></span>
    <span class="timeman-not-cl-text">
        Нельзя редактировать собственные комментарии через 12 часов после их публикации
    </span>
</span>