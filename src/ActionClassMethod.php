<?php

namespace eduluz1976\action;


class ActionClassMethod extends Action
{

    protected $className;
    protected $methodName;

    /**
     * @param $uri
     * @return bool
     */
    public static function checkURI($uri) {
        if ((strpos($uri, '::')!==false) && (substr($uri,-2) == '()')) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $uri
     * @param array $request
     * @param array $props
     * @return ActionClassMethod
     */
    public static function build($uri, $request=[], $props=[]) {
        $obj = new ActionClassMethod($uri, $request, $props);
        return $obj;
    }
    
    
}