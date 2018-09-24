<?php



class Server {


    protected $routes = [
        'GET' => [
            '/' => 'getRoot',
            '/users' => 'listUsers',
            '/user/1' => 'getUser',
            '/auth' => 'auth2',
            '/xml' => 'getXML',
            '/lines' => 'getLines'
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
        $lsHeaders = getallheaders();

        if (isset($lsHeaders['token']) && ($lsHeaders['token']=='12345')) {
            header('token: 23456');
            $this->doReturn(['root'=>true]);
        } else {
            $this->doReturn(['msg'=>'Auth required'],403);
        }

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

        $lsHeaders = getallheaders();

        if (isset($lsHeaders['Authorization']) && ($lsHeaders['Authorization'] == 'basic 12345')) {
            $this->doReturn([
                'success'=>true,
                'token' => '12345'
            ], 200);
        } else {

            $this->doReturn([
                'success'=>false,
                'msg' => 'Authentication failure'

            ], 403);
        }

    }

    protected function auth2() {

        $lsHeaders = getallheaders();


        if ((isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER']=='username')) &&
            (isset($_SERVER['PHP_AUTH_PW']) && ($_SERVER['PHP_AUTH_PW'] =='password'))) {

            header('token: 23456');

            $this->doReturn([
                'success'=>true
            ], 200);

        } else {
            $this->doReturn([
                'success'=>false,
                'msg' => 'Authentication failure'

            ], 403);
        }

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


    protected function getXML() {
        $s = '<user><name>John</name><surname>Doe</surname></user>';
        $this->doReturnXML($s,200);
    }



    protected function getLines() {
        $s = "line1\nline2\nline3";
        $this->doReturnXML($s,200);
    }



    protected function doReturn($s, $code=200) {
        http_response_code($code);
        echo json_encode($s);
        exit;
    }

    protected function doReturnXML($s, $code=200) {
        http_response_code($code);
        echo $s;
        exit;
    }

}