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

class ConsumerTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
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