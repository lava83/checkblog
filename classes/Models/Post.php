<?php

namespace Models;

use Core\Db;
use Core\Model;

class Post extends Model
{

    protected $tableName = 'posts';

    protected $filters = [
        'title' => 'trim|strip_tags',
        'content' => 'trim|strip_tags:<b><strong><p>'
    ];

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



    public function count($filter = []) {
        $sql = 'select count(*) cnt from posts p';
        $sql = $this->filterWhere($filter, $sql);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filter);
        return $stmt->fetchColumn();
    }

    public function findAll($limit = 3, $offset = 0, $filter = []) {
        $sql = $this->getBaseQuery();
        $sql = $this->filterWhere($filter, $sql);
        $stmt = $this->db->prepare($sql . ' order by created desc limit ' .$limit.' offset '.$offset);
        $stmt->execute($filter);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findAllByUser($userId, $limit = 3, $offset = 0) {
        return $this->findAll($limit, $offset, ['user_id' => $userId]);
    }

    public function find($id) {
        $filter = ['post_id' => $id];
        $sql = $this->getBaseQuery();
        $sql .= ' where p.id=:post_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filter);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @return string
     */
    protected function getBaseQuery(): string
    {
        return 'select p.id post_id, p.title, p.content, p.created, u.id user_id, u.username from posts p inner join users u on(u.id = p.user_id)';
    }

}