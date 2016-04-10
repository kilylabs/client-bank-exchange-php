<?php

namespace Kily\Tools1C\ClientBankExchange;

class Exception extends \Exception
{
    public function __construct($msg = '', $code = 0, $previous = null)
    {
        if (is_array($code)) {
            $msg = str_replace(array_keys($code), array_values($code), $msg);
            $code = 0;
        }

        parent::__construct($msg, $code, $previous);
    }
}
