<div class="footer">
    <div class="menu"> <!-- class="menu" -->
        <?require 'menu.php'?>
    </div> <!-- class="/menu" -->
    <center>Какая то информация о авторе, сайте, продукции, поставщиках, счетчики, статистика или что-либо еще!</center>
</div>
<script>
    var path = "<?=PATH?>";
    var search = "<?php if (isset($_GET['search'])) echo htmlspecialchars_decode($_GET['search']); else echo '';?>";
</script>
<script src="<?=$theme?>js/jquery-1.9.0.min.js"></script>
<script src="<?=$theme?>js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="<?=$theme?>js/jquery.cookie.js"></script>
<script src="<?=$theme?>js/jquery.accordion.js"></script>
<script src="<?=$theme?>js/jquery.hoverIntent.minified.js"></script>
<script src="<?=$theme?>js/jquery.highlight.js"></script>
<script src="<?=$theme?>js/script.js"></script>
</body>
</html>