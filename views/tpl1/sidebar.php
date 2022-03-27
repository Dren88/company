<div class="form auth">
    <div id="auth">
        <? if (!isset($_SESSION['auth']['user'])): ?>
            <form action="<?= PATH ?>login" method="post">
                <p>
                    <label for="login">Логин:</label>
                    <input type="text" name="login" id="login">
                </p>
                <p>
                    <label for="password">Пароль:</label>
                    <input type="password" name="password" id="password">
                </p>
                <p class="submit">
                    <input type="submit" value="Войти" name="log_in">
                </p>
            </form>
            <p><a href="<?=PATH?>reg">Регистрация</a> | <a id="forgot-link" href="">Забыли пароль</a></p>
            <? if (isset($_SESSION['auth']['errors'])): ?>
                <div class="error"><?= $_SESSION['auth']['errors'] ?></div>
                <? unset($_SESSION['auth']); ?>
            <? endif; ?>
            <? if (isset($_SESSION['auth']['ok'])): ?>
                <div class="ok"><?= $_SESSION['auth']['ok'] ?></div>
                <? unset($_SESSION['auth']); ?>
            <? endif; ?>
        <? else: ?>
            <p>Добро пожаловать, <b><?= htmlspecialchars_decode($_SESSION['auth']['user']) ?></b></p>
            <p><a href="<?= PATH ?>logout">Выход</a></p>
        <? endif; ?>
    </div>
<div id="forgot">
    <form action="<?=PATH?>forgot" method="post">
        <p>
            <label for="email">email регистрации:</label>
            <input type="text" name="email" id="email">
        </p>
        <p class="submit">
            <input type="submit" value="Выслать пароль" name="fpass">
        </p>
    </form>
    <p><a id="auth-link" href="">Вход на сайт</a></p>
</div>
</div>
<ul class="category">
    <? if (!isset($new_categories_menu)): ?>
        <?= $categories_menu ?>
    <? else: ?>
        <?= $new_categories_menu ?>
    <? endif; ?>
</ul>