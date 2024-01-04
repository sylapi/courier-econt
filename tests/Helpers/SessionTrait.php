<?php

namespace Sylapi\Courier\Econt\Tests\Helpers;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Sylapi\Courier\Econt\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client as HttpClient;


trait SessionTrait
{
    /**
     * @param array<array<mixed,mixed>> $responses
     */
    private function getSessionMock(array $responses)
    {
        $responseMocks = [];

        foreach ($responses as $response) {
            $responseMocks[] = new Response((int) $response['code'], $response['header'], $response['body']);
        }

        $mock = new MockHandler($responseMocks);

        $handlerStack = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handlerStack]);

        $sessionMock = $this->createMock(Session::class);
        $sessionMock->method('client')
            ->willReturn($client);

        return $sessionMock;
    }
}
