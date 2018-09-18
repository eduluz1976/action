<?php

namespace eduluz1976\action;


class ActionRegularFunction extends Action
{

    protected $functionName;

    /**
     * @param $uri
     * @return bool
     */
    public static function checkURI($uri) {
        if (substr($uri,-2) == '()') {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $uri
     * @param array $request
     * @param array $props
     * @return ActionRegularFunction
     */
    public static function build($uri, $request=[], $props=[]) {
        $obj = new ActionRegularFunction($uri, $request, $props);
        return $obj;
    }

    
}