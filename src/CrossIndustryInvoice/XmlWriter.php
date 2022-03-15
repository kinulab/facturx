<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class XmlWriter
{

    public static function write(CrossIndustryInvoice $invoice) : string
    {
        $xw = new \XMLWriter();
        $xw->openMemory();
        $xw->setIndent(true);
        $xw->setIndentString('  ');
        $xw->startDocument('1.0', 'UTF-8');
        $xw->startElementNs('rsm', 'CrossIndustryInvoice', 'urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100');
        $xw->writeAttribute('xmlns:qdt', 'urn:un:unece:uncefact:data:standard:QualifiedDataType:100');
        $xw->writeAttribute('xmlns:ram', 'urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100');
        $xw->writeAttribute('xmlns:udt', 'urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100');
        $xw->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        self::setExchangeDocumentContext($xw, $invoice);
        self::setExchangeDocument($xw, $invoice);
        self::setSupplyChainTradeTransaction($xw, $invoice);

        $xw->endDocument();
        $xml = $xw->outputMemory();

        // check that the generated XML is valid
        $validator = new \Atgp\FacturX\Facturx();
        $validator->checkFacturxXsd($xml);

        return $xml;
    }

    protected static function setExchangeDocumentContext(\XMLWriter $xw, CrossIndustryInvoice $invoice)
    {
        $xw->startElement('rsm:ExchangedDocumentContext');
            $xw->startElement('ram:BusinessProcessSpecifiedDocumentContextParameter');
                $xw->writeElement('ram:ID', 'A1');
            $xw->endElement();
            $xw->startElement('ram:GuidelineSpecifiedDocumentContextParameter');
                $xw->writeElement('ram:ID', $invoice->getSpecificationIdentifier());
            $xw->endElement();
        $xw->endElement();
    }

    protected static function setExchangeDocument(\XMLWriter $xw, CrossIndustryInvoice $invoice)
    {
        $xw->startElement('rsm:ExchangedDocument');
            $xw->writeElement('ram:ID', $invoice->getInvoiceNumber());
            $xw->writeElement('ram:TypeCode', $invoice->getInvoiceType());
            $xw->startElement('ram:IssueDateTime');
                self::generateUdtDate($xw, $invoice->getIssueDate());
            $xw->endElement();

            foreach($invoice->getNotes() as $code => $note){
                $xw->startElement('ram:IncludedNote');
                    $xw->writeElement('ram:Content', $note);
                    $xw->writeElement('ram:SubjectCode', $code);
                $xw->endElement();
            }
        $xw->endElement();
    }

    protected static function setSupplyChainTradeTransaction(\XMLWriter $xw, CrossIndustryInvoice $invoice)
    {
        $xw->startElement('rsm:SupplyChainTradeTransaction');
            $xw->startElement('ram:ApplicableHeaderTradeAgreement');
                $xw->startElement('ram:SellerTradeParty');
                    self::setLegalEntity($xw, $invoice->getSeller());
                $xw->endElement();
                $xw->startElement('ram:BuyerTradeParty');
                    self::setLegalEntity($xw, $invoice->getBuyer());
                $xw->endElement();
                if($invoice->getSaleOrderNumber()){
                    $xw->startElement('ram:BuyerOrderReferencedDocument');
                        $xw->writeElement('ram:IssuerAssignedID', $invoice->getSaleOrderNumber());
                    $xw->endElement();
                }
                if($invoice->getContractNumber()){
                    $xw->startElement('ram:ContractReferencedDocument');
                        $xw->writeElement('ram:IssuerAssignedID', $invoice->getContractNumber());
                    $xw->endElement();
                }
            $xw->endElement();
            $xw->startElement('ram:ApplicableHeaderTradeDelivery');
                // TODO
            $xw->endElement();
            $xw->startElement('ram:ApplicableHeaderTradeSettlement');
                self::setTradeSettlement($xw, $invoice);
            $xw->endElement();
        $xw->endElement();
    }

    protected static function setLegalEntity(\XMLWriter $xw, LegalEntity $legalEntity)
    {
        $xw->writeElement('ram:Name', $legalEntity->getName());
        $xw->startElement('ram:SpecifiedLegalOrganization');
            $xw->startElement('ram:ID');
            $xw->writeAttribute('schemeID', '0002');
            $xw->text($legalEntity->getSiret());
            $xw->endElement();
        $xw->endElement();
        if($legalEntity->getAddress()){
            $xw->startElement('ram:PostalTradeAddress');
            self::setAddress($xw, $legalEntity->getAddress());
            $xw->endElement();
        }
        if($legalEntity->getVatIdentifier()){
            $xw->startElement('ram:SpecifiedTaxRegistration');
                $xw->startElement('ram:ID');
                $xw->writeAttribute('schemeID', 'VA');
                $xw->text($legalEntity->getVatIdentifier());
                $xw->endElement();
            $xw->endElement();
        }
    }

    protected static function setAddress(\XMLWriter $xw, Address $address)
    {
        if($address->getZipCode()){
            $xw->writeElement('ram:PostcodeCode', $address->getZipCode());
        }
        if($address->getLines()){
            $lines = array_filter(array_map('trim', explode("\n", $address->getLines())));
            if(count($lines) > 3){
                throw new \Exception("The address lines attribut must not exceed 3 lines.");
            }

            $lines = array_combine(array_slice(['One', 'Two', 'Three'], 0, count($lines)), $lines);
            foreach($lines as $i => $line){
                $xw->writeElement("ram:Line$i", $line);
            }
        }
        if($address->getCityName()){
            $xw->writeElement('ram:CityName', $address->getCityName());
        }
        $xw->writeElement('ram:CountryID', $address->getCountryId());
    }

    protected static function setTradeSettlement(\XMLWriter $xw, CrossIndustryInvoice $invoice)
    {
        // Si prelevement sepa : <ram:CreditorReferenceID>REFERENCE</ram:CreditorReferenceID>
        // Si par bonheur, le client paie, on voudrait bien qu'il utilise cette référence dans le libelle de l'opération : <ram:PaymentReference>F20180023BUYER</ram:PaymentReference>
        $xw->writeElement('ram:InvoiceCurrencyCode', $invoice->getCurrencyCode());

        $xw->startElement('ram:PayeeTradeParty');
            self::setLegalEntity($xw, $invoice->getSeller()); //a modifier l'entitée du bénéficiaire (si différent du vendeur)
        $xw->endElement();

        // Moyen de paiement
        $xw->startElement('ram:SpecifiedTradeSettlementPaymentMeans');
            $xw->writeElement('ram:TypeCode', $invoice->getPaymentMeansCode());
        $xw->endElement();

        foreach($invoice->getVatDetails() as $vatDetail){
            self::generateApplicableTradeTax($xw, $vatDetail);
        }

        $xw->startElement('ram:SpecifiedTradePaymentTerms');
            $xw->startElement('ram:DueDateDateTime');
                self::generateUdtDate($xw, $invoice->getDueDate());
            $xw->endElement();
        $xw->endElement();
        $xw->startElement('ram:SpecifiedTradeSettlementHeaderMonetarySummation');
            $xw->writeElement('ram:LineTotalAmount', sprintf('%01.2F', $invoice->getTaxBasisTotalAmount()));
            $xw->writeElement('ram:TaxBasisTotalAmount', sprintf('%01.2F', $invoice->getTaxBasisTotalAmount()));
            $xw->startElement('ram:TaxTotalAmount');
                $xw->writeAttribute('currencyID', $invoice->getCurrencyCode());
                $xw->text(sprintf('%01.2F', $invoice->getTaxTotalAmount()));
            $xw->endElement();
            $xw->writeElement('ram:GrandTotalAmount', sprintf('%01.2F', $invoice->getGrandTotalAmount()));
            $xw->writeElement('ram:DuePayableAmount', sprintf('%01.2F', $invoice->getDuePayableAmount()));
        $xw->endElement();
    }

    protected static function generateUdtDate(\XMLWriter $xw, \DateTimeInterface $dateTime)
    {
        $xw->startElement('udt:DateTimeString');
        $xw->writeAttribute('format', '102');
        $xw->text($dateTime->format('Ymd'));
        $xw->endElement();
    }

    protected static function generateApplicableTradeTax(\XMLWriter $xw, VatDetail $vatDetail)
    {
        $xw->startElement('ram:ApplicableTradeTax');
            $xw->writeElement('ram:CalculatedAmount', sprintf('%01.2F', $vatDetail->getCalculatedAmount()));
            $xw->writeElement('ram:TypeCode', $vatDetail->getTypeCode());
            if($vatDetail->getExemptionReason()){
                $xw->writeElement('ram:ExemptionReason', $vatDetail->getExemptionReason());
            }
            $xw->writeElement('ram:BasisAmount', sprintf('%01.2F', $vatDetail->getBasisAmount()));
            $xw->writeElement('ram:CategoryCode', $vatDetail->getCategoryCode());
            $xw->writeElement('ram:RateApplicablePercent', sprintf('%01.2F', $vatDetail->getRateApplicablePercent()));
        $xw->endElement();
    }
}
