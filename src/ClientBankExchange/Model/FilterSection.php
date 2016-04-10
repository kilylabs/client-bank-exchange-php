<?php

namespace Kily\Tools1C\ClientBankExchange\Model;

use Kily\Tools1C\ClientBankExchange\Component;

class FilterSection extends Component
{
    static public function fields()
    {
        return [
            'ДатаНачала',
            'ДатаКонца',
            'РасчСчет',
            'Документ',
        ];
    }

}
