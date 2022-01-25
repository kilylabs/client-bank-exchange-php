<?php

namespace Kily\Tools1C\ClientBankExchange;

class Component implements \ArrayAccess
{
    protected $data;

    public static function fields()
    {
        return [];
    }

    public function __construct(array $data = [])
    {
        $this->init();
        foreach ($data as $k => $v) {
            if (!array_key_exists($k, $this->data)) {
                throw new Exception('There should no be such field ('.$k.') in '.static::class.' according to 1CClientBankExchange v1.02 format See http://v8.1c.ru/edi/edi_stnd/100/101.htm');
            }
            $this->data[$k] = $v;
        }
    }

    protected function init()
    {
        foreach (static::fields() as $k) {
            $this->data[$k] = null;
        }
    }

    public function __get($name)
    {
        $getter = 'get'.$name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (isset($this->data[$name])) {
            return $this->data[$name];
        }

        throw new Exception(
            'Property "{class}.{property}" is not defined.',
            ['{class}' => get_class($this), '{property}' => $name]
        );
    }

    public function __set($name, $value)
    {
        $setter = 'set'.$name;
        if (method_exists($this, $setter)) {
            return $this->$setter($value);
        } elseif (isset($this->data[$name])) {
            return $this->data[$name];
        }

        if (method_exists($this, 'get'.$name)) {
            throw new Exception(
                'Property "{class}.{property}" is read only.',
                ['{class}' => get_class($this), '{property}' => $name]
            );
        } else {
            throw new Exception(
                'Property "{class}.{property}" is not defined.',
                ['{class}' => get_class($this), '{property}' => $name]
            );
        }
    }

    public function __isset($name)
    {
        $getter = 'get'.$name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        } elseif (isset($this->data[$name])) {
            return true;
        }

        return false;
    }

    public function __unset($name)
    {
        $setter = 'set'.$name;
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif (isset($this->data[$name])) {
            $this->data[$name] = null;
        } elseif (method_exists($this, 'get'.$name)) {
            throw new Exception(
                'Property "{class}.{property}" is read only.',
                ['{class}' => get_class($this), '{property}' => $name]
            );
        }
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            throw new Exception('Not supported');
        } else {
            $this->$offset = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->$offset);
    }

    public function offsetUnset($offset): void
    {
        unset($this->$offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    protected function toDate($val)
    {
        if (!$val instanceof \DateTime) {
            if ($val) {
                $d = \DateTime::createFromFormat('d.m.Y', $val);
            } else {
                $d = $val;
            }
        } else {
            $d = $val;
        }

        return $d ? $d->format('Y-m-d') : null;
    }

    protected function toTime($val)
    {
        if ($val === null) {
            return null;
        }

        if (!($val instanceof \DateTime)) {
            $d = (new \DateTime($val))->format('H:i:s');
        } else {
            $d = $val->format('H:i:s');
        }

        return $d;
    }

    protected function toDMYDate($str)
    {
        return (new \DateTime($str))->format('d.m.Y');
    }

    protected function toHISDate($str)
    {
        return (new \DateTime($str))->format('H:i:s');
    }

    protected function toFloat($val)
    {
        return $val === null ? null : (float) preg_replace("/[\,]/", '.', $val);
    }

    protected function toInt($val)
    {
        return (int) $val;
    }

    public function toArray()
    {
        return $this->data;
    }
}
