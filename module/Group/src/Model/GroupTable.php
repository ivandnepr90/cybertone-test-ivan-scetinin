<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 14:40
 */

namespace Group\Model;


use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class GroupTable
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

    public function getGroup($groupId)
    {
        $groupId = (int)$groupId;
        $rowset = $this->tableGateway->select(['groupId' => $groupId]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $groupId
            ));
        }

        return $row;
    }

    public function saveConsumer(Group $group)
    {
        $data = [
            'groupId' => $group->groupId,
            'name'      => $group -> name
        ];

        $groupId = (int)$group->groupId;

        if ($groupId === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getGroup($groupId)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $groupId
            ));
        }

        $this->tableGateway->update($data, ['groupId' => $groupId]);
    }

    public function deleteConsumer($groupId)
    {
        $this->tableGateway->delete(['groupId' => (int)$groupId]);
    }

}