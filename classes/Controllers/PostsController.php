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
use Models\Comment;
use Models\Post;

class PostsController extends Controller
{

    const POST_LIMIT = 2;

    public function createAction(User $user, Post $post)
    {
        if (!$user->loggedin()) {
            $this->application->make(Session::class)->addFlash('error', 'Keine Berechtigung, um einen Beitrag anzulegen.');
            $this->redirect(Config::get('app.base_url'));
        }
        $data = [];
        if ($this->request->isPost()) {
            $postData = $this->request->getAll();
            $validate = $post->validate($postData);
            if ($validate === true) {
                $postData['user_id'] = $user->getId();
                if ($post->insert($postData)) {
                    $this->application->make(Session::class)->addFlash('success', 'Beitrag erfolgreich angelegt.');
                    $this->redirect(Config::get('app.base_url') . '/posts');
                }
            } else {
                $data['errors'] = $validate;
                $data['post'] = $post->filter($postData);
            }
        }

        $this->view->setTemplate('posts/create.php');
        $this->view->setData($data);
        return $this->view;
    }

    public function indexAction(Post $post)
    {
        $page = $this->request->get('page', 1);
        $pagination = $this->getPagination($post);
        $posts = $post->findAll(static::POST_LIMIT, ($page - 1) * static::POST_LIMIT);
        $this->setListView($posts, $pagination);
        return $this->view;
    }

    public function userListAction(Post $post, $userId)
    {
        $page = $this->request->get('page', 1);
        $filter = ['user_id' => $userId];
        $pagination = $this->getPagination($post, $filter);
        $posts = $post->findAll( static::POST_LIMIT, ($page - 1) * static::POST_LIMIT, $filter);
        $this->setListView($posts, $pagination);
        return $this->view;
    }

    protected function preparePagination($countAll, $page, $perPage = self::POST_LIMIT)
    {
        $countPages = ceil($countAll / $perPage);
        if ($page < $countPages) {
            $nextPage = $page + 1;
        }
        if ($page > 1) {
            $beforePage = $page - 1;
        }
        return ['beforePage' => (isset($beforePage)) ? $beforePage : null, 'nextPage' => (isset($nextPage)) ? $nextPage : null];
    }

    public function showAction(Post $post, Comment $comment, $id)
    {
        $data = [];
        if($this->request->isPost()) {
            //Neuer Kommentar
            $commentData = $this->request->getAll();
            $validate = $comment->validate($commentData);
            if ($validate === true) {
                $commentData['post_id'] = $id;
                $commentData['ip'] = getenv('REMOTE_ADDR');
                if ($comment->insert($commentData)) {
                    $this->application->make(Session::class)->addFlash('success', 'Kommentar erfolgreich hinzugefügt.');
                }
            } else {
                $data['errors'] = $validate;
                $data['commentData'] = $comment->filter($commentData);
            }
        }
        $posting = $post->find($id);
        $comments = $comment->findAll(['post_id' => $id]);
        $this->view->setTemplate('posts/show.php', array_merge($data, ['posting' => $posting, 'comments' => $comments]));
        return $this->view;
    }

    /**
     * @param Post $post
     * @return array
     */
    protected function getPagination(Post $post, $filter = []): array
    {
        $page = $this->request->get('page', 1);
        $countPosts = $post->count($filter);
        $pagination = $this->preparePagination($countPosts, $page);
        return $pagination;
    }

    /**
     * @param $posts
     * @param $pagination
     */
    protected function setListView($posts, $pagination): void
    {
        $this->view->setTemplate('posts/index.php', ['posts' => $posts, 'pagination' => $pagination, 'actUrl' => $this->request->getUrl()]);
    }

}