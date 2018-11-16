<?php

namespace eduluz1976\action;

use PHPUnit\Framework\TestCase;

class ParametersTest extends \PHPUnit\Framework\TestCase
{
    public function testAddValue()
    {
        $originalName = 'John';
        $attrName = 'name';

        $p = new Parameters();
        $p->add($attrName, $originalName);

        $name = $p->get($attrName);

        $this->assertEquals($originalName, $name);
    }

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
