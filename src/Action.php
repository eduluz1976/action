<?php

namespace eduluz1976\action;

use eduluz1976\action\exception\InvalidURIException;

abstract class Action
{
    /**
     * @var Parameters
     */
    protected $request;

    /**
     * @var Parameters
     */
    protected $response;

    /**
     *
     *
     * - POST;http://mydomain.com:8080/api/v1/my_service
     * - MyClass::myMethod()
     * - globalFunction()
     *
     * @var string
     */
    protected $uri;

    /**
     * @param string $uri
     * @param array $request
     * @param array $props
     * @throws InvalidURIException
     */
    public static function factory($uri, $request = [], $props = [])
    {
        if (ActionURLCall::checkURI($uri)) {
            return ActionURLCall::build($uri, $request, $props);
        } elseif (ActionRemoteAPICall::checkURI($uri)) {
            return ActionRemoteAPICall::build($uri, $request, $props);
        } elseif (ActionClassMethod::checkURI($uri)) {
            return ActionClassMethod::build($uri, $request, $props);
        } elseif (ActionRegularFunction::checkURI($uri)) {
            return ActionRegularFunction::build($uri, $request, $props);
        } else {
            throw new InvalidURIException("Invalid uri: $uri", 400);
        }
    }

    abstract public static function checkURI($uri);

    abstract public static function build($uri);

    /**
     * @param array $additionalRequestAttributes
     */
    public function exec(array $additionalRequestAttributes = [])
    {
        $this->getRequest()->addList($additionalRequestAttributes);
    }

    /**
     * @return Parameters
     */
    public function getRequest(): Parameters
    {
        if (!$this->request) {
            $this->request = new Parameters();
        }
        return $this->request;
    }

    /**
     * @param Parameters $request
     * @return Action
     */
    public function setRequest(Parameters $request): Action
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Parameters
     */
    public function getResponse(): Parameters
    {
        if (!$this->response) {
            $this->response = new Parameters();
        }

        return $this->response;
    }

    /**
     * @param Parameters $response
     * @return Action
     */
    public function setResponse(Parameters $response): Action
    {
        $this->response = $response;
        return $this;
    }
}
