<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class CrossIndustryInvoice
{

    const PROFILE_MINIMUM = 1;
    const PROFILE_BASIC_WL = 2;
    // More detailed profile later maybe...

    const SPECIFICATION_IDENTIFIERS = [
        self::PROFILE_MINIMUM => 'urn:factur-x.eu:1p0:minimum',
        self::PROFILE_BASIC_WL => 'urn:factur-x.eu:1p0:basicwl',
    ];

    // Required
    protected int $profile_id;
    protected string $invoiceNumber;
    protected int $invoiceType;
    protected \DateTimeInterface $issueDate;
    protected \DateTimeInterface $dueDate;
    protected LegalEntity $seller;
    protected LegalEntity $buyer;
    protected string $currencyCode;
    protected int $paymentMeansCode;
    protected float $lineTotalAmount;
    protected float $taxBasisTotalAmount;
    protected float $taxTotalAmount;
    protected float $grandTotalAmount;
    protected float $duePayableAmount;
    protected array $vatDetails = [];

    // optionnal
    protected array $notes = [];
    protected ?string $contractNumber = null;
    protected ?string $saleOrderNumber = null;

    const INVOICE_TYPE_COMMERCIAL_INVOICE = 380;
    const INVOICE_TYPE_CREDIT_NOTE = 381;
    const INVOICE_TYPE_CORRECTED_INVOICE = 384;
    const INVOICE_TYPE_PREPAYMENT_INVOICE = 386;
    const INVOICE_TYPE_SELF_BILLED_INVOICE = 389;

    const PAYMENT_MEANS_CODE_CASH = 10;
    const PAYMENT_MEANS_CODE_CHEQUE = 20;
    const PAYMENT_MEANS_CODE_BANK_TRANSFER = 30;
    const PAYMENT_MEANS_CODE_CARD = 48;
    const PAYMENT_DIRECT_CODE_DEBIT = 49;

    const NOTE_GENERAL_INFORMATION = 'AAI'; // General information
    const NOTE_PAYMENT_TERM = 'AAB'; // Payment term
    const NOTE_SUPPLIER_REMARKS = 'SUR'; // Supplier Remarks
    const NOTE_REGULATORY_INFORMATION = 'REG'; // Regulatory information
    const NOTE_GOVERNMENT_INFORMATION = 'ABL'; // Government information
    const NOTE_TAX_DECLARATION = 'TXD'; // Tax declaration
    const NOTE_CUSTOMS_DECLARATION_INFORMATION = 'CUS'; // Customs declaration information

    public function __construct(int $profile_id)
    {
        if(!in_array($profile_id, [self::PROFILE_MINIMUM, self::PROFILE_BASIC_WL])){
            throw new \InvalidArgumentException(sprintf("Profile ID must be one of : %s; %s",
                self::class.'::PROFILE_MINIMUM', self::class.'::PROFILE_MINIMUM'));
        }
        $this->profile_id = $profile_id;
    }

    public function getSpecificationIdentifier() :string
    {
        return self::SPECIFICATION_IDENTIFIERS[$this->profile_id];
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
     * @return CrossIndustryInvoice
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
     * @return CrossIndustryInvoice
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
     * @return CrossIndustryInvoice
     */
    public function setIssueDate(\DateTimeInterface $issueDate)
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTimeInterface $dueDate
     * @return CrossIndustryInvoice
     */
    public function setDueDate(\DateTimeInterface $dueDate)
    {
        $this->dueDate = $dueDate;
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
     * @return CrossIndustryInvoice
     */
    public function setSeller(LegalEntity $seller): CrossIndustryInvoice
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
     * @return CrossIndustryInvoice
     */
    public function setBuyer(LegalEntity $buyer): CrossIndustryInvoice
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
     * @return CrossIndustryInvoice
     */
    public function setCurrencyCode(string $currencyCode): CrossIndustryInvoice
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentMeansCode(): int
    {
        return $this->paymentMeansCode;
    }

    /**
     * @param int $paymentMeansCode
     * @return CrossIndustryInvoice
     */
    public function setPaymentMeansCode(int $paymentMeansCode): CrossIndustryInvoice
    {
        $this->paymentMeansCode = $paymentMeansCode;
        return $this;
    }

    /**
     * @return float
     */
    public function getLineTotalAmount(): float
    {
        return $this->lineTotalAmount;
    }

    /**
     * @param float $lineTotalAmount
     * @return CrossIndustryInvoice
     */
    public function setLineTotalAmount(float $lineTotalAmount): CrossIndustryInvoice
    {
        $this->lineTotalAmount = $lineTotalAmount;
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
     * @return CrossIndustryInvoice
     */
    public function setTaxBasisTotalAmount(float $taxBasisTotalAmount): CrossIndustryInvoice
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
     * @return CrossIndustryInvoice
     */
    public function setTaxTotalAmount(float $taxTotalAmount): CrossIndustryInvoice
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
     * @return CrossIndustryInvoice
     */
    public function setGrandTotalAmount(float $grandTotalAmount): CrossIndustryInvoice
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
     * @return CrossIndustryInvoice
     */
    public function setDuePayableAmount(float $duePayableAmount): CrossIndustryInvoice
    {
        $this->duePayableAmount = $duePayableAmount;
        return $this;
    }

    /**
     * @return array
     */
    public function getVatDetails(): array
    {
        return $this->vatDetails;
    }

    public function addVatDetail(VatDetail $detail): CrossIndustryInvoice
    {
        $this->vatDetails[] = $detail;
        return $this;
    }

    /**
     * @param array $vatDetails
     * @return CrossIndustryInvoice
     */
    public function setVatDetails(array $vatDetails): CrossIndustryInvoice
    {
        $this->vatDetails = $vatDetails;
        return $this;
    }

    /**
     * @return array
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

    /**
     * @param array $notes
     * @return CrossIndustryInvoice
     */
    public function setNotes(array $notes): CrossIndustryInvoice
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @param string $code a 3 letters code on "UNTDID 4451" list
     * @param string $note
     * @return $this
     */
    public function addNote(string $code, string $note): CrossIndustryInvoice
    {
        $this->notes[$code] = $note;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContractNumber(): ?string
    {
        return $this->contractNumber;
    }

    /**
     * @param string|null $contractNumber
     * @return CrossIndustryInvoice
     */
    public function setContractNumber(?string $contractNumber): CrossIndustryInvoice
    {
        $this->contractNumber = $contractNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSaleOrderNumber(): ?string
    {
        return $this->saleOrderNumber;
    }

    /**
     * @param string|null $saleOrderNumber
     * @return CrossIndustryInvoice
     */
    public function setSaleOrderNumber(?string $saleOrderNumber): CrossIndustryInvoice
    {
        $this->saleOrderNumber = $saleOrderNumber;
        return $this;
    }
}