<?php

namespace Core;


use Exceptions\ModelException;

class Model
{

    /**
     * @var \PDO
     */
    protected $db = null;

    protected $tableName;

    protected $filters = [
    ];

    public function __construct()
    {
        if(empty($this->tableName)) {
            throw new ModelException('Please add a table name to the property.');
        }
        $this->db = Db::getInstance();
    }

    public function filter($data)
    {
        foreach ($data as $key => $value) {
            if (isset($this->filters[$key])) {
                foreach (explode('|', $this->filters[$key]) as $filter) {
                    $funcParams = [$value];
                    if (strpos($filter, ':')) {
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

    public function insert($data)
    {
        $sql = 'insert into ' . $this->tableName . ' (';
        foreach ($data as $key => $value) {
            $sql .= '`' . $key . '`,';
        }
        $sql = substr($sql, 0, -1);
        $sql .= ') values (';
        foreach ($data as $key => $value) {
            $sql .= ':' . $key . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql .= ')';
        $stmt = $this->db->prepare($sql . '');
        $data = $this->filter($data);
        return $stmt->execute($data);
    }

    /**
     * @param $filter
     * @param $sql
     * @return string
     */
    protected function filterWhere($filter, $sql): string
    {
        if (!empty($filter)) {
            $sql .= ' where 1=1';
            foreach ($filter as $key => $value) {
                $sql .= ' and ' . $key . '=:' . $key;
            }
        }
        return $sql;
    }

}