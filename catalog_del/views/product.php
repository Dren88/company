<? defined('CATALOG') or die("Access denied")?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Каталог</title>
    <link rel="stylesheet" href="<?=PATH?>views/style.css">
</head>
<body>
<a href="/catalog">Главная</a>
<div class="wrapper">
    <div class="sidebar">
        <? include 'sidebar.php'?>
    </div>
    <div class="content">
        <p><?=$breadcrumbs?></p>
        <br>
        <hr>
        <?if ($get_one_product):?>
        <?print_r($get_one_product)?>
        <?else:?>
        Такого товара нет
        <?endif;?>
    </div>
</div>
<script src="<?=PATH?>views/js/jquery-1.9.0.min.js"></script>
<script src="<?=PATH?>views/js/jquery.accordion.js"></script>
<script src="<?=PATH?>views/js/jquery.cookie.js"></script>
<script>
    $(document).ready(function () {
        $('.category').dcAccordion()
    })
</script>
</body>
</html>