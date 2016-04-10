<?php

namespace Kily\Tools1C\ClientBankExchange\Model;

use Kily\Tools1C\ClientBankExchange\Component;

class GeneralSection extends Component
{

    static public function fields() {
        return [
            'ВерсияФормата',
            'Кодировка',
            'Отправитель',
            'Получатель',
            'ДатаСоздания',
            'ВремяСоздания',
        ];
    }

    public function __construct($data=[]) {
        parent::__construct($data);
        if($this->data['ДатаСоздания']) $this->data['ДатаСоздания'] = $this->toDate($this->data['ДатаСоздания']);
        if($this->data['ВремяСоздания']) $this->data['ВремяСоздания'] = $this->toTime($this->data['ВремяСоздания']);
    }

}
