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


?>






















<div class="b-enter__digits support">
	<div class="page-form__wrap">
		<div class="page-form__title">
			 Комплект поддержки 1С:ИТС
		</div>
		<div class="page-form__pre-title">
			 Обслуживание 1С в Челябинске
		</div>
		<div class="d-flex justify-content-around">
			<div class="button_block">
 <button href="#" class="btn-circle company__btn btn">Три месяца бесплатно</button>
				<div class="page-form__info">
					<div class="b-digit__descr">
						 Льготный период сопровождения*
					</div>
				</div>
			</div>
			<div class="stroke">
			</div>
			<div class="button_block">
 <button href="#" class="btn-circle company__btn btn">
				Приобрести </button>
				<div class="page-form__info">
					<div class="b-digit__descr">
						 Комплект поддержки на самых выгодных условиях
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="b-enter__project">
	<div class="b-enter__digits">
		<div class="b-digit">
			<div class="b-digit__descr">
				 Что такое ИТС
			</div>
		</div>
		<div class="b-digit">
			<div class="b-digit__descr">
				 Стоимость
			</div>
		</div>
		<div class="b-digit">
			<div class="b-digit__descr">
				 Сервисы 1С:ИТС
			</div>
		</div>
		<div class="b-digit">
			<div class="b-digit__descr">
				 Акции
			</div>
		</div>
		<div class="b-digit">
			<div class="b-digit__descr">
				 Приобрести
			</div>
		</div>
	</div>
</div>
<div class="mb-5">
	*При покупке программных продуктов 1С:Предприятие версии ПРОФ или КОРП или апгрейда с базовой версии
</div>
<div class="page_sub_title">
	 С договором 1С:ИТС Вы получаете:
</div>
<div class="direction__main">
	<div class="direction__item">
		<div class="direction__item_ico">
 <img src="/local/templates/itc2019/img/updating.svg">
		</div>
		<div class="direction__item_link">
			 Обновление программ 1С до последних релизов
		</div>
	</div>
	<div class="direction__item">
		<div class="direction__item_ico">
 <img src="/local/templates/itc2019/img/access.svg">
		</div>
		<div class="direction__item_link">
			 Доступ к информационной системе 1С:ИТС
		</div>
	</div>
	<div class="direction__item">
		<div class="direction__item_ico">
 <img src="/local/templates/itc2019/img/consultation.svg">
		</div>
		<div class="direction__item_link">
			 Профессиональную линию консультации
		</div>
	</div>
	<div class="direction__item">
		<div class="direction__item_ico">
 <img src="/local/templates/itc2019/img/services.svg">
		</div>
		<div class="direction__item_link">
			 Сервисы 1С:ИТС для комфортной и эффективной работы
		</div>
	</div>
</div>
<div class="page_sub_title_small">
	 Что такое 1С:ИТС
</div>
<p>
	Информационно-технологическое сопровождение (1С:ИТС) – это комплексная поддержка пользователей «1С:Предприятие» по всем направлениям, которую оказывают официальные партнеры фирмы «1С». В первую очередь, это регулярное предоставление комплекса услуг и сервисов профессиональными специалистами 1С для комфортной и эффективной работы по ведению учета и управлению предприятием.
