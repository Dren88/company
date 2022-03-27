<? defined('CATALOG') or die("Access denied");

require_once "models/{$view}_model.php";

if (isset($_GET['title'])){
    if( save_options() ){
        exit('Настройки сохранены');
    }else{
        exit('Ошибка сохранения настроек!');
    }
}
$get_options = get_options();
$themes = get_themes();
//print_arr($themes);
require_once "views/{$view}.php";