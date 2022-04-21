<?php

namespace Kinulab\Facturx\CrossIndustryInvoice\Payment;

use Kinulab\Facturx\CrossIndustryInvoice\BankAccount;
use Kinulab\Facturx\CrossIndustryInvoice\CrossIndustryInvoice;

class DirectDebit implements PaymentInstructionInterface
{

    protected string $creditorIdentifier;
    protected string $mandateID; // RUM
    protected string $paymentReference;
    protected BankAccount $debitedAccount;

    public function __construct(string $creditorIdentifier, string $mandateID, string $paymentReference, BankAccount $debitedAccount)
    {
        $this->creditorIdentifier = $creditorIdentifier;
        $this->mandateID = $mandateID;
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
     * @return string
     */
    public function getMandateID(): string
    {
        return $this->mandateID;
    }

    /**
     * @param string $mandateID
     */
    public function setMandateID(string $mandateID): void
    {
        $this->mandateID = $mandateID;
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

    /**
     * @return string
     */
    public function getPaymentReference(): string
    {
        return $this->paymentReference;
    }

    /**
     * @param string $paymentReference
     */
    public function setPaymentReference(string $paymentReference): void
    {
        $this->paymentReference = $paymentReference;
    }

    /**
     * @return BankAccount
     */
    public function getDebitedAccount(): BankAccount
    {
        return $this->debitedAccount;
    }

    /**
     * @param BankAccount $debitedAccount
     */
    public function setDebitedAccount(BankAccount $debitedAccount): void
    {
        $this->debitedAccount = $debitedAccount;
    }

}