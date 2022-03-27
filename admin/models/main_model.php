<? defined('CATALOG') or die("Access denied");

function escape_data($type = 'post'){
    global $connection;
    if ($type == 'post'){
        $data = $_POST;
    }elseif ($type == 'get'){
        $data = $_GET;
    }
    foreach ($data as $k => $v){
        $data[$k] = mysqli_real_escape_string($connection, $v);
    }
    return $data;
}

function get_flash(){
    require __DIR__ . '/../../views/flash.php';
}

function get_alias($table, $field, $str, $id)
{
    global $connection;
    $str = str2url($str);
    $str = mysqli_real_escape_string($connection, $str);
    $query = "SELECT $field FROM $table WHERE $field = '$str'";
    $res = mysqli_query($connection, $query);
    if (mysqli_num_rows($res)){
        $str = "{$str}-{$id}";
        $res = mysqli_query($connection, $query);
        if (mysqli_num_rows($res)){
            $str = get_alias($table, $field, $str, $id);
        }
    }
    return $str;
}

function rus2translit($string) {

    $converter = array(

        'а' => 'a',   'б' => 'b',   'в' => 'v',

        'г' => 'g',   'д' => 'd',   'е' => 'e',

        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',

        'и' => 'i',   'й' => 'y',   'к' => 'k',

        'л' => 'l',   'м' => 'm',   'н' => 'n',

        'о' => 'o',   'п' => 'p',   'р' => 'r',

        'с' => 's',   'т' => 't',   'у' => 'u',

        'ф' => 'f',   'х' => 'h',   'ц' => 'c',

        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',

        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',

        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',



        'А' => 'A',   'Б' => 'B',   'В' => 'V',

        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',

        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',

        'И' => 'I',   'Й' => 'Y',   'К' => 'K',

        'Л' => 'L',   'М' => 'M',   'Н' => 'N',

        'О' => 'O',   'П' => 'P',   'Р' => 'R',

        'С' => 'S',   'Т' => 'T',   'У' => 'U',

        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',

        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',

        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',

        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

    );

    return strtr($string, $converter);

}

function str2url($str) {
    // переводим в транслит
    $str = rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}
