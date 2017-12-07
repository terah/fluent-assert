# fluent-assert

[![Latest Version](https://img.shields.io/github/release/terah/fluent-assert.svg?style=flat-square)](https://github.com/terah/fluent-assert/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/terah/fluent-assert/master.svg?style=flat-square)](https://travis-ci.org/terah/fluent-assert)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/terah/fluent-assert.svg?style=flat-square)](https://scrutinizer-ci.com/g/terah/fluent-assert/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/terah/fluent-assert.svg?style=flat-square)](https://scrutinizer-ci.com/g/terah/fluent-assert)
[![Total Downloads](https://img.shields.io/packagist/dt/terah/fluent-assert.svg?style=flat-square)](https://packagist.org/packages/terah/fluent-assert)

This is a fork/subset of the awesome package Assert (https://github.com/beberlei/assert).  I only use the fluent (chained) interface and the assert library is very heavily used chunk of code.  By breaking it into it's own library the library is about 3 times faster (using my very unscienctific benchark).

## Install

Via Composer

``` bash
$ composer require terah/fluent-assert
```

## Usage

``` php

use Terah\Assert\Assert;

(new Assert($value))->eq($value2, $message = null, $propertyPath = null);
(new Assert($value))->same($value2, $message = null, $propertyPath = null);
(new Assert($value))->notEq($value2, $message = null, $propertyPath = null);
(new Assert($value))->notSame($value2, $message = null, $propertyPath = null);
(new Assert($value))->integer($message = null, $propertyPath = null);
(new Assert($value))->float($message = null, $propertyPath = null);
(new Assert($value))->digit($message = null, $propertyPath = null);
(new Assert($value))->date($message=null, $propertyPath=null);
(new Assert($value))->integerish($message = null, $propertyPath = null);
(new Assert($value))->boolean($message = null, $propertyPath = null);
(new Assert($value))->scalar($message = null, $propertyPath = null);
(new Assert($value))->notEmpty($message = null, $propertyPath = null);
(new Assert($value))->noContent($message = null, $propertyPath = null);
(new Assert($value))->notNull($message = null, $propertyPath = null);
(new Assert($value))->string($message = null, $propertyPath = null);
(new Assert($value))->regex($pattern, $message = null, $propertyPath = null);
(new Assert($value))->length($length, $message = null, $propertyPath = null, $encoding = 'utf8');
(new Assert($value))->minLength($minLength, $message = null, $propertyPath = null, $encoding = 'utf8');
(new Assert($value))->maxLength($maxLength, $message = null, $propertyPath = null, $encoding = 'utf8');
(new Assert($value))->betweenLength($minLength, $maxLength, $message = null, $propertyPath = null, $encoding = 'utf8');
(new Assert($value))->startsWith($needle, $message = null, $propertyPath = null, $encoding = 'utf8');
(new Assert($value))->endsWith($needle, $message = null, $propertyPath = null, $encoding = 'utf8');
(new Assert($value))->contains($needle, $message = null, $propertyPath = null, $encoding = 'utf8');
(new Assert($value))->choice(array $choices, $message = null, $propertyPath = null);
(new Assert($value))->inArray(array $choices, $message = null, $propertyPath = null);
(new Assert($value))->numeric($message = null, $propertyPath = null);
(new Assert($value))->isArray($message = null, $propertyPath = null);
(new Assert($value))->isTraversable($message = null, $propertyPath = null);
(new Assert($value))->isArrayAccessible($message = null, $propertyPath = null);
(new Assert($value))->keyExists($key, $message = null, $propertyPath = null);
(new Assert($value))->keysExist($keys, $message = null, $propertyPath = null);
(new Assert($value))->propertyExists($key, $message = null, $propertyPath = null);
(new Assert($value))->propertiesExist(array $keys, $message = null, $propertyPath = null);
(new Assert($value))->utf8($message = null, $propertyPath = null);
(new Assert($value))->keyIsset($key, $message = null, $propertyPath = null);
(new Assert($value))->notEmptyKey($key, $message = null, $propertyPath = null);
(new Assert($value))->notBlank($message = null, $propertyPath = null);
(new Assert($value))->isInstanceOf($className, $message = null, $propertyPath = null);
(new Assert($value))->notIsInstanceOf($className, $message = null, $propertyPath = null);
(new Assert($value))->subclassOf($className, $message = null, $propertyPath = null);
(new Assert($value))->range($minValue, $maxValue, $message = null, $propertyPath = null);
(new Assert($value))->min($minValue, $message = null, $propertyPath = null);
(new Assert($value))->max($maxValue, $message = null, $propertyPath = null);
(new Assert($value))->file($message = null, $propertyPath = null);
(new Assert($value))->directory($message = null, $propertyPath = null);
(new Assert($value))->readable($message = null, $propertyPath = null);
(new Assert($value))->writeable($message = null, $propertyPath = null);
(new Assert($value))->email($message = null, $propertyPath = null);
(new Assert($value))->url($message = null, $propertyPath = null);
(new Assert($value))->alnum($message = null, $propertyPath = null);
(new Assert($value))->true($message = null, $propertyPath = null);
(new Assert($value))->false($message = null, $propertyPath = null);
(new Assert($value))->classExists($message = null, $propertyPath = null);
(new Assert($value))->implementsInterface($interfaceName, $message = null, $propertyPath = null);
(new Assert($value))->isJsonString($message = null, $propertyPath = null);
(new Assert($value))->uuid($message = null, $propertyPath = null);
(new Assert($value))->samAccountName($message = null, $propertyPath = null);
(new Assert($value))->count($count, $message = null, $propertyPath = null);
(new Assert($value))->choicesNotEmpty(array $choices, $message = null, $propertyPath = null);
(new Assert($value))->methodExists($object, $message = null, $propertyPath = null);
(new Assert($value))->isObject($message = null, $propertyPath = null);

// Chaining
(new Assert($myValue))->integer()->notEmpty()->eq(1);

// Checking members of arrays and objects)
(new Assert($myArray))->all()->integer()->notEmpty()->eq(1);

// Null or valid
(new Assert($myNullValue)->nullOr()->integer()->notEmpty()->eq(1);

// Reset the all and nullOr flags and set value
(new Assert($value))->reset($value)
// Set a new value
(new Assert($value))->value($value)
// Set the null or flag
(new Assert($value))->nullOr($nullOr=true)
// Set the all flag
(new Assert($value))->all($all=true)
// Set the exception class
(new Assert($value))->setExceptionClass('\\My\\Exception\\Class');

```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email terry@terah.com.au instead of using the issue tracker.

## Credits

- [Terry Cullen](https://github.com/terah)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