</p>
<div class="products-box__wrap escort justify-content-around">
	<div class="products-box__item ">
		<div class="products-box__item_img">
 <img src="/local/templates/itc2019/img/time_2.svg" alt=""> <img src="/local/templates/itc2019/img/time_2_hover.svg" alt="">
		</div>
		<div class="products-box__item_text">
			 Поддержка программ 1С в режиме реального времени
		</div>
	</div>
	<div class="products-box__item ">
		<div class="products-box__item_img">
 <img src="/local/templates/itc2019/img/legislation.svg" alt=""> <img src="/local/templates/itc2019/img/legislation_hover.svg" alt="">
		</div>
		<div class="products-box__item_text">
			 Актуальная информация об изменениях законодательства
		</div>
	</div>
	<div class="products-box__item ">
		<div class="products-box__item_img">
 <img src="/local/templates/itc2019/img/new_functions.svg" alt=""> <img src="/local/templates/itc2019/img/new_functions_hover.svg" alt="">
		</div>
		<div class="products-box__item_text">
			 Новые функции и возможности в программах 1С
		</div>
	</div>
	<div class="products-box__item ">
		<div class="products-box__item_img">
 <img src="/local/templates/itc2019/img/new_reporting.svg" alt=""> <img src="/local/templates/itc2019/img/new_reporting_hover.svg" alt="">
		</div>
		<div class="products-box__item_text">
			 Новые формы отчетности
		</div>
	</div>
	<div class="products-box__item ">
		<div class="products-box__item_img">
 <img src="/local/templates/itc2019/img/DB.svg" alt=""> <img src="/local/templates/itc2019/img/DB_hover.svg" alt="">
		</div>
		<div class="products-box__item_text">
			 Сохранность вашей базы
		</div>
	</div>
	<div class="products-box__item ">
		<div class="products-box__item_img">
 <img src="/local/templates/itc2019/img/submission.svg" alt=""> <img src="/local/templates/itc2019/img/submission_hover.svg" alt="">
		</div>
		<div class="products-box__item_text">
			 Бесперебойная сдача отчетности
		</div>
	</div>
</div>
<div class="page_sub_title">
	 Стоимость 1С:Комплект поддержки ИТС
</div>
<div class="direction__main type_service">
	<div class="direction__item">
		<div class="direction__item_link">
			 ПРОФ
		</div>
	</div>
	<div class="direction__item">
		<div class="direction__item_link">
			 ТЕХНО
		</div>
	</div>
	<div class="direction__item">
		<div class="direction__item_link">
			 СТРОИТЕЛЬСТВО
		</div>
	</div>
	<div class="direction__item">
		<div class="direction__item_link">
			 МЕДИЦИНА
		</div>
	</div>
</div>
 <section class="content">
<!-- Small boxes (Stat box) -->
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-prices">
					<thead>
					<tr>
						<th>
						</th>
						<th>
							1 месяц
						</th>
						<th>
							3 месяца
						</th>
						<th>
							6 месяцев
						</th>
						<th>
							12 месяцев
						</th>
						<th>
							24 месяца
						</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							Льготная цена*
						</td>
						<td>
							4 557 руб.
						</td>
						<td>
							9 894 руб.
						</td>
						<td>
							17 869 руб.
						</td>
						<td>
							33 816 руб.
						</td>
						<td>
							60 869 руб.
						</td>
					</tr>
					<tr>
						<td>
							Рекомендованная цена
						</td>
						<td>
							5 493 руб.
						</td>
						<td>
							11 871 руб.
						</td>
						<td>
							21 440 руб.
						</td>
						<td>
							40 572 руб.
						</td>
						<td>
							-
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<button href="#" class="btn-circle company__btn btn btn-primary">Заказать</button>
						</td>
						<td>
							<button href="#" class="btn-circle company__btn btn btn-primary">Заказать</button>
						</td>
						<td>
							<button href="#" class="btn-circle company__btn btn btn-primary">Заказать</button>
						</td>
						<td>
							<button href="#" class="btn-circle company__btn btn btn-primary">Заказать</button>
						</td>
						<td>
							<button href="#" class="btn-circle company__btn btn btn-primary">Заказать</button>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mb-5">
	*При непрерывном продлении договора ИТС
</div>
<div class="order_form">
	<div class="page_sub_title modal-form__pre-title">
		 Вы можете приобрести комплект поддержки версии ПРОФ на 12 месяцев всего по цене 8 месяцев
	</div>
	<div class="d-flex justify-content-around">
		<div class="price price_old">
			33 816 р/год
		</div>
		<div class="price price_new">
			22 544 р/год
		</div>
	</div>
	<div class="button_block">
 <button href="#" class="btn-circle company__btn btn btn-primary">Узнать подробнее</button>
	</div>
