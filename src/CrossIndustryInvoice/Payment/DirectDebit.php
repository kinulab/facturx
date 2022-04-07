<?php

namespace Kinulab\Facturx\CrossIndustryInvoice\Payment;

use Kinulab\Facturx\CrossIndustryInvoice\BankAccount;
use Kinulab\Facturx\CrossIndustryInvoice\CrossIndustryInvoice;

class DirectDebit implements PaymentInstructionInterface
{

    protected string $creditorIdentifier;
    protected string $paymentReference;
    protected BankAccount $debitedAccount;

    public function __construct(string $creditorIdentifier, string $paymentReference, BankAccount $debitedAccount)
    {
        $this->creditorIdentifier = $creditorIdentifier;
        $this->paymentReference = $paymentReference;
        $this->debitedAccount = $debitedAccount;
    }

    public function getPaymentMeansCode() :int
    {
        return CrossIndustryInvoice::PAYMENT_DIRECT_CODE_DEBIT;
    }

    /**
     * @return string
     */
    public function getCreditorIdentifier(): string
    {
        return $this->creditorIdentifier;
    }

    /**
     * @param string $creditorIdentifier
     * @return DirectDebit
     */
    public function setCreditorIdentifier(string $creditorIdentifier): DirectDebit
    {
        $this->creditorIdentifier = $creditorIdentifier;
        return $this;
    }

}