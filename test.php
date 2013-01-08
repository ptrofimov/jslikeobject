<?php
require_once(__DIR__.'/src/JsLike/Object.php');




///////////////////////////// DYNAMIC OBJECT


$o = new Object([
    'property' => 1,
    'getProperty' => function () {
        return $this->property;
    },
]);

$o->setProperty = function ($value) {
    $this->property = $value;
};

$n = new Object($o);
$n->getProperty = function () {
    return $this->parent()->property * 9;
};

var_dump($o->getProperty());
var_dump($n->getProperty());

class MyClass
{
    use ObjectTrait;

    public function __construct()
    {
        $this->object = [
            'getString' => function () {
                return $this->string;
            },
        ];
    }
}

$mc = new MyClass();
$mc->getString = function () {
    return 'string';
};
var_dump($mc->getString());

class Ordinary
{
    public function getNumber()
    {
        return 5;
    }
}

$c = new Object('Ordinary');
$c->getNumber = function () {
    return $this->parent()->getNumber() * 2;
};

var_dump($c->getNumber());



