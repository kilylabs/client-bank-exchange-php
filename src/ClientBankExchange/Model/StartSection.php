<?php

namespace Kily\Tools1C\ClientBankExchange\Model;

use Kily\Tools1C\ClientBankExchange\Component;

class StartSection extends Component
{
    public static function fields()
    {
        return [
        ];
    }

    public function __toString() {
        return '1CClientBankExchange'."\n";
    }
}
