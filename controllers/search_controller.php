<? defined('CATALOG') or die("Access denied")?>
<?php
include 'main_controller.php';
include "models/{$view}_model.php";

if (isset($_GET['term'])){
    $result_search = search_autocomplete();
    exit(json_encode($result_search));
}elseif (isset($_GET['search']) && $_GET['search']){

    $perpage = $options['pagination'];
    $count_goods = count_search();
    $count_pages = ceil($count_goods / $perpage);
    if (!$count_pages) $count_pages = 1;
    if (isset($_GET['page'])){
        $page = (int)$_GET['page'];
        if ($page < 1) $page = 1;
    }else {$page = 1;}

    if ($page > $count_pages) $page = $count_pages;
    $start_pos = ($page - 1) * $perpage;
    $pagination = pagination($page, $count_pages);
    $result_search = search($start_pos, $perpage);

}else{
    $result_search = 'А что вы ищете?';
}

//if( isset($_GET['term']) ){
//    $arr = array('test1', 'test2');
//    exit( json_encode($arr) );
//    exit("Тест " . $_GET['term']);
//}

$breadcrumbs = "<li><a href = '".PATH."'>Главная</a></li> / <li>Результаты поиска</li>";
include "views/{$options['theme']}/{$view}.php";;
