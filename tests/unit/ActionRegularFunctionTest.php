<?php

namespace tests\eduluz1976\unit;

use eduluz1976\action\Action;

/**
 * Class ActionRegularFunctionTest
 * @package tests\eduluz1976\unit
 */
class ActionRegularFunctionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if the function name was setted properly.
     *
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testGetFunctionName()
    {
        $action = Action::factory('sampleFunction1()', ['test1']);

        $this->assertEquals('sampleFunction1', $action->getFunctionName());
    }

    /**
     * Tests if function is executed properly.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testExec()
    {
        $action = Action::factory('\sampleFunction1()', ['test1']);
        $response = $action->exec();

        $this->assertEquals('(((test1)))', $response);
    }

    /**
     * Tests if works the function name override method.
     *
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testSetFunctionName()
    {
        $action = Action::factory('sampleFunction1()');
        $action->setFunctionName('sampleFunction2');

        $this->assertEquals('sampleFunction2', $action->getFunctionName());
    }
}
