<?php

namespace Components;


use Core\Application;
use Core\Db;
use Core\Session;

class User
{

    /**
     * @var Session
     */
    protected $session = null;

    /**
     * @var Application
     */
    protected $application = null;

    public function __construct(Session $session, Application $application)
    {
        $this->session = $session;
        $this->application = $application;
    }

    public function getId() {
        return $this->getUser()['id'];
    }

    public function getUser() {
        return $this->session->get('user');
    }

    public function loggedin() {
        return $this->session->get('user_logged_in') === true;
    }

    public function login($username, $password) {
        /** @var \PDO $db */
        $db = $this->application->make(Db::class);
        $stmt = $db->prepare('select id, username, password, firstname, lastname, street, zip, city from users where username=:username');
        $stmt->execute([
            'username' => $username
        ]);
        if($user = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if(password_verify($password, $user['password'])) {
                unset($user['password']);
                $this->session->set('user', $user);
                $this->session->set('user_logged_in', true);
                return true;
            }
        }
        return false;
    }

    public function logout() {
        $this->session->set('user_logged_in', false);
        $this->session->set('user', null);
    }

}