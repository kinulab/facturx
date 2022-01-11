<?php

namespace Kinulab\Facturx\CrossIndustryInvoice;

class XmlWriter
{

    public static function write(CrossIndustryInvoiceMinimum $invoice) : string
    {
        $exchangeDocumentContext = self::getExchangeDocumentContext($invoice);
        $exchangeDocument = self::getExchangeDocument($invoice);
        $seller = self::getSeller($invoice);
        $buyer = self::getBuyer($invoice);
        $tradeSettlement = self::getTradeSettlement($invoice);

        $xml = <<<EOL
<?xml version='1.0' encoding='UTF-8'?>
<rsm:CrossIndustryInvoice xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   $exchangeDocumentContext
   $exchangeDocument
   <rsm:SupplyChainTradeTransaction>
      <ram:ApplicableHeaderTradeAgreement>
         $seller
         $buyer
      </ram:ApplicableHeaderTradeAgreement>
      <ram:ApplicableHeaderTradeDelivery/>
      $tradeSettlement
   </rsm:SupplyChainTradeTransaction>
</rsm:CrossIndustryInvoice>
EOL;

        // check that the generated XML is valid
        $validator = new \Atgp\FacturX\Facturx();
        $validator->checkFacturxXsd($xml);

        return $xml;
    }

    protected static function getExchangeDocumentContext(CrossIndustryInvoiceMinimum $invoice)
    {

        $format = <<<EOL
<rsm:ExchangedDocumentContext>
  <ram:GuidelineSpecifiedDocumentContextParameter>
     <ram:ID>%s</ram:ID>
  </ram:GuidelineSpecifiedDocumentContextParameter>
</rsm:ExchangedDocumentContext>
EOL;
        return sprintf($format, $invoice->getSpecificationIdentifier());
    }

    protected static function getExchangeDocument(CrossIndustryInvoiceMinimum $invoice)
    {
        $format = <<<EOL
<rsm:ExchangedDocument>
  <ram:ID>%s</ram:ID>
  <ram:TypeCode>%d</ram:TypeCode>
  <ram:IssueDateTime>
     <udt:DateTimeString format="102">%s</udt:DateTimeString>
  </ram:IssueDateTime>
</rsm:ExchangedDocument>
EOL;
        return sprintf($format, $invoice->getInvoiceNumber(), $invoice->getInvoiceType(), $invoice->getIssueDate()->format('Ymd'));
    }

    protected static function getSeller(CrossIndustryInvoiceMinimum $invoice)
    {
        $format = <<<EOL
<ram:SellerTradeParty>
    <ram:Name>%s</ram:Name>
    <ram:SpecifiedLegalOrganization>
       <ram:ID schemeID="0002">%s</ram:ID>
    </ram:SpecifiedLegalOrganization>
    <ram:PostalTradeAddress>
       %s
    </ram:PostalTradeAddress>
    <ram:SpecifiedTaxRegistration>
       <ram:ID schemeID="VA">%s</ram:ID>
    </ram:SpecifiedTaxRegistration>
 </ram:SellerTradeParty>
EOL;
        $seller = $invoice->getSeller();

        return sprintf($format, $seller->getName(), $seller->getSiret(), self::getAddress($seller->getAddress()), $seller->getVatIdentifier());
    }

    protected static function getBuyer(CrossIndustryInvoiceMinimum $invoice)
    {
        $format = <<<EOL
<ram:BuyerTradeParty>
    <ram:Name>%s</ram:Name>
    <ram:SpecifiedLegalOrganization>
       <ram:ID schemeID="0002">%s</ram:ID>
    </ram:SpecifiedLegalOrganization>
</ram:BuyerTradeParty>
EOL;
        $buyer = $invoice->getBuyer();

        return sprintf($format, $buyer->getName(), $buyer->getVatIdentifier());
    }

    protected static function getAddress(Address $address)
    {
        $xmlAddress = sprintf('<ram:CountryID>%s</ram:CountryID>', $address->getCountryId());
        if($address->getLines()){
            $lines = array_filter(array_map('trim', explode("\n", $address->getLines())));
            if(count($lines) > 3){
                throw new \Exception("The address lines attribut must not exceed 3 lines.");
            }

            $lines = array_combine(array_slice(['One', 'Two', 'Three'], 0, count($lines)), $lines);
            foreach($lines as $i => $line){
                $xmlAddress .= "<ram:Line$i>$line</ram:LineTwo>";
            }
        }
        if($address->getZipCode()){
            $xmlAddress .= sprintf('<ram:PostcodeCode>%s</ram:PostcodeCode>', $address->getZipCode());
        }
        if($address->getCityName()){
            $xmlAddress .= sprintf('<ram:CityName>%s</ram:CityName>', $address->getCityName());
        }

        return $xmlAddress;
    }

    protected static function getTradeSettlement(CrossIndustryInvoiceMinimum $invoice)
    {
        $monetarySummation = self::getMonetarySummation($invoice);
        $format = <<<EOL
<ram:ApplicableHeaderTradeSettlement>
    <ram:InvoiceCurrencyCode>%s</ram:InvoiceCurrencyCode>
    $monetarySummation
</ram:ApplicableHeaderTradeSettlement>
EOL;
        return sprintf($format, $invoice->getCurrencyCode());
    }

    protected static function getMonetarySummation(CrossIndustryInvoiceMinimum $invoice)
    {
        $elems = [
            sprintf('<ram:TaxBasisTotalAmount>%01.2F</ram:TaxBasisTotalAmount>', $invoice->getTaxBasisTotalAmount()),
            sprintf('<ram:TaxTotalAmount currencyID="%s">%01.2F</ram:TaxTotalAmount>', $invoice->getCurrencyCode(), $invoice->getTaxTotalAmount()),
            sprintf('<ram:GrandTotalAmount>%01.2F</ram:GrandTotalAmount>', $invoice->getGrandTotalAmount()),
            sprintf('<ram:DuePayableAmount>%01.2F</ram:DuePayableAmount>', $invoice->getDuePayableAmount()),
        ];

        $elems = implode("\n", $elems);
        return <<<EOL
<ram:SpecifiedTradeSettlementHeaderMonetarySummation>
$elems
</ram:SpecifiedTradeSettlementHeaderMonetarySummation>
EOL;
    }

}