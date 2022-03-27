<? defined('CATALOG') or die("Access denied") ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Каталог</title>
<!--    <link rel="stylesheet" href="--><?//= PATH . VIEW ?><!--views/style.css">-->
    <link rel="stylesheet" href="<?=PATH . VIEW?>css/style.css">
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <? include 'sidebar.php' ?>
    </div>
    <div class="content">
        <? include 'menu.php' ?>
        <p><?= $breadcrumbs ?></p>
        <br>
        <hr>
        <h3>Регистрация</h3>
        <?php if (isset($_SESSION['reg']['success'])): ?>
            <div class="ok"><?= $_SESSION['reg']['success'] ?></div>

        <?php elseif (!isset($_SESSION['auth']['user'])): ?>
            <div class="form">
                <form action="<?= PATH ?>reg" method="post">
                    <p>
                        <label for="name_reg">Имя:</label>
                        <input type="text" name="name_reg" id="name_reg">
                    </p>
                    <p>
                        <label for="email_reg">Email:</label>
                        <input class="access" type="text" data-field="email" name="email_reg" id="email_reg">
                        <span></span>
                    </p>
                    <p>
                        <label for="login_reg">Логин:</label>
                        <input class="access" type="text" data-field="login" name="login_reg" id="login_reg">
                        <span></span>
                    </p>
                    <p>
                        <label for="password_reg">Пароль:</label>
                        <input type="password" name="password_reg" id="password_reg">
                    </p>
                    <p class="submit">
                        <input type="submit" value="Зарегистрироваться" name="reg">
                    </p>
                </form>
            </div>

            <? if (isset($_SESSION['reg']['errors'])): ?>
                <br>
                <div class="error">
                    <?= $_SESSION['reg']['errors'];
                    unset($_SESSION['reg']); ?>
                </div>
            <? endif; ?>

        <?php endif;
        unset($_SESSION['reg']); ?>
    </div>
</div>
<script src="<?=PATH . VIEW?>js/jquery-1.9.0.min.js"></script>
<script src="<?=PATH . VIEW?>js/jquery.accordion.js"></script>
<script src="<?=PATH . VIEW?>js/jquery.cookie.js"></script>
<script>
    $(document).ready(function () {
        $('.category').dcAccordion()
        $('.access').change(function () {
            var $this = $(this)
            var val = $.trim($this.val())
            var dataField = $this.attr('data-field')
            var span = $this.next()
            if (val == '') {
                span.removeClass().addClass('reg-cross')
            } else {
                span.removeClass().addClass('reg-loader')
                $.ajax({
                    url: '<?=PATH?>reg',
                    type: 'POST',
                    data: {val: val, dataField: dataField},
                    success: function (res) {
                        if (res == 'no') {
                            span.removeClass().addClass('reg-cross')
                        } else {
                            span.removeClass().addClass('reg-check')
                        }

                    }
                })
            }
        })

    })
</script>
<script src="<?=PATH . VIEW?>js/workscript.js"></script>
</body>
</html>