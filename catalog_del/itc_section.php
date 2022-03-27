<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<? if(!CModule::IncludeModule('iblock')) die();?>
<?

$GLOBALS['arrFilter'] = array("PROPERTY_otrasl"=>$_REQUEST['id']);

?>
<?//foreach ($arItem['DISPLAY_PROPERTIES']['otrasl']['DISPLAY_VALUE'] as $item):?>
<?
$arSelect = Array("ID", "NAME");
$arFilter = Array('IBLOCK_ID' => 1, 'ID' => $arResult['PROPERTIES']['CLIENT_LINK']['VALUE'], "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
//print_r($res);
while($ar_fields = $res->GetNext()) {
    $arProductIndustry[] = array(
        'NAME' => $ar_fields['NAME'],// название раздела
        'ID' => $ar_fields['ID']
    );
}
$arResult['INDUSTRY'] = $arProductIndustry;?>

<?switch($arResult['VARIABLES']['SECTION_CODE']) {
    case 'avtomatizatsiya_biznesa':
    case 'otraslevye_resheniya':
    case 'podderzhka_i_obsluzhivanie':
        $product_select = false;
        $product_select_view = false; //свойство для отображения кнопок вывода
        $product_select_list = false; //свойство для отображения сортировки
        $product_btn = false; //свойство для отображения кнопки "Связаться с нами"
        break;
    case 'programmnoe_obespechenie':
        $product_select = true;
        $product_select_view = true;
        $product_select_list = true;
        $product_btn = true;
        break;
    case '1C_products':
        $product_select = true;
        $product_select_view = true;
        $product_select_list = false;
        $product_btn = true;
        break;
    case 'sobstvennye_razrabotki':
    case 'prodazha_torgovogo_oborudovaniya':
        $product_select = false;
        $product_select_view = true;
        $product_select_list = false;
        $product_btn = false;
        break;
    default:
        $product_select = false;
        $product_select_view = false;
        $product_select_list = false;
        $product_btn = false;
        break;
}
?>
<div class='product__select<?=($product_select ? '' : ' hidden')?>'>
    <div class='product__select_view d-none d-md-flex<?=($product_select_view ? '' : ' hidden')?>'>
        <a href='?view=plitka' class='product__select_ico <?=(empty($_REQUEST['view']) || $_REQUEST['view'] == 'plitka' ? 'product__select_ico-active' : '')?>'>
            <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <path fill-rule='evenodd' clip-rule='evenodd' d='M0 6H6V0H0V6ZM9 24H15V18H9V24ZM0 24H6V18H0V24ZM0 15H6V9H0V15ZM9 15H15V9H9V15ZM18 0V6H24V0H18ZM9 6H15V0H9V6ZM18 15H24V9H18V15ZM18 24H24V18H18V24Z' fill='#0067C2'/>
            </svg>
        </a>
        <a href='?view=list&PAGEN_1=1' class='product__select_ico <?=($_REQUEST['view'] == 'list' ? 'product__select_ico-active' : '')?>'>
            <svg width='23' height='24' viewBox='0 0 23 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <path fill-rule='evenodd' clip-rule='evenodd' d='M0 24H23V20H0V24ZM0 14H23V10H0V14ZM0 0V4H23V0H0Z' fill='#0067C2'/>
            </svg>
        </a>
    </div>
    <?$arSort = [];
    foreach ($arResult['INDUSTRY'] as $arItem) {
        array_push($arSort, [$arItem['ID'] => $arItem['NAME']]);
    }
    foreach ($arSort as $sort) {
        if (array_key_exists("id", $_REQUEST) && array_key_exists($_REQUEST["id"], $sort)) {
            $sortBy = $_REQUEST["id"];
            break;

        } else {
            $sortBy = "";
        }
    }
    ?>
    <div class='product__select-list<?=($product_select_list ? '' : ' hidden')?>'>
        <div class='product__select-list_item'>
            <select class='product__select-list_item-list'  name="sort">
                <option class='introduction-head__select-item_list-item' data-url = "">Все отрасли</option>
                <?
                foreach($arSort as $key => $sort):
                    ?>
                    <option class="introduction-head__select-item_list-item" data-url="<?=key($sort)?>" <?if(key($sort) == $sortBy):?>Selected<?endif?>><?=$sort[key($sort)]?></option>
                <?endforeach;?>
            </select>
        </div>
    </div>
    <div class='product__select-list<?=($product_select_list ? '' : ' hidden')?>'>
        <div class='product__select-list_item'>
            <select class='product__select-list_item-list'>
                <option class='introduction-head__select-item_list-item'>По акциям</option>
                <option class='introduction-head__select-item_list-item'>Акция1</option>
                <option class='introduction-head__select-item_list-item'>Акция2</option>
                <option class='introduction-head__select-item_list-item'>Акция3</option>
            </select>
        </div>
    </div>
</div>

<?
//Данные раздела
$arSectionsCount = 0;
$cache_id = $arParams['IBLOCK_ID'] . $arResult['VARIABLES']['SECTION_CODE'];//$arResult['VARIABLES']['SECTION_CODE']- название раздела транслитом
$obCache = new CPHPCache(); //CPhpCache - класс для кеширования PHP переменных и HTML результата выполнения скрипта.
if ($obCache->InitCache(360000, $cache_id . 'section', '/catalog/section')){ //InitCache - Инициализирует ряд свойств объекта класса CPHPCache. Если файл кеша отсутствует или истек период его жизни, то метод вернет "false", в противном случае метод вернет "true". Нестатический метод.
    $arSection = $obCache->GetVars();	//GetVars() - возвращает PHP переменные сохраненные в кеше. Нестатический метод.
}
elseif ($obCache->StartDataCache())	{//StartDataCache - Начинает буферизацию выводимого HTML, либо выводит содержимое кеша если он ещё не истек. Если файл кеша истек, то метод возвращает "true", в противном случае - "false". Нестатический метод.
    $arSelect = Array('ID', 'NAME', 'DESCRIPTION', 'DEPTH_LEVEL', 'UF_DESCR', 'UF_NEW', 'UF_SALE', 'UF_TITLE');
    $arFilter = Array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'CODE' => $arResult['VARIABLES']['SECTION_CODE']);
    $res = CIBlockSection::GetList(array(),$arFilter, false, $arSelect);// GetList - Возвращает список разделов, отсортированных в порядке arOrder по фильтру arFilter. Нестатический метод.
    while($ar_fields = $res->GetNext()) {
        $arSection = array(
            'ID' => $ar_fields['ID'],
            'NAME' => $ar_fields['NAME'],
            'DESCRIPTION' => $ar_fields['~DESCRIPTION'],
            'DEPTH_LEVEL' => $ar_fields['DEPTH_LEVEL'],
            'UF_DESCR' => $ar_fields['UF_DESCR'],
            'UF_NEW' => $ar_fields['UF_NEW'],
            'UF_SALE' => $ar_fields['UF_SALE'],
            'UF_TITLE' => $ar_fields['UF_TITLE'],
        );
    }

    if(!empty($arSection['ID'])) {
        $arFilter = Array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'SECTION_ID' => $arSection['ID'],// id раздела
            'ACTIVE' => 'Y'
        );
        $arSection['COUNT'] = CIBlockSection::GetCount($arFilter);	//CIBlockSection::GetCount - Возвращает количество разделов, удовлетворяющих фильтру arFilter. Нестатический метод.
    }

    $obCache->EndDataCache($arSection); //EndDataCache - Выводит буферизированный HTML и сохраняет его на диске вместе с заданным массивом переменных в файл кеша. Нестатический метод.
}

