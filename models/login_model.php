<?php

function authorization(){
    global $connection;
    $login = trim(mysqli_real_escape_string($connection, $_POST['login']));
    $password = trim($_POST['password']);
    if (empty($login) || empty($password)){
        $_SESSION['auth']['errors'] = 'Поля логин/пароль обязательны к заполнению';
    }else{
        $password = md5($password);
        $query = "SELECT name, is_admin FROM users WHERE login = '$login' AND password = '$password' LIMIT 1";
        $res = mysqli_query($connection, $query);
        if (mysqli_num_rows($res) == 1){
            $row = mysqli_fetch_assoc($res);
            $_SESSION['auth']['user'] = $row['name'];
            $_SESSION['auth']['is_admin'] = $row['is_admin'];
            if (isset($_POST['remember']) && $_POST['remember'] == 'on'){
                $hash = md5(time() . $login);
                setcookie('hash', $hash, time() + 60*60*24*7);
                $query = "UPDATE `users` set `remember` = '$hash' WHERE login = '$login'";
                $res = mysqli_query($connection, $query);
            }
        }else{
            $_SESSION['auth']['errors'] = 'Логин/пароль введены неверно';
        }
    }
}