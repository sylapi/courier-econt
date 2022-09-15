<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Exception;
use Sylapi\Courier\Entities\Status;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Econt\EcontSession;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Contracts\CourierGetStatuses;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\Status as StatusContract;


class EcontCourierGetStatuses implements CourierGetStatuses
{
    private $session;

    const API_PATH = '/services/Shipments/ShipmentService.getRequestCourierStatus.json';

    public function __construct(EcontSession $session)
    {
        $this->session = $session;
    }

    public function getStatus(string $shipmentId): StatusContract
    {
        $statusDescription = null;

        try {
            $stream = $this->session
            ->client()
            ->request(
                'POST',
                self::API_PATH,
                [
                    'json' => $this->request($shipmentId),
                ]
            );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new TransportException('Json data response is incorrect');
            }

            $statusName =  isset($result->requestCourierStatus[0]->status->status) ?
                new EcontStatusTransformer((string) $result->requestCourierStatus[0]->status->status)
                : StatusType::APP_RESPONSE_ERROR;
                
        } catch (ClientException $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }


        return new Status((string) $statusName);
    }


    private function request(string $shipmentId): array   
    {
        return [
            'requestCourierIds' => [
                $shipmentId
            ]
        ];
    }
}
