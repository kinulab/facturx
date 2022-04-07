<?php

namespace Kinulab\Facturx\CrossIndustryInvoice\Payment;

interface PaymentInstructionInterface
{

    public function getPaymentMeansCode() :int;

}