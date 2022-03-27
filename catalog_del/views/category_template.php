<? defined('CATALOG') or die("Access denied")?>
<li>
    <a href="<?=PATH?>category/<?=$category['id']?>"><?=$category['title']?></a>
    <?if($category['childs']):?>
    <ul><?echo categories_to_string($category['childs'])?></ul>
    <?endif;?>
</li>