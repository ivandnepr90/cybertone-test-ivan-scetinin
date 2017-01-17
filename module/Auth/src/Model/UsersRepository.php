<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 20:05
 */

namespace Auth\Model;


use Zend\Db\TableGateway\TableGateway;

class UsersRepository
{

    private $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this -> tableGateway = $tableGateway;
    }

    public function findAll() {

    }


    public function getTable()
    {
        return $this->tableGateway->getTable();
    }

    public function select($where = null)
    {
        return $this->tableGateway->select($where);
    }

    public function insert($set)
    {
        $this->tableGateway->insert($set);
        return $this->tableGateway->getLastInsertValue();
    }

    public function update($set, $where = null)
    {
        return $this->tableGateway->update($set, $where);
    }

    public function delete($where)
    {
        return $this -> tableGateway->delete($where);
    }
}