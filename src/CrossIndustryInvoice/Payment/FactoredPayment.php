<?php

namespace Kinulab\Facturx\CrossIndustryInvoice\Payment;

use Kinulab\Facturx\CrossIndustryInvoice\BankAccount;
use Kinulab\Facturx\CrossIndustryInvoice\CrossIndustryInvoice;
use Kinulab\Facturx\CrossIndustryInvoice\LegalEntity;

class FactoredPayment implements PaymentInstructionInterface
{

    protected LegalEntity $payee;
    protected BankAccount $account;

    public function __construct(LegalEntity $payee, BankAccount $account)
    {
        $this->payee = $payee;
        $this->account = $account;
    }

    public function getPaymentMeansCode() :int
    {
        return CrossIndustryInvoice::PAYMENT_MEANS_CODE_BANK_TRANSFER;
    }

    /**
     * @return LegalEntity
     */
    public function getPayee(): LegalEntity
    {
        return $this->payee;
    }

    /**
     * @param LegalEntity $payee
     * @return FactoredPayment
     */
    public function setPayee(LegalEntity $payee): FactoredPayment
    {
        $this->payee = $payee;
        return $this;
    }

    /**
     * @return BankAccount
     */
    public function getAccount(): BankAccount
    {
        return $this->account;
    }

    /**
     * @param BankAccount $account
     * @return FactoredPayment
     */
    public function setAccount(BankAccount $account): FactoredPayment
    {
        $this->account = $account;
        return $this;
    }
}