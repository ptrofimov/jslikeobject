<?php

/** @return \JsLike\Object */
function fn($arg)
{
    return new \JsLike\Object(is_callable($arg) ? ['constructor' => $arg] : (array) $arg);
}
