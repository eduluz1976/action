<?php
/**
 * Created by PhpStorm.
 * User: eduardoluz
 * Date: 2018-09-18
 * Time: 4:47 PM
 */

namespace eduluz1976\action;

class ActionRegularFunctionTest extends \PHPUnit\Framework\TestCase
{
    public function testGetFunctionName()
    {
        $action = Action::factory('sampleFunction1()', ['test1']);

        $this->assertEquals('sampleFunction1', $action->getFunctionName());
    }

    public function testExec()
    {
        $action = Action::factory('\sampleFunction1()', ['test1']);
        $response = $action->exec();

        $this->assertEquals('(((test1)))', $response);
    }

    public function testSetFunctionName()
    {
        $action = Action::factory('sampleFunction1()');
        $action->setFunctionName('sampleFunction2');

        $this->assertEquals('sampleFunction2', $action->getFunctionName());
    }
}
