<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$this->addExternalCss(SITE_TEMPLATE_PATH . "/lib/lightGallery/lightgallery.min.css");
$this->addExternalJS(SITE_TEMPLATE_PATH . "/lib/lightGallery/picturefill.min.js");
$this->addExternalJS(SITE_TEMPLATE_PATH . "/lib/lightGallery/jquery.mousewheel.min.js");
$this->addExternalJS(SITE_TEMPLATE_PATH . "/lib/lightGallery/lightgallery-all.min.js"); ?>
<? if ($arResult['CODE'] == 'analiz_dvizheniya_denezhnykh_sredstv_predpriyatiya'): ?>
    <? require_once 'analiz-dvizheniya-denezhnykh-sredstv-predpriyatiya-vr2.php'; ?>
<? else: ?>
    <? if (!empty($arResult['SECTION_INFO']))
        $APPLICATION->SetTitle($arResult['SECTION_INFO']["NAME"]);
    ?>
    <div class="product-description">
        <div class="product-description__head">
            <div class="product-description__head-product">
                <? $arImg = [];
                if (!empty($arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"]["SRC"])) {
                    $arImg = $arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"];
                } elseif (!empty($arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"])) {
                    foreach ($arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"] as $arItem) {
                        $arImg[] = $arItem;
                    }
                } elseif (!empty($arResult["DETAIL_PICTURE"]))
                    $arImg = $arResult["DETAIL_PICTURE"];
                elseif (!empty($arResult["PREVIEW_PICTURE"]))
                    $arImg = $arResult["PREVIEW_PICTURE"]; ?>
                <? if (!empty($arImg)): ?>
                    <div class="product-description__head-product_img <?= (!empty($arResult["PROPERTIES"]['ACTION']["VALUE"]) ? ' product-description__head-product_img-action' : (!empty($arResult["PROPERTIES"]['NEW_PRODUCTS']["VALUE"]) ? ' product-description__head-product_img-new' : '')) ?>">
                        <? if ($arImg['SRC']): ?>
                            <img src="<?= $arImg['SRC'] ?>" alt="<?= $arResult['NAME'] ?>">
                        <? else: ?>
                            <div id="slider_detail">
                                <? foreach ($arImg as $arItem): ?>
                                    <img src="<?= $arItem['SRC'] ?>" alt="<?= $arResult['NAME'] ?>">
                                <? endforeach; ?>
                            </div>
                        <? endif ?>
                    </div>
                <? endif; ?>
                <? if (!$arImg['SRC'] && count($arImg < 3)): ?>
                    <div class="product-description__head-product_min-img">
                        <div id="slider_pagination">
                            <? foreach ($arImg as $arItem): ?>
                                <div class="product-description__head-product_min-img_item">
                                    <img style="height: 100%; display: inline-block;" src="<?= $arItem['SRC'] ?>"
                                         alt="<?= $arResult['NAME'] ?>">
                                </div>
                            <? endforeach ?>
                        </div>
                    </div>
                    <div class="product-description__head-product_price">
                        <? if ($arResult['PROPERTIES']['PRICE']['VALUE']): ?>
                            <?= $arResult['PROPERTIES']['PRICE']['VALUE'] ?> руб.
                        <? endif ?>
                    </div>
                <? endif; ?>
                <? if (!empty($arResult["PROPERTIES"]['SHOW']["VALUE"])): ?>
                    <a href="<?= $arResult["PROPERTIES"]['SHOW']["VALUE"] ?>"
                       class="product-description__head-product_demo">
                        Демонстрация продукта
                    </a>
                <? endif; ?>
                <!--                <a href="javascript:void(0);" style = "bottom: 23px;"class="product-description__head-product_btn send-message" data-product='-->
                <? //=$arResult['NAME']?><!--'>-->
                <!--                    Заказать-->
                <!--                </a>-->
            </div>
            <div class="product-description__head-info">
                <div class="product-description__head-info_h3 h3">
                    <h3><?= $arResult['NAME'] ?></h3>
                </div>
                <? if (!empty($arResult["PROPERTIES"]['PREVIEW_TEXT']["VALUE"])): ?>
                    <div class="product-description__head-info_text blue_text">
                        <?= $arResult["PROPERTIES"]['PREVIEW_TEXT']["~VALUE"]['TEXT'] ?>
                    </div>
                <? else: ?>
                    <div class="product-description__head-info_text blue_text">
                        <?= $arResult["~PREVIEW_TEXT"] ?>
                    </div>
                <? endif; ?>
            </div>
        </div>
        <? if (!empty($arResult["PROPERTIES"]['DETAIL_TEXT']["VALUE"])): ?>
            <div class="product-description__head-info_detail" id='detail-text-btn'>
                <a href="javascript:void(0);" class="a-style product-description__head-info_detail-link">
				<span class="a-style__text">
					Подробное описание
				</span>
                </a>
                <span class="product-description__head-info_detail-ico">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd"
                      d="M18.809 10.8894L18.809 8.90955L10.8894 8.90955L10.8894 0.989949H8.90946L8.90946 8.90955L0.989869 8.90955L0.989869 10.8894L8.90946 10.8894V18.809H10.8894V10.8894L18.809 10.8894Z"
                      fill="#BBC5CD"/>
				</svg>
			</span>
            </div>
            <div class="product-description__head-info_text hidden" id='detail-text'>
                <?= $arResult["DETAIL_TEXT"] ?>
            </div>
            <div class="product-description__head-info_detail hidden" id='detail-text-hidden-btn'>
                <a href="javascript:void(0);" class="a-style product-description__head-info_detail-link">
				<span class="a-style__text">
					Свернуть описание
				</span>
                </a>
                <span class="product-description__head-info_detail-ico">
				<svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd"
                      d="M12.6 14.8994L14 13.4994L8.4 7.89941L14 2.29941L12.6 0.899414L7 6.49941L1.4 0.899414L0 2.29941L5.6 7.89941L0 13.4994L1.4 14.8994L7 9.29941L12.6 14.8994Z"
                      fill="#BBC5CD"/>
				</svg>
			</span>
            </div>
        <? endif; ?>
        <? if (count($arResult['DISPLAY_PROPERTIES']['IMAGES']['FILE_VALUE']) > 0): ?>
            <div class="review-photo__photos lightgallery">
                <? foreach ($arResult['DISPLAY_PROPERTIES']['IMAGES']['FILE_VALUE'] as $IMAGE): ?>
                    <a class="review-photo__photos_item" href='<?= $IMAGE['SRC'] ?>'
                       id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                        <img style="height: auto; width: 250px" src="<? echo $IMAGE['SRC'] ?>">
                    </a>
                <? endforeach; ?>
            </div>
        <? endif; ?>
    </div>
    <? if (!empty($arResult['SALES']) && count($arResult['SALES']) > 0): ?>
        <div class="product-description__slider">
            <? foreach ($arResult['SALES'] as $sale): ?>
                <div>
                    <div class="product-description__slide" style='background-image: url(<?= $sale['IMG'] ?>)'>
                        <div class="d-flex justify-content-center d-md-block">
                            <div class="slider-action__slide_date">
                                <?= $sale['DATE'] ?>
                            </div>
                        </div>
                        <div class="">
                            <div class="slider-action__slide_text">
                                <? if (!empty($sale['TEXT'])): ?>
                                    <div class="slider-action__slide_title">
                                        <h3>
                                            <?= $sale['TITLE'] ?>
                                        </h3></div>
                                    <div class="slider-action__slide_title-min">
                                        <?= $sale['TEXT'] ?>
                                    </div>
                                <? endif; ?>
                                <div class="slider-action__slide_btn-wrap">
                                    <a href="<?= $sale['URL'] ?>" class="slider-action__slide_btn">
                                        Подробнее
                                        <span class="slider-action__slide_btn-arrow">
											<svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M8.39062 0.92627L6.99062 2.32627L12.5906 7.92627H0.390625V9.92627H12.5906L6.99062 15.5263L8.39062 16.9263L16.3906 8.92627L8.39062 0.92627Z"
                                                  fill="white"/>
											</svg>
										</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    <? endif; ?>
    <? if (stripos($APPLICATION->GetCurPage(), "1C_products")): ?>
        <div class="product-description__tabs d-none d-md-flex">
            <!--<div class="product-description__tabs_item product-description__tabs_item-active" data-tab='versoins'>
                Версии
            </div>-->
            <div class="product-description__tabs_item product-description__tabs_item-active" data-tab='variants'>
                Варианты поставок
            </div>
            <div class="product-description__tabs_item" data-tab='licencies'>
                Лицензии
            </div>
        </div>
        <div class="product-description__tabs_mob d-block d-md-none">
            <select class="product__select-list_item-list">
                <option class="introduction-head__select-item_list-item" value='versoins'>Версии</option>
                <option class="introduction-head__select-item_list-item" value='variants'>Варианты поставок</option>
                <option class="introduction-head__select-item_list-item" value='licencies'>Лицензии</option>
            </select>
        </div>
        <div class="product-description__variants product-description__tab" id='variants'>
            <div class="product-description__version_h3 h3">
                <h3>Варианты поставок</h3>
            </div>
            <div class="product-description__variants_wrap">
                <? if (!empty($arResult['PRODUCT_VARIANTS']) && count($arResult['PRODUCT_VARIANTS']) > 0):
                    foreach ($arResult['PRODUCT_VARIANTS'] as $variant):
                        if (!empty($variant['OLD_PRICE']) && $variant['OLD_PRICE'] != $variant['PRICE'])
                            $action = true;
                        ?>
                        <div class="product-description__variants-row <?= ($action ? ' product-description__variants-row_action' : '') ?>">
							<span class="product-description__variants-row_text">
								<?= $variant['NAME'] ?>
                                <?
                                if (!empty($variant['TIME'])):?>
                                    <span class="product-description__variants-row_text-time">
										<?= $variant['TIME'] ?>*
									</span>
                                <?endif; ?>
							</span>
                            <span class="product-description__variants-row_price">
								<?
                                if ($action):?>
                                    <span class="product-description__variants-row_price-low">
										<?= $variant['OLD_PRICE'] ?> руб.
									</span>
                                <?endif; ?>
                                <?= $variant['PRICE'] ?> руб.
							</span>
                            <a class="product-description__variants-row_btn send-message">
                                Заказать
                            </a>
                        </div>
                        <?
                        $action = false;
                    endforeach;
                endif;
                ?>
                <div class="product-description__variants_explanation">
                    * дополнительное количество часов работы специалиста по внедрению и настройке 1С, входящее в
                    стоимость покупки
                </div>
            </div>
        </div>

        <div class="product-description__variants hidden product-description__tab" id='licencies'>
            <div class="product-description__version_h3 h3">
                <h3>Лицензии</h3>
            </div>
            <div class="product-description__variants_wrap">
                <?
                if (empty($arResult['LICENCES'])) {
                    for ($i = 0; $i <= count($arResult["DISPLAY_PROPERTIES"]["doplic"]["DESCRIPTION"]); $i++) {
                        if ($arResult["DISPLAY_PROPERTIES"]["doplic"]["DESCRIPTION"][$i]) { ?>
                            <!-- Добавляем клас product-description__variants-row_action для акции -->
                            <div class="product-description__variants-row">
								<span class="product-description__variants-row_text">
									<?= $arResult["DISPLAY_PROPERTIES"]["doplic"]["DESCRIPTION"][$i] ?>
								</span>
                                <span class="product-description__variants-row_price">
									<?= $arResult["DISPLAY_PROPERTIES"]["doplic"]["VALUE"][$i] ?> руб.
								</span>
                                <a href="javascript:void(0);" class="product-description__variants-row_btn send-message"
                                   data-product='<?= $arResult['NAME'] ?>'>
                                    Заказать
                                </a>
                            </div>
                        <?
                        }
                    }
                } else {
                    foreach ($arResult['LICENCES'] as $licence):?>
                        <!-- Добавляем клас product-description__variants-row_action для акции -->
                        <div class="product-description__variants-row">
							<span class="product-description__variants-row_text">
								<?= $licence["NAME"] ?>
							</span>
                            <span class="product-description__variants-row_price">
								<?= $licence["PRICE"] ?> руб.
							</span>
                            <a href="javascript:void(0);" class="product-description__variants-row_btn send-message"
                               data-product='<?= $arResult['NAME'] ?>'>
                                Заказать
                            </a>
                        </div>
                    <?endforeach;
                }
                ?>
            </div>
        </div>

    <? endif; ?>


    <? if (!empty($arResult["PROPERTIES"]['version_comparison']["VALUE"])):
        $arCompare = explode('|', $arResult["PROPERTIES"]['version_comparison']["VALUE"]['TEXT']);
        ?>
        <div class="">
            <div class="product-description__comparison_h3 h3">
                Сравнение версий
            </div>
            <div class="product-description__comparison-table d-none d-md-block">
                <div class="product-description__comparison-table_head">
                    <?
                    $arCompareHead = explode(';', $arCompare[0]);
                    foreach ($arCompareHead as $key_elem => $elem):
                        if ($key_elem == 0):
                            ?>
                            <div class="product-description__comparison-table_head-space"></div>
                        <? else:?>
                            <span class="product-description__comparison-table_head-text"><?= $elem ?></span>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
                <? foreach ($arCompare as $key_row => $row):
                    if ($key_row == 0) continue;
                    $arCompareRow = explode(';', $row); ?>
                    <div class="product-description__comparison-table_row">
                        <span class="product-description__comparison-table_row-text"><?= $arCompareRow[0] ?></span>
                        <? foreach ($arCompareRow as $key_elem => $elem):
                            if ($key_elem == 0) continue;
                            if ($elem == '+'):?>
                                <span class="product-description__comparison-table_row-ico">
										<svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5.6 11.1L1.4 6.9L0 8.3L5.6 13.9L17.6 1.9L16.2 0.5L5.6 11.1Z"
                                              fill="#27AE60"/>
										</svg>
									</span>
                            <? else:?>
                                <span class="product-description__comparison-table_row-ico">
										<svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M14 1.9L12.6 0.5L7 6.1L1.4 0.5L0 1.9L5.6 7.5L0 13.1L1.4 14.5L7 8.9L12.6 14.5L14 13.1L8.4 7.5L14 1.9Z"
                                                  fill="#E9E9E9"/>
										</svg>
									</span>
                            <? endif; ?>
                        <? endforeach; ?>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="product-description__comparison-slider d-block d-md-none">
                <div class="product-description__comparison-slider_head slider-for">
                    <?
                    $arCompareHead = explode(';', $arCompare[0]);
                    foreach ($arCompareHead as $key_elem => $elem):
                        if ($key_elem == 0):
                            ?>
                        <? else:?>
                            <div class="product-description__comparison-slider_head-item">
									<span class="product-description__comparison-table_head-text">
										<?= $elem ?>
									</span>
                            </div>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
                <div class="d-block d-md-none min-slider__arrow_white min-slider__arrow_left">
                    <div class="min-slider__arrow_ico min-slider__arrow_ico-left">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.54" fill-rule="evenodd" clip-rule="evenodd"
                                  d="M8.99414 16.4629L10.3941 15.0629L4.79414 9.46289L16.9941 9.46289L16.9941 7.46289L4.79414 7.46289L10.3941 1.86289L8.99414 0.46289L0.994141 8.46289L8.99414 16.4629Z"
                                  fill="#0067C2"/>
                        </svg>
                    </div>
                </div>
                <div class="min-slider__arrow_white min-slider__arrow_right d-block d-md-none">
                    <div class="min-slider__arrow_ico min-slider__arrow_ico-right">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.54" fill-rule="evenodd" clip-rule="evenodd"
                                  d="M8.00586 0.462891L6.60586 1.86289L12.2059 7.46289H0.00585938V9.46289H12.2059L6.60586 15.0629L8.00586 16.4629L16.0059 8.46289L8.00586 0.462891Z"
                                  fill="#0067C2"/>
                        </svg>
                    </div>
                </div>
                <div class="product-description__comparison-slider_items slider-nav">
                    <?
                    for ($i = 1; $i <= count($arCompareHead) - 1; $i++) { ?>
                        <div class="product-description__comparison-slider_item">
                            <? foreach ($arCompare as $key_row => $row):
                                $arCompareRow = explode(';', $row);
                                if ($key_row == 0 || empty($arCompareRow[0]) || count($arCompareRow) <= 1) continue;
                                ?>

                                <div class="product-description__comparison-table_row">
                                    <span class="product-description__comparison-table_row-text"><?= $arCompareRow[0] ?></span>
                                    <? if ($arCompareRow[$i] == '+'):?>
                                        <span class="product-description__comparison-table_row-ico">
													<svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd"
                                                          d="M5.6 11.1L1.4 6.9L0 8.3L5.6 13.9L17.6 1.9L16.2 0.5L5.6 11.1Z"
                                                          fill="#27AE60"/>
													</svg>
												</span>
                                    <? else:?>
                                        <span class="product-description__comparison-table_row-ico">
													<svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M14 1.9L12.6 0.5L7 6.1L1.4 0.5L0 1.9L5.6 7.5L0 13.1L1.4 14.5L7 8.9L12.6 14.5L14 13.1L8.4 7.5L14 1.9Z"
                                                              fill="#E9E9E9"/>
													</svg>
												</span>
                                    <? endif; ?>
                                </div>
                            <? endforeach; ?>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    <? endif; ?>
    <? if (!empty($arResult['PROPERTIES']['TAB1_TITLE']['VALUE']) || !empty($arResult['PROPERTIES']['TAB2_TITLE']['VALUE']) || !empty($arResult['PROPERTIES']['TAB3_TITLE']['VALUE'])): ?>
        <div class="product-description__tabs_mob d-block d-md-none">
            <select class="product__select-list_item-list">
                <? if (!empty($arResult['PROPERTIES']['TAB1_TITLE']['VALUE'])): ?>
                    <option class="introduction-head__select-item_list-item"
                            value='versoins'><?= $arResult['PROPERTIES']['TAB1_TITLE']['VALUE'] ?></option>
                <? endif ?>
                <? if (!empty($arResult['PROPERTIES']['TAB2_TITLE']['VALUE'])): ?>
                    <option class="introduction-head__select-item_list-item"
                            value='variants'><?= $arResult['PROPERTIES']['TAB2_TITLE']['VALUE'] ?></option>
                <? endif ?>
                <? if (!empty($arResult['PROPERTIES']['TAB3_TITLE']['VALUE'])): ?>
                    <option class="introduction-head__select-item_list-item"
                            value='licencies'><?= $arResult['PROPERTIES']['TAB3_TITLE']['VALUE'] ?></option>
                <? endif ?>
            </select>
        </div>
    <? endif ?>

    <? if (!empty($arResult['PROPERTIES']['TAB1_TEXT']['VALUE'])): ?>
        <div class="product-description__tab" id='tab1'>
            <div class="product-description__version_h3 h3">
                <h3><?= $arResult['PROPERTIES']['TAB1_TITLE']['VALUE'] ?></h3>
            </div>
            <div class="product-description__version_wrap">
                <?= $arResult['PROPERTIES']['TAB1_TEXT']['~VALUE']['TEXT'] ?>
            </div>
        </div>
    <? endif ?>
    <? if (is_array($arResult['PROPERTIES']['TAB1_TEXT']['VALUE'])): ?>
        <div class="benefit_block">
        <div class="">
    <? endif; ?>
    <? foreach ($arResult['PROPERTIES']['TAB1_TEXT']['VALUE'] as $key => $PROPERTY): ?>
        <? if ((count($arResult['PROPERTIES']['TAB1_TEXT']['VALUE']) - $key) < $key && $key - (count($arResult['PROPERTIES']['TAB1_TEXT']['VALUE']) - $key) < 2): ?>
            </div>
            <div class="">
        <? endif; ?>
        <div class="products-box__item product-description__version_wrap">
            <div class="element-title">
                <span class="benefit_title"><? echo $arResult['PROPERTIES']['TAB1_TEXT']['DESCRIPTION'][$key]; ?></span>
                <span class="arrow_img"><img src="/local/templates/itc2019/images/arrow_up.svg" alt="arrow"></span>
            </div>
            <div class="element-body hidden">
                <? echo $PROPERTY['TEXT']; ?>
            </div>
        </div>
        <? if ($key == count($arResult['PROPERTIES']['TAB1_TEXT']['VALUE']) - 1): ?>
            </div>
            </div>
        <? endif; ?>
    <? endforeach; ?>
    <? if (!empty($arResult['PROPERTIES']['TAB2_TEXT']['VALUE'])): ?>
        <div class="product-description__tab" id='tab2'>
            <div class="product-description__version_h3 h3">
                <h3><?= $arResult['PROPERTIES']['TAB2_TITLE']['VALUE'] ?></h3>
            </div>
            <div class="product-description__variants_wrap">
                <?= $arResult['PROPERTIES']['TAB2_TEXT']['~VALUE']['TEXT'] ?>
            </div>
        </div>
    <? endif ?>

    <? foreach ($arResult['PROPERTIES']['TAB2_TEXT']['VALUE'] as $key => $PROPERTY): ?>
        <div class="products-box__item tab2_item">
            <div class="tab2-title blue_text">
                <span><? echo $arResult['PROPERTIES']['TAB2_TEXT']['DESCRIPTION'][$key]; ?></span>
            </div>
            <div class="tab2-body">
                <? echo $PROPERTY['TEXT']; ?>
            </div>
        </div>
    <? endforeach; ?>
    <? if (!empty($arResult['PROPERTIES']['TAB3_TEXT']['VALUE'])): ?>
        <div class="product-description__variants product-description__tab" id='tab3'>
            <div class="product-description__version_h3 h3">
                <h3><?= $arResult['PROPERTIES']['TAB3_TITLE']['VALUE'] ?></h3>
            </div>
            <div class="product-description__variants_wrap">
                <?= $arResult['PROPERTIES']['TAB3_TEXT']['~VALUE']['TEXT'] ?>
            </div>
        </div>
    <? endif ?>
    <?
    $arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "PROPERTY_PRICE", "PROPERTY_QUANTITY");
    $arFilter = Array("ID" => $arResult['PROPERTIES']['PRICE_NEW']['VALUE']);
    $res = CIblockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields(); ?>
        <div class='products-box__item grey_background tab3_item'>
            <div class='tab3_content'>
                <div class='tab3-title blue_text'><?= $arFields['NAME'] ?></div>
                <div class='tab3-text'><?= $arFields['PREVIEW_TEXT'] ?></div>
            </div>
            <div class='tab3-price'>
                <?
                if ($arFields['PROPERTY_PRICE_VALUE']) { ?>
                    <div class='tab3-price_value'><?= $arFields['PROPERTY_PRICE_VALUE'] ?></div>
                <?
                } ?>
                <?
                if ($arFields['PROPERTY_PRICE_VALUE']) { ?>
                    <div class='tab3-price_quantity'><?= $arFields['PROPERTY_QUANTITY_VALUE'] ?></div>
                <?
                } ?>
                <button href="#" class="btn-circle company__btn btn btn-primary">Заказать</button>
            </div>
        </div>
    <?
    }
    ?>
    <!--    --><? //foreach ($arResult['PROPERTIES']['TAB3_TEXT']['VALUE']  as $key => $PROPERTY):?>
    <!--        <div class="products-box__item tab3_item">-->
    <!--            <div class="tab3-title">-->
    <!--                <span>--><? //echo $arResult['PROPERTIES']['TAB3_TEXT']['DESCRIPTION'][$key];?><!--</span>-->
    <!--            </div>-->
    <!--            <div class="tab3-body">-->
    <!--                --><? //echo $PROPERTY['TEXT'];?>
    <!--            </div>-->
    <!--        </div>-->
    <!--    --><? //endforeach;?>

    </div>
    <? if (!empty($arResult["PRODUCT_LIST"])): ?>
        <div class="product-description__vacancies">
            <div class="product-description__vacancies_h3 h3_my">
                <h3>
                    Подзаголовок
                </h3>
            </div>
            <? foreach ($arResult["PRODUCT_LIST"] as $arItem): ?>
                <div class="row" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="col-12">
                        <div class="vacancies__item">
                            <div class="vacancies__item_title d-flex justify-content-between align-items-center">
                                <p><?= $arItem["NAME"] ?></p>
                                <span class="vacancies__item_title-ico vacancies__item_title-ico">
            <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6 0L6 4.6L1.4 0L0 1.4L6 7.4L12 1.4L10.6 0Z"
                  fill="#0067C2"/>
            </svg>
          </span>
                            </div>
                            <div class="vacancies__item_text">
                                <? if (!empty($arItem["PREVIEW_TEXT"])): ?>
                                    <?= $arItem["PREVIEW_TEXT"] ?>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    <? endif ?>
    <?
    $this->SetViewTarget('product_detail');

    $APPLICATION->IncludeFile('/includes/catalog/services.php', Array(), Array("MODE" => "html"));

    if (!empty($arResult['CLIENTS'])) { ?>
        <section class="company company_catalog">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="company__h3 h3">
                            <h3>Данный продукт работает
                                у наших клиентов:</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-none d-md-block col-md-1 col-lg-1 col-xl-1">
                        <div class="company__arrow  company__arrow_left">
                            <svg width="69" height="21" viewBox="0 0 69 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.3918 21L12.2103 19.1625L4.93608 11.8125L69 11.8125V9.1875L4.93608 9.1875L12.2103 1.8375L10.3918 0L0 10.5L10.3918 21Z"
                                      fill="#76B0E3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="col-12 col-md-10 col-lg-10 col-xl-10">
                        <div class="company__logos-products">
                            <? foreach ($arResult['CLIENTS'] as $client): ?>
                                <div class="company__logo">
                                    <? if (!empty($client['URL'])): ?>
                                    <a href='<?= $client['URL'] ?>'>
                                        <? endif; ?>
                                        <img src="<?= $client['IMG']['src'] ?>" alt="<?= $client['NAME'] ?>">
                                        <? if (!empty($client['URL'])): ?>
                                    </a>
                                <? endif; ?>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-1 col-lg-1 col-xl-1">
                        <div class="company__arrow company__arrow_right">
                            <svg width="69" height="21" viewBox="0 0 69 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M58.6082 0L56.7897 1.8375L64.0639 9.1875H0V11.8125H64.0639L56.7897 19.1625L58.6082 21L69 10.5L58.6082 0Z"
                                      fill="#76B0E3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="d-block d-md-none min-slider__arrow_white min-slider__arrow_left company__arrow_left-m">
                        <div class="min-slider__arrow_ico min-slider__arrow_ico-left">
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.54" fill-rule="evenodd" clip-rule="evenodd"
                                      d="M8.99414 16.4629L10.3941 15.0629L4.79414 9.46289L16.9941 9.46289L16.9941 7.46289L4.79414 7.46289L10.3941 1.86289L8.99414 0.46289L0.994141 8.46289L8.99414 16.4629Z"
                                      fill="#0067C2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="min-slider__arrow_white min-slider__arrow_right  company__arrow_right-m d-block d-md-none">
                        <div class="min-slider__arrow_ico min-slider__arrow_ico-right">
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.54" fill-rule="evenodd" clip-rule="evenodd"
                                      d="M8.00586 0.462891L6.60586 1.86289L12.2059 7.46289H0.00585938V9.46289H12.2059L6.60586 15.0629L8.00586 16.4629L16.0059 8.46289L8.00586 0.462891Z"
                                      fill="#0067C2"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Company					   				end -->
    <? } ?>

    <? if (!empty($arResult['PRODUCTS'])) { ?>
        <!-- interest	                              begin -->
        <section class="interest">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="interest__h3 h3">
                            <h3>Также, вас могут заинтересовать</h3>
                        </div>
                    </div>
                </div>
                <div class="row interest__items">
                    <? foreach ($arResult['PRODUCTS'] as $product): ?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="interest__item">
                                <div class="interest__item_ico">
                                    <? if (empty($product['IMG'])): ?>
                                        <svg width="125" height="125" viewBox="0 0 125 125" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M124.85 58.3333C122.8 27.1333 97.8667 2.19167 66.6667 0.141667V0H62.5H58.3333V0.141667C27.1333 2.19167 2.19167 27.1333 0.141667 58.3333H0V62.5V66.6667H0.141667C2.19167 97.8667 27.1333 122.8 58.3333 124.85V125H62.5H66.6667V124.85C97.8667 122.8 122.8 97.8667 124.85 66.6667H125V62.5V58.3333H124.85ZM39.125 13.625C35.1 18.975 31.7583 25.6833 29.325 33.3333H16.8417C22.275 24.8583 29.9917 18 39.125 13.625ZM12.4833 41.6667H27.1333C26.0167 46.9333 25.3083 52.525 25.0833 58.3333H8.49167C8.93333 52.4667 10.3167 46.8583 12.4833 41.6667ZM8.49167 66.6667H25.0833C25.3083 72.475 26.0167 78.0667 27.1333 83.3333H12.4833C10.3167 78.1417 8.93333 72.5333 8.49167 66.6667ZM16.8417 91.6667H29.3167C31.75 99.3167 35.0917 106.025 39.125 111.375C29.9917 107 22.275 100.15 16.8417 91.6667ZM58.3333 116.133C49.7667 113.842 42.3917 104.642 37.9167 91.6667H58.3333V116.133ZM58.3333 83.3333H35.575C34.4 78.1417 33.6583 72.5333 33.4167 66.6667H58.3333V83.3333ZM58.3333 58.3333H33.4167C33.6583 52.4667 34.4 46.8583 35.575 41.6667H58.3333V58.3333ZM58.3333 33.3333H37.9167C42.3917 20.3583 49.7667 11.1583 58.3333 8.875V33.3333ZM108.158 33.3333H95.6917C93.25 25.6833 89.9167 18.975 85.875 13.625C95 18 102.725 24.8583 108.158 33.3333ZM66.6667 8.875C75.225 11.1583 82.6083 20.3583 87.0833 33.3333H66.6667V8.875ZM66.6667 41.6667H89.4167C90.6 46.8583 91.325 52.4667 91.5833 58.3333H66.6667V41.6667ZM66.6667 66.6667H91.5833C91.3417 72.5333 90.6 78.1417 89.4167 83.3333H66.6667V66.6667ZM66.6667 116.133V91.6667H87.0833C82.6083 104.642 75.225 113.842 66.6667 116.133ZM85.875 111.375C89.9 106.017 93.25 99.3167 95.6917 91.6667H108.158C102.725 100.15 95 107 85.875 111.375ZM112.517 83.3333H97.8667C98.9833 78.0667 99.6917 72.475 99.9167 66.6667H116.5C116.067 72.5333 114.683 78.1417 112.517 83.3333ZM99.9167 58.3333C99.6917 52.525 98.9833 46.9333 97.8667 41.6667H112.517C114.683 46.8583 116.067 52.4667 116.508 58.3333H99.9167Z"
                                                  fill="#E4E4E4"/>
                                        </svg>
                                    <? else: ?>
                                        <img src='<?= $product['IMG'] ?>' alt='<?= $product['NAME'] ?>'/>
                                    <? endif; ?>
                                </div>
                                <div class="interest__item_link">
                                    <a href="<?= $product['URL'] ?>" class="a-style">
									<span class="a-style__text">
										<?= $product['NAME'] ?>
									</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
                <? /*<div class="d-block d-md-none min-slider__arrow_white min-slider__arrow_left">
				<div class="min-slider__arrow_ico min-slider__arrow_ico-left">
					<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path opacity="0.54" fill-rule="evenodd" clip-rule="evenodd" d="M8.99414 16.4629L10.3941 15.0629L4.79414 9.46289L16.9941 9.46289L16.9941 7.46289L4.79414 7.46289L10.3941 1.86289L8.99414 0.46289L0.994141 8.46289L8.99414 16.4629Z" fill="#0067C2"/>
					</svg>
				</div>
			</div>
			<div class="min-slider__arrow_white min-slider__arrow_right d-block d-md-none">
				<div class="min-slider__arrow_ico min-slider__arrow_ico-right">
					<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path opacity="0.54" fill-rule="evenodd" clip-rule="evenodd" d="M8.00586 0.462891L6.60586 1.86289L12.2059 7.46289H0.00585938V9.46289H12.2059L6.60586 15.0629L8.00586 16.4629L16.0059 8.46289L8.00586 0.462891Z" fill="#0067C2"/>
					</svg>
				</div>
			</div>*/ ?>
            </div>

        </section>
        <!-- interest					   				end -->
    <? } ?>

    <? $APPLICATION->IncludeComponent(
        "itc:main.feedback",
        "main_feedback_new",
        array(
            "USE_CAPTCHA" => "Y",
            "OK_TEXT" => "Ваше сообщение отправлено.",
            "EXT_FIELDS" => array(),
            "EMAIL_TO" => "info@itc174.ru",
            "REQUIRED_FIELDS" => array(
                0 => "NAME",
                1 => "EMAIL",
                2 => "MESSAGE",
            ),
            "EVENT_MESSAGE_ID" => array(
                0 => "5",
            ),
            "COMPONENT_TEMPLATE" => "main_feedback_new"
        ),
        false,
        array(
            "ACTIVE_COMPONENT" => "Y"
        )
    ); ?>

    <?

    $this->EndViewTarget();
    ?>


    <? /*
<div class="product-description">

<div id="buy_pp_div"><a title="Купить <?=$arResult["NAME"]?>..."  href="/reference/buy_product/index.php?ID=<?=$arResult["ID"]?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/buy_pp_image.gif" width="243" height="90" border="0" alt="Купить <?=$arResult["NAME"]?>..." /></a></div>

<div class="all_tabs">
<div class="detail_tab_0" id="tab1">Описание продукта</div>
<div class="detail_tab_0" id="tab2">Виды поставки</div>
<div class="detail_tab_0" id="tab3">Дополнительные лицензии</div>
<div class="detail_tab_0" id="tab4" <? if (!($arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"])) { echo ' style="display:none" ';} ?> >Отраслевые решения</div>
</div>

<div class="detail_info" id="info_1" style="display: block;">



?><?=$arResult["DETAIL_TEXT"]?><?

if ($arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"])
{
?>
		<div id="list">
			<div class="prev"><img src="<?=SITE_TEMPLATE_PATH?>/images/prev.jpg" alt="prev" /></div>
				<div class="slider">
					<ul>

						<?

						if ($arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"]["SRC"])
						{ ?><li><a href="<?=$arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"]["SRC"]?>" target="_blank" rel="requestimage"><img border="1" src="<?=$arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"]["SRC"]?>" class="captify" /></a></li><? }
 	    	 				else
						{
						foreach ($arResult["DISPLAY_PROPERTIES"]["screenshots"]["FILE_VALUE"] as $arItem):?>
						<li><a href="<?=$arItem["SRC"]?>" target="_blank" rel="requestimage"><img border="1" src="<?=$arItem["SRC"]?>" class="captify" /></a></li>
						<?endforeach; } ?>
					</ul>
				</div>
			<div class="next"><img src="<?=SITE_TEMPLATE_PATH?>/images/next.jpg" alt="next" /></div>
		</div>
<? } ?>
</div>






<div class="detail_info" id="info_4" style="display: none;">
    <table width="100%" cellpadding="5" cellspacing="0">
        <tr>
        <td width="70%"><b>Название</b></td>
        </tr><?

//echo '<pre>'; print_r($arResult["DISPLAY_PROPERTIES"]); echo '</pre>';
        if (count($arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["DISPLAY_VALUE"])<=1)
		{
			if ($arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["DISPLAY_VALUE"])
            {
                ?><tr>
                <td><a href="/reference/<?=$arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["VALUE"][0]?>/"><? echo strip_tags($arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["DISPLAY_VALUE"]); ?></a></td>
                </tr><?
            }
		}
		else
        for ($i = 0; $i<=count($arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["DISPLAY_VALUE"]); $i++)
        {
            if ($arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["DISPLAY_VALUE"][$i])
            {
                ?><tr>
                <td><a href="/reference/<?=$arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["VALUE"][$i]?>/"><? echo strip_tags($arResult["DISPLAY_PROPERTIES"]["OTRASL_LINK"]["DISPLAY_VALUE"][$i]); ?></a></td>
                </tr><?
            }
        }
        ?>
    </table>
</div>

<?



/*



<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>

 	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?=GetMessage("IBLOCK_FIELD_" . $code)?>:&nbsp;<?=$value;?>
			<br />
	<?endforeach;?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;?>
	<?
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
</div>
<?
$url = "/reference/index.php?SECTION_ID=".$arResult["IBLOCK_SECTION_ID"];
?>
<div class="simple_link"><a class="simple_link" href="<?=$url?>"><img src="/images/to_list.gif" /> <?=GetMessage("T_NEWS_DETAIL_BACK")?></a></div>


?>

<?$APPLICATION->IncludeFile('/includes/likes.php',Array(),Array("MODE"=>"html"));?>

<br /><a class="back_link" href="/reference/index.php?ID=16&SECTION_ID=<?=$arResult["IBLOCK_SECTION_ID"]?>"><img src="/images/to_list.gif"> К списку продуктов</a>

<style>
	.product-description__head-product_img-new:after {
		content: "НОВИНКА";
	}
</style>

*/ ?>
<? endif ?>
<div class="delivery_blocks">
<div class="head_block">
    САМОВЫВОЗ
</div>
<div class="body_block">
    Возможен при онлайн-оплате на сайте в момент заказа. Примерка не возможна.
</div>
</div>

<?
$price = $arBonus[$arItem["ID"]]['PRICE']['DISCOUNT_PRICE'] ? $arBonus[$arItem["ID"]]['PRICE']['DISCOUNT_PRICE'] : $arBonus[$arItem["ID"]]['FULL_PRICE'];
$price_with_bonus =  round($price * (100 - $bonus_val) / 100);
?>
<?
ob_start();
\Aspro\Functions\CAsproItem::showItemPrices($arParams, $arCurrentSKU["PRICES"], '', $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));
$html_2 = ob_get_contents();
$html_2 = str_replace('руб.', '₽', $html_2);
ob_end_clean();
echo $html_2;
?>

