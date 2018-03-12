<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 12.03.18
 * Time: 12:51
 */

namespace Controllers;


use Components\User;
use Core\Config;
use Core\Controller;
use Core\Session;

class UserController extends Controller
{

    protected function preDispatch()
    {
        parent::preDispatch();
        $this->redirectIfLoggedin();
    }

    public function loginAction(User $user) {
        $data = [];
        if($this->request->isPost()) {
            if($user->login($this->request->username, $this->request->password)) {
                $this->application->make(Session::class)->addFlash('success', 'Login erfolgreich');
                $this->redirect(Config::get('app.base_url'));
            } else {
                $data['errors'] = [
                    'login' => 'Die Benutzerdaten sind leider nicht korrekt.'
                ];
                $data['post'] = [
                    'username' => $this->request->username
                ];
            }
        }
        $this->view->setTemplate('user/login.php');
        $this->view->setData($data);
        return $this->view;
    }

    public function logoutAction(User $user) {
        $user->logout();
        $this->application->make(Session::class)->addFlash('success', 'Logout erfolgreich');
        $this->redirect(Config::get('app.base_url'));
    }

    protected function redirectIfLoggedin(): void
    {
        if ($this->action === 'loginAction') {
            /** @var User $user */
            $user = $this->application->make(User::class);
            if ($user->loggedin()) {
                $this->redirect(Config::get('app.base_url'));
            }
        }
    }

}