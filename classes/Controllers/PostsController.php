<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 12.03.18
 * Time: 15:42
 */

namespace Controllers;


use Components\User;
use Core\Config;
use Core\Controller;
use Core\Session;
use Models\Post;

class PostsController extends Controller
{

    public function createAction(User $user, Post $post) {
        if(!$user->loggedin()) {
            $this->application->make(Session::class)->addFlash('error', 'Keine Berechtigung, um einen Beitrag anzulegen.');
            $this->redirect(Config::get('app.base_url'));
        }
        $data = [];
        if($this->request->isPost()) {
            $postData = $this->request->getAll();
            $validate = $post->validate($postData);
            if($validate === true) {
                $postData['user_id'] = $user->getId();
                if($post->insert($postData)) {
                    $this->application->make(Session::class)->addFlash('success', 'Beitrag erfolgreich angelegt.');
                    $this->redirect(Config::get('app.base_url') . '/posts');
                }
            } else {
                $data['errors'] = $validate;
                $data['post'] = $post->filter($postData);
            }
        }

        $this->view->setTemplateName('posts/create.php');
        $this->view->setData($data);
        return $this->view;
    }

    public function indexAction() {
        $this->view->setTemplateName('posts/index.php');
        return $this->view;
    }

    public function showAction() {

    }

}