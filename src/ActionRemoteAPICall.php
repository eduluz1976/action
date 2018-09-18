<?php

namespace eduluz1976\action;


class ActionRemoteAPICall extends Action
{

    protected $method;
    protected $schema;
    protected $url;
    protected $port;
    protected $path;
    protected $urlParams; // after '?' on URL
    protected $urlTarget; // after '#' on URL


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
     * @param $uri
     * @param array $request
     * @param array $props
     * @return ActionRemoteAPICall
     */
    public static function build($uri, $request=[], $props=[]) {
        $obj = new ActionRemoteAPICall($uri, $request, $props);
        return $obj;
    }

    
}