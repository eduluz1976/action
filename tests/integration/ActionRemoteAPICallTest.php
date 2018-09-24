<?php
namespace eduluz1976\action\integration;




use eduluz1976\action\Action;

class ActionRemoteAPICallTest extends \PHPUnit\Framework\TestCase
{



    public function testAuthOk()
    {
        $url = 'POST  http://127.0.0.1:8888/auth';

        $action = Action::factory($url,[],['headers'=> ['Authorization' => 'basic 12345']]);

        $response = $action->exec();

        $this->assertEquals('12345', $action->getResponse()->get('token'));
        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }

    public function testAuthError()
    {
        $url = 'POST  http://127.0.0.1:8888/auth';

        $action = Action::factory($url,[],['headers'=> ['Authorization' => 'basic abcde']]);

        $this->expectExceptionCode(403);

        $response = $action->exec();


        $this->assertEquals(403, $action->getResult()->getStatusCode());
    }


    public function testRootAuthenticationRequiredRequestOk()
    {
        $url = 'GET  http://127.0.0.1:8888/';

        $action = Action::factory($url,[],['headers'=> ['token' => '12345']]);

        $response = $action->exec();

        $hdrToken = $action->getHeadersReceived()->get('token');

        $this->assertEquals('23456', $hdrToken[0]);
        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }

    public function testRootAuthenticationRequiredRequestError()
    {
        $url = 'GET  http://127.0.0.1:8888/';

        $action = Action::factory($url,[],['headers'=> ['token' => 'aaaaa']]);

        $this->expectExceptionCode(403);

        $response = $action->exec();

        $this->assertEquals(403, $action->getResult()->getStatusCode());
    }


    public function testCreateUser()
    {
        $url = 'POST;http://username:password@127.0.0.1:8888/user';

        $action = Action::factory($url,['name'=>'John','surname'=>'Doe']);

        $response = $action->exec();

        $this->assertEquals('John', $action->getResponse()->get('name'));
    }

    /**
     *
     * @throws exception\InvalidURIException
     */
    public function testUpdateUser()
    {
        $url = 'PUT http://username:password@127.0.0.1:8888/user/1';

        $action = Action::factory($url,['name'=>'John','surname'=>'Doe']);

        $response = $action->exec();

        $this->assertEquals(204, $action->getResult()->getStatusCode());
    }


    public function testDeleteUser()
    {
        $url = 'DELETE http://username:password@127.0.0.1:8888/user/1';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertEquals(204, $action->getResult()->getStatusCode());
    }



    public function testListUsers()
    {
        $url = 'GET http://username:password@127.0.0.1:8888/users';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertCount(3, $action->getResponse()->get('users'));
        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }





    public function testAuth2Ok()
    {
        $url = 'GET http://username:password@127.0.0.1:8888/auth';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertEquals(200, $action->getResult()->getStatusCode());
    }

    public function testAuth2Error()
    {
        $url = 'GET http://username:password2@127.0.0.1:8888/auth';

        $action = Action::factory($url);

        $this->expectExceptionCode(403);
        $response = $action->exec();
    }


    public function testXML()
    {
        $url = 'GET http://username:password2@127.0.0.1:8888/xml';

        $action = Action::factory($url);

//        $this->expectExceptionCode(403);
        $response = $action->exec();

//        print_r($response);

        $this->assertEquals(200, $action->getResult()->getStatusCode());
        $this->assertEquals('John', $action->getResponse()->get('name'));

    }


    public function testMultiLines()
    {
        $url = 'GET http://username:password2@127.0.0.1:8888/lines';

        $action = Action::factory($url);

        $response = $action->exec();

        $this->assertEquals(200, $action->getResult()->getStatusCode());
        $this->assertCount(3, $action->getResponse()->getList());
    }





}
