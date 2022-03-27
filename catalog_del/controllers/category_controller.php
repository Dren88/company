<? defined('CATALOG') or die("Access denied")?>
<?php
include 'main_controller.php';
include "models/{$view}_model.php";
include "libs/breadcrumbs.php";

if(!isset($id)) $id = null;
$ids = cats_id($categories, $id);
$ids = !$ids ? $id : rtrim($ids,',');

$perpage = (int)$_COOKIE['per_page'] ? (int)$_COOKIE['per_page'] : PERPAGE;
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

$products = get_product($ids, $start_pos, $perpage);


include "views/{$view}.php";