<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 23:58
 */

namespace Auth\Form;


use Interop\Container\ContainerInterface;
use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct(ContainerInterface $containerInterface, $name = 'login', array $options = [])
    {
        parent::__construct($name, $options);
        $this -> setInputFilter($containerInterface->get(LoginFilter::class));

        $this -> setAttribute('action', 'login');
        $this -> setAttribute('class', 'form-signin');

        $this ->add(['name' => 'email',
        'type' => 'email',
        'options' => [
            'label' => 'E-Mail'
        ],
        'attributes' => [
            'id' => 'email',
            'required' => true,
            'class' => 'form-control',
            'placeholder' => 'Enter email'
        ]]);

        $this ->add(['name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => [
                'id' => 'password',
                'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Enter password'
            ]]);
    }
}