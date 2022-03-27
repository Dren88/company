<?
error_reporting(E_ALL ^ E_NOTICE);
define("CATALOG", true);
session_start();
require_once '../config.php';


$app_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$app_path = preg_replace('#[^/]+$#', '', $app_path);
define("PATH", $app_path);

$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = str_replace(PATH, '', $url);
$sire_url = rtrim(str_replace('admin', '', PATH), '/');
define("SITE", $sire_url);
$routes = [
    array('url' => '#^$|^\?#', 'view' => 'options'),
    array('url' => '#^login#i', 'view' => 'login'),
    array('url' => '#^category/(?P<category_alias>[a-z0-9-]+)#i', 'view' => 'category'),
    array('url' => '#^category#i', 'view' => 'category'),
    array('url' => '#^edit-product/(?P<product_id>[0-9]+)|^edit-product#i', 'view' => 'edit_product'),
    array('url' => '#^upload#i', 'view' => 'upload'),

];

foreach ($routes as $route){
    if (preg_match($route['url'], $url, $match)){
        $view = $route['view'];
        break;
    }
}

if (empty($match)){
    header('HTTP/1.1 404 Not Found');
    include '../' . VIEW . '404.php';
    exit();
}
require_once 'controllers/main_controller.php';

extract($match);

include "controllers/{$view}_controller.php";
