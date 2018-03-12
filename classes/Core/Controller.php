<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 12.03.18
 * Time: 11:10
 */

namespace Core;


use Components\User;

class Controller
{

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $action = null;

    public function __construct(Application $application, Request $request)
    {
        $this->application = $application;
        $this->request = $request;
        $this->view = $this->application->make(View::class);
    }

    public function dispatch($action, $params = []) {
        $this->preDispatch();
        $ret = call_user_func_array([$this, $action], $params);
        $this->postDispatch();
        return $ret;
    }

    protected function preDispatch() {

    }

    protected function postDispatch() {
        /** @var User $user */
        $user = $this->application->make(User::class);
        $this->view->assignGlobal('user_logged_in', $user->loggedin());
    }


    public function redirect($url) {
        header('location: ' . $url);
        exit;
    }

    public function setAction($action) {
        $this->action = $action;
    }
}