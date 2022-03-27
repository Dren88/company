<? defined('CATALOG') or die("Access denied")?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?echo $page_content['title'] ? $page_content['title'] : 'Каталог'?></title>
    <link rel="stylesheet" href="<?=PATH . VIEW?>css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <? include 'sidebar.php' ?>
        </div>
        <div class="content">
            <? include 'menu.php' ?>
<!--            --><?//print_arr($categories)?>
            <ul class="menu">
                <?foreach ($categories as $parent_item):?>
                    <?if (!$parent_item['parent']):?>
                        <li><a href="<?=PATH?>category/<?=$parent_item['id']?>"><?=$parent_item['title']?></a></li>
                    <?endif;?>
                <?endforeach;?>
            </ul>
            <div class="clear"></div>
            <p><?=$breadcrumbs?></p>
            <br>
            <hr>
            <div>
                <?=$page_content['description']?>
            </div>
            <div>
                <select name="perpage" id="perpage">
                    <?foreach ($option_perpage as $option):?>
                        <option <?php if($perpage == $option) echo "selected"; ?> value="<?=$option?>"><?=$option.' товаров на страницу'?></option>
                    <?endforeach?>
                </select>
            </div>
            <?php if($products): ?>
            <?if ($count_pages > 1):?>
                <div class="pagination"><?=$pagination?></div>
            <?endif;?>
                <?php foreach($products as $product): ?>
                    <a href="<?=PATH?>product/<?=$product['alias']?>"><?=$product['title']?></a><br>
                <?php endforeach; ?>
                <?if ($count_pages > 1):?>
                    <div class="pagination"><?=$pagination?></div>
                <?endif;?>
            <?php else: ?>
                <p>Здесь товаров нет!</p>
            <?php endif; ?>
        </div>
    </div>
<script src="<?=PATH . VIEW?>js/jquery-1.9.0.min.js"></script>
<script src="<?=PATH . VIEW?>js/jquery.accordion.js"></script>
<script src="<?=PATH . VIEW?>js/jquery.cookie.js"></script>
<script>
    $(document).ready(function () {
        $('.category').dcAccordion({autoExpand: true, })
        $("#perpage").change(function(){
            var perPage = this.value; // $(this).val()
            $.cookie('per_page', perPage, {expires:7, path: '/catalog/'});
            window.location = location.href;
        });
    })
    </script>
    <script src="<?=PATH . VIEW?>js/workscript.js"></script>
</body>
</html>