</div>
 <!--
<p>
	 Автоматизация магазинов, отделов продажи и предприятий сферы услуг невозможна без его оснащения современным торговым оборудованием. Компания «АйТиСи Сервис» предлагает купить торговое оборудование для магазинов, способствующего быстрому и качественному обслуживанию клиентов и учету продуктов, а также расходных материалов к нему.
</p>
 <br>
 <strong>Обслуживание 1C</strong> <br>
<p>
	 Компания ITCпроводит комплексное обслуживание 1C Челябинск. Мы имеем статус «Франчайзи», поэтому распространяем легальные программные продукты семейства 1С, а также имеем приоритетное право обслуживания клиентов, купивших у нас любое прикладное решение.
</p>
 <br>
 <strong>Зачем необходимо обслуживание?</strong> <br>
<p>
	 Мы проводим обслуживание в рамках договора ИТС Челябинск. Причины выполнения этой процедуры следующие.
</p>
<ul>
	<li>1. Пользователь нуждается в изменении или переносе баз данных, заполнении нормативно-справочных систем. Это наиболее частая услуга, в которой нуждается каждая компания. Эту работу безопаснее и проще доверить профильным экспертам, чем заниматься самостоятельным выполнением таких работ. </li>
	<li>2. Устранение конфигурационных неполадок. Подобное обслуживание 1с проводится либо по установленному графику, либо экстренно. Причина – необходимость проанализировать правильность ведения учета в системе, исправить ошибки, ранее допущенные пользователями. Поскольку экосистема 1С состоит из взаимосвязанных программ, при выходе новых обновлений не исключено появление незначительных ошибок, которые будут накапливаться по мере работы организации. Они останутся незаметными до тех пор, пока не начнут оказывать серьезное влияние на точность и качество ведения учета.</li>
	<li>3. Структурное изменение организации. Например, компания нуждается в автоматизации новых разновидностей работ, изменении выбранного направления деятельности, либо расширяется. В таком случае приходится адаптировать программный комплекс под актуальные изменения.</li>
</ul>
<p>
	 Одной из основных наших услуг является льготное сопровождение 1с Челябинск. Для ознакомления с условиями предоставления льготного периода свяжитесь с представителями ITC, либо следите за новостями.
</p>
 <br>
 <strong>Преимущества сотрудничества</strong>
<p>
	 По сравнению с другими профильными организациями, которые проводят обслуживание 1с предприятие,сотрудничество с компанией ITC характеризуется рядом преимуществ.
</p>
<ul>
	<li>1. Доступная стоимость предоставления услуг.</li>
	<li> 2. Возможность получения комплексной технической поддержки в срочном режиме.</li>
	<li> 3. Отсутствие необходимости выделять отдельный рабочий компьютер для эксперта. Все операции проводятся в онлайн-режиме, с использованием программ для получения удаленного доступа</li>
	<li>4. Работа по договору. Поддержка 1с Челябинск входит в общий договор на предоставление услуг.</li>
	<li>5. Оперативность</li>
</ul>
<p>
	 Мы всегда рады помочь вам!.
</p>--></section>






















