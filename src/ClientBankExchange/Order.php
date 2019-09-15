<?php

namespace Kily\Tools1C\ClientBankExchange;

class Order
{
    protected $encoding;
    protected $result;

    protected $start = null;
    protected $general = null;
    protected $filter = null;
    protected $documenits = [];

    public function __construct($owner_rschet,$encoding = 'cp1251')
    {
        $this->encoding = $encoding;
        $this->start = new Model\StartSection();
        $this->general = new Model\GeneralSection([
            'ВерсияФормата'=>'1.02',
            'Кодировка'=>'Windows',
            'Отправитель'=>'Бухгалтерия предприятия, редакция 3.0',
            'Получатель'=>'',
            'ДатаСоздания'=>new \DateTime,
            'ВремяСоздания'=>new \DateTime,
        ]);
        $this->filter = new Model\FilterSection([
            'ДатаНачала'=>new \DateTime,
            'ДатаКонца'=>new \DateTime,
            'РасчСчет'=>$owner_rschet,
            'Документ'=>'Платежное поручение',
        ]);
    }

    public function addFromArray($arr = [])
    {
        $this->documents[] = new Model\DocumentSection('Платежное поручение',$arr);
    }

    public function save($file) {
        return file_put_contents($file,$this->__toString());
    }

    public function __toString() {
        $out = '';
        foreach([$this->start,$this->general,$this->filter,$this->documents] as $item) {
            if(is_array($item)) {
                foreach($item as $_item) {
                    $out .= $_item->__toString();
                }
            } else {
                $out .= $item->__toString();
            }
        }
        return iconv('UTF-8',$this->encoding,$out."КонецФайла\n");
    }
}
