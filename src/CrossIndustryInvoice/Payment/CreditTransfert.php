<?php

namespace Kinulab\Facturx\CrossIndustryInvoice\Payment;

use Kinulab\Facturx\CrossIndustryInvoice\BankAccount;
use Kinulab\Facturx\CrossIndustryInvoice\CrossIndustryInvoice;

class CreditTransfert implements PaymentInstructionInterface
{

    protected $account;

    public function __construct(BankAccount $account)
    {
        $this->account = $account;
    }

    public function getPaymentMeansCode(): int
    {
        return CrossIndustryInvoice::PAYMENT_MEANS_CODE_BANK_TRANSFER;
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
     * @return CreditTransfert
     */
    public function setAccount(BankAccount $account): CreditTransfert
    {
        $this->account = $account;
        return $this;
    }

}