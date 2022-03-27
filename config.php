<?php

define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DB", "apple");
//define("PATH", 'http://company/');
//define("VIEW", 'views/apple/');
//define("PERPAGE", 6);
define("PRODUCTIMG", 'userfiles/products/');

$option_perpage = array(5, 10, 15);

$connection = @mysqli_connect(DBHOST, DBUSER, DBPASS, DB) or die("Нет соединения с БД");
mysqli_set_charset($connection, 'utf8') or die("Не установлена кодировка соединения");