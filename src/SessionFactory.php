<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;
use UnexpectedValueException;
use Sylapi\Courier\Econt\Entities\Credentials;

class SessionFactory
{
    private $sessions = [];

    //These constants can be extracted into injected configuration
    const API_LIVE = 'http://ee.econt.com/';

    public function session(Credentials $credentials): Session
    {
        $apiUrl = self::API_LIVE;


        $credentials->setApiUrl($apiUrl);

        $key = sha1( $apiUrl.':'.$credentials->getLogin().':'.$credentials->getPassword());

        return (isset($this->sessions[$key])) ? $this->sessions[$key] : ($this->sessions[$key] = new Session($credentials));
    }
}
