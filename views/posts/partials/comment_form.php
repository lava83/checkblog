<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Kommentar hinzufügen</h3>
    </div>
    <div class="panel-body">
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= \Core\Config::get('app.base_url') ?>/posts/<?= $posting['post_id'] ?>">
            <div class="form-group<?php if (isset($errors['name'])): ?> has-error<?php endif; ?>">
                <label for="name">Name</label>
                <input type="text" aria-required="true" required class="form-control" id="name" name="name"
                       placeholder="Dein Name..."
                       value="<?php if (isset($commentData['name'])): echo $commentData['name']; endif; ?>">
            </div>
            <div class="form-group<?php if (isset($errors['email'])): ?> has-error<?php endif; ?>">
                <label for="email">E-Mail-Adresse</label>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="Deine E-Mail-Adresse..."
                       value="<?php if (isset($commentData['email'])): echo $commentData['email']; endif; ?>">
            </div>
            <div class="form-group<?php if (isset($errors['url'])): ?> has-error<?php endif; ?>">
                <label for="email">E-Mail-Adresse</label>
                <input type="url" class="form-control" id="url" name="url" placeholder="Deine Website URL..."
                       value="<?php if (isset($commentData['url'])): echo $commentData['url']; endif; ?>">
            </div>
            <div class="form-group<?php if (isset($errors['content'])): ?> has-error<?php endif; ?>">
                <label for="content">Kommentar Text</label>
                <textarea required aria-required="true" rows="3" class="form-control" name="content" id="content"
                          placeholder="Dein Kommentar..."><?php if (isset($commentData['content'])): echo $commentData['content']; endif; ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">Kommentar Speichern</button>
        </form>
    </div>
</div>