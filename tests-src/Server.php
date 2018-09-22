<?php



class Server {


    protected $routes = [
        'GET' => [
            '/' => 'getRoot',
            '/users' => 'listUsers',
            '/user/1' => 'getUser'
        ],
        'POST' => [
            '/auth' => 'auth',
            '/user' => 'createUser'
        ],
        'PUT' => [
            '/user/1' => 'updateUser'
        ],
        'DELETE' => [
            '/user/1' => 'deleteUser',
            '/auth' => 'invalidAuth'
        ],
        'PATCH' => [
            '/user/1' => 'updateUser'
        ]
    ];




    public function run() {

        $uri = $_SERVER['REQUEST_URI']??'/';
        $httpMethod = $_SERVER['REQUEST_METHOD']??'GET';

        $methods = $this->routes[$httpMethod]??false;

        $method = 'undefined';

        if ($methods) {
            $method = $methods[$uri]??'undefined';
        }

        $this->$method();

    }


    protected function undefined() {
        $this->doReturn(['msg'=>'Undefined call'],403);
    }


    protected function getRoot() {
        $this->doReturn(['root'=>true]);
    }

    protected function listUsers() {
        $this->doReturn(['users'=>[
            [
            'id'=>1,'name'=>'John','surname'=>'Doe'
                ],[
            'id'=>2,'name'=>'Mary','surname'=>'Popkin'],[
            'id'=>3,'name'=>'Peter','surname'=>'McCain'
                ]
        ]]);
    }


    protected function getUser() {
        $this->doReturn([
            'id'=>1,
            'name'=>'John',
            'surname'=>'Doe'
        ]);
    }

    protected function auth() {
        $this->doReturn([
            'success'=>true,
            'token' => md5('123')
        ]);
    }

    protected function createUser() {
        $this->doReturn([
            "id" => 1,
            "name" => $_POST['name']
        ],201);
    }

    protected function updateUser() {
        $this->doReturn(
            [],
            204
        );
    }

    protected function deleteUser() {
        $this->doReturn(
            [],
            204
        );
    }


    protected function invalidAuth() {
        $this->doReturn(
            ['msg'=>'invalid credentials'],
            403
        );
    }




    protected function doReturn($s, $code=200) {
        http_response_code($code);
        echo json_encode($s);
        exit;
    }

}