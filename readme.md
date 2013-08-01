# JsLike\Object - dynamic objects a-la Javascript in PHP

Since PHP5.4 release many people tried to implement dynamic PHP objects
with the same functionality as in Javascript. Just for fun.

But many of them faced the problem of unability to use $this pointer in functions.
PHP forces to use $this pointer only in methods of class.

I'd like to show you the solution of this problem with Closure::bindTo method.
And for another thing I implemented several ways of inheritance.

Please, don't look at this in serious way. It's just for fun.

### 1. Create new object with properties and methods (access via $this)

```php
$o = new Object([
    'number' => 1,
    'getNumber' => function () {
        return $this->number;
    },
]);

echo $o->getNumber(); // 1
```

### 2. Add method to object dynamically:

```php
$o->setNumber = function ($value) {
    $this->number = $value;
};

$o->setNumber(2);

echo $o->getNumber(); // 2
```

### 3. Inherit dynamic object from another one:

```php
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
```

### 4. Create usual class for dynamic object:

```php
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
```

### 5. Inherit usual class from dynamic object class:

```php
class SuperNumber extends Number
{
    public function getNumber()
    {
        return parent::getNumber();
    }
}

$superNumber = new SuperNumber(5);

echo $superNumber->getNumber(); // 5
```

### 6. Inherit dynamic object from usual class:

```php
$o = new Object(
    new SuperNumber(6),
    [
        'getNumber' => function () {
            return $this->parent()->getNumber();
        },
    ]
);

echo $o->getNumber(); // 6
```

### 7. Create JS-like constructor-function that could produce new objects:

```php
$constructor = fn(function () {
    $this->property = 7;
});

$object = $constructor(); // new instance

echo $constructor()->property; // 7
```
