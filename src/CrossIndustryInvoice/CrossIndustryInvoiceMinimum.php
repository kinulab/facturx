<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class CrossIndustryInvoiceMinimum
{

    const SPECITIFACTION_IDENTIFIER = 'urn:factur-x.eu:1p0:minimum';

    protected string $invoiceNumber;
    protected int $invoiceType;
    protected \DateTimeInterface $issueDate;
    protected LegalEntity $seller;
    protected LegalEntity $buyer;
    protected string $currencyCode;
    protected float $taxBasisTotalAmount;
    protected float $taxTotalAmount;
    protected float $grandTotalAmount;
    protected float $duePayableAmount;

    const INVOICE_TYPE_COMMERCIAL_INVOICE = 380;
    const INVOICE_TYPE_CREDIT_NOTE = 381;
    const INVOICE_TYPE_CORRECTED_INVOICE = 384;
    const INVOICE_TYPE_PREPAYMENT_INVOICE = 386;
    const INVOICE_TYPE_SELF_BILLED_INVOICE = 389;

    public function getSpecificationIdentifier() :string
    {
        return self::SPECITIFACTION_IDENTIFIER;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     * @return CrossIndustryInvoiceMinimum
     */
    public function setInvoiceNumber(string $invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceType()
    {
        return $this->invoiceType;
    }

    /**
     * @param mixed $invoiceType
     * @return CrossIndustryInvoiceMinimum
     */
    public function setInvoiceType($invoiceType)
    {
        $this->invoiceType = $invoiceType;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @param \DateTimeInterface $issueDate
     * @return CrossIndustryInvoiceMinimum
     */
    public function setIssueDate(\DateTimeInterface $issueDate)
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    /**
     * @return LegalEntity
     */
    public function getSeller(): LegalEntity
    {
        return $this->seller;
    }

    /**
     * @param LegalEntity $seller
     * @return CrossIndustryInvoiceMinimum
     */
    public function setSeller(LegalEntity $seller): CrossIndustryInvoiceMinimum
    {
        $this->seller = $seller;
        return $this;
    }

    /**
     * @return LegalEntity
     */
    public function getBuyer(): LegalEntity
    {
        return $this->buyer;
    }

    /**
     * @param LegalEntity $buyer
     * @return CrossIndustryInvoiceMinimum
     */
    public function setBuyer(LegalEntity $buyer): CrossIndustryInvoiceMinimum
    {
        $this->buyer = $buyer;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     * @return CrossIndustryInvoiceMinimum
     */
    public function setCurrencyCode(string $currencyCode): CrossIndustryInvoiceMinimum
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return float
     */
    public function getTaxBasisTotalAmount(): float
    {
        return $this->taxBasisTotalAmount;
    }

    /**
     * @param float $taxBasisTotalAmount
     * @return CrossIndustryInvoiceMinimum
     */
    public function setTaxBasisTotalAmount(float $taxBasisTotalAmount): CrossIndustryInvoiceMinimum
    {
        $this->taxBasisTotalAmount = $taxBasisTotalAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTaxTotalAmount(): float
    {
        return $this->taxTotalAmount;
    }

    /**
     * @param float $taxTotalAmount
     * @return CrossIndustryInvoiceMinimum
     */
    public function setTaxTotalAmount(float $taxTotalAmount): CrossIndustryInvoiceMinimum
    {
        $this->taxTotalAmount = $taxTotalAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getGrandTotalAmount(): float
    {
        return $this->grandTotalAmount;
    }

    /**
     * @param float $grandTotalAmount
     * @return CrossIndustryInvoiceMinimum
     */
    public function setGrandTotalAmount(float $grandTotalAmount): CrossIndustryInvoiceMinimum
    {
        $this->grandTotalAmount = $grandTotalAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getDuePayableAmount(): float
    {
        return $this->duePayableAmount;
    }

    /**
     * @param float $duePayableAmount
     * @return CrossIndustryInvoiceMinimum
     */
    public function setDuePayableAmount(float $duePayableAmount): CrossIndustryInvoiceMinimum
    {
        $this->duePayableAmount = $duePayableAmount;
        return $this;
    }

}