$arSectionsCount = $arSection['COUNT'];//количество каталогов
$arCopy = $arResult["SECTIONS"];

/*foreach ($arResult["SECTIONS"] as $arSection)
{
$arSection["ITEMS"] = [];
// IBLOCK_SECTION_ID - ID головного каталога
//SECTION_ID - ID самого раздела
// если IBLOCK_SECTION_ID =
// у головных разделов [DEPTH_LEVEL] => 2
// у входящих разделов [DEPTH_LEVEL] => 3
   if ($arSection["DEPTH_LEVEL"] < $arParams["TOP_DEPTH"])
   {
     //$SUBITEMS = array();
      foreach ($arCopy as $subItem)
      {
         if (($subItem["DEPTH_LEVEL"] == ($arSection["DEPTH_LEVEL"]+1)) && ($subItem["IBLOCK_SECTION_ID"] == $arSection["IBLOCK_SECTION_ID"]) )
         $arSection["ITEMS"] = $subItem;
      }
      $arSection["ITEMS"] = $SUBITEMS;
      $SECT[] = $arSection;
   }
} */
//$arResult["SECT"] = $SECT; ?>

<?
$APPLICATION->SetTitle($arSection["NAME"]);
$page = $APPLICATION->GetCurPage();
$pattern = '#^/reference/prodazha_torgovogo_oborudovaniya/#';
$pattern_service = '#^/reference/podderzhka_i_obsluzhivanie/its/#';

