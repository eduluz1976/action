<?php

namespace tests\eduluz1976\integration;

use eduluz1976\action\Action;

/**
 * Class ActionRemoteAPICallTest
 * @package eduluz1976\action\integration
 */
class ActionRemoteAPICallTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if authentication works well.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testAuthOk()
    {
        $url = 'POST  http://127.0.0.1:18888/auth';

        $action = Action::factory($url, [], ['headers' => ['Authorization' => 'basic 12345']]);

        $response = $action->exec();

        $this->assertEquals('12345', $action->getResponse()->get('token'));
        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }

    /**
     * Tests if giving a bad credentials, the component will deal with authorization errors.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testAuthError()
    {
        $url = 'POST  http://127.0.0.1:18888/auth';

        $action = Action::factory($url, [], ['headers' => ['Authorization' => 'basic abcde']]);

        $this->expectExceptionCode(403);

        $response = $action->exec();

        $this->assertEquals(403, $action->getResult()->getStatusCode());
    }

    /**
     * Tests if passing a mocked jwtToken to test-server, it will receive the right
     * response data.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testRootAuthenticationRequiredRequestOk()
    {
        $url = 'GET  http://127.0.0.1:18888/';

        $action = Action::factory($url, [], ['headers' => ['token' => '12345']]);

        $response = $action->exec();

        $hdrToken = $action->getHeadersReceived()->get('token');

        $this->assertEquals('23456', $hdrToken[0]);
        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }

    /**
     * Tests if passing a wrong token, will cause error.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testRootAuthenticationRequiredRequestError()
    {
        $url = 'GET  http://127.0.0.1:18888/';

        $action = Action::factory($url, [], ['headers' => ['token' => 'aaaaa']]);

        $this->expectExceptionCode(403);

        $response = $action->exec();

        $this->assertEquals(403, $action->getResult()->getStatusCode());
    }

    /**
     * Tests a typical POST operation
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testCreateUser()
    {
        $url = 'POST;http://username:password@127.0.0.1:18888/user';

        $action = Action::factory($url, ['name' => 'John', 'surname' => 'Doe']);

        $response = $action->exec();

        $this->assertEquals('John', $action->getResponse()->get('name'));
        $this->assertEquals(201, $action->getResult()->getStatusCode());
    }

    /**
     * Tests a typical PUT (update) operation.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testUpdateUser()
    {
        $url = 'PUT http://username:password@127.0.0.1:18888/user/1';

        $action = Action::factory($url, ['name' => 'John', 'surname' => 'Doe']);

        $response = $action->exec();

        $this->assertEquals(204, $action->getResult()->getStatusCode());
    }

    /**
     * Test a typical DELETE operation
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testDeleteUser()
    {
        $url = 'DELETE http://username:password@127.0.0.1:18888/user/1';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertEquals(204, $action->getResult()->getStatusCode());
    }

    /**
     * Test a typical GET operation
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testListUsers()
    {
        $url = 'GET http://username:password@127.0.0.1:18888/users';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertCount(3, $action->getResponse()->get('users'));
        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }

    /**
     * Test authenticate only using username and password.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testAuth2Ok()
    {
        $url = 'GET http://username:password@127.0.0.1:18888/auth';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }

    /**
     * Tests authenticate with a wrong password.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testAuth2Error()
    {
        $url = 'GET http://username:wrong_password@127.0.0.1:18888/auth';

        $action = Action::factory($url);

        $this->expectExceptionCode(403);
        $response = $action->exec();
    }

    /**
     * Tests if contents coming from server are in XML format, and if is
     * decoded properly.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testXML()
    {
        $url = 'GET http://username:password2@127.0.0.1:18888/xml';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertEquals(200, $action->getResult()->getStatusCode());
        $this->assertEquals('John', $action->getResponse()->get('name'));
    }

    /**
     * Tests if response comes in multi-lines format.
     *
     * @throws \eduluz1976\action\exception\FunctionNotFoundException
     * @throws \eduluz1976\action\exception\InvalidURIException
     */
    public function testMultiLines()
    {
        $url = 'GET http://username:password2@127.0.0.1:18888/lines';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertEquals(200, $action->getResult()->getStatusCode());
        $this->assertCount(3, $action->getResponse()->getList());
    }
}
