<?php

namespace eduluz1976\action;

class ActionClassMethod extends Action
{
    use DBAccessible;

    protected $className;
    protected $methodName;
    protected $constructorParameters = [];

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     * @return ActionClassMethod
     */
    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param mixed $methodName
     * @return ActionClassMethod
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
        return $this;
    }

    /**
     * @return array
     */
    public function getConstructorParameters(): array
    {
        return $this->constructorParameters;
    }

    /**
     * @param array $constructorParameters
     * @return ActionClassMethod
     */
    public function setConstructorParameters(array $constructorParameters): ActionClassMethod
    {
        $this->constructorParameters = $constructorParameters;
        return $this;
    }

    /**
     * ActionRegularFunction constructor.
     * @param string $functionName
     * @param array $request
     */
    public function __construct($className, $methodName, $request = [])
    {
        $this->setClassName($className);
        $this->setMethodName($methodName);

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
        if ((strpos($uri, '::') !== false) && (substr($uri, -2) == '()')) {
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
    public static function build($uri, $request = [], $props = [])
    {
        $className = substr($uri, 0, strpos($uri, '::'));
        $methodName = substr($uri, strpos($uri, '::') + 2, -2);

        $obj = new ActionClassMethod($className, $methodName, $request);

        if (isset($props['constructor'])) {
            $obj->setConstructorParameters($props['constructor']);
        }

        return $obj;
    }

    /**
     * @param array $additionalRequestAttributes
     * @return mixed|void
     */
    public function exec(array $additionalRequestAttributes = [])
    {
        parent::exec($additionalRequestAttributes);

        $className = $this->getClassName();
        $parms = $this->getConstructorParameters();

        $obj = new $className(...$parms);

        $this->preparePlugins($obj);

        $runner = [$obj, $this->getMethodName()];
        $return = call_user_func_array($runner, $this->getRequest()->getList());
        $this->getResponse()->add(0, $return);
        return $return;
    }

    protected function preparePlugins(&$obj)
    {
        $traits = class_uses($obj);

        if (in_array('eduluz1976\action\DBAccessible', $traits) && $this->getConn()) {
            $obj->setConn($this->getConn());
        }
    }
}
