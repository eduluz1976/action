<?php

namespace eduluz1976\action;


use GuzzleHttp\Exception\GuzzleException;

class ActionRemoteAPICall extends Action
{

    protected $method;
    protected $schema;
    protected $user;
    protected $password;
    protected $hostname;
    protected $port;
    protected $path;
    protected $query; // after '?' on URL
    protected $fragment; // after '#' on URL

    protected $headersSent;
    protected $headersReceived;
    protected $options;

    protected $client;

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return ActionRemoteAPICall
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param mixed $schema
     * @return ActionRemoteAPICall
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     * @return ActionRemoteAPICall
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return ActionRemoteAPICall
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return ActionRemoteAPICall
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return ActionRemoteAPICall
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param mixed $hostname
     * @return ActionRemoteAPICall
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     * @return ActionRemoteAPICall
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param mixed $fragment
     * @return ActionRemoteAPICall
     */
    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     * @return Parameters
     */
    public function getHeadersSent()
    {
        return $this->headersSent;
    }

    /**
     * @param Parameters $headersSent
     * @return ActionRemoteAPICall
     */
    public function setHeadersSent($headersSent)
    {
        $this->headersSent = $headersSent;
        return $this;
    }

    /**
     * @return Parameters
     */
    public function getHeadersReceived()
    {
        if (!$this->headersReceived) {
            $this->headersReceived = new Parameters();
        }
        return $this->headersReceived;
    }

    /**
     * @param Parameters $headersReceived
     * @return ActionRemoteAPICall
     */
    public function setHeadersReceived($headersReceived)
    {
        $this->headersReceived = $headersReceived;
        return $this;
    }

    /**
     * @return Parameters
     */
    public function getOptions()
    {
        if (!$this->options) {
            $this->options = new Parameters();
        }
        return $this->options;
    }

    /**
     * @param Parameters $options
     * @return ActionRemoteAPICall
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new \GuzzleHttp\Client();
        }
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     * @return ActionRemoteAPICall
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }







    /**
     * @param $uri
     * @return bool
     */
    public static function checkURI($uri) {
        if (strpos($uri, 'http')!==false) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * ActionRemoteAPICall constructor.
     * @param string $method
     * @param null|string $schema
     * @param null|string $user
     * @param null|string $password
     * @param null|string $hostname
     * @param null|string $port
     * @param null|string $path
     * @param null|string $query
     * @param null|string $fragment
     * @param array $request
     */
    public function __construct($method='GET', $schema=null,$user=null,$password=null, $hostname=null, $port=null, $path=null, $query=null, $fragment=null, $request=[])
    {
        $this->setMethod($method);
        $this->setSchema($schema);
        $this->setUser($user);
        $this->setPassword($password);
        $this->setHostname($hostname);
        $this->setPort($port);
        $this->setPath($path);
        $this->setQuery($query);
        $this->setFragment($fragment);

        $this->getRequest()->addList($request);
    }


    /**
     * @param $uri
     * @param array $request
     * @param array $props
     * @return ActionRemoteAPICall
     */
    public static function build($uri, $request=[], $props=[]) {

        if (strpos($uri,';')) {
            list($method,$url) = explode(";",$uri);
        } else {
            $method='GET';
            $url=$uri;
        }

        $parts = parse_url($url);

//        print_r($parts);

        $schema = (isset($parts['scheme']))?$parts['scheme']:null;
        $user = (isset($parts['user']))?$parts['user']:null;
        $pass = (isset($parts['pass']))?$parts['pass']:null;
        $host = (isset($parts['host']))?$parts['host']:null;
        $port = (isset($parts['port']))?$parts['port']:null;
        $path = (isset($parts['path']))?$parts['path']:null;
        $query = (isset($parts['query']))?$parts['query']:null;
        $fragment = (isset($parts['fragment']))?$parts['fragment']:null;


        $obj = new ActionRemoteAPICall(strtoupper($method),$schema,$user,$pass, $host, $port, $path, $query, $fragment, $request);
//        $client = new \GuzzleHttp\Client($props);
//        $obj->setClient($client);

        if (isset($props['headers'])) {
            $obj->getHeadersSent()->addList($props['headers']);
        }


        return $obj;
    }

    public function exec(array $additionalRequestAttributes=[]) {


        $options = $this->getOptions()->getList()??[];

        if (in_array($this->getMethod(),['POST','PUT','PATCH'])) {
            $options['form_params'] = $this->getRequest()->getList();
        }


        $result = $this->getClient()
                    ->request(
                        $this->getMethod(),
                        $this->getFullURL(),
                        $options
                        );

        $headers =$result->getHeaders();

        $this->getHeadersReceived()->addList($headers);

        $contents = $result->getBody()->getContents();

        $response = $this->decodeResponse($contents);

        if (is_array($response)) {
            $this->getResponse()->addList($response);
        }


        return $response;
    }


    /**
     * @return string
     */
    public function getFullURL() {
        $url = '';

        $url .= ($this->getSchema())?$this->getSchema():'http';
        $url .= '://';

        if ($this->getUser()) {
            $url .= $this->getUser();
            if ($this->getPassword()) {
                $url .= ':'.$this->getPassword();
            }
            $url .= '@';
        }

        if ($this->getHostname()) {
            $url .= $this->getHostname();
        } else {
            $url .= '127.0.0.1';
        }

        if ($this->getPort()) {
            $url .= ':'.$this->getPort();
        }

        $url .= $this->getPath();

        if ($this->getQuery()) {
            $url .= '?'.$this->getQuery();
        }

        if ($this->getFragment()) {
            $url .= '#'.$this->getFragment();
        }

        return $url;

    }


    protected function decodeResponse($text) {


        $json = json_decode($text, true);

        if (is_array($json)) {
            $this->getResponse()->addList($json);
            return $json;
        }


        // test XML
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($text);

        if ($xml !== false) {
            $this->getResponse()->addList((array) $xml);
            return (array) $xml;
        }

        // test text multiline
        $lines = explode("\n", $text);
        if (is_array($lines)) {
            $this->getResponse()->addList($lines);
            return $lines;
        }

        // otherwise: single line
        $this->getResponse()->add(0,$text);
        return [$text];

    }


}