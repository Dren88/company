<? defined('CATALOG') or die("Access denied");
include 'main_controller.php';
require_once "models/{$view}_model.php";

if (isset($_GET['title'])){
    if (updatePrice()){
        exit('Цена изменена');
    }else{
        exit('Ошибка изменения');
    }
}
if (isset($_GET['id'])){
//    exit(deleteProduct());
    if (deleteProduct()){
        exit('OK');
    }else{
        exit('NO');
    }
}

if (isset($_POST['edit_product']))
{
    edit_product();
    redirect();
//    print_r($_POST);
}

$get_one_product = get_one_product($product_id);
if(!$get_one_product){
    http_response_code(404);
    include "views/404.php";
}
$id = $get_one_product['parent'];

include "../libs/breadcrumbs.php";
require_once "views/{$view}.php";