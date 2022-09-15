<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use GuzzleHttp\Client as Client;

class EcontSession
{
    private $parameters;
    private $client;

    public function __construct(EcontParameters $parameters)
    {
        $this->parameters = $parameters;
        $this->client = null;
    }

    public function parameters(): EcontParameters
    {
        return $this->parameters;
    }

    public function client(): Client
    {
        if (!$this->client) {
            $this->initializeSession();
        }

        return $this->client;
    }

    private function initializeSession(): void
    {
        $this->client = new Client([
            'base_uri' => $this->parameters->apiUrl,
            'auth' => [$this->parameters->login, $this->parameters->password],
            'headers'  => [
                'Content-Type'  => 'application/json',
            ],
        ]);
    }



}
