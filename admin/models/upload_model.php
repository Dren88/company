<?php defined("CATALOG") or die("Access denied");

function uploadImg($name, $path, $wmax, $hmax){
    $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$name]['name'])); // расширение картинки
    $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений
    if($_FILES[$name]['size'] > 1048576){
        $res = array("answer" => "error", "error" => "Ошибка! Максимальный вес файла - 1 Мб!");
        exit(json_encode($res));
    }
    if($_FILES[$name]['error']){
        $res = array("answer" => "error", "error" => "Ошибка! Возможно, файл слишком большой.");
        exit(json_encode($res));
    }
    if(!in_array($_FILES[$name]['type'], $types)){
        $res = array("answer" => "error", "error" => "Допустимые расширения - .gif, .jpg, .png");
        exit(json_encode($res));
    }
    $new_name = sha1(time()).".$ext";
    $uploadfile = $path.$new_name;
    if(@move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)){
        resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
        return $new_name;
    }
}

function resize($target, $dest, $wmax, $hmax, $ext){
    list($w_orig, $h_orig) = getimagesize($target);
    if($w_orig < $wmax && $h_orig < $hmax) return;
    $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

    if(($wmax / $hmax) > $ratio){
        $wmax = $hmax * $ratio;
    }else{
        $hmax = $wmax / $ratio;
    }

    $img = "";
    // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
    switch($ext){
        case("gif"):
            $img = imagecreatefromgif($target);
            break;
        case("png"):
            $img = imagecreatefrompng($target);
            break;
        default:
            $img = imagecreatefromjpeg($target);
    }
    $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки

    if($ext == "png"){
        imagesavealpha($newImg, true); // сохранение альфа канала
        $transPng = imagecolorallocatealpha($newImg,0,0,0,127); // добавляем прозрачность
        imagefill($newImg, 0, 0, $transPng); // заливка
    }

    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
    switch($ext){
        case("gif"):
            imagegif($newImg, $dest);
            break;
        case("png"):
            imagepng($newImg, $dest);
            break;
        default:
            imagejpeg($newImg, $dest);
    }
    imagedestroy($newImg);
}