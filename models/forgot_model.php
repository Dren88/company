<?php

function forgot(){
    global $connection;
    $email = trim(mysqli_real_escape_string($connection, $_POST['email']));
    if (empty($email)){
        $_SESSION['auth']['errors'] = 'Поле email не заполнено';
    }else{
        $query = "SELECT id FROM `users` WHERE email = '$email' LIMIT 1";
        $res = mysqli_query($connection, $query);
        if (mysqli_num_rows($res) == 1){
            $expire = time() + 3600;
            $hash = md5($expire . $email);
            $query = "INSERT INTO `forgot` (hash, expire, email) VALUES ('$hash', $expire, '$email')";
            $res = mysqli_query($connection, $query);
            if (mysqli_affected_rows($connection) > 0){
                $link = PATH . "forgot/?forgot={$hash}";
                $subject = "Запрос на восстановление пароля на сайте " . PATH;
                $body = "По ссылке <a href='{$link}'>{$link}</a> вы найдете страницу с формой, где сможете ввести новый пароль. Ссылка активна в течение 1 часа.";
                $headers = "FROM: " . strtoupper($_SERVER['SERVER_NAME']) . "\r\n";
                $headers .= "Content-type:text/html; charset=utf-8";
                mail($email, $subject, $body, $headers);
                $_SESSION['auth']['ok'] = 'На ваш email выслана инструкция по восстановлению пароля';
            }else{
                $_SESSION['auth']['errors'] = 'Ошибка!';
            }
        }else{
            $_SESSION['auth']['errors'] = 'Пользователь с таким email не найден';
        }
    }
}

function access_change(){
    global $connection;
    $hash = trim(mysqli_real_escape_string($connection, $_GET['forgot']));
    if (empty($hash)){
        $_SESSION['forgot']['errors'] = 'Перейдите по корректной ссылке';
        return;
    }
    $query = "SELECT * FROM forgot WHERE hash = '$hash' LIMIT 1";
    $res = mysqli_query($connection, $query);
    if (!mysqli_num_rows($res)){
        $_SESSION['forgot']['errors'] = 'Ссылка устарела или вы прошли по некорректной ссылке';
        return;
    }
    $now = time();
    $row = mysqli_fetch_assoc($res);
    if ($row['expire'] - $now < 0){
        $_SESSION['forgot']['errors'] = 'Ссылка устарела. Пройдите процедуру восстановления пароля заново';
        return;
    }
}
function change_forgot_password(){
    global $connection;
    $hash = trim(mysqli_real_escape_string($connection, $_POST['hash']));
    $password = trim($_POST['new_password']);
    if (empty($password)){
        $_SESSION['forgot']['change_error'] = "Не введен пароль";
        return;
    }
    $query = "SELECT * FROM forgot WHERE hash = '$hash' LIMIT 1";
    $res = mysqli_query($connection, $query);
    if (!mysqli_num_rows($res)) return;

    $now = time();
    $row = mysqli_fetch_assoc($res);

    // если ссылка устарела
    if($row['expire'] - $now < 0){
        mysqli_query($connection, "DELETE FROM forgot WHERE expire < $now");
        return;
    }
    $password = md5($password);
    mysqli_query($connection, "UPDATE users set password = '$password' WHERE email = '{$row['email']}'");
    mysqli_query($connection, "DELETE FROM forgot WHERE email = '{$row['email']}'");
    $_SESSION['forgot']['ok'] = "Вы успешно сменили пароль!";
}