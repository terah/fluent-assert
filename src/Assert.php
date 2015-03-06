<?php

namespace Terah\Assert;

/**
 * Assert
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to terry@terah.com.au so I can send you a copy immediately.
 */

/**
 * Assert library
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 *
 * METHODSTART
 * @method Assert nullOrEq($value, $value2, $message = null, $propertyPath = null)
 * @method Assert nullOrSame($value, $value2, $message = null, $propertyPath = null)
 * @method Assert nullOrNotEq($value1, $value2, $message = null, $propertyPath = null)
 * @method Assert nullOrNotSame($value1, $value2, $message = null, $propertyPath = null)
 * @method Assert nullOrInteger($value, $message = null, $propertyPath = null)
 * @method Assert nullOrFloat($value, $message = null, $propertyPath = null)
 * @method Assert nullOrDigit($value, $message = null, $propertyPath = null)
 * @method Assert nullOrDate($value, $message = null, $propertyPath = null)
 * @method Assert nullOrIntegerish($value, $message = null, $propertyPath = null)
 * @method Assert nullOrBoolean($value, $message = null, $propertyPath = null)
 * @method Assert nullOrScalar($value, $message = null, $propertyPath = null)
 * @method Assert nullOrNotEmpty($value, $message = null, $propertyPath = null)
 * @method Assert nullOrNoContent($value, $message = null, $propertyPath = null)
 * @method Assert nullOrNotNull($value, $message = null, $propertyPath = null)
 * @method Assert nullOrString($value, $message = null, $propertyPath = null)
 * @method Assert nullOrRegex($value, $pattern, $message = null, $propertyPath = null)
 * @method Assert nullOrLength($value, $length, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert nullOrMinLength($value, $minLength, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert nullOrMaxLength($value, $maxLength, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert nullOrBetweenLength($value, $minLength, $maxLength, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert nullOrStartsWith($string, $needle, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert nullOrEndsWith($string, $needle, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert nullOrContains($string, $needle, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert nullOrChoice($value, $choices, $message = null, $propertyPath = null)
 * @method Assert nullOrInArray($value, $choices, $message = null, $propertyPath = null)
 * @method Assert nullOrNumeric($value, $message = null, $propertyPath = null)
 * @method Assert nullOrIsArray($value, $message = null, $propertyPath = null)
 * @method Assert nullOrIsTraversable($value, $message = null, $propertyPath = null)
 * @method Assert nullOrIsArrayAccessible($value, $message = null, $propertyPath = null)
 * @method Assert nullOrKeyExists($value, $key, $message = null, $propertyPath = null)
 * @method Assert nullOrKeysExist($value, $keys, $message = null, $propertyPath = null)
 * @method Assert nullOrKeyIsset($value, $key, $message = null, $propertyPath = null)
 * @method Assert nullOrPropertyExists($value, $key, $message = null, $propertyPath = null)
 * @method Assert nullOrPropertiesExist($value, $keys, $message = null, $propertyPath = null)
 * @method Assert nullOrNotEmptyKey($value, $key, $message = null, $propertyPath = null)
 * @method Assert nullOrNotBlank($value, $message = null, $propertyPath = null)
 * @method Assert nullOrIsCallable($value, $message = null, $propertyPath = null)
 * @method Assert nullOrIsInstanceOf($value, $className, $message = null, $propertyPath = null)
 * @method Assert nullOrNotIsInstanceOf($value, $className, $message = null, $propertyPath = null)
 * @method Assert nullOrSubclassOf($value, $className, $message = null, $propertyPath = null)
 * @method Assert nullOrRange($value, $minValue, $maxValue, $message = null, $propertyPath = null)
 * @method Assert nullOrMin($value, $minValue, $message = null, $propertyPath = null)
 * @method Assert nullOrMax($value, $maxValue, $message = null, $propertyPath = null)
 * @method Assert nullOrFile($value, $message = null, $propertyPath = null)
 * @method Assert nullOrDirectory($value, $message = null, $propertyPath = null)
 * @method Assert nullOrReadable($value, $message = null, $propertyPath = null)
 * @method Assert nullOrWriteable($value, $message = null, $propertyPath = null)
 * @method Assert nullOrEmail($value, $message = null, $propertyPath = null)
 * @method Assert nullOrUrl($value, $message = null, $propertyPath = null)
 * @method Assert nullOrAlnum($value, $message = null, $propertyPath = null)
 * @method Assert nullOrTrue($value, $message = null, $propertyPath = null)
 * @method Assert nullOrFalse($value, $message = null, $propertyPath = null)
 * @method Assert nullOrClassExists($value, $message = null, $propertyPath = null)
 * @method Assert nullOrImplementsInterface($class, $interfaceName, $message = null, $propertyPath = null)
 * @method Assert nullOrIsJsonString($value, $message = null, $propertyPath = null)
 * @method Assert nullOrUuid($value, $message = null, $propertyPath = null)
 * @method Assert nullOrCount($countable, $count, $message = null, $propertyPath = null)
 * @method Assert nullOrChoicesNotEmpty($values, $choices, $message = null, $propertyPath = null)
 * @method Assert nullOrMethodExists($value, $object, $message = null, $propertyPath = null)
 * @method Assert nullOrIsObject($value, $message = null, $propertyPath = null)
 * @method Assert nullOrUtf8($value, $message = null, $propertyPath = null)
 * @method Assert allEq($value, $value2, $message = null, $propertyPath = null)
 * @method Assert allSame($value, $value2, $message = null, $propertyPath = null)
 * @method Assert allNotEq($value1, $value2, $message = null, $propertyPath = null)
 * @method Assert allNotSame($value1, $value2, $message = null, $propertyPath = null)
 * @method Assert allInteger($value, $message = null, $propertyPath = null)
 * @method Assert allFloat($value, $message = null, $propertyPath = null)
 * @method Assert allDigit($value, $message = null, $propertyPath = null)
 * @method Assert allDate($value, $message = null, $propertyPath = null)
 * @method Assert allIntegerish($value, $message = null, $propertyPath = null)
 * @method Assert allBoolean($value, $message = null, $propertyPath = null)
 * @method Assert allScalar($value, $message = null, $propertyPath = null)
 * @method Assert allNotEmpty($value, $message = null, $propertyPath = null)
 * @method Assert allNoContent($value, $message = null, $propertyPath = null)
 * @method Assert allNotNull($value, $message = null, $propertyPath = null)
 * @method Assert allString($value, $message = null, $propertyPath = null)
 * @method Assert allRegex($value, $pattern, $message = null, $propertyPath = null)
 * @method Assert allLength($value, $length, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert allMinLength($value, $minLength, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert allMaxLength($value, $maxLength, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert allBetweenLength($value, $minLength, $maxLength, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert allStartsWith($string, $needle, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert allEndsWith($string, $needle, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert allContains($string, $needle, $message = null, $propertyPath = null, $encoding = "utf8")
 * @method Assert allChoice($value, $choices, $message = null, $propertyPath = null)
 * @method Assert allInArray($value, $choices, $message = null, $propertyPath = null)
 * @method Assert allNumeric($value, $message = null, $propertyPath = null)
 * @method Assert allIsArray($value, $message = null, $propertyPath = null)
 * @method Assert allIsTraversable($value, $message = null, $propertyPath = null)
 * @method Assert allIsArrayAccessible($value, $message = null, $propertyPath = null)
 * @method Assert allKeyExists($value, $key, $message = null, $propertyPath = null)
 * @method Assert allKeysExist($value, $keys, $message = null, $propertyPath = null)
 * @method Assert allKeyIsset($value, $key, $message = null, $propertyPath = null)
 * @method Assert allPropertyExists($value, $key, $message = null, $propertyPath = null)
 * @method Assert allPropertiesExist($value, $keys, $message = null, $propertyPath = null)
 * @method Assert allNotEmptyKey($value, $key, $message = null, $propertyPath = null)
 * @method Assert allNotBlank($value, $message = null, $propertyPath = null)
 * @method Assert allIsCallable($value, $message = null, $propertyPath = null)
 * @method Assert allIsInstanceOf($value, $className, $message = null, $propertyPath = null)
 * @method Assert allNotIsInstanceOf($value, $className, $message = null, $propertyPath = null)
 * @method Assert allSubclassOf($value, $className, $message = null, $propertyPath = null)
 * @method Assert allRange($value, $minValue, $maxValue, $message = null, $propertyPath = null)
 * @method Assert allMin($value, $minValue, $message = null, $propertyPath = null)
 * @method Assert allMax($value, $maxValue, $message = null, $propertyPath = null)
 * @method Assert allFile($value, $message = null, $propertyPath = null)
 * @method Assert allDirectory($value, $message = null, $propertyPath = null)
 * @method Assert allReadable($value, $message = null, $propertyPath = null)
 * @method Assert allWriteable($value, $message = null, $propertyPath = null)
 * @method Assert allEmail($value, $message = null, $propertyPath = null)
 * @method Assert allUrl($value, $message = null, $propertyPath = null)
 * @method Assert allAlnum($value, $message = null, $propertyPath = null)
 * @method Assert allTrue($value, $message = null, $propertyPath = null)
 * @method Assert allFalse($value, $message = null, $propertyPath = null)
 * @method Assert allClassExists($value, $message = null, $propertyPath = null)
 * @method Assert allImplementsInterface($class, $interfaceName, $message = null, $propertyPath = null)
 * @method Assert allIsJsonString($value, $message = null, $propertyPath = null)
 * @method Assert allUuid($value, $message = null, $propertyPath = null)
 * @method Assert allCount($countable, $count, $message = null, $propertyPath = null)
 * @method Assert allChoicesNotEmpty($values, $choices, $message = null, $propertyPath = null)
 * @method Assert allMethodExists($value, $object, $message = null, $propertyPath = null)
 * @method Assert allIsObject($value, $message = null, $propertyPath = null)
 * @method Assert allUtf8($value, $message = null, $propertyPath = null)
 * METHODEND
 */
