<? defined('CATALOG') or die("Access denied")?>
<?php

function get_cat(){
    global $connection;
    $query = "SELECT * FROM categories";
    $res = mysqli_query($connection, $query);

    $arr_cat = array();
    while ($row = mysqli_fetch_assoc($res)){
        $arr_cat[$row['id']] = $row;
    }
    return $arr_cat;
}
function print_arr($array){
    echo '<pre>'.print_r($array, true).'</pre>';
}
/**
 * Построение дерева
 **/
function map_tree($dataset) {
    $tree = array();
    foreach ($dataset as $id=>&$node) {
        if (!$node['parent']){
            $tree[$id] = &$node;
        }else{
            $dataset[$node['parent']]['childs'][$id] = &$node;
        }
    }
    return $tree;
}
$str = '';
function categories_to_string($data){
    foreach ($data as $item){
        $string .= categories_to_template($item);
    }
    return $string;
}

function categories_to_template($category){
    ob_start();
    include 'views/category_template.php';
    return ob_get_clean();
}

function pagination($page, $count_pages, $moderew = true){
    $uri = '?';
    if (!$moderew){
        if ($_SERVER['QUERY_STRING']){
            foreach ($_GET as $key => $value){
                if ($key != 'page'){
                    $uri .= "{$key}=$value&amp;";
                }
            }
        }
    }else{
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        if (isset($url[1]) && $url[1] != ''){
            $params = explode('&', $url[1]);
            foreach ($params as $key => $param){
                if (!preg_match('#page=#', $param)){
                    $uri .= "{$param}&amp;";
                }
            }
        }
    }

    if ($page > 1)$back = "<a class='nav-link'href='{$uri}page=".($page - 1)."'>&lt;</a>";
    if ($page < $count_pages)$forward = "<a class='nav-link'href='{$uri}page=".($page + 1)."'>&gt;</a>";
    if ($page > 3)$startpage = "<a class='nav-link'href='{$uri}page=1'>&laquo;</a>";
    if ($page < ($count_pages - 2))$endpage = "<a class='nav-link'href='{$uri}page={$count_pages}'>&raquo;</a>";
    if ($page - 2 > 0)$page2left = "<a class='nav-link'href='{$uri}page=".($page - 2)."'>".($page - 2)."</a>";
    if ($page - 1 > 0)$page1left = "<a class='nav-link'href='{$uri}page=".($page - 1)."'>".($page - 1)."</a>";
    if ($page + 2 <= $count_pages)$page2right = "<a class='nav-link'href='{$uri}page=".($page + 2)."'>".($page + 2)."</a>";
    if ($page + 1 <= $count_pages)$page1right = "<a class='nav-link'href='{$uri}page=".($page + 1)."'>".($page + 1)."</a>";

    return $startpage.$back.$page2left.$page1left.'<a class="nav-active">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage;
}
function breadcrumbs($array, $id){
    if (!$id) return false;
    $count = count($array);
    $breadcrumbs_array = array();
    for ($i = 0; $i < $count; $i++){
        if ($array[$id]){
            $breadcrumbs_array[$array[$id]['id']] = $array[$id]['title'];
            $id = $array[$id]['parent'];
        }else break;
    }
    return array_reverse($breadcrumbs_array, true);
}

