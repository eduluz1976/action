<?php

namespace tests\eduluz1976\unit;

/**
 * Support class to perform the tests.
 *
 * Class MySampleClass
 * @package eduluz1976\action
 */
class MySampleClass
{
    protected $suffix = '_123';

    public function test1()
    {
        return date('Ymd') . $this->suffix;
    }

    public function enclose($string, $left='[[', $right=']]') {
        return $left.$string.$right;
    }
}
