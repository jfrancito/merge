<?php

namespace App\Greenter;

use Greenter\Model\Despatch\Shipment;

class CustomShipment extends Shipment
{
    /**
     * @var \DateTime
     */
    public $fecEntrega;

    /**
     * @return \DateTime|null
     */
    public function getFecEntrega(): ?\DateTime
    {
        return $this->fecEntrega;
    }

    /**
     * @param \DateTime|null $fecEntrega
     * @return CustomShipment
     */
    public function setFecEntrega(?\DateTime $fecEntrega): CustomShipment
    {
        $this->fecEntrega = $fecEntrega;
        return $this;
    }
}
