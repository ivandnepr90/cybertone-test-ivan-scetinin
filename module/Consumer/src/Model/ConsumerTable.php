<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 14:31
 */

namespace Consumer\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ConsumerTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false)
    {
        if ($paginated) {
            return $this->fetchPaginatedResults();
        }

        return $this->tableGateway->select();
    }

    private function fetchPaginatedResults()
    {
        // Create a new Select object for the table:
        $select = new Select($this->tableGateway->getTable());

        // Create a new result set based on the Album entity:
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Consumer());

        // Create a new pagination adapter object:
        $paginatorAdapter = new DbSelect(
        // our configured select object:
            $select,
            // the adapter to run it against:
            $this->tableGateway->getAdapter(),
            // the result set to hydrate:
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getConsumer($consumerId)
    {
        $consumerId = (int)$consumerId;
        $rowset = $this->tableGateway->select(['consumerId' => $consumerId]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $consumerId
            ));
        }

        return $row;
    }

    public function saveConsumer(Consumer $consumer)
    {
        $data = [
            'consumerId' => $consumer->consumerId,
            'groupId' => $consumer->groupId,
            'login' => $consumer->login,
            'password' => $consumer->password,
            'email' => $consumer->email,
            'expirationDateAndTime' => $consumer->expirationDateAndTime,
            'imageExtention' => $consumer->imageExtention
        ];

        $consumerId = (int)$consumer->consumerId;

        if ($consumerId === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getConsumer($consumerId)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $consumerId
            ));
        }

        $this->tableGateway->update($data, ['consumerId' => $consumerId]);
    }

    public function deleteConsumer($consumerId)
    {
        $this->tableGateway->delete(['consumerId' => (int)$consumerId]);
    }

}