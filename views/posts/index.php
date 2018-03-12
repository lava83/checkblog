<?php
(new \Core\View('layout/header.php'))->render();
?>

<?php if(!empty($posts)):?>
    <?php foreach($posts as $post): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="<?= \Core\Config::get('app.base_url')?>/posts/user/<?= $post['user_id'] ?>"><?= $post['username'] ?></a>
                    </div>
                    <div class="col-xs-6">
                        <a href=""><?= $post['title'] ?></a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?= $post['content'] ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif;?>

<?php
(new \Core\View('layout/footer.php'))->render();
?>