<?php

namespace tests\eduluz1976\unit;

use eduluz1976\action\Parameters;
use PHPUnit\Framework\TestCase;

/**
 * Class ParametersTest
 * @package tests\eduluz1976\unit
 */
class ParametersTest extends TestCase
{
    /**
     * Test add some value on object
     *
     * @throws \Exception
     */
    public function testAddValue()
    {
        $originalName = 'John';
        $attrName = 'name';

        $p = new Parameters();
        $p->add($attrName, $originalName);

        $name = $p->get($attrName);

        $this->assertEquals($originalName, $name);
    }

    /**
     * Test add an associative array to an Parameter instance
     *
     * @throws \Exception
     */
    public function testAddSetOfValues()
    {
        $attributes = [
            'name' => 'John',
            'surname' => 'Doe',
            'country' => 'Brazil',
            'city' => 'Florianopolis'
        ];

        $p = new Parameters();
        $p->addList($attributes);

        $this->assertCount(count($attributes), $p->getList());
    }

    /**
     * Test remove an item value.
     *
     * @throws \Exception
     */
    public function testRemoveValue()
    {
        $attributes = [
            'name' => 'John',
            'surname' => 'Doe',
            'country' => 'Brazil',
            'city' => 'Florianopolis'
        ];

        $p = new Parameters();
        $p->addList($attributes);

        $p->del('country');

        $this->assertCount(count($attributes) - 1, $p->getList());
    }

    /**
     * Test if the method 'has' works.
     *
     * @throws \Exception
     */
    public function testHasAttribute()
    {
        $attributes = [
            'name' => 'John',
            'surname' => 'Doe',
            'country' => 'Brazil',
            'city' => 'Florianopolis'
        ];

        $p = new Parameters();
        $p->addList($attributes);

        $this->assertTrue($p->has('country'));
        $this->assertFalse($p->has('age'));
    }
}
