<?php

namespace eduluz1976\action;

use eduluz1976\action\exception\FunctionNotFoundException;

class ActionRegularFunction extends Action
{
    protected $functionName;

    /**
     * @return mixed
     */
    public function getFunctionName()
    {
        return $this->functionName;
    }

    /**
     * @param mixed $functionName
     * @return $this
     */
    public function setFunctionName($functionName)
    {
        $this->functionName = $functionName;
        return $this;
    }

    /**
     * ActionRegularFunction constructor.
     * @param string $functionName
     * @param array $request
     */
    public function __construct($functionName, $request = [])
    {
        $this->setFunctionName($functionName);
        if (!empty($request)) {
            $this->getRequest()->addList($request);
        }
    }

    /**
     * @param $uri
     * @return bool
     */
    public static function checkURI($uri)
    {
        if (substr($uri, -2) == '()') {
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
    public static function build($uri, $request = [], $props = [])
    {
        $functionName = trim(substr(trim($uri), 0, -2));
        $obj = new ActionRegularFunction($functionName, $request, $props);
        return $obj;
    }

    /**
     * @param array $additionalRequestAttributes
     * @return mixed
     */
    public function exec(array $additionalRequestAttributes = [])
    {
        parent::exec($additionalRequestAttributes);

        if (!function_exists($this->getFunctionName())) {
            throw new FunctionNotFoundException("Function '" . $this->getFunctionName() . "' not found");
        }

        $return = call_user_func_array($this->getFunctionName(), $this->getRequest()->getList());
        $this->getResponse()->add(0, $return);
        return $return;
    }
}
