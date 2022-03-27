<? defined('CATALOG') or die("Access denied")?>
<?php

function setMeta($data){
    global $meta;
    $meta = [
        'm_title' => isset($data['m_title']) ? $data['m_title'] : '',
        'm_desc' => isset($data['m_desc']) ? $data['m_desc'] : '',
        'm_keys' => isset($data['m_keys']) ? $data['m_keys'] : '',
    ];
    return $meta;
}

function getMeta(){
    global $meta;
    return '<title>' . $meta['m_title'] . '</title>
    <meta name="description" content="' . $meta['m_desc'] . '">
    <meta name="keywords" content="' . $meta['m_keys'] . '">' . PHP_EOL;
}
function get_options_use(){
    global $connection;
    $query = "SELECT * FROM options";
    $res = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($res)){
        $options[$row['title']] = $row['value'];
    }
    return $options;
}

function check_remember(){
    if (isset($_SESSION['auth']['user'])){
        return;
    }
    if (!isset($_COOKIE['hash'])){
        return;
    }
    global $connection;
    $hash = mysqli_real_escape_string($connection, $_COOKIE['hash']);
    $query = "SELECT name, is_admin FROM users WHERE remember = '$hash' AND password = '$password' LIMIT 1";
    $res = mysqli_query($connection, $query);
    if (mysqli_num_rows($res) == 1){
        $row = mysqli_fetch_assoc($res);
        $_SESSION['auth']['user'] = $row['name'];
        $_SESSION['auth']['is_admin'] = $row['is_admin'];
    }else{
        setcookie('hash', "", time() - 3600);
    }
}

function get_cat(){
    global $connection;
//    $query = "SELECT * FROM categories";
    $query = "SELECT c.*, COUNT(p.parent) AS count_products FROM categories c
LEFT JOIN products p ON p.parent = c.id GROUP BY c.id ORDER BY NULL";
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
function categories_to_string($data, $template = 'category_template.php'){
    $string = null;
    foreach ($data as $item){
        if (!isset($item['childs']) && !$item['count_products']) continue;
        $string .= categories_to_template($item, $template);
    }
    return $string;
}

function categories_to_template($category, $template){
    global $parent_cat;
    ob_start();
    include "views/{$template}";
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

    if ($page > 1)$back = "<li><a class='nav-link'href='{$uri}page=".($page - 1)."'>Назад</a></li>";
    if ($page < $count_pages)$forward = "<li><a class='nav-link'href='{$uri}page=".($page + 1)."'>Вперед</a></li>";
    if ($page > 3)$startpage = "<li><a class='nav-link'href='{$uri}page=1'>В начало</a></li>";
    if ($page < ($count_pages - 2))$endpage = "<li><a class='nav-link'href='{$uri}page={$count_pages}'>В конец</a></li>";
    if ($page - 2 > 0)$page2left = "<li><a class='nav-link'href='{$uri}page=".($page - 2)."'>".($page - 2)."</a></li>";
    if ($page - 1 > 0)$page1left = "<li><a class='nav-link'href='{$uri}page=".($page - 1)."'>".($page - 1)."</a></li>";
    if ($page + 2 <= $count_pages)$page2right = "<li><a class='nav-link'href='{$uri}page=".($page + 2)."'>".($page + 2)."</a></li>";
    if ($page + 1 <= $count_pages)$page1right = "<li><a class='nav-link'href='{$uri}page=".($page + 1)."'>".($page + 1)."</a></li>";

    return $startpage.$back.$page2left.$page1left.'<li class="active-page">'.$page .$page1right.$page2right.$forward.$endpage;
}
function breadcrumbs($array, $id){
    if (!$id) return false;
    $count = count($array);
    $breadcrumbs_array = array();
    for ($i = 0; $i < $count; $i++){
        if ($array[$id]){
            $breadcrumbs_array[$array[$id]['alias']] = $array[$id]['title'];
            $id = $array[$id]['parent'];
        }else break;
    }
    return array_reverse($breadcrumbs_array, true);
}

function get_pages(){
    global $connection;
    $query = "SELECT * FROM pages ORDER BY position";
    $res = mysqli_query($connection, $query);
    $pages = array();
    while ($row = mysqli_fetch_assoc($res)){
        $pages[$row['alias']] = $row['title'];
    }
    return $pages;
}

function get_one_page($page_alias){
    global $connection;
    $page_alias = mysqli_real_escape_string($connection, $page_alias);
    $query = "SELECT * FROM pages WHERE alias = '$page_alias' LIMIT 1";
    $res = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($res);
}

function redirect($http = false){
    if ($http)$redirect = $http;
    else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit();
}