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

    public function __construct($data = [])
    {
        parent::__construct($data);
        if ($this->data['ДатаНачала']) {
            $this->data['ДатаНачала'] = $this->toDate($this->data['ДатаНачала']);
        }
        if ($this->data['ДатаКонца']) {
            $this->data['ДатаКонца'] = $this->toDate($this->data['ДатаКонца']);
        }
    }

    public function __toString() {
        $out = [];
        foreach($this->fields() as $f) {
            if(in_array($f,['ДатаНачала','ДатаКонца'])) {
                $out[$f] = $this->toDMYDate($this->data[$f]);
            } else {
                $out[$f] = $this->data[$f];
            }
        }
        return implode("\n",array_map(function($k,$v){return $k.'='.$v;},array_keys($out),$out))."\n";
    }
}