<?elseif($arSectionsCount > 0) {
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

<?php
<?php

//поиск вхождения в массиве строк
function strposa($haystack, $needles=array(), $offset=0) {
    $chr = array();
    foreach($needles as $needle) {
        $res = strpos($haystack, $needle, $offset);
        if ($res !== false) $chr[$needle] = $res;
    }
    if(empty($chr)) return false;
    return min($chr);
}
//TODO не работает, уточнить
//исключаем из поиска детальное описание и предварительное описание
function BeforeIndexHandler($arFields) {
    $arrIblock = array(19, 20); //ID инфоблоков, для которых производить модификацию
    $arDelFields = array("DETAIL_TEXT", "PREVIEW_TEXT" ); //стандартные поля, которые нужно исключить
    if (CModule::IncludeModule('iblock') && $arFields["MODULE_ID"] == 'iblock' && in_array($arFields["PARAM2"], $arrIblock) && intval($arFields["ITEM_ID"] ) > 0){

        $dbElement = CIblockElement::GetByID($arFields["ITEM_ID"] );
        if ($arElement = $dbElement->Fetch()){
            foreach ($arDelFields as $value){
                if (isset ($arElement[$value] ) && strlen($arElement[$value] ) > 0){
                    $arElement[$value] = strip_tags($arElement[$value]);
                    $arElement[$value] = str_replace(array(' '), " ", $arElement[$value]);
                    $arElement[$value] = preg_replace('|[\s]+|s', ' ', $arElement[$value]);
                    $arFields["BODY"] = str_replace($arElement[$value], "", preg_replace('|[\s]+|s', ' ', $arFields["BODY"]));

                }
            }
        }

        return $arFields;
    }
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "OnBeforeIBlockElementModify");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementModify");
function OnBeforeIBlockElementModify(&$arFields) {

    $CATALOG_IBLOCK_ID = 19;

    if($CATALOG_IBLOCK_ID == $arFields["IBLOCK_ID"]) {
        //инфо о свойствах каталога
        $arProps = [];
        $properties = CIBlockProperty::GetList(array(), array("ACTIVE"=>"Y", "IBLOCK_ID" => $CATALOG_IBLOCK_ID));
        while ($prop_fields = $properties->GetNext()) {
            $arProps[$prop_fields["CODE"]] = $prop_fields["ID"];
        }

        foreach($arFields["PROPERTY_VALUES"] as $key => $prop) {
            if(IntVal($key) ==  IntVal($arProps["POLNOE_NAIMENOVANIE"])){
                foreach($prop as $val) {
                    $name_new = $val["VALUE"];
                }
            }
        }

        $name = $arFields["NAME"];
        if(!empty($name_new) && $name_new != $name) {
            $arFields["PREVIEW_TEXT"] = $arFields["NAME"];
            $arFields["NAME"] = $name_new;
        }

        if (@$_REQUEST['mode'] == 'import' && !empty($arFields["ID"])) {
            unset($arFields['DETAIL_TEXT']);
            unset($arFields['DETAIL_TEXT_TYPE']);
        }

    }

    if($arFields["IBLOCK_ID"] == 20) {
        CModule::IncludeModule('catalog');
        $mxResult = CCatalogSku::GetProductInfo($arFields["ID"]);
        if (is_array($mxResult)) {
            $arFilter = ['IBLOCK_ID' => 19, 'ID' => $mxResult['ID']];
            $res = CIBlockElement::GetList([], $arFilter, false, false, ['NAME']);
            while($ar_fields = $res->GetNext()) {
                $name = $ar_fields['NAME'];
            }
        }
        if(!empty($name)) {
            preg_match_all('/\((.*?)\)/', $arFields['NAME'], $matches);
            if(!empty($matches)) {
                if(count($matches[0]) > 1)
                    $arFields['NAME'] = $name . ' ' . end($matches[0]);
                else
                    $arFields['NAME'] = $name . ' ' . reset($matches[0]);

            }
        }

    }

    return $arFields;
}

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");
function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
    //СОСТАВ ЗАКАЗА РАЗБИРАЕМ SALE_ORDER НА ЗАПЧАСТИ
    $strOrderList = "";
    $dbBasketItems = CSaleBasket::GetList(
        array("NAME" => "ASC"),
        array("ORDER_ID" => $orderID),
        false,
        false,
        array("PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY")
    );
    while ($arProps = $dbBasketItems->Fetch())
    {
        //ПЕРЕМНОЖАЕМ КОЛИЧЕСТВО НА ЦЕНУ
        $summ = $arProps['QUANTITY'] * $arProps['PRICE'];
        $PRODUCT_ID = $arProps['PRODUCT_ID'];

        $mxResult = CCatalogSku::GetProductInfo(
            $PRODUCT_ID
        );
        if (is_array($mxResult))
        {
            $itemid = $mxResult['ID'];
        }
        else
        {
            $itemid = $PRODUCT_ID; //('Это не торговое предложение');
        }
        $res = CIBlockElement::GetByID($itemid);

        if($ar_res = $res->GetNext()) {
            $productUrl =  $ar_res['DETAIL_PAGE_URL'];
            $image = CFile::GetPath($ar_res["DETAIL_PICTURE"]);
        }

//        $ID = $arProps['ID'];
//        $article_find = CIBlockElement::GetProperty(19, $arProps["PRODUCT_ID"], array(), Array("CODE"=>"CML2_ARTICLE"));
//        var_dump ($article_find->Fetch());
//        die();
//        if($article_value = $article_find->Fetch()) $product_article = $article_value["VALUE"];
//        else $product_article = 'No';
        $res = CIBlockElement::GetProperty(19, $itemid, array("sort" => "asc"),  Array("CODE"=>"CML2_ARTICLE"));
        if ($ob = $res->GetNext())
        {
            $ARTICLE = $ob;
        }
//        ob_start();
//        var_dump($productUrl);
        //todo разобраться с ссылками
//        $art = ob_get_clean();
//        $art =  "";
        //СОБИРАЕМ В СТРОКУ ТАБЛИЦЫ
        $strCustomOrderList .= "<tr><td><a href='". $productUrl ."'>". $ARTICLE['VALUE'] ."</a></td><td><image width='100' src='" . $image . "'/>".$arProps['NAME']."</td><td>".$arProps['QUANTITY']."</td><td>".(float)$arProps['PRICE']."</td><td>".$arProps['CURRENCY']."</td><td>".$summ."</td><tr>";
    }
    //ОБЪЯВЛЯЕМ ПЕРЕМЕННУЮ ДЛЯ ПИСЬМА
    $arFields["ORDER_TABLE_ITEMS"] = $strCustomOrderList;

    $additional_information = '';
    $arOrder = CSaleOrder::GetByID($orderID);
    $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
    while ($arProps = $order_props->Fetch()){
//        $additional_information.='id: '. ($arProps["ORDER_PROPS_ID"]).'<br>';
//        $additional_information.='val: '. ($arProps["VALUE"]).'<br>';
//        var_dump($arProps['VALUE']);
        //имя
        if ($arProps['ORDER_PROPS_ID']==1){
            $additional_information.='Имя: '.$arProps['VALUE'].'<br>';
        }
        //e-mail
        if ($arProps['ORDER_PROPS_ID']==2){
            $additional_information.='E-mail: '.$arProps['VALUE'].'<br>';
        }
        //контактный телефон
        if ($arProps['ORDER_PROPS_ID']==3){
            $additional_information.='Контактный телефон: '.$arProps['VALUE'].'<br>';
        }
        //желаемая дата и время доставки
        if ($arProps['ORDER_PROPS_ID']==20){
            $additional_information.='Желаемая дата и время доставки: '.$arProps['VALUE'].'<br>';
        }
        //Комментарий к заказу
        if ($arProps['ORDER_PROPS_ID']==23){
            $additional_information.='Комментарий к заказу: '.$arProps['VALUE'].'<br>';
        }
        //Район доставки
        if ($arProps['ORDER_PROPS_ID']==22){
            $additional_information.='Район доставки: '.$arProps['VALUE'].'<br>';
        }
        //Этаж
        if ($arProps['ORDER_PROPS_ID']==25){
            $additional_information.='Этаж: '.$arProps['VALUE'].'<br>';
        }
        //Лифт
        if ($arProps['ORDER_PROPS_ID']==26){
            $additional_information.='Лифт: '.$arProps['VALUE'].'<br>';
        }
        //Улица
        if ($arProps['ORDER_PROPS_ID']==27){
            $additional_information.='Улица: '.$arProps['VALUE'].'<br>';
        }
        //Местоположение
        if ($arProps['ORDER_PROPS_ID'] == 6){
            $db_vars = CSaleLocation::GetList(
                array(
                    "SORT" => "ASC",
                    "COUNTRY_NAME_LANG" => "ASC",
                    "CITY_NAME_LANG" => "ASC"
                ),
                array("ID" => $arProps['VALUE'], "COUNTRY_LID" => "ru", "REGION_LID" => "ru", "CITY_LID" => "ru"),
                false,
                false,
                array()
            );
            while ($vars = $db_vars->Fetch()) {
                $additional_information .= 'Регион/Город: ' . $vars["REGION_NAME"] . ", " . $vars["CITY_NAME"] . '<br>';
            }

        }
        //Дом, корпус, квартира (офис)
        if ($arProps['ORDER_PROPS_ID']==7){
            $additional_information.='Дом, корпус, квартира (офис): '.$arProps['VALUE'].'<br>';
        }



    }
    $arrPay = CSalePaySystem::GetByID((int)$arOrder["PAY_SYSTEM_ID"],(int)$arOrder["PERSON_TYPE_ID"]);
    $additional_information .= 'Способ оплаты: ' . $arrPay["NAME"] . '<br>';

    $db_dtype = CSaleDelivery::GetList(
        array(
            "SORT" => "ASC",
            "NAME" => "ASC",
        ),
        array('ACTIVE' => 'Y', "ID" => IntVal($arOrder["DELIVERY_ID"])),
        false,
        false,
        array()
    );
    while ($ar_dtype = $db_dtype->Fetch()) {
        $additional_information .= 'Способ доставки: ' . $ar_dtype["NAME"] . '<br>';
    }
    $arFields["ADDITIONAL_INFORMATION"] = $additional_information;
}


Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleBasketBeforeSaved',
    'OnSaleBasketBeforeSavedHandler'
);
function OnSaleBasketBeforeSavedHandler(Bitrix\Main\Event $event) {

    $basket = $event->getParameter("ENTITY");
    $basketItems = $basket->getBasketItems();
    foreach ($basketItems as $basketItem) {
        $basketPropertyCollection = $basketItem->getPropertyCollection();
        $arProps = $basketPropertyCollection->getPropertyValues();

        if(empty($arProps['CML2_ARTICLE'])) {
            $mxResult = CCatalogSku::GetProductInfo($basketItem->getProductId());
            if (is_array($mxResult)) {
                $productID = $mxResult['ID'];
            }
            else {
                $productID = $basketItem->getProductId();
            }
            $db_props = CIBlockElement::GetProperty(19, $productID, [], ['CODE' => 'CML2_ARTICLE']);
            if($ar_props = $db_props->Fetch())
                $article = $ar_props["VALUE"];

            $basketPropertyCollection->setProperty(array(
                array(
                    'NAME' => 'Артикул',
                    'CODE' => 'CML2_ARTICLE',
                    'VALUE' => $article,
                    'SORT' => 100,
                ),
            ));
            $basketPropertyCollection->save();
        }
    }

    return new Bitrix\Main\EventResult(Bitrix\Main\EventResult::SUCCESS);
}

