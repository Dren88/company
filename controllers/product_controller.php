<? defined('CATALOG') or die("Access denied")?>
<?php
include 'main_controller.php';
include "models/{$view}_model.php";

$get_one_product = get_one_product($product_alias);
if (!$get_one_product){
//    $products = $count_pages = null;
    header('HTTP/1.1 404 Not Found');
    include "views/{$options['theme']}/404.php";
    exit();
}
setMeta($get_one_product);
$id = $get_one_product['parent'];
$product_id = $get_one_product['id'];
$get_comments = get_comments($product_id);

$comments_tree = map_tree($get_comments);
$comments = categories_to_string($comments_tree, 'comments_template.php');
$count_comments = count_comments($product_id);
include "libs/breadcrumbs.php";
include "views/{$options['theme']}/{$view}.php";

