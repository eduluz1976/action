<?php

namespace eduluz1976\action;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ActionRemoteAPICall
 * @package eduluz1976\action
 */
class ActionRemoteAPICall extends ActionClassMethod
{

    /**
     * @param $uri
     * @return bool
     */
    public static function checkURI($uri)
    {
        if (strpos($uri, 'rpc://') !== false) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $uri
     * @param array $request
     * @param array $props
     * @return ActionRemoteAPICall
     */
    public static function build($uri, $request = [], $props = [])
    {
        $className = substr($uri, 6, strpos($uri, '::')-6);
        $methodName = substr($uri, strpos($uri, '::') + 2, -2);


        $obj = new ActionRemoteAPICall($className, $methodName, $request);
       return $obj;

    }

    /**
     * @param array $additionalRequestAttributes
     * @return array|mixed|void
     */
    public function exec(array $additionalRequestAttributes = [])
    {
        $response = [];
        // TODO Implement service discovery, remote call and protocol among client-server

        return $response;
    }

}
