<? defined('CATALOG') or die("Access denied")?>
<?php

function get_one_product($product_alias){
    global $connection;
    $product_alias = mysqli_real_escape_string($connection, $product_alias);
    $query = "SELECT * FROM products WHERE alias = '$product_alias' LIMIT 1";
    $res = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($res);
}