<?php require_once 'header.php' ?>

    <div class="page-wrap"> <!-- class="page-wrap" -->

        <div class="content"> <!-- class="content" -->
            <ul class="breadcrumbs">
                <?= $breadcrumbs ?>
            </ul>
            <? if (is_array($result_search)): ?>
                <? foreach ($result_search as $product): ?>
                    <div class="product"> <!-- class="product" -->
                        <h1><a href="<?= PATH . 'product/'. $product['cat_alias']. '/' .$product['alias']?>"><?= $product['title'] ?></a></h1>
                        <div class="img-wrap">
                            <img src="<?= PATH . PRODUCTIMG . $product['image'] ?>" alt="<?= $product['image'] ?>"/>
                        </div>
                        <p class="price">Цена: <span><?= $product['price'] ?></span> руб</p>
                        <p class="views"><img align="center" src="<?= $theme ?>img/views.jpg" alt=""/> <span>680</span>
                        </p>
                        <p class="comments"><img align="center" src="<?= $theme ?>img/comments.jpg" alt=""/>
                            <span>61</span></p>
                        <p class="permalink"><a href="<?= PATH . 'product/' .$product['alias']?>">Подробнее</a>
                        </p>
                    </div> <!-- class="product" -->
                <? endforeach; ?>
            <? else: ?>
                <p><b><?= $result_search ?></b></p>
            <? endif; ?>
            <div class="clr"></div>
            <?if($count_pages > 1):?>
                <ul class="pagination">
                    <?echo $pagination?>
                </ul>
            <?endif;?>
        </div> <!-- class="content" -->

        <?php require_once 'sidebar.php' ?>

    </div> <!-- class="page-wrap" -->

<?php require_once 'footer.php' ?>