if (preg_match($pattern, $APPLICATION->GetCurPage()) && $arSectionsCount > 0){
    echo $arSectionsCount;
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "equipment",
        Array(
            'VIEW_MODE' => 'TEXT',
            'SHOW_PARENT_NAME' => 'N',
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
            'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
            'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
            'COUNT_ELEMENTS' => 'Y',
            'TOP_DEPTH' => '2',
            'SECTION_FIELDS' => '',
            'SECTION_USER_FIELDS' => array('UF_DESCR', 'UF_NEW', 'UF_SALE', 'UF_TITLE'),
            'ADD_SECTIONS_CHAIN' => 'N',
            'CACHE_TYPE' => 'A',
            'CACHE_TIME' => '36000000',
            'CACHE_NOTES' => '',
            'CACHE_GROUPS' => 'Y'
        )
    );
}
elseif($arSectionsCount > 0) {
    echo '<div class="product__text"><p>';
    echo $arSection['DESCRIPTION'];
    echo '</p></div>';
    if($arResult['VARIABLES']['SECTION_CODE'] != 'podderzhka_i_obsluzhivanie'){

        $APPLICATION->IncludeComponent('bitrix:catalog.section.list','',
            Array(
                'VIEW_MODE' => 'TEXT',
                'SHOW_PARENT_NAME' => 'N',
                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
                'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
                'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
                'COUNT_ELEMENTS' => 'Y',
                'TOP_DEPTH' => '2',
                'SECTION_FIELDS' => '',
                'SECTION_USER_FIELDS' => array('UF_DESCR', 'UF_NEW', 'UF_SALE', 'UF_TITLE'),
                'ADD_SECTIONS_CHAIN' => 'N',
                'CACHE_TYPE' => 'A',
                'CACHE_TIME' => '36000000',
                'CACHE_NOTES' => '',
                'CACHE_GROUPS' => 'Y'
            )
        );
    }
}
// else {

