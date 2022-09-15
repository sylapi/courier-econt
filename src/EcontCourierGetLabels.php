<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Exception;
use Sylapi\Courier\Entities\Label;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Contracts\CourierGetLabels;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\Label as LabelContract;
use Sylapi\Courier\Econt\Helpers\EcontApiErrorsHelper;

class EcontCourierGetLabels implements CourierGetLabels
{
    private $session;

    const API_PATH = '/services/Shipments/ShipmentService.getShipmentStatuses.json';

    public function __construct(EcontSession $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId): LabelContract
    {
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

            $labelUrl = $result->shipmentStatuses[0]->status->pdfURL ?? NULL;

            if($labelUrl === NULL){
                throw new TransportException('Label does not exist.');
            }

        } catch (ClientException $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }
        return new Label($labelUrl);
    }


    private function request(string $shipmentId): array   
    {
        return [
            'shipmentNumbers' => [ $shipmentId ]
        ];
    }    
}
