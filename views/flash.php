<?php if(isset($_SESSION['res']['ok'])): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=$_SESSION['res']['ok']?>
    </div>
<?php elseif(isset($_SESSION['res']['error'])): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?=$_SESSION['res']['error']?>
    </div>
<?php endif; unset($_SESSION['res']) ?>