//Pixite Цена уценки
function getOldPrice($elementID, $arOffers, $iblockID) {
    $ucenka = 0;
    $utsenka_show = false;
    $db_groups = CIBlockElement::GetElementGroups($elementID, true, ['ID', 'CODE']);
    while($ar_group = $db_groups->Fetch())
        $arSections[] = $ar_group;
    foreach($arSections as $section) {
        if($section["CODE"] == "utsenka" || $section["CODE"] == 'tovary_so_skidkoy')
            $utsenka_show = true;
    }

    if($utsenka_show) {
        foreach($arOffers as $offer) {
            if(!empty($offer["PROPERTIES"]["UCENKA"]["VALUE"]) && IntVal($offer["PROPERTIES"]["UCENKA"]["VALUE"]) > 0)
                $ucenka = IntVal($offer["PROPERTIES"]["UCENKA"]["VALUE"]);
            else {

                $db_props = CIBlockElement::GetProperty($iblockID, $offer["PROPERTIES"]["CML2_LINK"]["VALUE"], array("sort" => "asc"), Array("CODE"=>"UCENKA"));
                if($ar_props = $db_props->Fetch())
                    $ucenka = IntVal($ar_props["VALUE"]);
            }
        }
    }

    return $ucenka;
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnIBlockElementEditHandler");
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnIBlockElementEditHandler");

//Pixite bela обработчик при изменении товара start
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterIBlockElementUpdateHandler");
function OnAfterIBlockElementUpdateHandler(&$arFields)
{
    if($arFields['IBLOCK_ID'] == 19) {

        $arrayID = array(4446);
        $arFilter = Array('IBLOCK_ID'=>19, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>4446);
        $db_list = CIBlockSection::GetList(Array(), $arFilter, true);
        while($ar_result = $db_list->GetNext())
        {
            $arrayID[] = $ar_result['ID'];
        }

        $arSections = [];
        $change_property = false;
        $arPropertyArchive = [];
        $db_groups = CIBlockElement::GetElementGroups($arFields["ID"], true, ['ID']);
        while($ar_group = $db_groups->Fetch())
            $arSections[] = $ar_group['ID'];

        foreach($arSections as $section) {
            if (in_array($section, $arrayID)){
                $change_property = true;
            }
        }




        if ($change_property){
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => $arFields["IBLOCK_ID"], "CODE" => "SPECIALOFFER"));
            while($enum_fields = $property_enums->GetNext()) {
                /* Если значение равно "Да" */
                if ($enum_fields["VALUE"] == "да") {
                    $arPropertyArchive = Array(
                        "SPECIALOFFER" => $enum_fields["ID"],
                    );
                }
            }
            // Установим новое значение для данного свойства данного элемента
            CIBlockElement::SetPropertyValuesEx($arFields["ID"], false, $arPropertyArchive);
        }
        else {
            CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arFields["IBLOCK_ID"], array("SPECIALOFFER"=>""));
        }
    }
}
//Pixite bela обработчик при изменении товара end
function OnIBlockElementEditHandler(&$arFields) {
    if($arFields['IBLOCK_ID'] == 19) {
        $date_compare =  date('d.m.Y H:i:s', strtotime("-30 days"));
        $dbItem = \Bitrix\Iblock\ElementTable::getList([
            'filter' => [
                'ID' => $arFields['ID'],
                'IBLOCK_ID' => $arFields['IBLOCK_ID'],
                'ACTIVE' => 'Y',
            ],
            'select' => ['ID', 'DATE_CREATE']
        ]);
        while ($arItem = $dbItem->fetch()) {
            if(strtotime($arItem['DATE_CREATE']->toString()) >= strtotime($date_compare)) {
                CIBlockElement::SetPropertyValueCode($arItem['ID'], "NEWPRODUCT", ['VALUE' => 1762]);
                CIBlockElement::SetPropertyValueCode($arItem['ID'], "DATE_NEW", ['VALUE' => $arItem['DATE_CREATE']->toString()]);
            }
            else {
                $dbProperty = \CIBlockElement::getProperty($arFields['IBLOCK_ID'], $arItem['ID'], [], ['CODE' => 'NEWPRODUCT']);
                while ($arProperty = $dbProperty->GetNext()) {
                    if ($arProperty['VALUE']) {
                        $new = $arProperty['VALUE'];
                    }
                }
            }
            if($new) {
                CIBlockElement::SetPropertyValueCode($arItem['ID'], "NEWPRODUCT", ['VALUE' => '']);
                CIBlockElement::SetPropertyValueCode($arItem['ID'], "DATE_NEW", ['VALUE' => '']);
            }
        }
    }
}