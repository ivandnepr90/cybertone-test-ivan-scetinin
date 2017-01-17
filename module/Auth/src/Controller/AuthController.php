<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09.01.2017
 * Time: 23:14
 */

namespace Auth\Controller;


use Auth\Model\UsersRepository;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{

    private $containerInterface;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this -> containerInterface = $containerInterface;
    }

    public function indexAction() {
        $this -> checkIdentity();

        $users = $this -> containerInterface->get(UsersRepository::class)->select();
       // $this->layout('layout/auth');
        return new ViewModel(compact('users'));
    }

    protected function checkIdentity() {
        if(!$this->identity()) {
            return $this->redirect()->toRoute('login');
        }
    }
}