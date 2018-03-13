<?php

namespace Models;

use Core\Model;

class Comment extends Model
{

    protected $tableName = 'comments';

    protected $filters = [
        'name' => 'trim|strip_tags',
        'email' => 'trim|strip_tags',
        'url' => 'trim|strip_tags',
        'content' => 'trim|strip_tags'
    ];

    /**
     * @param $data
     * @return array|bool
     */
    public function validate($data) {
        $data = $this->filter($data);
        $errors = [];
        if(!isset($data['name']) || empty($data['name'])) {
            $errors['title'] = 'Bitte gebe einen Namen an.';
        }

        if(!isset($data['content']) || empty($data['content'])) {
            $errors['content'] = 'Bitte gebe einen Text ein.';
        }

        return empty($errors) ? true : $errors;
    }



    public function count($filter = []) {
        $sql = 'select count(*) cnt from comments c';
        $sql = $this->filterWhere($filter, $sql);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filter);
        return $stmt->fetchColumn();
    }

    public function findAll($filter = []) {
        $sql = $this->getBaseQuery();
        $sql = $this->filterWhere($filter, $sql);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filter);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return string
     */
    protected function getBaseQuery(): string
    {
        return 'select c.id comment_id, c.name, c.email, c.ip, c.url, c.content, c.created from comments c';
    }

}