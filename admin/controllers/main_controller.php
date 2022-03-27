<? defined('CATALOG') or die("Access denied");

require_once 'models/main_model.php';
require_once '../models/main_model.php';

check_remember();

if (!isset($_SESSION['auth']['is_admin']) || $_SESSION['auth']['is_admin'] != 1){
    $view = 'login';
}

$categories = get_cat();
$categories_tree = map_tree($categories);
$categories_menu = categories_to_string($categories_tree);