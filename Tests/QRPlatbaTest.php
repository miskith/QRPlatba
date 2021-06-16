<?php

/*
 * This file is part of the library "QRPlatba".
 *
 * (c) Dennis Fridrich <fridrich.dennis@gmail.com>
 *
 * For the full copyright and license information,
 * please view LICENSE.
 */

use PHPUnit\Framework\TestCase;
use Defr\QRPlatba\QRPlatba;

/**
 * Class QRPlatbaTest.
 */
class QRPlatbaTest extends TestCase
{
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFakeCurrencyString()
	{
		$this->expectException(InvalidArgumentException::class);

		QRPlatba::create('12-3456789012/0100', '1234.56', '2016001234')
			->setMessage('Düakrítičs')
			->setCurrency('FAKE');
	}

	public function testCzkString()
	{
		$string = QRPlatba::create('12-3456789012/0100', '1234.56', '2016001234')
			->setMessage('Düakrítičs');

		$this->assertSame(
			'SPD*1.0*ACC:CZ0301000000123456789012*AM:1234.56*CC:CZK*MSG:Duakritics*X-VS:2016001234',
			$string->__toString()
		);

		$string = QRPlatba::create('12-3456789012/0100', '1234.56', '2016001234')
			->setMessage('Düakrítičs')
			->setCurrency('CZK');

		$this->assertSame(
			'SPD*1.0*ACC:CZ0301000000123456789012*AM:1234.56*CC:CZK*MSG:Duakritics*X-VS:2016001234',
			$string->__toString()
		);
	}

	public function testEurString()
	{
		$string = QRPlatba::create('12-3456789012/0100', '1234.56', '2016001234')
			->setMessage('Düakrítičs')
			->setCurrency('EUR');

		$this->assertSame(
			'SPD*1.0*ACC:CZ0301000000123456789012*AM:1234.56*CC:EUR*MSG:Duakritics*X-VS:2016001234',
			$string->__toString()
		);
	}

	public function testQrCodeInstante()
	{
		$qrPlatba = QRPlatba::create('12-3456789012/0100', 987.60)
			->setMessage('QR platba je parádní!')
			->getQRCodeInstance();

		$this->assertInstanceOf('Endroid\\QrCode\\QrCode', $qrPlatba);
	}

	public function testQrCodePngFileIsCreated()
	{
		$temp_name = tempnam(sys_get_temp_dir(), 'QrCode');

		$this->assertTrue(is_file($temp_name), 'Could not create temp file.');
		$this->assertEmpty(file_get_contents($temp_name), 'Temp file is not empty.');

		(new QRPlatba())->setAccount('12-3456789012/0100')
			->setVariableSymbol('2016001234')
			->setMessage('Toto je testovací QR platba.')
			->setSpecificSymbol('0308')
			->setSpecificSymbol('1234')
			->setCurrency('CZK')
			->setDueDate(new \DateTime())
			->saveQRCodeImage($temp_name, 'png', 100, 5);

		$this->assertNotEmpty(file_get_contents($temp_name), 'QR code image for payment could not be created into the temp dir.');
	}

	public function testQrCodeSvgFileIsCreated()
	{
		$temp_name = tempnam(sys_get_temp_dir(), 'QrCode');

		$this->assertTrue(is_file($temp_name), 'Could not create temp file.');
		$this->assertEmpty(file_get_contents($temp_name), 'Temp file is not empty.');

		(new QRPlatba())->setAccount('12-3456789012/0100')
			->setVariableSymbol('2016001234')
			->setMessage('Toto je testovací QR platba.')
			->setSpecificSymbol('0308')
			->setSpecificSymbol('1234')
			->setCurrency('CZK')
			->setDueDate(new \DateTime())
			->saveQRCodeImage($temp_name, 'svg', 300, 20);

		$this->assertNotEmpty(file_get_contents($temp_name), 'QR code image for payment could not be created into the temp dir.');
	}

	public function testRecipientName()
	{
		$string = QRPlatba::create('12-3456789012/0100', '1234.56', '2016001234')
			->setRecipientName('Düakrítičs');

		$this->assertSame(
			'SPD*1.0*ACC:CZ0301000000123456789012*AM:1234.56*CC:CZK*X-VS:2016001234*RN:Duakritics',
			$string->__toString()
		);
	}
}
