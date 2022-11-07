<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;


use Exception;
use Sylapi\Courier\Entities\Response;
use Sylapi\Courier\Contracts\Shipment;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\CourierCreateShipment;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\Courier\Econt\Helpers\EcontApiErrorsHelper;


class EcontCourierCreateShipment implements CourierCreateShipment
{
    private $session;

    const API_PATH = '/services/Shipments/LabelService.createLabel.json';

    public function __construct(EcontSession $session)
    {
        $this->session = $session;
    }

    public function createShipment(Shipment $shipment): ResponseContract
    {
        $response = new Response();
        try {
            $stream = $this->session
            ->client()
            ->request(
                'POST',
                self::API_PATH,
                [
                    'json' => $this->request($shipment),
                ]
            );

            $result = json_decode($stream->getBody()->getContents());

            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new TransportException('Json data response is incorrect');
            }

            $response->shipmentId = $result->label->shipmentNumber;
            $response->referenceId = $response->shipmentId;
            if($response->shipmentId === NULL){
                throw new TransportException('Shipment Id does not exist.');
            }

        
        } catch (ClientException $e) {
            $exception = new TransportException($e->getMessage(), $e->getCode());
            ResponseHelper::pushErrorsToResponse($response, [$exception]);
        } 
        catch (ServerException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $message = EcontApiErrorsHelper::buildErrorMessage($responseBody);
            $exception = new TransportException($message, $e->getCode());
            ResponseHelper::pushErrorsToResponse($response, [$exception]);
        } catch (Exception $e) {
            $exception = new TransportException($e->getMessage(), $e->getCode());       
            ResponseHelper::pushErrorsToResponse($response, [$exception]);
        }
        return $response;
    }

    private function request(Shipment $shipment): array   
    {
        $parameters = $this->session->parameters();

        $request = [
            'label' => [
                'senderClient' => [
                    'name' => $shipment->getSender()->getFullName(),
                    'phones' => [
                        $shipment->getSender()->getPhone()
                    ],
                    'email' => $shipment->getSender()->getEmail()
                ],
                'senderAgent' => [
                    'name' => $shipment->getSender()->getContactPerson(),
                    'phones' => [
                        $shipment->getSender()->getPhone()
                    ],
                    'email' => $shipment->getSender()->getEmail()                   
                ],
                'senderAddress' => [
                    'city' => [
                        'country' => [
                            'code3' => $shipment->getSender()->getCountryCode(),
                            'name' => $shipment->getSender()->getCountry(),
                        ],
                        'name' => $shipment->getSender()->getCity(),
                        'postCode' => $shipment->getSender()->getZipCode()
                    ],
                    'street' => $shipment->getSender()->getStreet(),
                    'num' => trim($shipment->getSender()->getHouseNumber().' '.$shipment->getSender()->getApartmentNumber()),
                ],
                'receiverClient' => [
                    'name' => $shipment->getReceiver()->getFullName(),
                    'phones' => [
                        $shipment->getReceiver()->getPhone()
                    ],
                    'email' => $shipment->getReceiver()->getEmail()
                ],

                'receiverAddress' => [
                    "city" => [
                        'country' => [
                            'code3' => $shipment->getReceiver()->getCountryCode(),
                            'name' => $shipment->getReceiver()->getCountry(),
                        ],
                        'name' => $shipment->getReceiver()->getCity(),
                        "postCode" => $shipment->getReceiver()->getZipCode()
                    ],
                    'street' => $shipment->getReceiver()->getStreet(),
                    'num' => trim($shipment->getReceiver()->getHouseNumber().' '.$shipment->getReceiver()->getApartmentNumber()),
                    'other' => ''
                ],
                'packCount' =>  $shipment->getQuantity(),
                'shipmentType' => ($parameters->hasProperty('shipmentType')) ? $parameters->shipmentType : 'PACK',
                'weight' => $shipment->getParcel()->getWeight(),
                'shipmentDescription' => $shipment->getContent(),                            
            ],
            'mode' => ($parameters->hasProperty('mode')) ? $parameters->mode : 'create', 
        ];

        if($parameters->hasProperty('senderClientNumber')) {
            $request['label']['senderClient']['clientNumber'] = $parameters->senderClientNumber;
        }

        if($parameters->hasProperty('senderOfficeCode')) {
            $request['label']['senderOfficeCode'] = $parameters->senderOfficeCode;
        }

        if($parameters->hasProperty('paymentSenderMethod')) {
            $request['label']['paymentSenderMethod'] = $parameters->paymentSenderMethod;
        }  
        
        if($parameters->hasProperty('holidayDeliveryDay')) {
            $request['label']['holidayDeliveryDay'] = $parameters->holidayDeliveryDay;
        }          

        return $request;
    }
}