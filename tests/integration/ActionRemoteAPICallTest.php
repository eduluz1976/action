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

}
