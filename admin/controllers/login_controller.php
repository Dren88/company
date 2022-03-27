<? defined('CATALOG') or die("Access denied");

require_once "models/{$view}_model.php";
if (isset($_POST['log_in'])){
    authorization();
    redirect();
}
require_once "views/{$view}.php";