class Assert
{
    const INVALID_FLOAT             = 9;
    const INVALID_INTEGER           = 10;
    const INVALID_DIGIT             = 11;
    const INVALID_INTEGERISH        = 12;
    const INVALID_BOOLEAN           = 13;
    const VALUE_EMPTY               = 14;
    const VALUE_NULL                = 15;
    const INVALID_STRING            = 16;
    const INVALID_REGEX             = 17;
    const INVALID_MIN_LENGTH        = 18;
    const INVALID_MAX_LENGTH        = 19;
    const INVALID_STRING_START      = 20;
    const INVALID_STRING_CONTAINS   = 21;
    const INVALID_CHOICE            = 22;
    const INVALID_NUMERIC           = 23;
    const INVALID_ARRAY             = 24;
    const INVALID_KEY_EXISTS        = 26;
    const INVALID_NOT_BLANK         = 27;
    const INVALID_INSTANCE_OF       = 28;
    const INVALID_SUBCLASS_OF       = 29;
    const INVALID_RANGE             = 30;
    const INVALID_ALNUM             = 31;
    const INVALID_TRUE              = 32;
    const INVALID_EQ                = 33;
    const INVALID_SAME              = 34;
    const INVALID_MIN               = 35;
    const INVALID_MAX               = 36;
    const INVALID_LENGTH            = 37;
    const INVALID_FALSE             = 38;
    const INVALID_STRING_END        = 39;
    const INVALID_UUID              = 40;
    const INVALID_COUNT             = 41;
    const INVALID_NOT_EQ            = 42;
    const INVALID_NOT_SAME          = 43;
    const INVALID_TRAVERSABLE       = 44;
    const INVALID_ARRAY_ACCESSIBLE  = 45;
    const INVALID_KEY_ISSET         = 46;
    const INVALID_DIRECTORY         = 101;
    const INVALID_FILE              = 102;
    const INVALID_READABLE          = 103;
    const INVALID_WRITEABLE         = 104;
    const INVALID_CLASS             = 105;
    const INVALID_EMAIL             = 201;
    const INTERFACE_NOT_IMPLEMENTED = 202;
    const INVALID_URL               = 203;
    const INVALID_NOT_INSTANCE_OF   = 204;
    const VALUE_NOT_EMPTY           = 205;
    const INVALID_JSON_STRING       = 206;
    const INVALID_OBJECT            = 207;
    const INVALID_METHOD            = 208;
    const INVALID_SCALAR            = 209;
    const INVALID_DATE              = 210;
    const INVALID_CALLABLE          = 211;
    const INVALID_KEYS_EXIST        = 300;
    const INVALID_PROPERTY_EXISTS   = 301;
    const INVALID_PROPERTIES_EXIST  = 302;
    const INVALID_UTF8              = 303;

