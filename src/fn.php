<?php

/** @return \JsLike\Object */
function fn($arg)
{
    return new Object(is_callable($arg) ? ['constructor' => $arg] : (array) $arg);
}
