<? defined('CATALOG') or die("Access denied")?>
<?php

function get_one_product($product_alias){
    global $connection;
    $product_alias = mysqli_real_escape_string($connection, $product_alias);
    $query = "SELECT * FROM products WHERE alias = '$product_alias' LIMIT 1";
    $res = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($res);
}

function get_comments($product_id){
    global $connection;
    $query = "SELECT * FROM `comments` WHERE comment_product = $product_id ORDER BY comment_id";
    $res = mysqli_query($connection, $query);
    $comments = array();
    while ($row = $res ->fetch_assoc()){
        $comments[$row['comment_id']] = $row;
    }
    return $comments;
}

function count_comments($product_id){
    global $connection;
    $query = "SELECT COUNT(*) FROM comments WHERE comment_product = $product_id";
    $res = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($res);
    return $row[0];
}