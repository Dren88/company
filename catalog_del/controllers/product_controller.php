<? defined('CATALOG') or die("Access denied")?>
<?php
include 'main_controller.php';
include "models/{$view}_model.php";
    $get_one_product = get_one_product($product_alias);
    $id = $get_one_product['parent'];
include "libs/breadcrumbs.php";
include "views/{$view}.php";
?>
<div class="form__element">
<label class="form-checkbox">
	<input type="checkbox" value="Y" checked="" name="USER_AGREEMENT" class="focus">
    <span class="checkmarkbox agree_checkbox">&nbsp;</span>
	<span class="main-user-consent-request-announce-link">Я согласен на обработку личных данных</span>
</label>
</div>