$template = '';
if(!empty($_REQUEST['view']) && $_REQUEST['view'] == 'list' || preg_match($pattern, $APPLICATION->GetCurPage())){
    $template = 'list_with_section';
}
elseif(preg_match($pattern_service, $APPLICATION->GetCurPage())){
    $template = 'list_service';
}
else{
    $template = 'list_new';
}
echo '<div class = "all_services">';
$APPLICATION->IncludeComponent(
    'bitrix:news.list',
    $template,
    Array(
        'IBLOCK_TYPE'	=>	$arParams['IBLOCK_TYPE'],
        'IBLOCK_ID'	=>	$arParams['IBLOCK_ID'],
        'NEWS_COUNT'	=>	6,
        'SORT_BY1'	=>	$arParams['SORT_BY1'],
        'SORT_ORDER1'	=>	$arParams['SORT_ORDER1'],
        'SORT_BY2'	=>	$arParams['SORT_BY2'],
        'SORT_ORDER2'	=>	$arParams['SORT_ORDER2'],
        'FIELD_CODE'	=>	$arParams['LIST_FIELD_CODE'],
        'PROPERTY_CODE'	=>	$arParams['LIST_PROPERTY_CODE'],
        'DISPLAY_PANEL'	=>	$arParams['DISPLAY_PANEL'],
        'SET_TITLE'	=>	$arParams['SET_TITLE'],
        'SET_STATUS_404' => $arParams['SET_STATUS_404'],
        'INCLUDE_IBLOCK_INTO_CHAIN'	=>	$arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
        'ADD_SECTIONS_CHAIN'	=>	$arParams['ADD_SECTIONS_CHAIN'],
        'CACHE_TYPE'	=>	$arParams['CACHE_TYPE'],
        'CACHE_TIME'	=>	$arParams['CACHE_TIME'],
        'CACHE_FILTER'	=>	$arParams['CACHE_FILTER'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
        'DISPLAY_TOP_PAGER'	=>	'N',
        'DISPLAY_BOTTOM_PAGER'	=>	'N',
        'PAGER_TITLE'	=>	$arParams['PAGER_TITLE'],
        'PAGER_TEMPLATE'	=>	$arParams['PAGER_TEMPLATE'],
        'PAGER_SHOW_ALWAYS'	=>	$arParams['PAGER_SHOW_ALWAYS'],
        'PAGER_DESC_NUMBERING'	=>	$arParams['PAGER_DESC_NUMBERING'],
        'PAGER_DESC_NUMBERING_CACHE_TIME'	=>	$arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
        'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
        'DISPLAY_DATE'	=>	$arParams['DISPLAY_DATE'],
        'DISPLAY_NAME'	=>	'Y',
        'DISPLAY_PICTURE'	=>	$arParams['DISPLAY_PICTURE'],
        'DISPLAY_PREVIEW_TEXT'	=>	$arParams['DISPLAY_PREVIEW_TEXT'],
        'PREVIEW_TRUNCATE_LEN'	=>	$arParams['PREVIEW_TRUNCATE_LEN'],
        'ACTIVE_DATE_FORMAT'	=>	$arParams['LIST_ACTIVE_DATE_FORMAT'],
        'USE_PERMISSIONS'	=>	$arParams['USE_PERMISSIONS'],
        'GROUP_PERMISSIONS'	=>	$arParams['GROUP_PERMISSIONS'],
        'FILTER_NAME'	=>	$arParams['FILTER_NAME'],
        'HIDE_LINK_WHEN_NO_DETAIL'	=>	$arParams['HIDE_LINK_WHEN_NO_DETAIL'],
        'CHECK_DATES'	=>	$arParams['CHECK_DATES'],
        'PARENT_SECTION'	=>	$arResult['VARIABLES']['SECTION_ID'],
        'PARENT_SECTION_CODE'	=>	$arResult['VARIABLES']['SECTION_CODE'],
        'DETAIL_URL'	=>	$arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'],
        'SECTION_URL'	=>	$arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
        'IBLOCK_URL'	=>	$arResult['FOLDER'].$arResult['URL_TEMPLATES']['news'],
        'SECTION_INFO'	=>	$arSection,
    ),
    $component
);
// }
echo '</div>';
?>
<?foreach ($arResult["SECTIONS"] as $arSection)
{$arSection["ITEMS"] = [];
}
?>

<div class='product__btn<?=($product_btn ? '' : ' hidden')?>'>
    <a href='#' class='btn-style'><?=GetMessage('SECTION_TO_CONTACT_US')?></a>
</div>

<script type="text/javascript">$(".product__select-list_item-list").change(function(){
        var $url = $(this).find("option:selected").data("url");
        document.location.replace("?id=" + $url);
    });</script>