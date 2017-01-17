<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11.01.2017
 * Time: 22:34
 */

namespace Auth\Storage;


class Result
{
    protected $message;
    const SUCCESS = 1;
    const FAILURE = 0;
    const FAILURE_IDENTITY_NOT_FOUND = -1;
    const FAILURE_IDENTITY_AMBIGUOUS = -2;
    const FAILURE_CREDENTIAL_INVALID = -3;
    const FAILURE_UNCATEGORIZED = -4;

    public function __construct($code, $identity, array $messages = [
        0 => "0",
        1 => "1",
        -1 => "-1",
        -2 => "-2",
        -3 => "-3",
        -4 => "-4"
    ]) {

        switch ($code) {
            case Result::FAILURE:
                $this->setMessage("Faillure", "error");
                break;
            case Result::SUCCESS:
                $this->setMessage(sprintf($messages[$code], $identity), "success");
                break;
            case Result::FAILURE_IDENTITY_NOT_FOUND:
                $this->setMessage(sprintf($messages[$code], $identity), "alert");
                break;
            case Result::FAILURE_IDENTITY_AMBIGUOUS:
                $this->setMessage(sprintf($messages[$code], $identity), "alert");
                break;
            case Result::FAILURE_CREDENTIAL_INVALID:
                $this->setMessage(sprintf($messages[$code], $identity), "alert");
                break;
            case Result::FAILURE_UNCATEGORIZED:
                $this->setMessage(sprintf($messages[$code], $identity), "alert");
                break;
            default:
        }

    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message, $class='success') {
        $icon['success'] = 'ion-checkmark-found';
        $icon['info'] = 'ion-information-circled';
        $icon['alert'] = 'ion-alert-circled';
        $icon['error'] = 'ion-close-circled';
        $this->message = sprintf("<div class='alert alert_%s'><span>%s<i class='icone %s'></i></span></div>div>", $class, $message, $icon[$class]);
    }
}