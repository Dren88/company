<? defined('CATALOG') or die("Access denied")?>
<?php
include 'main_controller.php';
include "models/{$view}_model.php";
include "../models/{$view}_model.php";

if (!isset($category_alias)) $category_alias = null;
$id = get_id($categories, $category_alias);
include "../libs/breadcrumbs.php";

if ($category_alias && !$id){
    http_response_code(404);
    include "views/404.php";
    exit();
}
// ID дочрних категорий
$ids = cats_id($categories, $id);
$ids = !$ids ? $id : $ids . $id;
/*
 * колличество товаров на страницу
 */
$perpage = 20;

/*
 * общее количество товаров
 */
$count_goods = count_goods($ids);
$count_pages = ceil($count_goods / $perpage);
if (!$count_pages) $count_pages = 1;
if (isset($_GET['page'])){
    $page = (int)$_GET['page'];
    if ($page < 1) $page = 1;
}else {$page = 1;}

if ($page > $count_pages) $page = $count_pages;
$start_pos = ($page - 1) * $perpage;
$pagination = pagination($page, $count_pages);


$products = get_products($ids, $start_pos, $perpage);
//include VIEW . "{$view}.php";
include "views/{$view}.php";