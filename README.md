# 1CClientBankExchange parser
Парсер формата обмена данными [1CClientBankExchange](http://v8.1c.ru/edi/edi_stnd/100/101.htm) (версии 1.02)

Установка
------------

Рекомендуемый способ установки через
[Composer](http://getcomposer.org):

```
$ composer require kilylabs/client-bank-exchange-php
```

Использование
-----

Пример кода

```php
<?php

use Kily\Tools1C\ClientBankExchange\Parser;

require('vendor/autoload.php');

$p = new Parser('tests/resources/huge.txt');
var_dump($p->general); // general info
var_dump($p->filter); // selection settings
var_dump($p->remainings); // to see bank account remainings
foreach($p->documents as $d) {
    echo $d['type'], " => "; // document type
    echo $d->{'Номер'}; // some fields
    echo "\n";
}
```

TODO
-----
- сделать проверку файла на корректность структуры
- написать генератор
