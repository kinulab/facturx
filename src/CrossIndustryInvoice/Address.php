<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class Address
{

    protected ?string $lines = null;
    protected ?string $zipCode = null;
    protected ?string $cityName = null;
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

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string|null $zipCode
     * @return Address
     */
    public function setZipCode(?string $zipCode): Address
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    /**
     * @param string|null $cityName
     * @return Address
     */
    public function setCityName(?string $cityName): Address
    {
        $this->cityName = $cityName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLines(): ?string
    {
        return $this->lines;
    }

    /**
     * @param string|null $lines
     * @return Address
     */
    public function setLines(?string $lines): Address
    {
        $this->lines = $lines;
        return $this;
    }

}