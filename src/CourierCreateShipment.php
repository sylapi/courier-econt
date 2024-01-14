<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt;


use Exception;
use Sylapi\Courier\Contracts\Shipment;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Sylapi\Courier\Econt\Entities\Options;
use Sylapi\Courier\Econt\Helpers\ApiErrorsHelper;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Econt\Responses\Shipment as ShipmentResponse;
use Sylapi\Courier\Contracts\CourierCreateShipment as CourierCreateShipmentContract;
use Sylapi\Courier\Responses\Shipment as ResponseShipment;


class CourierCreateShipment implements CourierCreateShipmentContract
{
    private $session;

    const API_PATH = '/services/Shipments/LabelService.createLabel.json';

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function createShipment(Shipment $shipment): ResponseShipment
    {
        $response = new ShipmentResponse();
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

            if($result->label->shipmentNumber === NULL){
                throw new TransportException('Shipment Id does not exist.');
            }

            $response->setResponse($result);
            $response->setReferenceId((string) $result->label->shipmentNumber);
            $response->setShipmentId((string) $result->label->shipmentNumber);
        
        } catch (ClientException $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        } 
        catch (ServerException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            throw new TransportException(ApiErrorsHelper::buildErrorMessage($responseBody), $e->getCode());
        } catch (Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());       
        }
        return $response;
    }

    private function request(Shipment $shipment): array   
    {
        /**
         * @var Options $options
         */
        $options = $shipment->getOptions();

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
                'shipmentType' => $options->getShipmentType(),
                'weight' => $shipment->getParcel()->getWeight(),
                'shipmentDescription' => $shipment->getContent(),                            
            ],
            'mode' => $options->getMode(), 
        ];


        if($options->has('senderClientNumber')) {
            $request['label']['senderClient']['clientNumber'] = $options->getSenderClientNumber();
        }

        if($options->has('senderOfficeCode')) {
            $request['label']['senderOfficeCode'] = $options->getSenderOfficeCode();
        }

        if($options->has('paymentSenderMethod')) {
            $request['label']['paymentSenderMethod'] = $options->getPaymentSenderMethod();
        }

        if($options->has('holidayDeliveryDay')) {
            $request['label']['holidayDeliveryDay'] = $options->getHolidayDeliveryDay();
        }       

        return $request;
    }
}