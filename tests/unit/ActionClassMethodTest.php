<?php
/**
 * Created by PhpStorm.
 * User: eduardoluz
 * Date: 2018-09-18
 * Time: 4:47 PM
 */

namespace eduluz1976\action;


class MySampleClass {

    protected $suffix = '_123';


    public function test1() {
        return date('Ymd').$this->suffix;
    }

}

class MySampleClass2 {

    use \eduluz1976\action\DBAccessible;

    protected $suffix = '_123';
    protected $list = [];

    public function __construct($first,$second,$third,$fourth)
    {
        $this->list = [
            $first,$second,$third,$fourth
        ];
    }

    public function test1() {
        return $this->list;
    }

    public function test2() {

        $sql = "INSERT INTO my_test (col1,col2,col3,col4) VALUES (?,?,?,?)";

        $statement = $this->getConn()->prepare($sql);

        $result = $statement->execute($this->list);

    }

}


class ActionClassMethodTest extends \PHPUnit\Framework\TestCase
{

    public function testGetFunctionName()
    {

        $action = Action::factory('\eduluz1976\action\MySampleClass::test1()');


        $this->assertEquals('test1', $action->getMethodName());

    }


    public function testSetFunctionName()
    {
        $action = Action::factory('\eduluz1976\action\MySampleClass::test1()');
        $action->setMethodName('test2');

        $this->assertEquals('test2', $action->getMethodName());

    }



    public function testConstructor2Params()
    {


        $action = Action::factory('\eduluz1976\action\MySampleClass2::test1()',
            [],
            ['constructor'=>[
                '1st',
                '2nd',
                '3rd'
                ,
                '4th'
            ]]);
        $response = $action->exec();

        $this->assertCount(4, $response);
        $this->assertEquals('1st', $response[0]);
        $this->assertEquals('2nd', $response[1]);
    }




    public function testExec()
    {

        $action = Action::factory('\eduluz1976\action\MySampleClass::test1()');
        $response = $action->exec();

        $this->assertEquals(date('Ymd').'_123', $response);
    }


    /**
     * Tests if the dyn object (Action) can access the global DB Connection properly
     * @throws exception\InvalidURIException
     */
    public function testDBAccessibleAttached()
    {

        $pdo = new \PDO('sqlite::memory:');

        $pdo->exec("CREATE TABLE my_test (col1 INTEGER , col2 INTEGER , col3 INTEGER , col4 INTEGER )");


        $action = Action::factory('\eduluz1976\action\MySampleClass2::test2()',[],  ['constructor'=>[1,2,3,4]]);

        $action->setConn($pdo);

        $action->exec();


        $sql = "SELECT col1+col2+col3+col4 as total FROM my_test";

        $statement = $action->getConn()->query($sql);

        $results = $statement->fetchAll(\PDO::FETCH_COLUMN, 0);

        $value = $results[0];

        $this->assertEquals(10,$value);

        $this->assertTrue(method_exists($action,'getConn'));
    }


}
