<?php

\Core\Router::add('', \Controllers\PostsController::class . '@index');
\Core\Router::add('impressum', \Controllers\ImpressumController::class . '@index');
\Core\Router::add('login', \Controllers\UserController::class . '@login');
\Core\Router::add('logout', \Controllers\UserController::class . '@logout');
\Core\Router::add('posts', \Controllers\PostsController::class . '@index');
\Core\Router::add('posts/user/(.*)', \Controllers\PostsController::class . '@userList');
\Core\Router::add('posts/create', \Controllers\PostsController::class . '@create');
\Core\Router::add('posts/(.*)', \Controllers\PostsController::class . '@show');

//\Core\Router::add('post/delete/(*.)', \Controllers\UserController::class . '@logout');