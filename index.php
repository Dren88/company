<?php
error_reporting(E_ALL ^ E_NOTICE);
define("CATALOG", true);
session_start();
include 'config.php';

$routes = array(
    array('url' => '#^$|^\?#', 'view' => 'category'),
    array('url' => '#^product/[a-z0-9-]+/(?P<product_alias>[a-z0-9-]+)#i', 'view' => 'product'),
    array('url' => '#^product/(?P<product_alias>[a-z0-9-]+)#i', 'view' => 'product'),
    array('url' => '#^category/(?P<category_alias>[a-z0-9-]+)#i', 'view' => 'category'),
    array('url' => '#^login#i', 'view' => 'login'),
    array('url' => '#^logout#i', 'view' => 'logout'),
    array('url' => '#^forgot#i', 'view' => 'forgot'),
    array('url' => '#^registration#i', 'view' => 'reg'),
    array('url' => '#^add_comment#i', 'view' => 'add_comment'),
    array('url' => '#^search#i', 'view' => 'search'),
    array('url' => '#^page/(?P<page_alias>[a-z0-9-]+)#i', 'view' => 'page')
);

$app_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$app_path = preg_replace('#[^/]+$#', '', $app_path);
define("PATH", $app_path);

$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = str_replace(PATH, '', $url);

foreach ($routes as $route){
    if (preg_match($route['url'], $url, $match)){
        $view = $route['view'];
        break;
    }
}

if (empty($match)){
    header('HTTP/1.1 404 Not Found');
    include "views/404.php";
    exit();
}
extract($match);

include "controllers/{$view}_controller.php";