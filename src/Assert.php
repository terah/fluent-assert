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
 * @author Terry Cullen <terry@terah.com.au>
 *
 */
class Assert
{
    const INVALID_FLOAT = 9;
    const INVALID_INTEGER = 10;
    const INVALID_DIGIT = 11;
    const INVALID_INTEGERISH = 12;
    const INVALID_BOOLEAN = 13;
    const VALUE_EMPTY = 14;
    const VALUE_NULL = 15;
    const INVALID_STRING = 16;
    const INVALID_REGEX = 17;
    const INVALID_MIN_LENGTH = 18;
    const INVALID_MAX_LENGTH = 19;
    const INVALID_STRING_START = 20;
    const INVALID_STRING_CONTAINS = 21;
    const INVALID_CHOICE = 22;
    const INVALID_NUMERIC = 23;
    const INVALID_ARRAY = 24;
    const INVALID_KEY_EXISTS = 26;
    const INVALID_NOT_BLANK = 27;
    const INVALID_INSTANCE_OF = 28;
    const INVALID_SUBCLASS_OF = 29;
    const INVALID_RANGE = 30;
    const INVALID_ALNUM = 31;
    const INVALID_TRUE = 32;
    const INVALID_EQ = 33;
    const INVALID_SAME = 34;
    const INVALID_MIN = 35;
    const INVALID_MAX = 36;
    const INVALID_LENGTH = 37;
    const INVALID_FALSE = 38;
    const INVALID_STRING_END = 39;
    const INVALID_UUID = 40;
    const INVALID_COUNT = 41;
    const INVALID_NOT_EQ = 42;
    const INVALID_NOT_SAME = 43;
    const INVALID_TRAVERSABLE = 44;
    const INVALID_ARRAY_ACCESSIBLE = 45;
    const INVALID_KEY_ISSET = 46;
    const INVALID_DIRECTORY = 101;
    const INVALID_FILE = 102;
    const INVALID_READABLE = 103;
    const INVALID_WRITEABLE = 104;
    const INVALID_CLASS = 105;
    const INVALID_EMAIL = 201;
    const INTERFACE_NOT_IMPLEMENTED = 202;
    const INVALID_URL = 203;
    const INVALID_NOT_INSTANCE_OF = 204;
    const VALUE_NOT_EMPTY = 205;
    const INVALID_JSON_STRING = 206;
    const INVALID_OBJECT = 207;
    const INVALID_METHOD = 208;
    const INVALID_SCALAR = 209;
    const INVALID_DATE = 210;
    const INVALID_CALLABLE = 211;
    const INVALID_KEYS_EXIST = 300;
    const INVALID_PROPERTY_EXISTS = 301;
    const INVALID_PROPERTIES_EXIST = 302;
    const INVALID_UTF8 = 303;
    const INVALID_DOMAIN_NAME = 304;
    const INVALID_NOT_FALSE = 305;
    const INVALID_FILE_OR_DIR = 306;
    const INVALID_ASCII = 307;
    const INVALID_NOT_REGEX = 308;
    /** @var bool */
    protected $nullOr       = false;

    /** @var mixed */
    protected $value        = null;

    /** @var bool */
    protected $all          = false;

