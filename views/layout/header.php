<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= \Core\Config::get('app.application_name')?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= \Core\Config::get('app.base_url'); ?>/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= \Core\Config::get('app.base_url')?>"><?= \Core\Config::get('app.application_name')?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?= \Core\Config::get('app.base_url')?>">Startseite</a></li>
                <?php if(!$user_logged_in): ?>
                    <li><a href="<?= \Core\Config::get('app.base_url')?>/login">Login</a></li>
                <?php else: ?>
                    <li><a href="<?= \Core\Config::get('app.base_url')?>/logout">Logout</a></li>
                    <li><a href="<?= \Core\Config::get('app.base_url')?>/posts/create">Beitrag hinzufügen</a></li>
                <?php endif;?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container"><div class="template">
        <?php if(\Core\Session::getInstance()->hasFlash('success')): ?>
            <div class="alert alert-success" role="alert">
                <p><?= \Core\Session::getInstance()->flash('success')?></p>
            </div>
        <?php endif; ?>
        <?php if(\Core\Session::getInstance()->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <p><?= \Core\Session::getInstance()->flash('error')?></p>
            </div>
        <?php endif; ?>
