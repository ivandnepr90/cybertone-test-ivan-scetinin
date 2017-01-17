<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 22:20
 */

namespace Auth\Controller;


use Auth\Form\LoginForm;
use Auth\Storage\Authenticate;
use Auth\Storage\Result;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{

    protected $authenticate;

    private $containerInterface;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    /**
     * @return mixed
     */
    public function getAuthenticate()
    {
        $this->authenticate = $this->containerInterface->get(Authenticate::class); //new AuthenticationService();
        return $this->authenticate;
    }

    public function LoginAction()
    {
        $this->layout('layout/login');
        $auth = $this->getAuthenticate();

        if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $form = $this->containerInterface->get(LoginForm::class);

        if ($this->params()->fromPost()):

            $form->setData($this->params()->fromPost());

            if($form->isValid()) {
                $dataform = $form->getData();

                $result = $auth->login(
                    $dataform['email'],
                    md5($dataform['password']),
                    $this->getRequest()->getServer('HTTP_USER_AGENT'),
                    $this->getRequest()->getServer('REMOTE_ADDR')
                );

                $messagesResult = new Result($result->getCode(), $result->getIdentity());

                if($result->isValid()) {
                    return $this->redirect()->toRoute('home');
                }
            }
        endif;

        return new ViewModel(compact('form'));
    }

    public function logoutAction() {
        if($this->getAuthenticate()->hasIdentity()) {
            $this->getAuthenticate()->logout();
        }
        return $this->redirect()->toRoute('login');
    }
}