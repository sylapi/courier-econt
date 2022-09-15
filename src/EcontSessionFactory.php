<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;
use UnexpectedValueException;

class EcontSessionFactory
{
    private $sessions = [];

    /**
     * @var null|EcontParameters<string,mixed>
     */
    private $parameters;

    //These constants can be extracted into injected configuration
    const API_LIVE = 'http://ee.econt.com/';

    public function session(EcontParameters $parameters): EcontSession
    {
        $this->parameters = $parameters;

        if($this->parameters->sandbox) {
            throw new UnexpectedValueException('Sandbox is not available.');
        }

        $this->parameters->apiUrl =  self::API_LIVE;

        $key = sha1($this->parameters->apiUrl.':'.$this->parameters->login.':'.$this->parameters->password);

        return (isset($this->sessions[$key])) ? $this->sessions[$key] : ($this->sessions[$key] = new EcontSession($this->parameters));
    }
}
