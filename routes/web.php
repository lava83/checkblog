<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 11.03.2018
 * Time: 22:57
 */

\Core\Router::add('user/list', function(){
    echo 'liste';
});
\Core\Router::add('user/show/(.*)', ['use' => 'Controllers\\IndexController@index']);