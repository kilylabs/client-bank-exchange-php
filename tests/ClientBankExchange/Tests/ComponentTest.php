<?php

namespace Tests\Kily\Tools1C\Tests\ClientBankExchange;

use Kily\Tools1C\ClientBankExchange\Component;
use PHPUnit\Framework\TestCase;
use Kily\Tools1C\ClientBankExchange\Exception;

class ComponentTest extends TestCase
{
    /**
     * @var Component
     */
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Component([]);
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::fields
     */
    public function testFields()
    {
        $this->assertEquals(Component::fields(), []);
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::__get
     */
    public function test__get()
    {
        $this->expectException(Exception::class);
        $this->object->{'Номер'};
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::__set
     */
    public function test__set()
    {
        $this->expectException(Exception::class);
        $this->object->{'Номер'} = 123;
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::__isset
     */
    public function test__isset()
    {
        $this->assertEquals(isset($this->object->{'Номер'}), false);
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::__unset
     */
    public function test__unset()
    {
        unset($this->object->{'Номер'});
        $this->assertFalse(isset($this->object->{'Номер'}));
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::offsetSet
     */
    public function testOffsetSet()
    {
        $this->expectException(Exception::class);
        $this->object['Номер'] = 123;
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::offsetExists
     */
    public function testOffsetExists()
    {
        $this->assertEquals(isset($this->object['Номер']), false);
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::offsetUnset
     */
    public function testOffsetUnset()
    {
        unset($this->object['Номер']);
        $this->assertFalse(isset($this->object->{'Номер'}));
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::offsetGet
     */
    public function testOffsetGet()
    {
        $this->expectException(Exception::class);
        $a = $this->object['Номер'];
        var_dump($a);
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::toDate
     */
    public function testToDate()
    {
        $m = self::getMethod('toDate', $this->object);
        $this->assertEquals('2015-12-01', $m->invokeArgs($this->object, ['01.12.2015']));
        $this->assertEquals('2015-01-01', $m->invokeArgs($this->object, ['1.1.2015']));
        $this->assertEquals(null, $m->invokeArgs($this->object, [null]));
        $this->assertNotEquals('2015-01-01', $m->invokeArgs($this->object, ['1.1.15']));
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::toTime
     */
    public function testToTime()
    {
        $m = self::getMethod('toTime', $this->object);
        $this->assertEquals('00:00:01', $m->invokeArgs($this->object, ['00:00:01']));
        $this->assertEquals('10:10:10', $m->invokeArgs($this->object, ['10:10:10.0000']));
        $this->assertEquals('00:00:00', $m->invokeArgs($this->object, ['00:00']));
        $this->assertEquals(null, $m->invokeArgs($this->object, [null]));
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::toFloat
     */
    public function testToFloat()
    {
        $m = self::getMethod('toFloat', $this->object);
        $this->assertEquals(1.1, $m->invokeArgs($this->object, ['1.1']));
        $this->assertEquals(1.1, $m->invokeArgs($this->object, ['1,1']));
        $this->assertEquals(1.100, $m->invokeArgs($this->object, ['1,100']));
        $this->assertEquals(null, $m->invokeArgs($this->object, [null]));
    }

    /**
     * @covers Kily\Tools1C\ClientBankExchange\Component::toInt
     */
    public function testToInt()
    {
        $m = self::getMethod('toInt', $this->object);
        $this->assertEquals(1, $m->invokeArgs($this->object, ['1.1']));
        $this->assertEquals(1, $m->invokeArgs($this->object, ['1,1']));
        $this->assertEquals(1, $m->invokeArgs($this->object, ['1,100']));
        $this->assertEquals(null, $m->invokeArgs($this->object, [null]));
    }

    protected static function getMethod($name, $obj)
    {
        $class = new \ReflectionClass(get_class($obj));
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
