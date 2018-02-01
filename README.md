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

(new Assert($value))->eq($value2, $message = null, $fieldName = null);
(new Assert($value))->same($value2, $message = null, $fieldName = null);
(new Assert($value))->notEq($value2, $message = null, $fieldName = null);
(new Assert($value))->notSame($value2, $message = null, $fieldName = null);
(new Assert($value))->integer($message = null, $fieldName = null);
(new Assert($value))->float($message = null, $fieldName = null);
(new Assert($value))->digit($message = null, $fieldName = null);
(new Assert($value))->date($message=null, $fieldName=null);
(new Assert($value))->integerish($message = null, $fieldName = null);
(new Assert($value))->boolean($message = null, $fieldName = null);
(new Assert($value))->scalar($message = null, $fieldName = null);
(new Assert($value))->notEmpty($message = null, $fieldName = null);
(new Assert($value))->noContent($message = null, $fieldName = null);
(new Assert($value))->notNull($message = null, $fieldName = null);
(new Assert($value))->string($message = null, $fieldName = null);
(new Assert($value))->regex($pattern, $message = null, $fieldName = null);
(new Assert($value))->length($length, $message = null, $fieldName = null, $encoding = 'utf8');
(new Assert($value))->minLength($minLength, $message = null, $fieldName = null, $encoding = 'utf8');
(new Assert($value))->maxLength($maxLength, $message = null, $fieldName = null, $encoding = 'utf8');
(new Assert($value))->betweenLength($minLength, $maxLength, $message = null, $fieldName = null, $encoding = 'utf8');
(new Assert($value))->startsWith($needle, $message = null, $fieldName = null, $encoding = 'utf8');
(new Assert($value))->endsWith($needle, $message = null, $fieldName = null, $encoding = 'utf8');
(new Assert($value))->contains($needle, $message = null, $fieldName = null, $encoding = 'utf8');
(new Assert($value))->choice(array $choices, $message = null, $fieldName = null);
(new Assert($value))->inArray(array $choices, $message = null, $fieldName = null);
(new Assert($value))->numeric($message = null, $fieldName = null);
(new Assert($value))->isArray($message = null, $fieldName = null);
(new Assert($value))->isTraversable($message = null, $fieldName = null);
(new Assert($value))->isArrayAccessible($message = null, $fieldName = null);
(new Assert($value))->keyExists($key, $message = null, $fieldName = null);
(new Assert($value))->keysExist($keys, $message = null, $fieldName = null);
(new Assert($value))->propertyExists($key, $message = null, $fieldName = null);
(new Assert($value))->propertiesExist(array $keys, $message = null, $fieldName = null);
(new Assert($value))->utf8($message = null, $fieldName = null);
(new Assert($value))->keyIsset($key, $message = null, $fieldName = null);
(new Assert($value))->notEmptyKey($key, $message = null, $fieldName = null);
(new Assert($value))->notBlank($message = null, $fieldName = null);
(new Assert($value))->isInstanceOf($className, $message = null, $fieldName = null);
(new Assert($value))->notIsInstanceOf($className, $message = null, $fieldName = null);
(new Assert($value))->subclassOf($className, $message = null, $fieldName = null);
(new Assert($value))->range($minValue, $maxValue, $message = null, $fieldName = null);
(new Assert($value))->min($minValue, $message = null, $fieldName = null);
(new Assert($value))->max($maxValue, $message = null, $fieldName = null);
(new Assert($value))->file($message = null, $fieldName = null);
(new Assert($value))->directory($message = null, $fieldName = null);
(new Assert($value))->readable($message = null, $fieldName = null);
(new Assert($value))->writeable($message = null, $fieldName = null);
(new Assert($value))->email($message = null, $fieldName = null);
(new Assert($value))->url($message = null, $fieldName = null);
(new Assert($value))->alnum($message = null, $fieldName = null);
(new Assert($value))->true($message = null, $fieldName = null);
(new Assert($value))->false($message = null, $fieldName = null);
(new Assert($value))->classExists($message = null, $fieldName = null);
(new Assert($value))->implementsInterface($interfaceName, $message = null, $fieldName = null);
(new Assert($value))->isJsonString($message = null, $fieldName = null);
(new Assert($value))->uuid($message = null, $fieldName = null);
(new Assert($value))->samAccountName($message = null, $fieldName = null);
(new Assert($value))->userPrincipalName($message = null, $fieldName = null);
(new Assert($value))->count($count, $message = null, $fieldName = null);
(new Assert($value))->choicesNotEmpty(array $choices, $message = null, $fieldName = null);
(new Assert($value))->methodExists($object, $message = null, $fieldName = null);
(new Assert($value))->isObject($message = null, $fieldName = null);

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