    /** @var null|string */
    protected $propertyPath = null;
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected $exceptionClass = 'Terah\Assert\AssertionFailedException';

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value($value);
    }

    /**
     * @param $value
     * @return Assert
     */
    public static function that($value)
    {
        return Assert($value);
    }

    /**
     * @param mixed $value
     * @return Assert
     */
    public function reset($value)
    {
        return $this->all(false)->nullOr(false)->value($value);
    }

    /**
     * @param mixed $value
     * @return Assert
     */
    public function value($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param bool $nullOr
     * @return Assert
     */
    public function nullOr($nullOr = true)
    {
        $this->nullOr = $nullOr;
        return $this;
    }

    /**
     * @param bool $all
     * @return Assert
     */
    public function all($all = true)
    {
        $this->all = $all;
        return $this;
    }

    /**
     * Helper method that handles building the assertion failure exceptions.
     * They are returned from this method so that the stack trace still shows
     * the assertions method.
     *
     * @param string $message
     * @param int    $code
     * @param string $propertyPath
     * @param array  $constraints
     * @return AssertionFailedException
     */
    protected function createException($message, $code, $propertyPath, array $constraints = [])
    {
        $exceptionClass = $this->exceptionClass;
        $propertyPath = is_null($propertyPath) ? $this->propertyPath : $propertyPath;
        return new $exceptionClass($message, $code, $propertyPath, $this->value, $constraints);
    }

    /**
     * @param $exceptionClass
     * @return Assert
     */
    public function setExceptionClass($exceptionClass)
    {
        $this->exceptionClass = $exceptionClass;
        return $this;
    }

    /**
     * @param string $name
     * @return Assert
     */
    public function name($name)
    {
        $this->propertyPath = $name;
        return $this;
    }

    /**
     * Assert that two values are equal (using == ).
     *
     * @param mixed       $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function eq($value2, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value != $value2 )
        {
            $message = sprintf(
                $message ?: 'Value "%s" does not equal expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );
            throw $this->createException($message, self::INVALID_EQ, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }

    /**
     * Assert that two values are the same (using ===).
     *
     * @param mixed       $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function same($value2, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value !== $value2 )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not the same as expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );
            throw $this->createException($message, self::INVALID_SAME, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }

    /**
     * Assert that two values are not equal (using == ).
     *
     * @param mixed       $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEq($value2, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value == $value2 )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is equal to expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );
            throw $this->createException($message, self::INVALID_NOT_EQ, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }

    /**
     * @param string|null $message
     * @param null        $propertyPath
     *
     * @return $this
     */
    public function isCallable($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_callable($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not callable.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_NOT_EQ, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that two values are not the same (using === ).
     *
     * @param mixed       $value2
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notSame($value2, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value === $value2 )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is the same as expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );
            throw $this->createException($message, self::INVALID_NOT_SAME, $propertyPath, ['expected' => $value2]);
        }
        return $this;
    }

    public function id($message = null, $propertyPath = null)
    {
        $message = $message ?: 'Value "%s" is not an integer id.';
        return $this->nonEmptyInt($message, $propertyPath)->range(1, PHP_INT_MAX);
    }

    public function flag($message = null, $propertyPath = null)
    {
        $message = $message ?: 'Value "%s" is not a 0 or 1.';
        return $this->range(0, 1, $message, $propertyPath);
    }

    public function status($message = null, $propertyPath = null)
    {
        $message = $message ?: 'Value "%s" is not a valid status.';
        return $this->integer($message, $propertyPath)->inArray([-1, 0, 1]);
    }

    public function nullOrId($message = null, $propertyPath = null)
    {
        return $this->nullOr()->id($message, $propertyPath);
    }

    public function allIds($message = null, $propertyPath = null)
    {
        return $this->all()->id($message, $propertyPath);
    }

    public function int($message = null, $propertyPath = null)
    {
        return $this->integer($message, $propertyPath);
    }

    /**
     * Assert that value is a php integer.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function integer($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_int($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not an integer.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_INTEGER, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is a php float.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function float($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_float($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a float.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_FLOAT, $propertyPath);
        }
        return $this;
    }

    /**
     * Validates if an integer or integerish is a digit.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function digit($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !ctype_digit((string)$this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a digit.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_DIGIT, $propertyPath);
        }
        return $this;
    }

    /**
     * Validates if an string is a date .
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function date($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->notEmpty($message, $propertyPath);
        if ( strtotime($this->value) === false )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a date.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_DATE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is a php integer'ish.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function integerish($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( is_object($this->value) || strval(intval($this->value)) != $this->value || is_bool($this->value) || is_null($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not an integer or a number castable to integer.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_INTEGERISH, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is php boolean
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function boolean($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_bool($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a boolean.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_BOOLEAN, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is a PHP scalar
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function scalar($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_scalar($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a scalar.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_SCALAR, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is not empty
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEmpty($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ( is_object($this->value) && empty((array)$this->value) ) || empty($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is empty, but non empty value was expected.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::VALUE_EMPTY, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is empty
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function noContent($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !empty( $this->value ) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not empty, but empty value was expected.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::VALUE_NOT_EMPTY, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is not null
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notNull($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value === null )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is null, but non null value was expected.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::VALUE_NULL, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is a string
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function string($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_string($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" expected to be string, type %s given.',
                $this->stringify($this->value),
                gettype($this->value)
            );
            throw $this->createException($message, self::INVALID_STRING, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value matches a regex
     *
     * @param string      $pattern
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function regex($pattern, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( !preg_match($pattern, $this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" does not match expression.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_REGEX, $propertyPath, ['pattern' => $pattern]);
        }
        return $this;
    }

    public function notRegex($pattern, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( preg_match($pattern, $this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" does not match expression.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_REGEX, $propertyPath, ['pattern' => $pattern]);
        }
        return $this;
    }

    /**
     * Assert that string has a given length.
     *
     * @param int         $length
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function length($length, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( mb_strlen($this->value, $encoding) !== $length )
        {
            $message     = sprintf(
                $message ?: 'Value "%s" has to be %d exactly characters long, but length is %d.',
                $this->stringify($this->value),
                $length,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['length' => $length, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }

    /**
     * Assert that a string is at least $minLength chars long.
     *
     * @param int         $minLength
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function minLength($minLength, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( mb_strlen($this->value, $encoding) < $minLength )
        {
            $message     = sprintf(
                $message
                    ?: 'Value "%s" is too short, it should have more than %d characters, but only has %d characters.',
                $this->stringify($this->value),
                $minLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['min_length' => $minLength, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_MIN_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }

    /**
     * Assert that string value is not longer than $maxLength chars.
     *
     * @param integer     $maxLength
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function maxLength($maxLength, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( mb_strlen($this->value, $encoding) > $maxLength )
        {
            $message     = sprintf(
                $message ?: 'Value "%s" is too long, it should have no more than %d characters, but has %d characters.',
                $this->stringify($this->value),
                $maxLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['max_length' => $maxLength, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_MAX_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }

    /**
     * Assert that string length is between min,max lengths.
     *
     * @param integer     $minLength
     * @param integer     $maxLength
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function betweenLength($minLength, $maxLength, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( mb_strlen($this->value, $encoding) < $minLength )
        {
            $message     = sprintf(
                $message
                    ?: 'Value "%s" is too short, it should have more than %d characters, but only has %d characters.',
                $this->stringify($this->value),
                $minLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['min_length' => $minLength, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_MIN_LENGTH, $propertyPath, $constraints);
        }
        if ( mb_strlen($this->value, $encoding) > $maxLength )
        {
            $message     = sprintf(
                $message ?: 'Value "%s" is too long, it should have no more than %d characters, but has %d characters.',
                $this->stringify($this->value),
                $maxLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['max_length' => $maxLength, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_MAX_LENGTH, $propertyPath, $constraints);
        }
        return $this;
    }

    /**
     * Assert that string starts with a sequence of chars.
     *
     * @param string      $needle
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function startsWith($needle, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( mb_strpos($this->value, $needle, null, $encoding) !== 0 )
        {
            $message     = sprintf(
                $message ?: 'Value "%s" does not start with "%s".',
                $this->stringify($this->value),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_STRING_START, $propertyPath, $constraints);
        }
        return $this;
    }

    /**
     * Assert that string ends with a sequence of chars.
     *
     * @param string      $needle
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function endsWith($needle, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        $stringPosition = mb_strlen($this->value, $encoding) - mb_strlen($needle, $encoding);
        if ( mb_strripos($this->value, $needle, null, $encoding) !== $stringPosition )
        {
            $message     = sprintf(
                $message ?: 'Value "%s" does not end with "%s".',
                $this->stringify($this->value),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_STRING_END, $propertyPath, $constraints);
        }
        return $this;
    }

    /**
     * Assert that string contains a sequence of chars.
     *
     * @param string      $needle
     * @param string|null $message
     * @param string|null $propertyPath
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function contains($needle, $message = null, $propertyPath = null, $encoding = 'utf8')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( mb_strpos($this->value, $needle, null, $encoding) === false )
        {
            $message     = sprintf(
                $message ?: 'Value "%s" does not contain "%s".',
                $this->stringify($this->value),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];
            throw $this->createException($message, self::INVALID_STRING_CONTAINS, $propertyPath, $constraints);
        }
        return $this;
    }

    /**
     * Assert that value is in array of choices.
     *
     * @param array       $choices
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function choice(array $choices, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !in_array($this->value, $choices, true) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not an element of the valid values: %s',
                $this->stringify($this->value),
                implode(", ", array_map('Terah\Assert\Assert::stringify', $choices))
            );
            throw $this->createException($message, self::INVALID_CHOICE, $propertyPath, ['choices' => $choices]);
        }
        return $this;
    }

    /**
     * Alias of {@see choice()}
     *
     * @throws AssertionFailedException
     *
     * @param array $choices
     * @param null  $message
     * @param null  $propertyPath
     * @return $this
     */
    public function inArray(array $choices, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->choice($choices, $message, $propertyPath);
        return $this;
    }

    /**
     * Assert that value is numeric.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function numeric($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_numeric($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not numeric.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_NUMERIC, $propertyPath);
        }
        return $this;
    }

    public function nonEmptyArray($message = null, $propertyPath = null)
    {
        $message = $message ?: 'Value "%s" is not a non-empty array.';
        return $this->isArray($message, $propertyPath)->notEmpty($message, $propertyPath);
    }

    public function nonEmptyInt($message = null, $propertyPath = null)
    {
        $message = $message ?: 'Value "%s" is not a non-empty integer.';
        return $this->integer($message, $propertyPath)->notEmpty($message, $propertyPath);
    }

    public function nonEmptyString($message = null, $propertyPath = null)
    {
        $message = $message ?: 'Value "%s" is not a non-empty string.';
        return $this->integer($message, $propertyPath)->notEmpty($message, $propertyPath);
    }

    /**
     * Assert that value is an array.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isArray($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_array($this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not an array.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_ARRAY, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is an array or a traversable object.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isTraversable($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_array($this->value) && !$this->value instanceof \Traversable )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not an array and does not implement Traversable.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_TRAVERSABLE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is an array or an array-accessible object.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isArrayAccessible($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_array($this->value) && !$this->value instanceof \ArrayAccess )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not an array and does not implement ArrayAccess.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_ARRAY_ACCESSIBLE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that key exists in an array
     *
     * @param string|integer $key
     * @param string|null    $message
     * @param string|null    $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keyExists($key, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isArray($message, $propertyPath);
        if ( !array_key_exists($key, $this->value) )
        {
            $message = sprintf(
                $message ?: 'Array does not contain an element with key "%s"',
                $this->stringify($key)
            );
            throw $this->createException($message, self::INVALID_KEY_EXISTS, $propertyPath, ['key' => $key]);
        }
        return $this;
    }

    /**
     * Assert that keys exist in array
     *
     * @param array       $keys
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keysExist($keys, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isArray($message, $propertyPath);
        foreach ( $keys as $key )
        {
            if ( !array_key_exists($key, $this->value) )
            {
                $message = $message
                    ?: sprintf(
                        'Array does not contain an element with key "%s"',
                        $this->stringify($key)
                    );
                throw $this->createException($message, self::INVALID_KEYS_EXIST, $propertyPath, ['key' => $key]);
            }
        }
        return $this;
    }

    /**
     * Assert that property exists in array
     *
     * @param string|integer $key
     * @param string|null    $message
     * @param string|null    $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function propertyExists($key, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isObject($message, $propertyPath);
        if ( !property_exists($this->value, $key) && !isset( $this->value->$key ) )
        {
            $message = $message
                ?: sprintf(
                    'Object does not contain a property with key "%s"',
                    $this->stringify($key)
                );
            throw $this->createException($message, self::INVALID_PROPERTY_EXISTS, $propertyPath, ['key' => $key]);
        }
        return $this;
    }

    /**
     * Assert that properties exists in array
     *
     * @param array       $keys
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function propertiesExist(array $keys, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isObject($message, $propertyPath);
        foreach ( $keys as $key )
        {
            // Using isset to allow resolution of magically defined properties
            if ( !property_exists($this->value, $key) && !isset( $this->value->$key ) )
            {
                $message = $message
                    ?: sprintf(
                        'Object does not contain a property with key "%s"',
                        $this->stringify($key)
                    );
                throw $this->createException($message, self::INVALID_PROPERTIES_EXIST, $propertyPath, ['key' => $key]);
            }
        }
        return $this;
    }

    /**
     * Assert that string is valid utf8
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function utf8($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( mb_detect_encoding($this->value, 'UTF-8', true) !== 'UTF-8' )
        {
            $message = $message
                ?: sprintf(
                    'Value "%s" was expected to be a valid UTF8 string',
                    $this->stringify($this->value)
                );
            throw $this->createException($message, self::INVALID_UTF8, $propertyPath);
        }
        return $this;
    }


    /**
     * Assert that string is valid utf8
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function ascii($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( ! preg_match('/^[ -~]+$/', $this->value) )
        {
            $message = $message
                ?: sprintf(
                    'Value "%s" was expected to be a valid ASCII string',
                    $this->stringify($this->value)
                );
            throw $this->createException($message, self::INVALID_ASCII, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that key exists in an array/array-accessible object using isset()
     *
     * @param string|integer $key
     * @param string|null    $message
     * @param string|null    $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keyIsset($key, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isArrayAccessible($message, $propertyPath);
        if ( !isset( $this->value[$key] ) )
        {
            $message = sprintf(
                $message ?: 'The element with key "%s" was not found',
                $this->stringify($key)
            );
            throw $this->createException($message, self::INVALID_KEY_ISSET, $propertyPath, ['key' => $key]);
        }
        return $this;
    }

    /**
     * Assert that key exists in an array/array-accessible object and it's value is not empty.
     *
     * @param string|integer $key
     * @param string|null    $message
     * @param string|null    $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEmptyKey($key, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->keyIsset($key, $message, $propertyPath);
        Assert($this->value[$key])->notEmpty($message, $propertyPath);
        return $this;
    }

    /**
     * Assert that value is not blank
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notBlank($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( false === $this->value || ( empty( $this->value ) && '0' != $this->value ) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is blank, but was expected to contain a value.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_NOT_BLANK, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is instance of given class-name.
     *
     * @param string      $className
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isInstanceOf($className, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !( $this->value instanceof $className ) )
        {
            $message = sprintf(
                $message ?: 'Class "%s" was expected to be instanceof of "%s" but is not.',
                $this->stringify($this->value),
                $className
            );
            throw $this->createException($message, self::INVALID_INSTANCE_OF, $propertyPath, ['class' => $className]);
        }
        return $this;
    }

    /**
     * Assert that value is not instance of given class-name.
     *
     * @param string      $className
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notIsInstanceOf($className, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value instanceof $className )
        {
            $message = sprintf(
                $message ?: 'Class "%s" was not expected to be instanceof of "%s".',
                $this->stringify($this->value),
                $className
            );
            throw $this->createException($message, self::INVALID_NOT_INSTANCE_OF, $propertyPath, ['class' => $className]);
        }
        return $this;
    }

    /**
     * Assert that value is subclass of given class-name.
     *
     * @param string      $className
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function subclassOf($className, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_subclass_of($this->value, $className) )
        {
            $message = sprintf(
                $message ?: 'Class "%s" was expected to be subclass of "%s".',
                $this->stringify($this->value),
                $className
            );
            throw $this->createException($message, self::INVALID_SUBCLASS_OF, $propertyPath, ['class' => $className]);
        }
        return $this;
    }

    /**
     * Assert that value is in range of numbers.
     *
     * @param integer     $minValue
     * @param integer     $maxValue
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function range($minValue, $maxValue, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->numeric($message, $propertyPath);
        if ( $this->value < $minValue || $this->value > $maxValue )
        {
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at least "%d" and at most "%d".',
                $this->stringify($this->value),
                $this->stringify($minValue),
                $this->stringify($maxValue)
            );
            throw $this->createException($message, self::INVALID_RANGE, $propertyPath, [
                'min' => $minValue,
                'max' => $maxValue
            ]);
        }
        return $this;
    }

    /**
     * Assert that a value is at least as big as a given limit
     *
     * @param mixed       $minValue
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function min($minValue, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->numeric($message, $propertyPath);
        if ( $this->value < $minValue )
        {
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at least "%d".',
                $this->stringify($this->value),
                $this->stringify($minValue)
            );
            throw $this->createException($message, self::INVALID_MIN, $propertyPath, ['min' => $minValue]);
        }
        return $this;
    }

    /**
     * Assert that a number is smaller as a given limit
     *
     * @param mixed       $maxValue
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function max($maxValue, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->numeric($message, $propertyPath);
        if ( $this->value > $maxValue )
        {
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at most "%d".',
                $this->stringify($this->value),
                $this->stringify($maxValue)
            );
            throw $this->createException($message, self::INVALID_MAX, $propertyPath, ['max' => $maxValue]);
        }
        return $this;
    }

    /**
     * Assert that a file exists
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function file($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        $this->notEmpty($message, $propertyPath);
        if ( !is_file($this->value) )
        {
            $message = sprintf(
                $message ?: 'File "%s" was expected to exist.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_FILE, $propertyPath);
        }
        return $this;
    }

    /**
     * @param string|null $message
     * @param string|null $propertyPath
     * @return $this
     */
    public function fileExists($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        $this->notEmpty($message, $propertyPath);
        if ( ! file_exists($this->value) )
        {
            $message = sprintf(
                $message ?: 'File or directory "%s" was expected to exist.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_FILE_OR_DIR, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that a directory exists
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function directory($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( !is_dir($this->value) )
        {
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be a directory.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_DIRECTORY, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the value is something readable
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function readable($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( !is_readable($this->value) )
        {
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be readable.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_READABLE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the value is something writeable
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function writeable($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( !is_writeable($this->value) )
        {
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be writeable.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_WRITEABLE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is an email adress (using
     * input_filter/FILTER_VALIDATE_EMAIL).
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function email($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        if ( ! filter_var($this->value, FILTER_VALIDATE_EMAIL) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid e-mail address.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_EMAIL, $propertyPath);
        }
        else
        {
            $host = substr($this->value, strpos($this->value, '@') + 1);
            // Likely not a FQDN, bug in PHP FILTER_VALIDATE_EMAIL prior to PHP 5.3.3
            if ( version_compare(PHP_VERSION, '5.3.3', '<') && strpos($host, '.') === false )
            {
                $message = sprintf(
                    $message ?: 'Value "%s" was expected to be a valid e-mail address.',
                    $this->stringify($this->value)
                );
                throw $this->createException($message, self::INVALID_EMAIL, $propertyPath);
            }
        }
        return $this;
    }

    public function emailPrefix($message = null, $propertyPath = null)
    {
        $this->value($this->value . '@example.com');
        return $this->email($message, $propertyPath);
    }

    /**
     * Assert that value is an URL.
     *
     * This code snipped was taken from the Symfony project and modified to the special demands of this method.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     *
     *
     * @link https://github.com/symfony/Validator/blob/master/Constraints/UrlValidator.php
     * @link https://github.com/symfony/Validator/blob/master/Constraints/Url.php
     */
    public function url($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        $protocols = ['http', 'https'];
        $pattern   = '~^
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
        $pattern   = sprintf($pattern, implode('|', $protocols));
        if ( !preg_match($pattern, $this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid URL starting with http or https',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_URL, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is domain name.
     *
     * This code snipped was taken from the Symfony project and modified to the special demands of this method.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     *
     */
    public function domainName($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $propertyPath);
        $pattern   = '/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}$/';
        if ( ! preg_match($pattern, $this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid domain name',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_DOMAIN_NAME, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that value is alphanumeric.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function alnum($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        try
        {
            $this->regex('(^([a-zA-Z]{1}[a-zA-Z0-9]*)$)', $message, $propertyPath);
        }
        catch (AssertionFailedException $e)
        {
            $message = sprintf(
                $message
                    ?: 'Value "%s" is not alphanumeric, starting with letters and containing only letters and numbers.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_ALNUM, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the value is boolean True.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function true($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value !== true )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not TRUE.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_TRUE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the value is boolean True.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function truthy($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! $this->value )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not truthy.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_TRUE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the value is boolean False.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function false($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value !== false )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not FALSE.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_FALSE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the value is not boolean False.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notFalse($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value === false )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not FALSE.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_NOT_FALSE, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the class exists.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function classExists($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !class_exists($this->value) )
        {
            $message = sprintf(
                $message ?: 'Class "%s" does not exist.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_CLASS, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the class implements the interface
     *
     * @param string      $interfaceName
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function implementsInterface($interfaceName, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $reflection = new \ReflectionClass($this->value);
        if ( !$reflection->implementsInterface($interfaceName) )
        {
            $message = sprintf(
                $message ?: 'Class "%s" does not implement interface "%s".',
                $this->stringify($this->value),
                $this->stringify($interfaceName)
            );
            throw $this->createException($message, self::INTERFACE_NOT_IMPLEMENTED, $propertyPath, ['interface' => $interfaceName]);
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
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isJsonString($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( null === json_decode($this->value) && JSON_ERROR_NONE !== json_last_error() )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid JSON string.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_JSON_STRING, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the given string is a valid UUID
     *
     * Uses code from {@link https://github.com/ramsey/uuid} that is MIT licensed.
     *
     * @param string|null $message
     * @param string|null $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function uuid($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->value = str_replace(['urn:', 'uuid:', '{', '}'], '', $this->value);
        if ( $this->value === '00000000-0000-0000-0000-000000000000' )
        {
            return $this;
        }
        if ( !preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $this->value) )
        {
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid UUID.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_UUID, $propertyPath);
        }
        return $this;
    }

    /**
     * Assert that the count of countable is equal to count.
     *
     * @param int    $count
     * @param string $message
     * @param string $propertyPath
     * @return Assert
     * @throws AssertionFailedException
     */
    public function count($count, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $count !== count($this->value) )
        {
            $message = sprintf(
                $message ?: 'List does not contain exactly "%d" elements.',
                $this->stringify($this->value),
                $this->stringify($count)
            );
            throw $this->createException($message, self::INVALID_COUNT, $propertyPath, ['count' => $count]);
        }
        return $this;
    }

    protected function doAllOrNullOr($func, $args)
    {
        if ( $this->nullOr && is_null($this->value) )
        {
            return true;
        }
        if ( $this->all && Assert($this->value)->isTraversable() )
        {
            foreach ( $this->value as $idx => $value )
            {
                $object = Assert($value);
                call_user_func_array([$object, $func], $args);
            }
            return true;
        }
        return $this->nullOr && is_null($this->value) ? true : false;
    }

    /**
     * Determines if the values array has every choice as key and that this choice has content.
     *
     * @param array $choices
     * @param null  $message
     * @param null  $propertyPath
     * @return $this
     */
    public function choicesNotEmpty(array $choices, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->notEmpty($message, $propertyPath);
        foreach ( $choices as $choice )
        {
            $this->notEmptyKey($choice, $message, $propertyPath);
        }
        return $this;
    }

    /**
     * Determines that the named method is defined in the provided object.
     *
     * @param mixed $object
     * @param null  $message
     * @param null  $propertyPath
     * @returns Assert
     * @throws
     */
    public function methodExists($object, $message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        Assert($object)->isObject($message, $propertyPath);
        if ( !method_exists($object, $this->value) )
        {
            $message = sprintf(
                $message ?: 'Expected "%s" does not a exist in provided object.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_METHOD, $propertyPath);
        }
        return $this;
    }

    /**
     * Determines that the provided value is an object.
     *
     * @param null $message
     * @param null $propertyPath
     * @return $this
     */
    public function isObject($message = null, $propertyPath = null)
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_object($this->value) )
        {
            $message = sprintf(
                $message ?: 'Provided "%s" is not a valid object.',
                $this->stringify($this->value)
            );
            throw $this->createException($message, self::INVALID_OBJECT, $propertyPath);
        }
        return $this;
    }

    /**
     * Make a string version of a value.
     *
     * @param $value
     * @return string
     */
    private function stringify($value)
    {
        if ( is_bool($value) )
        {
            return $value ? '<TRUE>' : '<FALSE>';
        }
        if ( is_scalar($value) )
        {
            $val = (string)$value;
            if ( strlen($val) > 100 )
            {
                $val = substr($val, 0, 97) . '...';
            }
            return $val;
        }
        if ( is_array($value) )
        {
            return '<ARRAY>';
        }
        if ( is_object($value) )
        {
            return get_class($value);
        }
        if ( is_resource($value) )
        {
            return '<RESOURCE>';
        }
        if ( $value === null )
        {
            return '<NULL>';
        }
        return 'unknown';
    }
}

