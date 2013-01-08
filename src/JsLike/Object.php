<?php
namespace JsLike;

trait ObjectTrait
{
    private $object, $parent;

    public function __construct()
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                $this->object = $arg;
            } elseif (is_object($arg)) {
                $this->parent = $arg;
            } elseif (is_string($arg)) {
                $reflectionClass = new ReflectionClass($arg);
                $instance = $reflectionClass->newInstanceWithoutConstructor();
                $object = [];
                foreach ($reflectionClass->getMethods() as $method) {
                    $object[$method->getName()] = $method->getClosure($instance);
                }
                $this->parent = new Object($object);
            }
        }
    }

    public function parent()
    {
        return $this->parent;
    }

    public function __get($key)
    {
        if (isset($this->object[$key])) {
            return $this->object[$key];
        } elseif (is_object($this->parent)) {
            return $this->parent->{$key};
        }

        return null;
    }

    public function __set($key, $value)
    {
        $this->object[$key] = $value;
    }

    public function __call($method, array $args)
    {
        return isset($this->object[$method])
            && is_callable($this->object[$method]) ? call_user_func_array(
            $this->object[$method]->bindTo($this),
            $args
        ) : null;
    }
}

class Object
{
    use ObjectTrait;
}