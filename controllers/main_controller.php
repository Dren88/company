<? defined('CATALOG') or die("Access denied")?>
<?php

include 'models/main_model.php';
$meta = [
    'm_title' => 'Title',
    'm_desc' => 'Desc',
    'm_keys' => 'keys',
];

$options = get_options_use();
$theme = PATH . "views/{$options['theme']}/";
// $categories - массив со всеми категориями товара

$categories = get_cat();
$categories_tree = map_tree($categories);
$categories_menu = categories_to_string($categories_tree);
$pages = get_pages();

check_remember();