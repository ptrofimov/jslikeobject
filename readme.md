## fn - dynamic objects a-la Javascript in PHP

Previous version is here https://github.com/ptrofimov/jslikeobject/tree/1.0

So, well... **fn** is a magic function that transforms PHP anonymous function
into function-constructor a-la Javascript. Like in JS, this function is an object
and it could instantiate new objects on the own base.

```php
$constructor = fn(function () {        // function-constructor
    $this->property = 1;               // add property
    $this->getProperty = function () { // add method
        return $this->property;
    };
});

$instance = $constructor();            // create new instance

echo $instance->getProperty();         // result: 1
```
