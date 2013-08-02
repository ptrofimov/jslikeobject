<?php
require_once(__DIR__ . '/vendor/autoload.php');

/**
 * Usage example for JsLike\Object
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov/jslikeobject
 */

$constructor = fn(function () { // function-constructor
    $this->property = 1;
    $this->getProperty = function () {
        return $this->property;
    };
});

$instance = $constructor();

echo $instance->getProperty(); // 1