    protected $nullOr   = false;
    protected $all      = false;
    protected $value    = null;
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected $exceptionClass = 'Assert\AssertionFailedException';


    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Helper method that handles building the assertion failure exceptions.
     * They are returned from this method so that the stack trace still shows
     * the assertions method.
     *
     * @param string $value
     * @param string $message
     * @param int $code
     * @param string $propertyPath
     * @param array $constraints
     * @return mixed
     */
    protected function createException($value, $message, $code, $propertyPath, array $constraints = [])
    {
        $exceptionClass = $this->exceptionClass;
        return new $exceptionClass($message, $code, $propertyPath, $value, $constraints);
    }
    /**
     * @param $exceptionClass
     */
    public function setExceptionClass($exceptionClass)
    {
        $this->$exceptionClass = $exceptionClass;
    }
    /**
     * Assert that two values are equal (using == ).
     *
     * @param mixed $value
     * @param mixed $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function eq($value, $value2, $message = null, $propertyPath = null)
    {
        if ($value != $value2) {
            $message = sprintf(
                $message ?: 'Value "%s" does not equal expected value "%s".',
                $this->stringify($value),
                $this->stringify($value2)
            );
            throw $this->createException($value, $message, self::INVALID_EQ, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }
    /**
     * Assert that two values are the same (using ===).
     *
     * @param mixed $value
     * @param mixed $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function same($value, $value2, $message = null, $propertyPath = null)
    {
        if ($value !== $value2) {
            $message = sprintf(
                $message ?: 'Value "%s" is not the same as expected value "%s".',
                $this->stringify($value),
                $this->stringify($value2)
            );
            throw $this->createException($value, $message, self::INVALID_SAME, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }
    /**
     * Assert that two values are not equal (using == ).
     *
     * @param mixed $value1
     * @param mixed $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEq($value1, $value2, $message = null, $propertyPath = null)
    {
        if ($value1 == $value2) {
            $message = sprintf(
                $message ?: 'Value "%s" is equal to expected value "%s".',
                $this->stringify($value1),
                $this->stringify($value2)
            );
            throw $this->createException($value1, $message,self::INVALID_NOT_EQ, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }
    /**
     * Assert that two values are not the same (using === ).
     *
     * @param mixed $value1
     * @param mixed $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notSame($value1, $value2, $message = null, $propertyPath = null)
    {
        if ($value1 === $value2) {
            $message = sprintf(
                $message ?: 'Value "%s" is the same as expected value "%s".',
                $this->stringify($value1),
                $this->stringify($value2)
            );
            throw $this->createException($value1, $message, self::INVALID_NOT_SAME, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }
    /**
     * Assert that value is a php integer.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function integer($value, $message = null, $propertyPath = null)
    {
        if ( ! is_int($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not an integer.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_INTEGER, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is a php float.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function float($value, $message = null, $propertyPath = null)
    {
        if ( ! is_float($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not a float.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_FLOAT, $propertyPath);
        }
        return $this;
    }
    /**
     * Validates if an integer or integerish is a digit.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function digit($value, $message = null, $propertyPath = null)
    {
        if ( ! ctype_digit((string)$value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not a digit.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_DIGIT, $propertyPath);
        }
        return $this;
    }
    /**
     * Validates if an string is a date .
     *
     * @param string $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function date($value, $message=null, $propertyPath=null)
    {
        if ( strtotime($value) === false )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a date.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_DATE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is a php integer'ish.
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function integerish($value, $message = null, $propertyPath = null)
    {
        if (is_object($value) || strval(intval($value)) != $value || is_bool($value) || is_null($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not an integer or a number castable to integer.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_INTEGERISH, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is php boolean
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function boolean($value, $message = null, $propertyPath = null)
    {
        if ( ! is_bool($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not a boolean.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_BOOLEAN, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is a PHP scalar
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function scalar($value, $message = null, $propertyPath = null)
    {
        if (!is_scalar($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not a scalar.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_SCALAR, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is not empty
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEmpty($value, $message = null, $propertyPath = null)
    {
        if (empty($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is empty, but non empty value was expected.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::VALUE_EMPTY, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is empty
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function noContent($value, $message = null, $propertyPath = null)
    {
        if (!empty($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not empty, but empty value was expected.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::VALUE_NOT_EMPTY, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is not null
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notNull($value, $message = null, $propertyPath = null)
    {
        if ($value === null) {
            $message = sprintf(
                $message ?: 'Value "%s" is null, but non null value was expected.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::VALUE_NULL, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is a string
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function string($value, $message = null, $propertyPath = null)
    {
        if ( ! is_string($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" expected to be string, type %s given.',
                $this->stringify($value),
                gettype($value)
            );
            throw $this->createException($value, $message, self::INVALID_STRING, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value matches a regex
     *
     * @param mixed $value
     * @param string $pattern
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function regex($value, $pattern, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        if ( ! preg_match($pattern, $value)) {
            $message = sprintf(
                $message ?: 'Value "%s" does not match expression.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_REGEX , $propertyPath, ['pattern' => $pattern]);
        }
        return $this;
    }
    /**
     * Assert that string has a given length.
     *
     * @param mixed $value
     * @param int $length
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function length($value, $length, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        $this->string($value, $message, $propertyPath);
        if (mb_strlen($value, $encoding) !== $length) {
            $message = sprintf(
                $message ?: 'Value "%s" has to be %d exactly characters long, but length is %d.',
                $this->stringify($value),
                $length,
                mb_strlen($value, $encoding)
            );
            $constraints = ['length' => $length, 'encoding' => $encoding];
            throw $this->createException($value, $message, self::INVALID_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }
    /**
     * Assert that a string is at least $minLength chars long.
     *
     * @param mixed $value
     * @param int $minLength
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function minLength($value, $minLength, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        $this->string($value, $message, $propertyPath);
        if (mb_strlen($value, $encoding) < $minLength) {
            $message = sprintf(
                $message ?: 'Value "%s" is too short, it should have more than %d characters, but only has %d characters.',
                $this->stringify($value),
                $minLength,
                mb_strlen($value, $encoding)
            );
            $constraints = ['min_length' => $minLength, 'encoding' => $encoding];
            throw $this->createException($value, $message, self::INVALID_MIN_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }
    /**
     * Assert that string value is not longer than $maxLength chars.
     *
     * @param mixed $value
     * @param integer $maxLength
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function maxLength($value, $maxLength, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        $this->string($value, $message, $propertyPath);
        if (mb_strlen($value, $encoding) > $maxLength) {
            $message = sprintf(
                $message ?: 'Value "%s" is too long, it should have no more than %d characters, but has %d characters.',
                $this->stringify($value),
                $maxLength,
                mb_strlen($value, $encoding)
            );
            $constraints = ['max_length' => $maxLength, 'encoding' => $encoding];
            throw $this->createException($value, $message, self::INVALID_MAX_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }
    /**
     * Assert that string length is between min,max lengths.
     *
     * @param mixed $value
     * @param integer $minLength
     * @param integer $maxLength
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function betweenLength($value, $minLength, $maxLength, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        $this->string($value, $message, $propertyPath);
        if (mb_strlen($value, $encoding) < $minLength) {
            $message = sprintf(
                $message ?: 'Value "%s" is too short, it should have more than %d characters, but only has %d characters.',
                $this->stringify($value),
                $minLength,
                mb_strlen($value, $encoding)
            );
            $constraints = ['min_length' => $minLength, 'encoding' => $encoding];
            throw $this->createException($value, $message, self::INVALID_MIN_LENGTH, $propertyPath, $constraints);
        }
        if (mb_strlen($value, $encoding) > $maxLength) {
            $message = sprintf(
                $message ?: 'Value "%s" is too long, it should have no more than %d characters, but has %d characters.',
                $this->stringify($value),
                $maxLength,
                mb_strlen($value, $encoding)
            );
            $constraints = ['max_length' => $maxLength, 'encoding' => $encoding];
            throw $this->createException($value, $message, self::INVALID_MAX_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }
    /**
     * Assert that string starts with a sequence of chars.
     *
     * @param mixed $string
     * @param string $needle
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function startsWith($string, $needle, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        $this->string($string, $message, $propertyPath);
        if (mb_strpos($string, $needle, null, $encoding) !== 0) {
            $message = sprintf(
                $message ?: 'Value "%s" does not start with "%s".',
                $this->stringify($string),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];
            throw $this->createException($string, $message, self::INVALID_STRING_START, $propertyPath, $constraints);
        }
        return $this;
    }
    /**
     * Assert that string ends with a sequence of chars.
     *
     * @param mixed $string
     * @param string $needle
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function endsWith($string, $needle, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        $this->string($string, $message, $propertyPath);
        $stringPosition = mb_strlen($string, $encoding) - mb_strlen($needle, $encoding);
        if (mb_strripos($string, $needle, null, $encoding) !== $stringPosition) {
            $message = sprintf(
                $message ?: 'Value "%s" does not end with "%s".',
                $this->stringify($string),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];
            throw $this->createException($string, $message, self::INVALID_STRING_END, $propertyPath, $constraints);
        }
        return $this;
    }
    /**
     * Assert that string contains a sequence of chars.
     *
     * @param mixed $string
     * @param string $needle
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function contains($string, $needle, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        $this->string($string, $message, $propertyPath);
        if (mb_strpos($string, $needle, null, $encoding) === false) {
            $message = sprintf(
                $message ?: 'Value "%s" does not contain "%s".',
                $this->stringify($string),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];
            throw $this->createException($string, $message, self::INVALID_STRING_CONTAINS, $propertyPath, $constraints);
        }
        return $this;
    }
    /**
     * Assert that value is in array of choices.
     *
     * @param mixed $value
     * @param array $choices
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function choice($value, array $choices, $message = null, $propertyPath = null)
    {
        if ( ! in_array($value, $choices, true)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not an element of the valid values: %s',
                $this->stringify($value),
                implode(", ", array_map('Assert\Assertion::stringify', $choices))
            );
            throw $this->createException($value, $message, self::INVALID_CHOICE, $propertyPath, ['choices' => $choices]);
        }
        return $this;
    }
    /**
     * Alias of {@see choice()}
     *
     * @throws AssertionFailedException
     *
     * @param       $value
     * @param array $choices
     * @param null  $message
     * @param null  $propertyPath
     * @return $this
     */
    public function inArray($value, array $choices, $message = null, $propertyPath = null)
    {
        $this->choice($value, $choices, $message, $propertyPath);
        return $this;
    }
    /**
     * Assert that value is numeric.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function numeric($value, $message = null, $propertyPath = null)
    {
        if ( ! is_numeric($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not numeric.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_NUMERIC, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is an array.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isArray($value, $message = null, $propertyPath = null)
    {
        if ( ! is_array($value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not an array.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_ARRAY, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is an array or a traversable object.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isTraversable($value, $message = null, $propertyPath = null)
    {
        if ( ! is_array($value) && ! $value instanceof \Traversable) {
            $message = sprintf(
                $message ?: 'Value "%s" is not an array and does not implement Traversable.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_TRAVERSABLE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is an array or an array-accessible object.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isArrayAccessible($value, $message = null, $propertyPath = null)
    {
        if ( ! is_array($value) && ! $value instanceof \ArrayAccess) {
            $message = sprintf(
                $message ?: 'Value "%s" is not an array and does not implement ArrayAccess.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_ARRAY_ACCESSIBLE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that key exists in an array
     *
     * @param mixed $value
     * @param string|integer $key
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keyExists($value, $key, $message = null, $propertyPath = null)
    {
        $this->isArray($value, $message, $propertyPath);
        if ( ! array_key_exists($key, $value)) {
            $message = sprintf(
                $message ?: 'Array does not contain an element with key "%s"',
                $this->stringify($key)
            );
            throw $this->createException($value, $message, self::INVALID_KEY_EXISTS, $propertyPath, ['key' => $key]);
        }
        return $this;
    }
    /**
     * Assert that keys exist in array
     *
     * @param mixed $value
     * @param array $keys
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keysExist($value, $keys, $message = null, $propertyPath = null)
    {
        $this->isArray($value, $message, $propertyPath);
        foreach ( $keys as $key ) {
            if ( ! array_key_exists($key, $value)) {
                $message = $message ?: sprintf(
                    'Array does not contain an element with key "%s"',
                    $this->stringify($key)
                );
                throw $this->createException($value, $message, self::INVALID_KEYS_EXIST, $propertyPath, ['key' => $key]);
            }
        }
        return $this;
    }
    /**
     * Assert that property exists in array
     *
     * @param mixed $value
     * @param string|integer $key
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function propertyExists($value, $key, $message = null, $propertyPath = null)
    {
        $this->isObject($value);
        if ( ! property_exists($value, $key) && ! isset($value->$key) ) {
            $message = $message ?: sprintf(
                'Object does not contain an property with key "%s"',
                $this->stringify($key)
            );
            throw $this->createException($value, $message, self::INVALID_PROPERTY_EXISTS, $propertyPath, ['key' => $key]);
        }
        return $this;
    }
    /**
     * Assert that properties exists in array
     *
     * @param mixed $value
     * @param array $keys
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function propertiesExist($value, array $keys, $message = null, $propertyPath = null)
    {
        $this->isObject($value);
        foreach ($keys as $key )
        {
            // Using isset to allow resolution of magically defined properties
            if ( ! property_exists($value, $key) && ! isset($value->$key) )
            {
                $message = $message ?: sprintf(
                    'Object does not contain an property with key "%s"',
                    $this->stringify($key)
                );
                throw $this->createException($value, $message, self::INVALID_PROPERTIES_EXIST, $propertyPath, ['key' => $key]);
            }
        }
        return $this;
    }
    /**
     * Assert that string is valid utf8
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function utf8($value, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        if  ( mb_detect_encoding($value, 'UTF-8', true) !== 'UTF-8' ) {
            $message = $message ?: sprintf(
                'Value "%s" was expected to be a valid UTF8 string',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_UTF8, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that key exists in an array/array-accessible object using isset()
     *
     * @param mixed $value
     * @param string|integer $key
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keyIsset($value, $key, $message = null, $propertyPath = null)
    {
        $this->isArrayAccessible($value, $message, $propertyPath);
        if ( ! isset($value[$key])) {
            $message = sprintf(
                $message ?: 'The element with key "%s" was not found',
                $this->stringify($key)
            );
            throw $this->createException($value, $message, self::INVALID_KEY_ISSET, $propertyPath, ['key' => $key]);
        }
        return $this;
    }
    /**
     * Assert that key exists in an array/array-accessible object and it's value is not empty.
     *
     * @param mixed $value
     * @param string|integer $key
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEmptyKey($value, $key, $message = null, $propertyPath = null)
    {
        $this->keyIsset($value, $key, $message, $propertyPath);
        $this->notEmpty($value[$key], $message, $propertyPath);
        return $this;
    }
    /**
     * Assert that value is not blank
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notBlank($value, $message = null, $propertyPath = null)
    {
        if (false === $value || (empty($value) && '0' != $value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is blank, but was expected to contain a value.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_NOT_BLANK, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is instance of given class-name.
     *
     * @param mixed $value
     * @param string $className
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isInstanceOf($value, $className, $message = null, $propertyPath = null)
    {
        if ( ! ($value instanceof $className)) {
            $message = sprintf(
                $message ?: 'Class "%s" was expected to be instanceof of "%s" but is not.',
                $this->stringify($value),
                $className
            );
            throw $this->createException($value, $message, self::INVALID_INSTANCE_OF, $propertyPath, ['class' => $className]);
        }
        return $this;
    }
    /**
     * Assert that value is not instance of given class-name.
     *
     * @param mixed $value
     * @param string $className
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notIsInstanceOf($value, $className, $message = null, $propertyPath = null)
    {
        if ($value instanceof $className) {
            $message = sprintf(
                $message ?: 'Class "%s" was not expected to be instanceof of "%s".',
                $this->stringify($value),
                $className
            );
            throw $this->createException($value, $message, self::INVALID_NOT_INSTANCE_OF, $propertyPath, ['class' => $className]);
        }
        return $this;
    }
    /**
     * Assert that value is subclass of given class-name.
     *
     * @param mixed $value
     * @param string $className
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function subclassOf($value, $className, $message = null, $propertyPath = null)
    {
        if ( ! is_subclass_of($value, $className)) {
            $message = sprintf(
                $message ?: 'Class "%s" was expected to be subclass of "%s".',
                $this->stringify($value),
                $className
            );
            throw $this->createException($value, $message, self::INVALID_SUBCLASS_OF, $propertyPath, ['class' => $className]);
        }
        return $this;
    }
    /**
     * Assert that value is in range of numbers.
     *
     * @param mixed $value
     * @param integer $minValue
     * @param integer $maxValue
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function range($value, $minValue, $maxValue, $message = null, $propertyPath = null)
    {
        $this->numeric($value, $message, $propertyPath);
        if ($value < $minValue || $value > $maxValue) {
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at least "%d" and at most "%d".',
                $this->stringify($value),
                $this->stringify($minValue),
                $this->stringify($maxValue)
            );
            throw $this->createException($value, $message, self::INVALID_RANGE, $propertyPath, ['min' => $minValue, 'max' => $maxValue]);
        }
        return $this;
    }
    /**
     * Assert that a value is at least as big as a given limit
     *
     * @param mixed $value
     * @param mixed $minValue
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function min($value, $minValue, $message = null, $propertyPath = null)
    {
        $this->numeric($value, $message, $propertyPath);
        if ($value < $minValue) {
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at least "%d".',
                $this->stringify($value),
                $this->stringify($minValue)
            );
            throw $this->createException($value, $message, self::INVALID_MIN, $propertyPath, ['min' => $minValue]);
        }
        return $this;
    }
    /**
     * Assert that a number is smaller as a given limit
     *
     * @param mixed $value
     * @param mixed $maxValue
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function max($value, $maxValue, $message = null, $propertyPath = null)
    {
        $this->numeric($value, $message, $propertyPath);
        if ($value > $maxValue) {
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at most "%d".',
                $this->stringify($value),
                $this->stringify($maxValue)
            );
            throw $this->createException($value, $message, self::INVALID_MAX, $propertyPath, ['max' => $maxValue]);
        }
        return $this;
    }
    /**
     * Assert that a file exists
     *
     * @param string $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function file($value, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        $this->notEmpty($value, $message, $propertyPath);
        if ( ! is_file($value)) {
            $message = sprintf(
                $message ?: 'File "%s" was expected to exist.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_FILE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that a directory exists
     *
     * @param string $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function directory($value, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        if ( ! is_dir($value)) {
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be a directory.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_DIRECTORY, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the value is something readable
     *
     * @param string $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function readable($value, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        if ( ! is_readable($value)) {
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be readable.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_READABLE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the value is something writeable
     *
     * @param string $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function writeable($value, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        if ( ! is_writeable($value)) {
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be writeable.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_WRITEABLE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is an email adress (using
     * input_filter/FILTER_VALIDATE_EMAIL).
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function email($value, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        if ( ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid e-mail address.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_EMAIL, $propertyPath);
        } else {
            $host = substr($value, strpos($value, '@') + 1);
            // Likely not a FQDN, bug in PHP FILTER_VALIDATE_EMAIL prior to PHP 5.3.3
            if (version_compare(PHP_VERSION, '5.3.3', '<') && strpos($host, '.') === false) {
                $message = sprintf(
                    $message ?: 'Value "%s" was expected to be a valid e-mail address.',
                    $this->stringify($value)
                );
                throw $this->createException($value, $message, self::INVALID_EMAIL, $propertyPath);
            }
        }
        return $this;
    }
    /**
     * Assert that value is an URL.
     *
     * This code snipped was taken from the Symfony project and modified to the special demands of this method.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     *
     *
     * @link https://github.com/symfony/Validator/blob/master/Constraints/UrlValidator.php
     * @link https://github.com/symfony/Validator/blob/master/Constraints/Url.php
     */
    public function url($value, $message = null, $propertyPath = null)
    {
        $this->string($value, $message, $propertyPath);
        $protocols = ['http', 'https'];
        $pattern = '~^
            (%s)://                                 # protocol
            (
                ([\pL\pN\pS-]+\.)+[\pL]+                   # a domain name
                    |                                     #  or
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}      # a IP address
                    |                                     #  or
                \[
                    (?:(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-f]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,1}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,2}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,3}(?:(?:[0-9a-f]{1,4})))?::(?:(?:[0-9a-f]{1,4})):)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,4}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,5}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,6}(?:(?:[0-9a-f]{1,4})))?::))))
                \]  # a IPv6 address
            )
            (:[0-9]+)?                              # a port (optional)
            (/?|/\S+)                               # a /, nothing or a / with something
        $~ixu';
        $pattern = sprintf($pattern, implode('|', $protocols));
        if (!preg_match($pattern, $value)) {
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid URL starting with http or https',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_URL, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that value is alphanumeric.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function alnum($value, $message = null, $propertyPath = null)
    {
        try {
            $this->regex($value, '(^([a-zA-Z]{1}[a-zA-Z0-9]*)$)', $message, $propertyPath);
        } catch(AssertionFailedException $e) {
            $message = sprintf(
                $message ?: 'Value "%s" is not alphanumeric, starting with letters and containing only letters and numbers.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_ALNUM, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the value is boolean True.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function true($value, $message = null, $propertyPath = null)
    {
        if ($value !== true) {
            $message = sprintf(
                $message ?: 'Value "%s" is not TRUE.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_TRUE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the value is boolean False.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function false($value, $message = null, $propertyPath = null)
    {
        if ($value !== false) {
            $message = sprintf(
                $message ?: 'Value "%s" is not FALSE.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_FALSE, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the class exists.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function classExists($value, $message = null, $propertyPath = null)
    {
        if ( ! class_exists($value)) {
            $message = sprintf(
                $message ?: 'Class "%s" does not exist.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_CLASS, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the class implements the interface
     *
     * @param mixed $class
     * @param string $interfaceName
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function implementsInterface($class, $interfaceName, $message = null, $propertyPath = null)
    {
        $reflection = new \ReflectionClass($class);
        if ( ! $reflection->implementsInterface($interfaceName)) {
            $message = sprintf(
                $message ?: 'Class "%s" does not implement interface "%s".',
                $this->stringify($class),
                $this->stringify($interfaceName)
            );
            throw $this->createException($class, $message, self::INTERFACE_NOT_IMPLEMENTED, $propertyPath, ['interface' => $interfaceName]);
        }
        return $this;
    }
    /**
     * Assert that the given string is a valid json string.
     *
     * NOTICE:
     * Since this does a json_decode to determine its validity
     * you probably should consider, when using the variable
     * content afterwards, just to decode and check for yourself instead
     * of using this assertion.
     *
     * @param mixed $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isJsonString($value, $message = null, $propertyPath = null)
    {
        if (null === json_decode($value) && JSON_ERROR_NONE !== json_last_error()) {
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid JSON string.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_JSON_STRING, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the given string is a valid UUID
     *
     * Uses code from {@link https://github.com/ramsey/uuid} that is MIT licensed.
     *
     * @param string $value
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function uuid($value, $message = null, $propertyPath = null)
    {
        $value = str_replace(['urn:', 'uuid:', '{', '}'], '', $value);
        if ($value === '00000000-0000-0000-0000-000000000000') {
            return $this;
        }
        if (!preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $value)) {
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid UUID.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_UUID, $propertyPath);
        }
        return $this;
    }
    /**
     * Assert that the count of countable is equal to count.
     *
     * @param array|\Countable $countable
     * @param int              $count
     * @param string           $message
     * @param string           $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function count($countable, $count, $message = null, $propertyPath = null)
    {
        if ($count !== count($countable)) {
            $message = sprintf(
                $message ?: 'List does not contain exactly "%d" elements.',
                $this->stringify($countable),
                $this->stringify($count)
            );
            throw $this->createException($countable, $message, self::INVALID_COUNT, $propertyPath, ['count' => $count]);
        }
        return $this;
    }
    /**
     * static call handler to implement:
     *  - "null or assertion" delegation
     *  - "all" delegation
     *
     * @param $method
     * @param $args
     * @return $this|mixed
     */
    public function __call($method, $args)
    {
        if (strpos($method, "nullOr") === 0) {
            if ( ! array_key_exists(0, $args)) {
                throw new \BadMethodCallException("Missing the first argument.");
            }
            if ($args[0] === null) {
                return $this;
            }
            $method = substr($method, 6);
            return call_user_func_array([get_called_class(), $method], $args);
        }
        if (strpos($method, "all") === 0) {
            if ( ! array_key_exists(0, $args)) {
                throw new \BadMethodCallException("Missing the first argument.");
            }
            $this->isTraversable($args[0]);
            $method      = substr($method, 3);
            $values      = array_shift($args);
            $calledClass = get_called_class();
            foreach ($values as $value) {
                call_user_func_array([$calledClass, $method], array_merge([$value], $args));
            }
            return $this;
        }
        throw new \BadMethodCallException("No assertion Assertion#" . $method . " exists.");
    }
    /**
     * Determines if the values array has every choice as key and that this choice has content.
     *
     * @param array $values
     * @param array $choices
     * @param null  $message
     * @param null  $propertyPath
     * @return $this
     */
    public function choicesNotEmpty(array $values, array $choices, $message = null, $propertyPath = null)
    {
        $this->notEmpty($values, $message, $propertyPath);
        foreach ($choices as $choice) {
            $this->notEmptyKey($values, $choice, $message, $propertyPath);
        }
        return $this;
    }
    /**
     * Determines that the named method is defined in the provided object.
     *
     * @param string $value
     * @param mixed  $object
     * @param null   $message
     * @param null   $propertyPath
     * @returns Assert
     * @throws
     */
    public function methodExists($value, $object, $message = null, $propertyPath = null)
    {
        $this->isObject($object, $message, $propertyPath);
        if (!method_exists($object, $value)) {
            $message = sprintf(
                $message ?: 'Expected "%s" does not a exist in provided object.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_METHOD, $propertyPath);
        }
        return $this;
    }
    /**
     * Determines that the provided value is an object.
     *
     * @param mixed $value
     * @param null $message
     * @param null $propertyPath
     * @return $this
     */
    public function isObject($value, $message = null, $propertyPath = null)
    {
        if (!is_object($value)) {
            $message = sprintf(
                $message ?: 'Provided "%s" is not a valid object.',
                $this->stringify($value)
            );
            throw $this->createException($value, $message, self::INVALID_OBJECT, $propertyPath);
        }
        return $this;
    }
    /**
     * Make a string version of a value.
     *
     * @param mixed $value
     * @return string
     */
    private static function stringify($value)
    {
        if (is_bool($value)) {
            return $value ? '<TRUE>' : '<FALSE>';
        }
        if (is_scalar($value)) {
            $val = (string)$value;
            if (strlen($val) > 100) {
                $val = substr($val, 0, 97) . '...';
            }
            return $val;
        }
        if (is_array($value)) {
            return '<ARRAY>';
        }
        if (is_object($value)) {
            return get_class($value);
        }
        if (is_resource($value)) {
            return '<RESOURCE>';
        }
        if ($value === NULL) {
            return '<NULL>';
        }
        return 'unknown';
    }
}

