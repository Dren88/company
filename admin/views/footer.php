<div class="footer">
    <div class="menu"> <!-- class="menu" -->
        <?require 'menu.php'?>
    </div> <!-- class="/menu" -->
    <center>Какая то информация о авторе, сайте, продукции, поставщиках, счетчики, статистика или что-либо еще!</center>
</div>
<div id="mes-edit">
    <span class="responce"></span>
    <span class="cross-times">&times;</span>
</div>
<div id="loader"><span></span></div>
<script>
    var path = "<?=PATH?>";
</script>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="<?=PATH?>views/ckeditor/ckeditor.js">"></script>
<script src="<?=PATH?>views/ckeditor/adapters/jquery.js">"></script>
<script src="<?=PATH?>views/scripts/jquery.cookie.js"></script>
<script src="<?=PATH?>views/scripts/jquery.accordion.js"></script>
<script src="<?=PATH?>views/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=PATH?>views/dropzone/dropzone.js"></script>
<script src="<?=PATH?>views/scripts/scripts.js"></script>
</body>
</html>