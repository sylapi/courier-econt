<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use GuzzleHttp\Client as Client;
use Sylapi\Courier\Econt\Entities\Credentials;

class Session
{
    private $credentials;
    private $client;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
        $this->client = null;
    }


    public function client(): Client
    {
        if (!$this->client) {
            $this->client = $this->initializeSession();
        }

        return $this->client;
    }

    private function initializeSession(): Client
    {
        $this->client = new Client([
            'base_uri' => $this->credentials->getApiUrl(),
            'auth' => [$this->credentials->getLogin(), $this->credentials->getPassword()],
            'headers'  => [
                'Content-Type'  => 'application/json',
            ],
        ]);

        return $this->client;
    }



}
