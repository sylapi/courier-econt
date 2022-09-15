<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Exception;
use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Entities\Response;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\Courier\Contracts\CourierPostShipment;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class EcontCourierPostShipment implements CourierPostShipment
{
    private $session;

    const API_PATH = '/services/Shipments/ShipmentService.requestCourier.json';

    public function __construct(EcontSession $session)
    {
        $this->session = $session;
    }

    public function postShipment(Booking $booking): ResponseContract
    {
        $response = new Response();
        try {
            $stream = $this->session
            ->client()
            ->request(
                'POST',
                self::API_PATH,
                [
                    'json' => $this->request($booking),
                ]
            );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new TransportException('Json data response is incorrect');
            }

            $response->courierRequestID = $result->courierRequestID ?? NULL;

            if($response->courierRequestID === NULL){
                throw new TransportException('Request courier id does not exist.');
            }
        } catch (ClientException $e) {
            $exception = new TransportException($e->getMessage(), $e->getCode());
            ResponseHelper::pushErrorsToResponse($response, [$exception]);
        } catch (Exception $e) {
            $exception = new TransportException($e->getMessage(), $e->getCode());
            ResponseHelper::pushErrorsToResponse($response, [$exception]);
        }

        return $response;
    }

    private function request(Booking $booking): array   
    {
        return [
            'requestTimeFrom' => $booking->requestTimeFrom ?? NULL,
            'requestTimeTo' => $booking->requestTimeTo ?? NULL,
            'shipmentType' => $booking->shipmentType ?? NULL,
            'shipmentPackCount' => $booking->shipmentPackCount ?? NULL,
            'shipmentWeight' => $booking->shipmentWeight ?? NULL,
            'senderClient' => [
                'name' => $booking->senderClient['name'] ?? NULL,
                'phones' => $booking->senderClient['phones'] ?? []
            ],
            'senderAddress' => [
                'city' => [
                    'country' => [
                        'code3' => $booking->senderAddress['city']['country']['code3'] ?? NULL
                    ],
                    'postCode' => $booking->senderAddress['city']['postCode'] ?? NULL,
                    'name' => $booking->senderAddress['city']['name'] ?? NULL
                ],
                'fullAddress' => $booking->senderAddress['fullAddress'] ?? NULL
            ]
        ];
    }
}
