<? defined('CATALOG') or die("Access denied")?>
<?php
$breadcrumbs_array = breadcrumbs($categories, $id);
if ($breadcrumbs_array){
    $parent_cat = key($breadcrumbs_array);
    $breadcrumbs = "<a href='".PATH."'>Главная</a> / ";
    foreach ($breadcrumbs_array as $alias => $title){
        $breadcrumbs .= "<a href='".PATH."category/{$alias}'>{$title}</a> / ";
    }
    if (!isset($get_one_product)){
        $breadcrumbs = rtrim($breadcrumbs, " / ");
        $breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs);
    }else{
        $breadcrumbs .= $get_one_product['title'];
    }
}else{
    $breadcrumbs = "<a href='".PATH."'>Главная</a> / Каталог";
}
$breadcrumbs2 = explode(' / ', $breadcrumbs);
$breadcrumbs_new = null;
$end = array_pop($breadcrumbs2);
foreach ($breadcrumbs2 as $item){
    $breadcrumbs_new .= "<li>{$item} - </li>";
}
$breadcrumbs_new .= "<li>{$end}</li>";
if (isset($parent_cat)){
    $new_categories_tree[$parent_cat] = $categories_tree[$parent_cat];
    $new_categories_menu = categories_to_string($new_categories_tree);
}