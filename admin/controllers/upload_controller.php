<? defined('CATALOG') or die("Access denied");

//require_once "models/{$view}.php";
require_once "models/{$view}_model.php";
if (!empty($_FILES)){
    if (isset($_FILES['file'])){
        $file = 'file';
    }elseif (isset($_FILES['files'])){
        $file = 'files';
    }else{
        $res = ['answer' => 'error', 'error' => 'Некорректно имя файла в форме'];
        exit(json_encode($res));
    }
    $path = __DIR__ . '/../../userfiles/products/';

    $new_name = uploadImg($file, $path, 216, 313);

    if ($file == 'file'){
        $_SESSION['file'] = $new_name;
    }else{
        $_SESSION['file'][] = $new_name;
    }
    $res = array("answer" => "ok", "file" => $new_name);
    exit(json_encode($res));
}
//require_once "views/{$view}.php";