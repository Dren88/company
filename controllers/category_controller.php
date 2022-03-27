<? defined('CATALOG') or die("Access denied")?>
<?php
include 'main_controller.php';
include "models/{$view}_model.php";

if (!isset($category_alias)) $category_alias = null;
$id = get_id($categories, $category_alias);
include "libs/breadcrumbs.php";
//if(!isset($id)){
//    $id = null;
//    $page_content = get_one_page('index');
//}
if ($category_alias && !$id){
//    $products = $count_pages = null;
    header('HTTP/1.1 404 Not Found');
    include "views/{$options['theme']}/404.php";
    exit();
}

$ids = cats_id($categories, $id);

$ids = !$ids ? $id : $ids . $id;

$perpage = (int)$_COOKIE['per_page'] ? (int)$_COOKIE['per_page'] : $options['pagination'];
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
include "views/{$options['theme']}/{$view}.php";