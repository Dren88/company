<?php require_once 'header.php' ?>
<div class="page-wrap">
    <div class="content">

        <h1>Настройки сайта</h1>
        <small>*Измените настройку и кликните вне поля для ее сохранения или нажмите Enter</small>

        <table class="zebra" data-table="">
            <thead>
            <tr>
                <th>Настройка</th>
                <th>Значение</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($get_options as $option): ?>
                <tr>
                    <td><?= $option['name'] ?></td>
                    <td>
                        <? if ($option['title'] == 'theme'): ?>
                            <select name="theme" class="edit">
                                <?foreach ($themes as $theme):?>
                                    <option value="<?=$theme?>" <?if ($theme == $option['value']) echo 'selected'?>>
                                        <?=$theme?>
                                    </option>
                                <?endforeach;?>
                            </select>
                        
                        <? else: ?>
                            <input type="text" name="<?= $option['title'] ?>" value="<?= $option['value'] ?>"
                                   class="edit">
                        <? endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <div class="sidebar-wrap">
        <?require_once 'sidebar.php'?>
    </div>
    </div>

<?php require_once 'footer.php' ?>