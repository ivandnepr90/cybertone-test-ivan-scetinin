<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 23:16
 */

namespace Consumer\Form;

use Zend\Form\Form;

class ConsumerForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('consumer');

        $this->add([
            'name' => 'consumerId',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'groupId',
            'type' => 'text',
            'options' => [
                'label' => 'groupId',
            ],
        ]);
        $this->add([
            'name' => 'login',
            'type' => 'text',
            'options' => [
                'label' => 'login',
            ],
        ]);
        $this->add([
            'name' => 'password',
            'type' => 'text',
            'options' => [
                'label' => 'password',
            ],
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'options' => [
                'label' => 'email',
            ],
        ]);
        $this->add([
            'name' => 'expirationDateAndTime',
            'type' => 'Zend\Form\Element\DateTime',
            'options' => [
                'label' => 'expirationDateAndTime',
                'format' => 'Y-m-d'
            ],
        ]);
        /*$this->add([
            'name' => 'imageExtention',
            'type' => 'text',
            'options' => [
                'label' => 'imageExtention',
            ],
        ]);*/

        $this -> add([
            'name' => 'imageExtention',
            'type' => 'Zend\Form\Element\File',
            'options' => [
                'label' => 'imageExtention',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}