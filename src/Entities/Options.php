<?php

declare(strict_types=1);

namespace Sylapi\Courier\Econt\Entities;

use Sylapi\Courier\Abstracts\Options as OptionsAbstract;

class Options extends OptionsAbstract
{
    const DEFAULT_SHIPMENT_TYPE = 'PACK';
    const DEFAULT_MODE = 'create';

    private string $shipmentType = self::DEFAULT_SHIPMENT_TYPE;
    private string $mode = self::DEFAULT_MODE;
    private string $senderClientNumber;
    private string $senderOfficeCode;
    private string $paymentSenderMethod;
    private string $holidayDeliveryDay;


    public function getShipmentType(): string
    {
        return $this->shipmentType;
    }

    public function setShipmentType(string $shipmentType): self
    {
        $this->shipmentType = $shipmentType;

        return $this;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getSenderClientNumber(): ?string
    {
        return $this->senderClientNumber;
    }

    public function setSenderClientNumber(?string $senderClientNumber): self
    {
        $this->senderClientNumber = $senderClientNumber;

        return $this;
    }

    public function getSenderOfficeCode(): ?string
    {
        return $this->senderOfficeCode;
    }

    public function setSenderOfficeCode(?string $senderOfficeCode): self
    {
        $this->senderOfficeCode = $senderOfficeCode;

        return $this;
    }

    public function getPaymentSenderMethod(): ?string
    {
        return $this->paymentSenderMethod;
    }

    public function setPaymentSenderMethod(?string $paymentSenderMethod): self
    {
        $this->paymentSenderMethod = $paymentSenderMethod;

        return $this;
    }

    public function getHolidayDeliveryDay(): ?string
    {
        return $this->holidayDeliveryDay;
    }

    public function setHolidayDeliveryDay(?string $holidayDeliveryDay): self
    {
        $this->holidayDeliveryDay = $holidayDeliveryDay;

        return $this;
    }

    public function validate(): bool
    {
        return true;
    }
}
