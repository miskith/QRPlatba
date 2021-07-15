<?php

/*
 * This file is part of the library "QRInvoice".
 *
 * (c) Dennis Fridrich <fridrich.dennis@gmail.com>
 *
 * For the full copyright and license information,
 * please view LICENSE.
 */

use PHPUnit\Framework\TestCase;
use miskith\QRInvoice\QRInvoice;

/**
 * Class QRInvoiceTest.
 */
class QRInvoiceTest extends TestCase
{
	public function testSimpleInvoice()
	{
		$string = QRInvoice::create('12-3456789012/0100', '1234.56', '2016001234')
			->setMessage('Düakrítičs')
			->setInvoiceId('123456789')
			->setInvoiceDate(new \DateTime('2021-07-15'));

		$this->assertSame(
			'SPD*1.0*ACC:CZ0301000000123456789012*AM:1234.56*CC:CZK*MSG:Duakritics*X-VS:2016001234*X-INV:SID%2A1.0%2AID:123456789%2ADD:20210715*',
			$string->__toString()
		);
	}

	public function testSimpleOnlyInvoice()
	{
		$string = QRInvoice::create('12-3456789012/0100', '1234.56', '2016001234')
			->setIsOnlyInvoice(true)
			->setMessage('Düakrítičs')
			->setInvoiceId('123456789')
			->setInvoiceDate(new \DateTime('2021-07-15'));

		$this->assertSame(
			'SID*1.0*ID:123456789*DD:20210715*AM:1234.56*MSG:Duakritics*VS:2016001234*CC:CZK*ACC:CZ0301000000123456789012*',
			$string->__toString()
		);
	}

	public function testFirstFromDocumentation()
	{
		$string = QRInvoice::create('27-16060243/0300', 495.00, '012150672')
			->setInvoiceId('012150672')
			->setDueDate(new \DateTime('2015-12-17'))
			->setInvoiceDate(new \DateTime('2015-12-01'))
			->setTaxDate(new \DateTime('2015-12-01'))
			->setTaxPerformance(0)
			->setCompanyTaxId('CZ60194383')
			->setCompanyRegistrationId('60194383')
			->setInvoiceSubjectTaxId('CZ12345678')
			->setTaxBase(409.09, 0)
			->setTaxAmount(85.91, 0);

		$this->assertSame(
			'SPD*1.0*ACC:CZ3103000000270016060243*AM:495.00*CC:CZK*DT:20151217*X-VS:012150672*X-INV:SID%2A1.0%2AID:012150672%2ADD:20151201%2ATP:0%2AVII:CZ60194383%2AINI:60194383%2AVIR:CZ12345678%2ADUZP:20151201%2ATB0:409.09%2AT0:85.91*',
			$string->__toString()
		);
	}

	public function testFirstFromDocumentationOnlyInvoice()
	{
		$string = QRInvoice::create('27-16060243/0300', 495.00, '012150672')
			->setIsOnlyInvoice(true)
			->setTaxPerformance(0)
			->setInvoiceId('012150672')
			->setDueDate(new \DateTime('2015-12-17'))
			->setInvoiceDate(new \DateTime('2015-12-01'))
			->setTaxDate(new \DateTime('2015-12-01'))
			->setTaxPerformance(0)
			->setCompanyTaxId('CZ60194383')
			->setCompanyRegistrationId('60194383')
			->setInvoiceSubjectTaxId('CZ12345678')
			->setTaxBase(409.09, 0)
			->setTaxAmount(85.91, 0);

		$this->assertSame(
			'SID*1.0*ID:012150672*DD:20151201*AM:495.00*TP:0*VS:012150672*VII:CZ60194383*INI:60194383*VIR:CZ12345678*DUZP:20151201*DT:20151217*TB0:409.09*T0:85.91*CC:CZK*ACC:CZ3103000000270016060243*',
			$string->__toString()
		);
	}
}
