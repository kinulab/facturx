<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class Address
{

    protected string $countryId;

    /**
     * @return string
     */
    public function getCountryId(): string
    {
        return $this->countryId;
    }

    /**
     * @param string $countryId
     * @return Address
     */
    public function setCountryId(string $countryId): Address
    {
        $this->countryId = $countryId;
        return $this;
    }

}