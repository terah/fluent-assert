# fluent-assert

[![Latest Version](https://img.shields.io/github/release/terah/fluent-assert.svg?style=flat-square)](https://git.terah.com.au/terah/fluent-assert/releases)
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

(new Assert($value))->eq($value2, string $message='', string $fieldName='');
(new Assert($value))->same($value2, string $message='', string $fieldName='');
(new Assert($value))->notEq($value2, string $message='', string $fieldName='');
(new Assert($value))->notSame($value2, string $message='', string $fieldName='');
(new Assert($value))->integer(string $message='', string $fieldName='');
(new Assert($value))->float(string $message='', string $fieldName='');
(new Assert($value))->digit(string $message='', string $fieldName='');
(new Assert($value))->date($message=null, $fieldName=null);
(new Assert($value))->integerish(string $message='', string $fieldName='');
(new Assert($value))->boolean(string $message='', string $fieldName='');
(new Assert($value))->scalar(string $message='', string $fieldName='');
(new Assert($value))->notEmpty(string $message='', string $fieldName='');
(new Assert($value))->noContent(string $message='', string $fieldName='');
(new Assert($value))->notNull(string $message='', string $fieldName='');
(new Assert($value))->string(string $message='', string $fieldName='');
(new Assert($value))->regex($pattern, string $message='', string $fieldName='');
(new Assert($value))->length($length, string $message='', string $fieldName='', $encoding = 'utf8');
(new Assert($value))->minLength($minLength, string $message='', string $fieldName='', $encoding = 'utf8');
(new Assert($value))->maxLength($maxLength, string $message='', string $fieldName='', $encoding = 'utf8');
(new Assert($value))->betweenLength($minLength, $maxLength, string $message='', string $fieldName='', $encoding = 'utf8');
(new Assert($value))->startsWith($needle, string $message='', string $fieldName='', $encoding = 'utf8');
(new Assert($value))->endsWith($needle, string $message='', string $fieldName='', $encoding = 'utf8');
(new Assert($value))->contains($needle, string $message='', string $fieldName='', $encoding = 'utf8');
(new Assert($value))->choice(array $choices, string $message='', string $fieldName='');
(new Assert($value))->inArray(array $choices, string $message='', string $fieldName='');
(new Assert($value))->numeric(string $message='', string $fieldName='');
(new Assert($value))->isArray(string $message='', string $fieldName='');
(new Assert($value))->isTraversable(string $message='', string $fieldName='');
(new Assert($value))->isArrayAccessible(string $message='', string $fieldName='');
(new Assert($value))->keyExists($key, string $message='', string $fieldName='');
(new Assert($value))->keysExist($keys, string $message='', string $fieldName='');
(new Assert($value))->propertyExists($key, string $message='', string $fieldName='');
(new Assert($value))->propertiesExist(array $keys, string $message='', string $fieldName='');
(new Assert($value))->utf8(string $message='', string $fieldName='');
(new Assert($value))->keyIsset($key, string $message='', string $fieldName='');
(new Assert($value))->notEmptyKey($key, string $message='', string $fieldName='');
(new Assert($value))->notBlank(string $message='', string $fieldName='');
(new Assert($value))->isInstanceOf($className, string $message='', string $fieldName='');
(new Assert($value))->notIsInstanceOf($className, string $message='', string $fieldName='');
(new Assert($value))->subclassOf($className, string $message='', string $fieldName='');
(new Assert($value))->range($minValue, $maxValue, string $message='', string $fieldName='');
(new Assert($value))->min($minValue, string $message='', string $fieldName='');
(new Assert($value))->max($maxValue, string $message='', string $fieldName='');
(new Assert($value))->file(string $message='', string $fieldName='');
(new Assert($value))->directory(string $message='', string $fieldName='');
(new Assert($value))->readable(string $message='', string $fieldName='');
(new Assert($value))->writeable(string $message='', string $fieldName='');
(new Assert($value))->email(string $message='', string $fieldName='');
(new Assert($value))->url(string $message='', string $fieldName='');
(new Assert($value))->alnum(string $message='', string $fieldName='');
(new Assert($value))->true(string $message='', string $fieldName='');
(new Assert($value))->false(string $message='', string $fieldName='');
(new Assert($value))->classExists(string $message='', string $fieldName='');
(new Assert($value))->implementsInterface($interfaceName, string $message='', string $fieldName='');
(new Assert($value))->isJsonString(string $message='', string $fieldName='');
(new Assert($value))->uuid(string $message='', string $fieldName='');
(new Assert($value))->samAccountName(string $message='', string $fieldName='');
(new Assert($value))->userPrincipalName(string $message='', string $fieldName='');
(new Assert($value))->count($count, string $message='', string $fieldName='');
(new Assert($value))->choicesNotEmpty(array $choices, string $message='', string $fieldName='');
(new Assert($value))->methodExists($object, string $message='', string $fieldName='');
(new Assert($value))->isObject(string $message='', string $fieldName='');

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
$ bin/tester tests/

```

Please see tests/AssertSuite.php for example of writing tests

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email terry@terah.com.au instead of using the issue tracker.

## Credits

- [Terry Cullen](https://git.terah.com.au/terah)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
