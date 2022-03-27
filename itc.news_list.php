<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$pattern = '#^/reference/prodazha_torgovogo_oborudovaniya/#';
?>
    <div class="product__wrap"<? if (preg_match($pattern, $APPLICATION->GetCurPage())): ?>"product__wrap"<? else: ?>"product__wrap_list"<? endif ?>>
    <div class="products-box__wrap products-box__wrap_new">
        <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="products-box__item <?= (!empty($arItem["PROPERTIES"]['ACTION']["VALUE"]) ? ' products-box__item_action' : (!empty($arItem["PROPERTIES"]['NEW_PRODUCTS']["VALUE"]) ? ' products-box__item_new' : '')) ?>"
                 id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="element-title page-form__wrap">
                <span class="">
                    <?= $arItem["NAME"] ?>
                </span>
                </div>
                <div class="element-body">
                    <? if (!empty($arItem["PREVIEW_TEXT"])): ?>
                        <?= $arItem["PREVIEW_TEXT"] ?>
                    <? endif; ?>
                </div>
                <div class="element-bottom">
                    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="btn btn-primary">
                        Подробнее
                    </a>
                </div>
            </div>
        <? endforeach; ?>
    </div>
<?if(!$_REQUEST["count"]):?>
    <div class="button_block">
        <button href="<?=$arResult['count']?>" class="all_services_button btn-circle btn btn-primary">Все сервисы 1С:ИТС</button>
    </div>
<?endif;?>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>
    </div>
<?
$sectionLVL = count(arResult['SECTION']['PATH']);
?>
<pre> { "type": "ВыгрузкаЦен", "value":
    { "ИдентификаторДокумента": "60648bb7-3848-40b7-a1bc-623cf8776e7c", "ДатаДокумента": "2022-02-16T16:35:44", "МассивСтрок": [ { "Номенклатура": "", "ВидЦены": "", "Цена": "0" }, { "Номенклатура": "", "ВидЦены": "", "Цена": "0" }, { "Номенклатура": "", "ВидЦены": "", "Цена": "0" } ] } }</pre>