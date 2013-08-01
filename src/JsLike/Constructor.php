<?php
namespace JsLike;

class Constructor
{
    private $constructor;

    public function __construct($constructor)
    {
        $this->constructor = $constructor;
    }

    public function __invoke()
    {
        $object = new Object([
            'constructor' => $this->constructor,
        ]);

        $object->constructor();

        return $object;
    }
}

function fn($constructor)
{
    return new Constructor($constructor);
}
