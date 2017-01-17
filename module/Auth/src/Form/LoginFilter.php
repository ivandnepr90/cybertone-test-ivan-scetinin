<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 23:58
 */

namespace Auth\Form;


use Interop\Container\ContainerInterface;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;

class LoginFilter extends InputFilter
{
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->add([
            'name' => 'email',
            //'type' => 'Zend\Form\Element\Email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [NotEmpty::IS_EMPTY => 'Empty string']
                    ],
                ],
                [
                    'name' => EmailAddress::class,
                    'options' => [
                        'messages' => [EmailAddress::INVALID_FORMAT => 'Invalid format']
                    ],
                ]
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [NotEmpty::IS_EMPTY => 'Empty string']
                    ],
                ]
            ],
        ]);
    }
}