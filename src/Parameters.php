<?php

namespace eduluz1976\action;

class Parameters
{
    protected $attributes = [];

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function add($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @param $name
     * @param null|mixed $defaultValue
     * @return mixed|null
     */
    public function get($name, $defaultValue = null)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return $defaultValue;
    }

    /**
     * @param array $list
     * @return $this
     */
    public function addList(array $list)
    {
        $this->attributes = array_replace($this->attributes, $list);
        return $this;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->attributes;
    }

    /**
     * @param $name
     * @return bool
     */
    public function del($name)
    {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return (true === isset($this->attributes[$name]));
    }
}
