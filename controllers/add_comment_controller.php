<? defined('CATALOG') or die("Access denied")?>
<?php
include "models/main_model.php";
include "models/{$view}_model.php";

echo add_comment();
?>