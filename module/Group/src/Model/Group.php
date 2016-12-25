<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 14:18
 */

namespace Group\Model;


class Group
{
    public $groupId;
    public $name;

    public function  exchangeArray(array $data) {
        $this->groupId = !empty($data['groupId']) ? $data['groupId'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
    }

}