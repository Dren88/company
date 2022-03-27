<?php require_once 'header.php' ?>
    <div class="page-wrap">
        <div class="content">

            <h1>Список товаров</h1>
            <small>*Измените настройку и кликните вне поля для ее сохранения или нажмите Enter</small>
            <ul class="breadcrumbs">
                <?=$breadcrumbs_new?>
            </ul>
            <?if ($products):?>
                <?if($count_pages > 1):?>
                    <ul class="pagination">
                        <?echo $pagination?>
                    </ul>
                <?endif;?>
                <table class="zebra" data-table="edit-product">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['title'] ?></td>
                        <td>
                            <input type="text" data-id="<?= $product['id'] ?>" name="price" value="<?= $product['price'] ?>" class="edit-price"><?= $product['title'] ?>
                        </td>
                        <td>
                            <a href="<?=PATH?>edit-product/<?= $product['id'] ?>">
                                <img src="<?=PATH?>views/img/edit.png" alt="">
                            </a>
                        </td>
                        <td>
                                <img class="del" data-id="<?= $product['id'] ?>" src="<?=PATH?>views/img/delete.png" alt="">
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
                <?if($count_pages > 1):?>
                    <ul class="pagination">
                        <?echo $pagination?>
                    </ul>
                <?endif;?>
            <?else:?>
            <p>В этой категории товаров нет</p>
            <?endif;?>
        </div>

        <div class="sidebar-wrap">
            <?require_once 'sidebar.php'?>
        </div>
    </div>

<?php require_once 'footer.php' ?>