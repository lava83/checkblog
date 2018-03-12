<?php
(new \Core\View('layout/header.php'))->render();
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            Login
        </div>
        <div class="panel-body">
            <?php if(isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif;?>
            <form method="post" action="<?= \Core\Config::get('app.base_url') ?>/login">
                <div class="form-group">
                    <label for="username">Nutzername</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Dein Nutzername..." value="<?php if(isset($post['username'])): echo $post['username']; endif;?>">
                </div>
                <div class="form-group">
                    <label for="password">Passwort</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Dein Passwort...">
                </div>
                <button type="submit" class="btn btn-default">Login</button>
            </form>
        </div>
    </div>

<?php
(new \Core\View('layout/footer.php'))->render();
?>