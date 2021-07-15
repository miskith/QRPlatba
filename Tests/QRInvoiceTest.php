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
use Miskith\QRInvoice\QRInvoice;

/**
 * Class QRInvoiceTest.
 */
class QRInvoiceTest extends TestCase
{
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSimpleInvoice()
	{
		$string = QRInvoice::create('12-3456789012/0100', '1234.56', '2016001234')
			->setMessage('Düakrítičs')
			->setInvoiceId('123456789')
			->setInvoiceDate(new \DateTime('2021-07-15'));

		$this->assertSame(
			'SPD*1.0*ACC:CZ0301000000123456789012*AM:1234.56*CC:CZK*MSG:Duakritics*X-VS:2016001234*X-INV:SID%2A1.0%2AID:123456789%2ADD:20210715%2AAM:1234.56%2AMSG:Duakritics%2AVS:2016001234%2ACC:CZK%2AACC:CZ0301000000123456789012*',
			$string->__toString()
		);
	}
}
