<?php
require_once(__DIR__ . '/vendor/autoload.php');

/**
 * Usage example for JsLike\Object
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov/jslikeobject
 */

use JsLike\Object;
use JsLike\ObjectTrait;

/**
 * 1. Create new object with properties and methods (access via $this)
 */

$o = new Object([
    'number' => 1,
    'getNumber' => function () {
        return $this->number;
    },
]);

echo $o->getNumber(); // 1

/**
 * 2. Add method to object dynamically:
 */

$o->setNumber = function ($value) {
    $this->number = $value;
};

$o->setNumber(2);

echo $o->getNumber(); // 2

/**
 * 3. Inherit dynamic object from another one:
 */

$n = new Object(
    $o,
    [
        'getNumber' => function () {
            return $this->number;
        },
        'getNumberViaParent' => function () {
            return $this->parent()->getNumber();
        },
    ]
);

$o->setNumber(3);

echo $o->getNumber(); // 3
echo $n->getNumber(); // 3
echo $n->getNumberViaParent(); // 3

/**
 * 4. Create usual class for dynamic object:
 */

class Number
{
    use ObjectTrait;

    public function __construct($number)
    {
        $this->object = [
            'number' => $number,
            'getNumber' => function () {
                return $this->number;
            },
        ];
    }
}

$number = new Number(1);
$number->setNumber = function ($value) {
    $this->number = $value;
};

$number->setNumber(4);

echo $number->getNumber(); // 4

/**
 * 5. Inherit usual class from dynamic object class:
 */

class SuperNumber extends Number
{
    public function getNumber()
    {
        return parent::getNumber();
    }
}

$superNumber = new SuperNumber(5);

echo $superNumber->getNumber(); // 5

/**
 * 6. Inherit dynamic object from usual class:
 */

$o = new Object(
    new SuperNumber(6),
    [
        'getNumber' => function () {
            return $this->parent()->getNumber();
        },
    ]
);

echo $o->getNumber(); // 6

