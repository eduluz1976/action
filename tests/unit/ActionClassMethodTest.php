<?php

namespace tests\eduluz1976\unit;

use eduluz1976\action\Action;

/**
 * Class ActionClassMethodTest
 * @package tests\eduluz1976\unit
 */
class ActionClassMethodTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if the object created have the right method name.
     *
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testGetFunctionName()
    {
        $action = Action::factory('tests\eduluz1976\unit\MySampleClass::test1()');

        $this->assertEquals('test1', $action->getMethodName());
    }

    /**
     * Tests if is possible overwrite the method name programaticaly.
     *
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testSetFunctionName()
    {
        $action = Action::factory('tests\eduluz1976\unit\MySampleClass::test1()');
        $action->setMethodName('test2');

        $this->assertEquals('test2', $action->getMethodName());
    }

    /**
     * Tests if constructor class receive the right number of parameters
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testConstructor2Params()
    {
        $action = Action::factory(
            'tests\eduluz1976\unit\MySampleClass2::test1()',
            [],
            ['constructor' => [
                '1st',
                '2nd',
                '3rd',
                '4th'
            ]]
        );
        $response = $action->exec();

        $this->assertCount(4, $response);
        $this->assertEquals('1st', $response[0]);
        $this->assertEquals('2nd', $response[1]);
    }

    /**
     * Tests if execution of method is ok.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testExec()
    {
        $action = Action::factory('tests\eduluz1976\unit\MySampleClass::test1()');
        $response = $action->exec();

        $this->assertEquals(date('Ymd') . '_123', $response);
    }

    /**
     * Tests if the dyn object (Action) can access the global DB Connection properly
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testDBAccessibleAttached()
    {
        $pdo = new \PDO('sqlite::memory:');

        $pdo->exec('CREATE TABLE my_test (col1 INTEGER , col2 INTEGER , col3 INTEGER , col4 INTEGER )');

        $action = Action::factory('tests\eduluz1976\unit\MySampleClass2::test2()', [], ['constructor' => [1, 2, 3, 4]]);

        $action->setConn($pdo);

        $action->exec();

        $sql = 'SELECT col1+col2+col3+col4 as total FROM my_test';

        $statement = $action->getConn()->query($sql);

        $results = $statement->fetchAll(\PDO::FETCH_COLUMN, 0);

        $value = $results[0];

        $this->assertEquals(10, $value);

        $this->assertTrue(method_exists($action, 'getConn'));
    }
}
