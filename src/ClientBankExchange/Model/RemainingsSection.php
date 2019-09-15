<?php

namespace Kily\Tools1C\ClientBankExchange\Model;

use Kily\Tools1C\ClientBankExchange\Component;

class RemainingsSection extends Component
{
    public static function fields()
    {
        return [
            'ДатаНачала',
            'ДатаКонца',
            'РасчСчет',
            'НачальныйОстаток',
            'ВсегоПоступило',
            'ВсегоСписано',
            'КонечныйОстаток',
        ];
    }

    public function __construct($data = [])
    {
        parent::__construct($data);

        foreach (['ДатаНачала', 'ДатаКонца'] as $k) {
            if ($this->data[$k]) {
                $this->data[$k] = $this->toDate($this->data[$k]);
            }
        }

        foreach (['НачальныйОстаток', 'ВсегоПоступило', 'ВсегоСписано', 'КонечныйОстаток'] as $k) {
            if ($this->data[$k]) {
                $this->data[$k] = $this->toFloat($this->data[$k]);
            }
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
        return "СекцияРасчСчет\n".implode("\n",array_map(function($k,$v){return $k.'='.$v;},array_keys($out),$out))."\nКонецРасчСчет\n";
    }
}
