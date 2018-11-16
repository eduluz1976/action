<?php

namespace tests\eduluz1976\unit;

use eduluz1976\action\Action;
use eduluz1976\action\ActionClassMethod;
use eduluz1976\action\ActionRegularFunction;
use eduluz1976\action\ActionRemoteAPICall;
use eduluz1976\action\ActionURLCall;
use eduluz1976\action\Parameters;

/**
 * Class ActionTest
 * @package tests\eduluz1976\unit
 */
class ActionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if building a dynamic class, extending from Action, and calling getRequest method,
     * will return an object of Parameters.
     *
     * @throws \Exception
     */
    public function testGetRequest()
    {
        $action = new class extends Action {
            public static function checkURI($uri)
            {
                // placeholder
            }

            public static function build($uri, $request = [], $props = [])
            {
                // placehloder
            }

            public function exec(array $additionalRequestAttributes = [])
            {
                // placeholder
            }
        };

        $request = $action->getRequest();

        $this->assertInstanceOf(Parameters::class, $request);
    }

    /**
     * Tests if building a dynamic class, extending from Action, and calling getResponse method,
     * will return an object of Parameters.
     *
     * @throws \Exception
     */
    public function testGetResponse()
    {
        $action = new class extends Action {
            public static function checkURI($uri)
            {
                // placeholder
            }

            public static function build($uri, $request = [], $props = [])
            {
            }

            public function exec(array $additionalRequestAttributes = [])
            {
                // placeholder
            }
        };

        $response = $action->getResponse();

        $this->assertInstanceOf(Parameters::class, $response);
    }

    /**
     * Tests if the method checkURI works detecting a valid URI, and if
     * detect an invalid too, for ActionRegularFunction classes.
     *
     * @throws \Exception
     */
    public function testCheckUriActionRegularFunction()
    {
        $invalid = 'http://www.domain.com';
        $valid = 'myTest()';

        $this->assertTrue(ActionRegularFunction::checkURI($valid));
        $this->assertFalse(ActionRegularFunction::checkURI($invalid));
    }

    /**
     * Tests if the check method works well to ActionURLCall class.
     * @throws \Exception
     */
    public function testCheckUriActionRemoteAPICall()
    {
        $invalid = 'ftp://xpto';
        $valid = 'POST;https://mydomain.com/api/v3/xpto';

        $this->assertTrue(ActionURLCall::checkURI($valid));
        $this->assertFalse(ActionURLCall::checkURI($invalid));
    }

    /**
     * Tests if the check method works well to ActionClassMethod class.
     *
     * @throws \Exception
     */
    public function testCheckUriActionClassMethod()
    {
        $invalid = 'myFunction()';
        $valid = 'eduluz1976\\action\\Task::method()';

        $this->assertTrue(ActionClassMethod::checkURI($valid));
        $this->assertFalse(ActionClassMethod::checkURI($invalid));
    }

    /**
     * Tests the factory method, returning an ActionURLCall method (the most complex URI),
     * and if an invalid URI will trigger an Exception (InvalidURIException).
     *
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testFactory()
    {
        $uri = 'POST;https://user!password@my_domain.com:8081/api/v99/xpto?v1=1&v2=2#xpto';
        $request = [];
        $props = [];

        $obj = Action::factory($uri, $request, $props);

        $this->assertInstanceOf(ActionURLCall::class, $obj);

        $this->expectException('eduluz1976\action\exception\InvalidURIException');
        Action::factory('@#$%11');
    }

    /**
     * Test if calling a regular function will works.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testExec1()
    {
        $uri = '\json_encode()';

        $obj = Action::factory($uri, [['success' => true, 'name' => 'John'], true]);

        $res = $obj->exec();

        $json = json_decode($res, true);

        $this->assertTrue(is_array($json));
        $this->assertArrayHasKey('name', $json);
    }
}
