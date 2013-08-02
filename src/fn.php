<?php
/**
 * Base class for creating dynamic objects
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov/jslikeobject
 */

/** @return fn */
function fn($arg)
{
    return new fn(is_callable($arg) ? ['constructor' => $arg] : (array) $arg);
}

class fn
{
    /** @var array */
    private $properties = [];

    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    public function __get($key)
    {
        $value = null;
        if (array_key_exists($key, $this->properties)) {
            $value = $this->properties[$key];
        } elseif (isset($this->properties['prototype'])) {
            $value = $this->properties['prototype']->{$key};
        }

        return $value;
    }

    public function __set($key, $value)
    {
        $this->properties[$key] = $value;
    }

    public function __call($method, array $args)
    {
        return is_callable($this->{$method})
            ? call_user_func_array(
                $this->{$method}->bindTo($this),
                $args
            ) : null;
    }

    public function __invoke()
    {
        $instance = new static($this->properties);
        if ($this->constructor) {
            $instance->constructor();
        }

        return $instance;
    }
}
