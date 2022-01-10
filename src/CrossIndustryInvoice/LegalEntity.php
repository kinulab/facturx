<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class LegalEntity
{

    protected string $name;
    protected string $siret;
    protected Address $address;
    protected string $vatIdentifier;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return LegalEntity
     */
    public function setName(string $name): LegalEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiret(): string
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     * @return LegalEntity
     */
    public function setSiret(string $siret): LegalEntity
    {
        $this->siret = $siret;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return LegalEntity
     */
    public function setAddress(Address $address): LegalEntity
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getVatIdentifier(): string
    {
        return $this->vatIdentifier;
    }

    /**
     * @param string $vatIdentifier
     * @return LegalEntity
     */
    public function setVatIdentifier(string $vatIdentifier): LegalEntity
    {
        $this->vatIdentifier = $vatIdentifier;
        return $this;
    }

}