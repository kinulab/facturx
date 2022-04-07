<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class BankAccount
{

    protected string $iban;

    public function __construct(string $iban)
    {
        $this->iban = $iban;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

}