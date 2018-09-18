<?php
/**
 * Created by PhpStorm.
 * User: eduardoluz
 * Date: 2018-09-17
 * Time: 11:56 PM
 */

namespace eduluz1976\action;


class ActionTest extends \PHPUnit\Framework\TestCase
{

    public function testGetRequest()
    {
        $action = new class extends Action{
            public static function checkURI($uri) {
                // placeholder
            }

            public static function build($uri, $request=[], $props=[]) {

            }
        };

        $request = $action->getRequest();

        $this->assertInstanceOf(Parameters::class, $request);

    }

    public function testGetResponse()
    {
        $action = new class extends Action{
            public static function checkURI($uri) {
                // placeholder
            }


            public static function build($uri, $request=[], $props=[]) {

            }
        };

        $response = $action->getResponse();

        $this->assertInstanceOf(Parameters::class, $response);

    }


    public function testCheckUriActionRegularFunction() {

        $invalid = 'http://www.domain.com';
        $valid = 'myTest()';

        $this->assertTrue(ActionRegularFunction::checkURI($valid));
        $this->assertFalse(ActionRegularFunction::checkURI($invalid));

    }

    public function testCheckUriActionRemoteAPICall() {

        $invalid = 'ftp://xpto';
        $valid = 'POST;https://mydomain.com/api/v3/xpto';

        $this->assertTrue(ActionRemoteAPICall::checkURI($valid));
        $this->assertFalse(ActionRemoteAPICall::checkURI($invalid));

    }

    public function testCheckUriActionClassMethod() {

        $invalid = 'myFunction()';
        $valid = 'eduluz1976\\action\\Task::method()';

        $this->assertTrue(ActionClassMethod::checkURI($valid));
        $this->assertFalse(ActionClassMethod::checkURI($invalid));

    }




    public function testFactory()
    {

        $uri = 'POST;https://user!password@my_domain.com:8081/api/v99/xpto?v1=1&v2=2#xpto';
        $request = [];
        $props = [];


        $obj = Action::factory($uri, $request, $props);

        $this->assertInstanceOf(ActionRemoteAPICall::class, $obj);

    }





}
