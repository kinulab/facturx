<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

/**
 * To make reference about an other invoice (ie. for refund invoice)
 */
class InvoiceReference
{

    protected $number;
    protected $issueDate;

    public function __construct(string $number, ?\DateTime $issueDate = null)
    {
        $this->number = $number;
        $this->issueDate = $issueDate;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return InvoiceReference
     */
    public function setNumber(string $number): InvoiceReference
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getIssueDate(): ?\DateTime
    {
        return $this->issueDate;
    }

    /**
     * @param \DateTime|null $issueDate
     * @return InvoiceReference
     */
    public function setIssueDate(?\DateTime $issueDate): InvoiceReference
    {
        $this->issueDate = $issueDate;
        return $this;
    }

}