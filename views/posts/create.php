<?php
(new \Core\View('layout/header.php'))->render();
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            Neue Beitrag anlegen
        </div>
        <div class="panel-body">
            <?php if(isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif;?>
            <form method="post" action="<?= \Core\Config::get('app.base_url') ?>/posts/create">
                <div class="form-group<?php if(isset($errors['title'])):?> has-error<?php endif; ?>">
                    <label for="title">Beitragstitel</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Der Beitragstitel..." value="<?php if(isset($post['title'])): echo $post['title']; endif;?>">
                </div>
                <div class="form-group<?php if(isset($errors['content'])):?> has-error<?php endif; ?>">
                    <label for="content">Bietrags Text</label>
                    <textarea rows="3" class="form-control" name="content" id="content" placeholder="Der Beitragstext..."><?php if(isset($post['content'])): echo $post['content']; endif;?></textarea>
                </div>
                <button type="submit" class="btn btn-default">Beitrag Speichern</button>
            </form>
        </div>
    </div>

<?php
(new \Core\View('layout/footer.php'))->render();
?>