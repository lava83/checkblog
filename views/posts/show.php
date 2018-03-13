<?php
(new \Core\View('layout/header.php'))->render();
?>

<?php if (!empty($posting)): ?>
    <?php (new \Core\View('posts/partials/post.php', ['post' => $posting]))->render() ?>
    <?php if (!empty($comments)): ?>
        <h3>Kommentare</h3>
        <?php foreach ($comments as $comment): ?>
            <?php (new \Core\View('posts/partials/comment.php', ['comment' => $comment]))->render() ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php (new \Core\View('posts/partials/comment_form.php', ['posting' => $posting, 'commentData' => $commentData]))->render() ?>
<?php endif; ?>

<?php
(new \Core\View('layout/footer.php'))->render();
?>