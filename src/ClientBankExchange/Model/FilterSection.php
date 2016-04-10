<?php

namespace Kily\Tools1C\ClientBankExchange\Model;

use Kily\Tools1C\ClientBankExchange\Component;

class FilterSection extends Component
{
    public static function fields()
    {
        return [
            'ДатаНачала',
            'ДатаКонца',
            'РасчСчет',
            'Документ',
        ];
    }
}
