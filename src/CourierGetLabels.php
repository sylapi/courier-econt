<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Sylapi\Courier\Contracts\CourierGetLabels as CourierGetLabelsContract;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\LabelType as LabelTypeContract;
use Sylapi\Courier\Econt\Responses\Label as LabelResponse;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Responses\Label as ResponseLabel;

class CourierGetLabels implements CourierGetLabelsContract
{
    private $session;

    const API_PATH = '/services/Shipments/ShipmentService.getShipmentStatuses.json';

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId, LabelTypeContract $labelType): ResponseLabel
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
        return new LabelResponse($labelUrl);
    }


    private function request(string $shipmentId): array   
    {
        return [
            'shipmentNumbers' => [ $shipmentId ]
        ];
    }    
}
