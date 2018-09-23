<?php
namespace eduluz1976\action;




class ActionRemoteAPICallTest extends \PHPUnit\Framework\TestCase
{



    public function testCreateUser()
    {
        $url = 'POST;http://username:password@127.0.0.1:8888/user';

        $action = Action::factory($url,['name'=>'John','surname'=>'Doe']);

        $response = $action->exec();

        $this->assertEquals('John', $action->getResponse()->get('name'));
    }

    /**
     * Todo: use alternatively ' ' instead ';' to separate method
     *
     * provide an way to get the header http code
     *
     * @throws exception\InvalidURIException
     */
    public function testUpdateUser()
    {
        $url = 'PUT http://username:password@127.0.0.1:8888/user/1';

        $action = Action::factory($url,['name'=>'John','surname'=>'Doe']);

        $response = $action->exec();



//        print_r($action->getResponse()->getList());

//        $action->getHeadersReceived()->get('http_code');

//        $this->assertEquals('John', $action->getResponse()->get('name'));
        $this->assertEquals(204, $action->getResult()->getStatusCode());
    }

}
