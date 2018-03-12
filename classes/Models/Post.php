<?php
/**
 * Created by PhpStorm.
 * User: stefanriedel
 * Date: 12.03.18
 * Time: 16:14
 */

namespace Models;

use Core\Db;

class Post
{

    /**
     * @var \PDO
     */
    protected $db = null;

    protected $filters = [
        'title' => 'trim|strip_tags',
        'content' => 'trim|strip_tags:<b><strong><p>'
    ];

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function filter($data) {
        foreach($data as $key => $value) {
            if(isset($this->filters[$key])) {
                foreach(explode('|', $this->filters[$key]) as $filter) {
                    $funcParams = [$value];
                    if(strpos($filter, ':')) {
                        $extraParams = explode(':', $filter);
                        $filter = $extraParams[0];
                        //the first param is the function name
                        array_shift($extraParams);
                        $funcParams = array_merge($funcParams, $extraParams);
                    }
                    $data[$key] = call_user_func_array($filter, $funcParams);
                }
            }
        }
        return $data;
    }

    /**
     * @param $data
     * @return array|bool
     */
    public function validate($data) {
        $data = $this->filter($data);
        $errors = [];
        if(!isset($data['title']) || empty($data['title'])) {
            $errors['title'] = 'Bitte gebe einen Titel an.';
        }

        if(!isset($data['content']) || empty($data['content'])) {
            $errors['content'] = 'Bitte gebe einen Text ein.';
        }

        return empty($errors) ? true : $errors;
    }

    public function insert($data) {
        $stmt = $this->db->prepare('insert into posts (user_id, title, content) values (:user_id, :title, :content)');
        $data = $this->filter($data);
        return $stmt->execute($data);
    }

}