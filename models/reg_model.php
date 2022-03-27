<? defined('CATALOG') or die("Access denied")?>
<?php
function access_field(){
    global $connection;
    $fields = array('login', 'email');
    $val = trim(mysqli_real_escape_string($connection, $_POST['val']));
    $field = $_POST['dataField'];
    if (!in_array($field, $fields)){
        $res = array('answer' => 'no', 'info' => 'Ошибка!');
        return json_encode($res);
    }

    if ($field == 'email' && !empty($val)){
        if(!preg_match("#^\w+@\w+\.\w+$#i", $val)){
            $res = array('answer' => 'no', 'info' => 'Email не соответствует формату');
            return json_encode($res);
        }
    }


    $query = "SELECT id FROM users WHERE $field = '$val'";
    $res = mysqli_query($connection, $query);
    if (mysqli_num_rows($res) > 0){
        $res = array('answer' => 'no', 'info' => "Выберите другой $field");
        return json_encode($res);
    }else{
        $res = array('answer' => 'yes');
        return json_encode($res);
    }
}

function registration(){
    global $connection;
    $errors = '';
    $login = trim($_POST['login_reg']);
    $fields = array('login' => 'логин', 'email' => 'email');
    $password = trim($_POST['password_reg']);
    $password2 = trim($_POST['password_reg2']);
    $name = trim($_POST['name_reg']);
    $email = trim($_POST['email_reg']);
    $post = array($login,$email);

    if(empty($login)) $errors .= '<li>Не указан логин</li>';
    if(empty($password)) $errors .= '<li>Не указан пароль</li>';
    if(empty($name)) $errors .= '<li>Не указано имя</li>';
    if(empty($email)) $errors .= '<li>Не указан email</li>';
    if( !empty($email) ){
        if(!preg_match("#^\w+@\w+\.\w+$#i", $email)){
            $errors .= '<li>Email не соответствует формату</li>';
        }
    }
    if($password != $password2) $errors .= '<li>Пароли не совпадают</li>';

    if (!empty($errors)){
        $_SESSION['reg']['errors'] = "Ошибка регистрации: <ul>{$errors}</ul>";
		return;
    }

    $login = mysqli_real_escape_string($connection, $login);
    $password = md5($password);
    $name = mysqli_real_escape_string($connection, $name);
    $email = mysqli_real_escape_string($connection, $email);

    $query = "SELECT login, email FROM users WHERE login = '$login' OR email = '$email'";
    $res = mysqli_query($connection, $query);
    if (mysqli_num_rows($res) > 0) {
        $data = [];
        while (($row = mysqli_fetch_assoc($res))) {
            $data = array_intersect($row, $post);
            foreach ($data as $key => $val) {
                $k[$key] = $key;
            }
        }

        foreach ($k as $key => $val) {
            $errors .= "<li>{$fields[$key]}</li>";
        }
        $_SESSION['reg']['errors'] = "Выберите другие значения для полей: <ul>{$errors}</ul>";
        return;
    }
    $query = "INSERT INTO users (login, password, email, name)
				VALUES ('$login', '$password', '$email', '$name')";
//    print_arr($query);
    $res = mysqli_query($connection, $query);
    if (mysqli_affected_rows($connection) > 0){
        $_SESSION['reg']['success'] = "Регистрация прошла успешно";
        $_SESSION['auth']['user'] = stripslashes($name);
        $_SESSION['auth']['is_admin'] = 0;
    }else{
        $_SESSION['reg']['errors'] = "Ошибка регистрации";
    }

}