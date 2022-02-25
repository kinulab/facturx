<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class VatDetail
{

    const CATEGORY_CODE_STANDARD = 'S';
    const CATEGORY_CODE_ZERO_RATED_GOODS = 'Z';
    const CATEGORY_CODE_EXEMPT_FROM_TAX = 'E';
    const CATEGORY_CODE_VAT_REVERSE_CHARGE = 'AE';
    const CATEGORY_CODE_VAT_EXEMPT_FOR_EEA = 'K';
    const CATEGORY_CODE_FREE_EXPORT_ITEM = 'G';
    const CATEGORY_CODE_SERVICE_OUTSIDE_SCOPE = 'O';
    const CATEGORY_CODE_CANARY_ISLANDS = 'L';
    const CATEGORY_CODE_CEUTA_MELILLA = 'M';


    protected float $calculatedAmount;
    protected string $typeCode = 'VAT';
    protected ?string $exemptionReason = null;
    protected int $basisAmount;
    protected string $categoryCode;
    protected ?string $exemptionReasonCode = null;
    protected ?int $rateApplicablePercent = null;

    /**
     * @return float
     */
    public function getCalculatedAmount(): float
    {
        return $this->calculatedAmount;
    }

    /**
     * @param float $calculatedAmount
     * @return VatDetail
     */
    public function setCalculatedAmount(float $calculatedAmount): VatDetail
    {
        $this->calculatedAmount = $calculatedAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    /**
     * @param string $typeCode
     * @return VatDetail
     */
    public function setTypeCode(string $typeCode): VatDetail
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExemptionReason(): ?string
    {
        return $this->exemptionReason;
    }

    /**
     * @param string|null $exemptionReason
     * @return VatDetail
     */
    public function setExemptionReason(?string $exemptionReason): VatDetail
    {
        $this->exemptionReason = $exemptionReason;
        return $this;
    }

    /**
     * @return int
     */
    public function getBasisAmount(): int
    {
        return $this->basisAmount;
    }

    /**
     * @param int $basisAmount
     * @return VatDetail
     */
    public function setBasisAmount(int $basisAmount): VatDetail
    {
        $this->basisAmount = $basisAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryCode(): string
    {
        return $this->categoryCode;
    }

    /**
     * @param string $categoryCode
     * @return VatDetail
     */
    public function setCategoryCode(string $categoryCode): VatDetail
    {
        $this->categoryCode = $categoryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExemptionReasonCode(): ?string
    {
        return $this->exemptionReasonCode;
    }

    /**
     * @param string|null $exemptionReasonCode
     * @return VatDetail
     */
    public function setExemptionReasonCode(?string $exemptionReasonCode): VatDetail
    {
        $this->exemptionReasonCode = $exemptionReasonCode;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRateApplicablePercent(): ?int
    {
        return $this->rateApplicablePercent;
    }

    /**
     * @param int|null $rateApplicablePercent
     * @return VatDetail
     */
    public function setRateApplicablePercent(?int $rateApplicablePercent): VatDetail
    {
        $this->rateApplicablePercent = $rateApplicablePercent;
        return $this;
    }


}