<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11.01.2017
 * Time: 1:19
 */

namespace Auth\Storage;

use Zend\Authentication\Storage\Session as SessionStorage;

class AuthStorage extends SessionStorage
{
    protected $session;

    public function setRememberMe($rememberMe = 0, $time = 1209600) {
        if($rememberMe == 1) {
            $this -> session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe() {
        $this->session->getManager()->forgetMe();
    }

    public function setSessionId() {
        return $this -> session->getManager()->getId();
    }
}