<?if ($price_with_bonus && $use_bonus):?>
    <div class="price_with_bonus price_with_bonus_section">
        <span class="price"><?=$price_with_bonus?> ₽</span>
        <span class="price-text">При оплате бонусами</span>
    </div>
<?endif;?>
    <label>
        <input type="radio" id="2" name="form_radio_SIMPLE_QUESTION_892" value="2">
    </label>
    <label for="2">отличается от картинки на сайте</label><br>
    <label>
    <input type="radio" id="3" name="form_radio_SIMPLE_QUESTION_892" value="3">
</label>
    <label for="3">были заказаны позиции на выбор</label><br>
    <label><input type="radio" id="4" name="form_radio_SIMPLE_QUESTION_892" value="4">
    </label>
    <label for="4">товар доставлен слишком поздно</label><br>
    <label><input type="radio" id="5" name="form_radio_SIMPLE_QUESTION_892" value="5">
    </label>
    <label for="5">плохое качество/брак</label><br>
    <label><input type="radio" id="6" name="form_radio_SIMPLE_QUESTION_892" value="6"></label>
    <label for="6">заказ был оплачен, но не получен</label><br>
    <label><input type="radio" id="7" name="form_radio_SIMPLE_QUESTION_892" value="7"></label>
    <label for="7">прочее</label>

    <a href="https://www.arte-grim.ru/about/recovery/">сайте</a>
    Я ознакомлен с правилами возврата, представленными на <a href="https://www.arte-grim.ru/about/recovery/">сайте</a>
    Заявление на возврат(<a href="https://www.arte-grim.ru/about/recovery/%D0%97%D0%B0%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D1%8F_%D0%9E%D0%9E%D0%9E_%D0%90%D0%A0%D0%A2%D0%AD_%D0%9E%D0%9D%D0%9B%D0%90%D0%99%D0%9D.xlsx">скачать</a>)
    <script>
        $('#header .action_block .action_span').text()
    </script>
