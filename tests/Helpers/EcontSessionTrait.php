<?php

namespace Sylapi\Courier\Econt\Tests\Helpers;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Sylapi\Courier\Econt\EcontParameters;
use Sylapi\Courier\Econt\EcontSession;

trait EcontSessionTrait
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

        $parametersMock = $this->createMock(EcontParameters::class);

        $sessionMock = $this->createMock(EcontSession::class);
        $sessionMock->method('client')
            ->willReturn($client);
        $sessionMock->method('parameters')
            ->willReturn($parametersMock);

        return $sessionMock;
    }
}
