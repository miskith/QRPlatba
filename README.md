# QR Platba

[![Latest Stable Version](https://poser.pugx.org/miskith/qr-platba/v/stable)](https://packagist.org/packages/miskith/qr-platba)
[![Total Downloads](https://poser.pugx.org/miskith/qr-platba/downloads)](https://packagist.org/packages/miskith/qr-platba)
[![Build Status](https://travis-ci.com/miskith/QRPlatba.svg)](https://travis-ci.com/miskith/QRPlatba)

Knihovna pro generování QR plateb v PHP. QR platba zjednodušuje koncovému uživateli
provedení příkazu k úhradě, protože obsahuje veškeré potřebné údaje, které stačí jen
naskenovat. Nově lze použít i jiné měny než CZK a to pomocí metody ```setCurrenty($currency)```.

Tato knihovna umožňuje:

- zobrazení obrázku v ```<img>``` tagu, který obsahuje v ```src``` rovnou data-uri s QR kódem, takže vygenerovaný
obrázek tak není třeba ukládat na server (```$qrPlatba->getQRCodeImage()```)
- uložení obrázku s QR kódem (```$qrPlatba->saveQRCodeImage()```)
- získání data-uri (```$qrPlatba->getQRCodeImage(false)```)
- získání instance objektu [QrCode](https://github.com/endroid/QrCode) (```$qrPlatba->getQRCodeInstance()```)

QRPlatbu v současné době podporují tyto banky:
Air Bank, Česká spořitelna, ČSOB, Equa bank, Era, Fio banka, Komerční banka, mBank, Raiffeisenbank, ZUNO.


Podporuje PHP ^7.3||^8.0.

## Instalace pomocí Composeru

`composer require miskith/qr-platba`

## Příklad

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Defr\QRPlatba\QRPlatba;

$qrPlatba = new QRPlatba();

$qrPlatba->setAccount('12-3456789012/0100')
    ->setVariableSymbol('2016001234')
    ->setMessage('Toto je první QR platba.')
    ->setSpecificSymbol('0308')
    ->setSpecificSymbol('1234')
    ->setCurrency('CZK') // Výchozí je CZK, lze zadat jakýkoli ISO kód měny
    ->setDueDate(new \DateTime());

echo $qrPlatba->getQRCodeImage(); // Zobrazí <img> tag s kódem, viz níže
```

![Ukázka](qrcode.png)

Lze použít i jednodušší zápis:

```php
echo QRPlatba::create('12-3456789012/0100', 987.60)
    ->setMessage('QR platba je parádní!')
    ->getQRCodeImage();
```

### Další možnosti

Uložení do souboru
```php
// Uloží png o velikosti 100x100 px
$qrPlatba->saveQRCodeImage("qrcode.png", "png", 100);

// Uloží svg o velikosti 100x100 px s 10 px marginem
$qrPlatba->saveQRCodeImage("qrcode.svg", "svg", 100, 10);
```

Aktuální možné formáty jsou:
* Png
* Svg
* Eps
* binární

Pro další je potřeba dopsat vlastní Writter

Zobrazení data-uri
```php
// data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFAAQMAAAD3XjfpAAAA...
echo $qrPlatba->getQRCodeImage(false);
```

## Odkazy

- Dokumentace - https://www.davidmyska.com/qr-platba/
- Oficiálí web QR Platby - http://qr-platba.cz/
- Originální projekt - https://github.com/dfridrich/QRPlatba
- Inspirace pro originálního developera - https://github.com/snoblucha/QRPlatba

## Contributing

Budu rád za každý návrh na vylepšení ať už formou issue nebo pull requestu.
