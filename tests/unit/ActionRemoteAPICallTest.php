<?php

namespace tests\eduluz1976\unit;

use eduluz1976\action\Action;

/**
 * Class ActionRemoteAPICallTest
 * @package eduluz1976\action
 */
class ActionRemoteAPICallTest extends \PHPUnit\Framework\TestCase
{

   public function testInstantiation() {
       $uri = "rpc://tests\\eduluz1976\\unit\\MySampleClass::enclose()";

       $obj = Action::factory($uri);

       $this->assertEquals('enclose', $obj->getMethodName());
       $this->assertEquals('tests\\eduluz1976\\unit\\MySampleClass', $obj->getClassName());
   }


}
