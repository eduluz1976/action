<?php

namespace tests\eduluz1976\unit;

/**
 * Support class to perform the tests.
 *
 * Class MySampleClass2
 * @package tests\eduluz1976\unit
 */
class MySampleClass2
{
    use \eduluz1976\action\DBAccessible;

    protected $suffix = '_123';
    protected $list = [];

    public function __construct($first, $second, $third, $fourth)
    {
        $this->list = [
            $first, $second, $third, $fourth
        ];
    }

    public function test1()
    {
        return $this->list;
    }

    public function test2()
    {
        $sql = 'INSERT INTO my_test (col1,col2,col3,col4) VALUES (?,?,?,?)';

        $statement = $this->getConn()->prepare($sql);

        $result = $statement->execute($this->list);
    }
}
