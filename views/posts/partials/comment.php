<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-6">
                <?php if ($comment['url']): ?>
                <a href="<?= $comment['url'] ?>" target="_blank">
                    <?php endif; ?>
                    <b><?= $comment['name'] ?></b>
                    <?php if ($comment['url']): ?>
                </a>
            <?php endif; ?>meint
                am: <?= date('d.m.Y', strtotime($comment['created'])) ?>
                um <?= date('H:i', strtotime($comment['created'])) ?>
                <?php if($user_logged_in): ?><?= $comment['ip'] ?><?php endif; ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= nl2br($comment['content']) ?>
    </div>
</div>