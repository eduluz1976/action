<?php

namespace eduluz1976\action;

class ActionRemoteAPICallTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAttributes()
    {
        $url = 'post;https://username:password@my.hostname:9090/path?arg=value#anchor';

        $action = Action::factory($url);

        $this->assertEquals('POST', $action->getMethod());
        $this->assertEquals('https', $action->getSchema());
        $this->assertEquals('username', $action->getUser());
        $this->assertEquals('password', $action->getPassword());
        $this->assertEquals('my.hostname', $action->getHostname());
        $this->assertEquals('9090', $action->getPort());
        $this->assertEquals('/path', $action->getPath());
    }

    public function testAdditionalParameters()
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';

        $action = Action::factory($url, ['name' => 'John', 'surname' => 'Doe']);

        $this->assertEquals('John', $action->getRequest()->get('name'));
    }

    public function testExec()
    {
        $action = Action::factory('\sampleFunction1()', ['test1']);
        $response = $action->exec();

        $this->assertEquals('(((test1)))', $response);
    }

    public function testSetFunctionName()
    {
        $action = Action::factory('sampleFunction1()');
        $action->setFunctionName('sampleFunction2');

        $this->assertEquals('sampleFunction2', $action->getFunctionName());
    }
}
