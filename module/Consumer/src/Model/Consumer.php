<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 14:21
 */

namespace Consumer\Model;


use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Consumer
{
    public $consumerId;
    public $groupId;
    public $login;
    public $password;
    public $email;
    public $expirationDateAndTime;
    public $imageExtention;

    private $inputFilter;


    public function  exchangeArray(array $data) {
        $this->consumerId = !empty($data['consumerId']) ? $data['consumerId'] : null;
        $this->groupId = !empty($data['groupId']) ? $data['groupId'] : null;
        $this->login = !empty($data['login']) ? $data['login'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->expirationDateAndTime = !empty($data['expirationDateAndTime']) ? $data['expirationDateAndTime'] : null;
        $this->imageExtention = !empty($data['imageExtention']) ? $data['imageExtention'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'consumerId'     => $this->consumerId,
            'groupId' => $this->groupId,
            'login'  => $this->login,
            'password' => $this -> password,
            'email' => $this -> email,
            'expirationDateAndTime' => $this -> expirationDateAndTime,
            'imageExtention' => $this -> imageExtention
        ];
    }

    /* Add the following methods: */

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'consumerId',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'login',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}