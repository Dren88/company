<? defined('CATALOG') or die("Access denied")?>
<?php
include 'main_controller.php';
include "models/{$view}_model.php";
$page = get_one_page($page_alias);
if (!$page){
    header('HTTP/1.1 404 Not Found');
    include "views/{$options['theme']}/404.php";
    exit();
}
$breadcrumbs = "<li><a href = '".PATH."'>Главная</a></li> / <li>{$page['title']}</li>";
//include VIEW . "{$view}.php";
include "views/{$options['theme']}/{$view}.php";
