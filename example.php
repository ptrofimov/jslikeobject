<?php
require_once(__DIR__ . '/vendor/autoload.php');

/**
 * Usage example for JsLike\Object
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov/jslikeobject
 */

/**
 * 1. Function-constructor
 */

$constructor = fn(function () {
    $this->property = 1;
    $this->getProperty = function () {
        return $this->property;
    };
});

$instance = $constructor();

echo $instance->getProperty(); // 1

/**
 * 2. Different objects
 */

$instance2 = $constructor();

assert($instance !== $instance2);

$instance2->property = 2;
echo $instance->getProperty(); // 1
echo $instance2->getProperty(); // 2

/**
 * 3. Prototype
 */

$constructor->prototype = fn([
    'getDouble' => function () {
        return $this->getProperty() * 2;
    },
]);

$doubleInstance = $constructor();

echo $doubleInstance->getDouble();// 2
