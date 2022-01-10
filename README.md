# Kinulab/Facturx

This library aims to simplify the generation of Factur-X / ZUGFeRD XML files.

For the moment, this library only generate minimal format.

## Installation

```shell
composer require kinulab/facturx
```

## Usage

```php
require 'vendor/autoload.php';

$invoice = new \Kinulab\Facturx\CrossIndustryInvoice\CrossIndustryInvoiceMinimum();
$invoice->setInvoiceNumber("FC123456789");
$invoice->setInvoiceType(Kinulab\Facturx\CrossIndustryInvoice\CrossIndustryInvoiceMinimum::INVOICE_TYPE_COMMERCIAL_INVOICE);
$invoice->setIssueDate( new \DateTime('today') );
$invoice->setSeller( new \Kinulab\Facturx\CrossIndustryInvoice\LegalEntity() );
$invoice->setBuyer( new \Kinulab\Facturx\CrossIndustryInvoice\LegalEntity() );
$invoice->setCurrencyCode('EUR');
$invoice->setTaxBasisTotalAmount(100);
$invoice->setTaxTotalAmount(5.61);
$invoice->setGrandTotalAmount( 105.61 );
$invoice->setDuePayableAmount( 105.61 );

$seller = $invoice->getSeller();
$seller->setName('My Company Name');
$seller->setSiret('XXXXXX');
$seller->setVatIdentifier( 'XXXXX');
$seller->setAddress( new \Kinulab\Facturx\CrossIndustryInvoice\Address() );

$sellerAddress = $seller->getAddress();
$sellerAddress->setCountryId('FR');

$buyer = $invoice->getBuyer();
$buyer->setName('The Client');
$buyer->setVatIdentifier("ABC123");

// This is the XML that must be added to the PDF
$xml = \Kinulab\Facturx\CrossIndustryInvoice\XmlWriter::write($invoice);
$pdfFile = './raw-pdf-invoice/invoice-FC123456789.pdf'; // my invoice in PDF format

$facturx = new \Atgp\FacturX\Facturx();
$electronicInvoice = $facturx->generateFacturxFromFiles($pdfFile, $xml);
// $electronicInvoice is your invoice in Factur-x/ZUGFeRD format

file_put_contents('./facturx-invoice/invoice-FC123456789.pdf', $electronicInvoice);
```