<?php

use Bitrix\Sale;
/*
 * получаем массив id пользователей без заполненного поля телефон
 */
$arUsersWithoutPhone = array();
$data = CUser::GetList(($by="ID"),
    ($order="ASC"),
    array('ACTIVE' => 'Y' )
);

while($arUser = $data->Fetch()) {
    if(!$arUser['PERSONAL_PHONE']){
        $arUsersWithoutPhone[] = $arUser['ID'];
    }
}

echo '<pre>';
print_r($arUsersWithoutPhone);
echo '</pre>';
/*
 * получаем id заказа пользователя
 */
$count = 0;
foreach ($arUsersWithoutPhone as $userId) {
    if ($count > 500){
        break;
    }
    if (CModule::IncludeModule("sale")):
        $arFilter = Array("USER_ID" => $userId);
        $rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
        while ($arSales = $rsSales->Fetch()) {
            $orderId = $arSales['ID'];
        }
    endif;
    /*
     * получаем телефон из заказа
     */
    if ($orderId) {
        $order = Sale\Order::load($orderId);
        $propertyCollection = $order->getPropertyCollection();

        $ar = $propertyCollection->getArray();
        $orderPhone = '';
        foreach ($ar['properties'] as $property) {
            if ($property['CODE'] == 'PHONE') $orderPhone = $property['VALUE'][0];
        }
        /*
         * обновляем телефон пользователя если нашли в заказе
         */
        if ($orderPhone) {
            echo '<pre>';
            print_r($arUsersWithoutPhone);
//            var_dump($orderPhone);
            echo '<br>';
//        $user = new CUser;
//        $fields = Array("PERSONAL_PHONE" => $orderPhone);
//        $user->Update($userId, $fields);
        }
        $count++;
    }
}


CModule::IncludeModule('crm');
$srcOwnerTypeID = 3;
$srcOwnerID = 24164;
$dbResult = \Bitrix\Main\Application::getConnection()->query(
    "SELECT a.ID, a.TYPE_ID
                FROM b_crm_act a INNER JOIN b_crm_act_bind b ON a.ID = b.ACTIVITY_ID
                WHERE b.OWNER_TYPE_ID = {$srcOwnerTypeID} AND b.OWNER_ID = {$srcOwnerID}"
);

$itemFields = array();
while($fields = $dbResult->fetch())
{
    $itemFields[] = $fields;
}

foreach($itemFields as $fields)
{
    if ($fields['TYPE_ID'] == 2 || $fields['TYPE_ID'] == 4){
        $itemID = (int)$fields['ID'];
        $bindings = CCrmActivity::GetBindings($itemID);
        $bindings[] = array('OWNER_TYPE_ID' => $targOwnerTypeID, 'OWNER_ID' => $targOwnerID);
        \CCrmActivity::SaveBindings($itemID, $bindings, false, false);
    }

}
echo '<pre>';
print_r($itemFields);
echo '</pre>';





?>
<script>
    $('.bonus-val').data('val')
</script>
