<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-6">
                Erstellt:
                <b><?php
                    $created = date('d.m.Y', strtotime($post['created']));
                    if($created == date('d.m.Y')) {
                        echo 'Heute';
                    } else {
                        echo $created;
                    }
                    ?></b> von
                <a href="<?= \Core\Config::get('app.base_url')?>/posts/user/<?= $post['user_id'] ?>"><?= $post['username'] ?></a>
            </div>
            <div class="col-xs-6">
                <a href="<?= \Core\Config::get('app.base_url')?>/posts/<?= $post['post_id'] ?>"><?= $post['title'] ?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= $post['content'] ?>
    </div>
</div>