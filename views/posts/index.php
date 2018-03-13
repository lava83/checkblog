<?php
(new \Core\View('layout/header.php'))->render();
?>

<?php if(!empty($posts)):?>
    <?php foreach($posts as $post): ?>
        <?php (new \Core\View('posts/partials/post.php', ['post' => $post]))->render() ?>
    <?php endforeach; ?>
    <?php if(!empty($pagination['beforePage'])):?>
        <a href="<?= $actUrl ?>?page=<?= $pagination['beforePage']?>" class="btn btn-default">Neuere Einträge</a>
    <?php endif; ?>
    <?php if(!empty($pagination['nextPage'])):?>
        <a href="<?= $actUrl ?>?page=<?= $pagination['nextPage']?>" class="btn btn-default">Ältere Einträge</a>
    <?php endif; ?>
<?php endif;?>

<?php
(new \Core\View('layout/footer.php'))->render();
?>