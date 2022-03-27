<? defined('CATALOG') or die("Access denied")?>
<?php

function search_autocomplete(){
    global $connection;
    $search = trim(mysqli_real_escape_string($connection, $_GET['term']));
    $query = "SELECT title from products WHERE title LIKE '%{$search}%' LIMIT 5";
    $query2 = "SELECT content from products WHERE content LIKE '%{$search}%' LIMIT 5";
    $res = mysqli_query($connection, $query);
    $res2 = mysqli_query($connection, $query2);
    $result_search = array();
    while ($row = mysqli_fetch_assoc($res)){
        $result_search[] = array('label' => $row['title'], 'category' => 'Title');
    }
    while ($row = mysqli_fetch_assoc($res2)){
        $result_search[] = array('label' => $row['content'], 'category' => 'Content');
    }
    return $result_search;
}

function count_search(){
    global $connection;
    $search = trim(mysqli_real_escape_string($connection, $_GET['search']));
    $query = "SELECT COUNT(*) from products WHERE title LIKE '%{$search}%'";
    $res = mysqli_query($connection, $query);
    $count_search = mysqli_fetch_row($res);
    return $count_search[0];
}

function search($start_pos, $perpage){
    global $connection;
    $search = trim(mysqli_real_escape_string($connection, $_GET['search']));
    $query = "SELECT id, title, alias, price, image from products WHERE title LIKE '%{$search}%' LIMIT $start_pos, $perpage";
    $res = mysqli_query($connection, $query);
    if (!mysqli_num_rows($res)){
        return 'Ничего не найдего';
    }else{
        $result_search = array();
        while ($row = mysqli_fetch_assoc($res)){
            $result_search[] = $row;
        }
    }
    return $result_search;
}