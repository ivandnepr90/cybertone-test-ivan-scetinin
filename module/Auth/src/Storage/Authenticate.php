<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11.01.2017
 * Time: 1:19
 */

namespace Auth\Storage;


use Zend\Authentication\AuthenticationService;

class Authenticate
{

    protected $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this -> authenticationService = $authenticationService;
    }

    public function login($identity, $credential, $user_agent, $ip_address) {
        $this->getAuthService()->getAdapter()->setIdentity($identity) -> setCredential($credential);
        $result = $this->getAuthService()->authenticate();
        if($result->isValid) {
            $columnsToOmit = ['password'];
            $user=$this->getAuthService()->getAdapter() -> getResultRowObject(null, $columnsToOmit);
            $user->ip_address = $ip_address;
            $user->user_agent = $user_agent;
            $this->storeIdentity($user);
        }
        return $result;
    }

    function logout() {
        $this->getAuthService()->getStorage()->clear();
    }

    public function hasIdentity() {
        return $this -> getAuthService()->getStorage()->read();
    }

    public function storeIdentity($identity) {
        $this->getAuthService()->getStorage()->write($identity);
    }

    public function getAuthService() {
        return $this->authenticationService;
    }

    public function toArray() {
        $hidraty = json_encode($this->hasIdentity());
        return json_decode($hidraty, true);
    }
}