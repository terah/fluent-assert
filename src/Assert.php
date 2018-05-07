<?php declare(strict_types=1);

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
    const INVALID_FLOAT                 = 1;
    const INVALID_INTEGER               = 2;
    const INVALID_DIGIT                 = 3;
    const INVALID_INTEGERISH            = 4;
    const INVALID_BOOLEAN               = 5;
    const VALUE_EMPTY                   = 6;
    const VALUE_NULL                    = 7;
    const INVALID_STRING                = 8;
    const INVALID_REGEX                 = 9;
    const INVALID_MIN_LENGTH            = 10;
    const INVALID_MAX_LENGTH            = 11;
    const INVALID_STRING_START          = 12;
    const INVALID_STRING_CONTAINS       = 13;
    const INVALID_CHOICE                = 14;
    const INVALID_NUMERIC               = 15;
    const INVALID_ARRAY                 = 16;
    const INVALID_KEY_EXISTS            = 17;
    const INVALID_NOT_BLANK             = 18;
    const INVALID_INSTANCE_OF           = 19;
    const INVALID_SUBCLASS_OF           = 20;
    const INVALID_RANGE                 = 21;
    const INVALID_ALNUM                 = 22;
    const INVALID_TRUE                  = 23;
    const INVALID_EQ                    = 24;
    const INVALID_SAME                  = 25;
    const INVALID_MIN                   = 26;
    const INVALID_MAX                   = 27;
    const INVALID_LENGTH                = 28;
    const INVALID_FALSE                 = 29;
    const INVALID_STRING_END            = 30;
    const INVALID_UUID                  = 31;
    const INVALID_COUNT                 = 32;
    const INVALID_NOT_EQ                = 33;
    const INVALID_NOT_SAME              = 34;
    const INVALID_TRAVERSABLE           = 35;
    const INVALID_ARRAY_ACCESSIBLE      = 36;
    const INVALID_KEY_ISSET             = 37;
    const INVALID_SAMACCOUNTNAME        = 38;
    const INVALID_USERPRINCIPALNAME     = 39;
    const INVALID_DIRECTORY             = 40;
    const INVALID_FILE                  = 41;
    const INVALID_READABLE              = 42;
    const INVALID_WRITEABLE             = 43;
    const INVALID_CLASS                 = 44;
    const INVALID_EMAIL                 = 45;
    const INTERFACE_NOT_IMPLEMENTED     = 46;
    const INVALID_URL                   = 47;
    const INVALID_NOT_INSTANCE_OF       = 48;
    const VALUE_NOT_EMPTY               = 49;
    const INVALID_JSON_STRING           = 50;
    const INVALID_OBJECT                = 51;
    const INVALID_METHOD                = 52;
    const INVALID_SCALAR                = 53;
    const INVALID_DATE                  = 54;
    const INVALID_CALLABLE              = 55;
    const INVALID_KEYS_EXIST            = 56;
    const INVALID_PROPERTY_EXISTS       = 57;
    const INVALID_PROPERTIES_EXIST      = 58;
    const INVALID_UTF8                  = 59;
    const INVALID_DOMAIN_NAME           = 60;
    const INVALID_NOT_FALSE             = 61;
    const INVALID_FILE_OR_DIR           = 62;
    const INVALID_ASCII                 = 63;
    const INVALID_NOT_REGEX             = 64;
    const INVALID_GREATER_THAN          = 65;
    const INVALID_LESS_THAN             = 66;
    const INVALID_GREATER_THAN_OR_EQ    = 67;
    const INVALID_LESS_THAN_OR_EQ       = 68;
    const INVALID_IP_ADDRESS            = 69;
    const INVALID_AUS_MOBILE            = 70;
    const INVALID_ISNI                  = 71;

    const EMERGENCY                     = 'emergency';
    const ALERT                         = 'alert';
    const CRITICAL                      = 'critical';
    const ERROR                         = 'error';
    const WARNING                       = 'warning';
    const NOTICE                        = 'notice';
    const INFO                          = 'info';
    const DEBUG                         = 'debug';

    /** @var bool */
    protected $nullOr                   = false;

    /** @var bool */
    protected $emptyOr                  = false;

    /** @var mixed */
    protected $value                    = null;

    /** @var bool */
    protected $all                      = false;

    /** @var string */
    protected $fieldName                = '';

    /** @var string */
    protected $propertyPath             = '';

    /** @var string */
    protected $level                    = 'critical';

    /** @var int */
    protected $overrideCode             = null;

    /** @var string */
    protected $overrideError            = '';
    
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected $exceptionClass           = AssertionFailedException::class;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value($value);
    }

    /**
     * @param \Closure[] $validators
     * @return array
     */
    public static function runValidators(array $validators) : array
    {
        $errors = [];
        foreach ( $validators as $fieldName => $validator )
        {
            try
            {
                $validator->__invoke();
            }
            catch ( AssertionFailedException $e )
            {
                $errors[$fieldName]     = $e->getMessage();
            }
        }

        return $errors;
    }

    /**
     * @param        $value
     * @param string $fieldName
     * @param int    $code
     * @param string $error
     * @param string $level
     * @return Assert
     */
    public static function that($value, string $fieldName='', int $code=0, string $error='', string $level=Assert::WARNING) : Assert
    {
        $assert = new static($value);
        if ( $fieldName )
        {
            $assert->fieldName($fieldName);
        }
        if ( $code )
        {
            $assert->code($code);
        }
        if ( $error )
        {
            $assert->error($error);
        }
        if ( $level )
        {
            $assert->level($level);
        }

        return $assert;
    }

    /**
     * @param mixed $value
     * @return Assert
     */
    public function reset($value) : Assert
    {
        return $this->all(false)->nullOr(false)->value($value);
    }

    /**
     * @param mixed $value
     * @return Assert
     */
    public function value($value) : Assert
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Allow value to pass assertion if it is null.
     *
     * @param bool $nullOr
     * @return Assert
     */
    public function nullOr(bool $nullOr = true) : Assert
    {
        $this->nullOr = $nullOr;

        return $this;
    }

    /**
     * Allow value to pass assertion if it is empty.
     *
     * @param bool $emptyOr
     * @return Assert
     */
    public function emptyOr(bool $emptyOr = true) : Assert
    {
        $this->emptyOr = $emptyOr;

        return $this;
    }

    /**
     * Assert all values in the value array.
     *
     * @param bool $all
     * @return Assert
     */
    public function all(bool $all = true) : Assert
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
     * @param string $fieldName
     * @param array  $constraints
     * @param string $level
     * @return AssertionFailedException
     */
    protected function createException(string $message, int $code, string $fieldName, array $constraints=[], string $level='') : AssertionFailedException
    {
        $exceptionClass = $this->exceptionClass;
        $fieldName      = empty($fieldName) ? $this->fieldName : $fieldName;
        $level          = empty($level) ? $this->level : $level;

        return new $exceptionClass($message, $code, $fieldName, $this->value, $constraints, $level, $this->propertyPath);
    }

    /**
     * @param string $exceptionClass
     * @return Assert
     */
    public function setExceptionClass(string $exceptionClass) : Assert
    {
        $this->exceptionClass = $exceptionClass;

        return $this;
    }

    /**
     * @param int $code
     * @return Assert
     */
    public function code(int $code) : Assert
    {
        $this->overrideCode = $code;

        return $this;
    }

    /**
     * @param string $fieldName
     * @return Assert
     */
    public function fieldName(string $fieldName) : Assert
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * @deprecated
     * @param string $fieldName
     * @return Assert
     */
    public function name(string $fieldName) : Assert
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * @param string $level
     * @return Assert
     */
    public function level(string $level) : Assert
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @param string $error
     * @return Assert
     */
    public function error(string $error) : Assert
    {
        $this->overrideError = $error;

        return $this;
    }

    /**
     * User controlled way to define a sub-property causing
     * the failure of a currently asserted objects.
     *
     * Useful to transport information about the nature of the error
     * back to higher layers.
     *
     * @param string $propertyPath
     * @return Assert
     */
    public function propertyPath(string $propertyPath) : Assert
    {
        $this->propertyPath = $propertyPath;

        return $this;
    }

    /**
     * Assert that value is equal to a provided value (using == ).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function eq($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value != $value2 )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" does not equal expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_EQ, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value is greater than a provided value (exclusive).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function greaterThan($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! ( $this->value > $value2 ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" does not greater then expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_EQ, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value is greater than or equal to a provided value (inclusive).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function greaterThanOrEq($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! ( $this->value >= $value2 ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" does not greater than or equal to expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_EQ, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value is less than a provided value (exclusive).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function lessThan($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! ( $this->value < $value2 ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" does not less then expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_LESS_THAN, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value is less than or equal to a provided value (inclusive).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function lessThanOrEq($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! ( $this->value <= $value2 ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" does not less than or equal to expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_LESS_THAN_OR_EQ, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value is the same as a provided value (using === ).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function same($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value !== $value2 )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not the same as expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_SAME, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value is not equal to a provided value (using == ).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEq($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value == $value2 )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is equal to expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_NOT_EQ, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value can be called as a function (using is_callable()).
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isCallable(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_callable($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not callable.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_NOT_EQ, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is not the same as a provided value (using === ).
     *
     * @param mixed  $value2
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notSame($value2, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value === $value2 )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is the same as expected value "%s".',
                $this->stringify($this->value),
                $this->stringify($value2)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_NOT_SAME, $fieldName, ['expected' => $value2]);
        }

        return $this;
    }

    /**
     * Assert that value is a valid ID (non-empty, non-zero, valid integer).
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function id(string $message='', string $fieldName='') : Assert
    {
        $message = $message ?: $this->overrideError;
        $message = $message ?: 'Value "%s" is not an integer id.';

        return $this->nonEmptyInt($message, $fieldName)->range(1, PHP_INT_MAX, $message, $fieldName);
    }

    /**
     * Assert that value is a unsigned int (non-empty valid integer, can be zero).
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function unsignedInt(string $message='', string $fieldName='') : Assert
    {
        $message = $message ?: $this->overrideError;
        $message = $message ?: 'Value "%s" is not an integer id.';

        return $this->int($message, $fieldName)->range(0, PHP_INT_MAX, $message, $fieldName);
    }

    /**
     * Assert that value is a valid flag (0 or 1).
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function flag(string $message='', string $fieldName='') : Assert
    {
        $message = $message ?: $this->overrideError;
        $message = $message ?: 'Value "%s" is not a 0 or 1.';

        return $this->range(0, 1, $message, $fieldName);
    }

    /**
     * Assert that value is a valid status (-1, 0, or 1).
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function status(string $message='', string $fieldName='') : Assert
    {
        $message = $message ?: $this->overrideError;
        $message = $message ?: 'Value "%s" is not a valid status.';

        return $this->integer($message, $fieldName)->inArray([-1, 0, 1]);
    }

    /**
     * Assert that value is null or a valid ID.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function nullOrId(string $message='', string $fieldName='') : Assert
    {
        return $this->nullOr()->id($message, $fieldName);
    }

    /**
     * Assert that values are all valid IDs.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function allIds(string $message='', string $fieldName='') : Assert
    {
        return $this->all()->id($message, $fieldName);
    }

    /**
     * Alias of {@see integer()}.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function int(string $message='', string $fieldName='') : Assert
    {
        return $this->integer($message, $fieldName);
    }

    /**
     * Assert that value is a valid PHP integer.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function integer(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_int($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not an integer.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_INTEGER, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a valid PHP float.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function float(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! is_float($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a float.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_FLOAT, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value (integer or integer'ish) is a digit.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function digit(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! ctype_digit((string)$this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a digit.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_DIGIT, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a valid date.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function date(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->notEmpty($message, $fieldName);
        if ( $this->value instanceof \DateTime )
        {
            return $this;
        }
        if ( strtotime($this->value) === false )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a date.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_DATE, $fieldName);
        }

        return $this;
    }

    /**
     * @param        $afterDate
     * @param string $message
     * @param string $fieldName
     * @return $this
     * @throws AssertionFailedException
     */
    public function after($afterDate, string $message='', string $fieldName='')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->notEmpty($message, $fieldName);
        if ( strtotime($this->value) === false && strtotime($afterDate) === false && strtotime($this->value) < strtotime($afterDate) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a date, comparison date is not a date or value is not before comparison date.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_DATE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a PHP integer'ish.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function integerish(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( is_object($this->value) || strval(intval($this->value)) != $this->value || is_bool($this->value) || is_null($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not an integer or a number castable to integer.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_INTEGERISH, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a valid PHP boolean.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function boolean(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! is_bool($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a boolean.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_BOOLEAN, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a valid PHP scalar.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function scalar(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! is_scalar($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a scalar.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_SCALAR, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is not empty.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEmpty(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ( is_object($this->value) && empty((array)$this->value) ) || empty($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is empty, but non empty value was expected.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::VALUE_EMPTY, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is empty.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function noContent(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !empty( $this->value ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not empty, but empty value was expected.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::VALUE_NOT_EMPTY, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is not null.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notNull(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value === null )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is null, but non null value was expected.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::VALUE_NULL, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a string
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function string(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_string($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" expected to be string, type %s given.',
                $this->stringify($this->value),
                gettype($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_STRING, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value matches a provided Regex.
     *
     * @param string $pattern
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function regex(string $pattern, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( ! preg_match($pattern, $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" does not match expression.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_REGEX, $fieldName, ['pattern' => $pattern]);
        }

        return $this;
    }

    /**
     * Assert that value is a valid IP address.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function ipAddress(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        $pattern   = '/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/';
        if ( ! preg_match($pattern, $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid IP Address',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_IP_ADDRESS, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value does not match a provided Regex.
     *
     * @param string $pattern
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notRegex(string $pattern, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( preg_match($pattern, $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" does not match expression.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_REGEX, $fieldName, ['pattern' => $pattern]);
        }

        return $this;
    }

    /**
     * Assert that value is a string and has a character count which is equal to a given length.
     *
     * @param int    $length
     * @param string $message
     * @param string $fieldName
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function length(int $length, string $message='', string $fieldName='', string $encoding='utf8') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( mb_strlen($this->value, $encoding) !== $length )
        {
            $message    = $message ?: $this->overrideError;
            $message    = sprintf(
                $message ?: 'Value "%s" has to be %d exactly characters long, but length is %d.',
                $this->stringify($this->value),
                $length,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['length' => $length, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_LENGTH, $fieldName, $constraints);
        }

        return $this;
    }

    /**
     * Assert that value is a string and has a character count which is
     * greater than or equal to a given lower limit ($minLength chars).
     *
     * @param int    $minLength
     * @param string $message
     * @param string $fieldName
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function minLength(int $minLength, string $message='', string $fieldName='', string $encoding='utf8') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( mb_strlen($this->value, $encoding) < $minLength )
        {
            $message = $message ?: $this->overrideError;
            $message     = sprintf(
                $message
                    ?: 'Value "%s" is too short, it should have more than %d characters, but only has %d characters.',
                $this->stringify($this->value),
                $minLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['min_length' => $minLength, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_MIN_LENGTH, $fieldName, $constraints);
        }

        return $this;
    }

    /**
     * Assert that value is a string and has a character count which is
     * less than or equal to given upper limit ($maxLength chars).
     *
     * @param int    $maxLength
     * @param string $message
     * @param string $fieldName
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function maxLength(int $maxLength, string $message='', string $fieldName='', string $encoding='utf8') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( mb_strlen($this->value, $encoding) > $maxLength )
        {
            $message = $message ?: $this->overrideError;
            $message     = sprintf(
                $message ?: 'Value "%s" is too long, it should have no more than %d characters, but has %d characters.',
                $this->stringify($this->value),
                $maxLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['max_length' => $maxLength, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_MAX_LENGTH, $fieldName, $constraints);
        }

        return $this;
    }

    /**
     * Assert that value has a length between min,max lengths (inclusive).
     *
     * @param int    $minLength
     * @param int    $maxLength
     * @param string $message
     * @param string $fieldName
     * @param string      $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function betweenLength(int $minLength, int $maxLength, string $message='', string $fieldName='', string $encoding='utf8') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( mb_strlen($this->value, $encoding) < $minLength )
        {
            $message = $message ?: $this->overrideError;
            $message     = sprintf(
                $message
                    ?: 'Value "%s" is too short, it should have more than %d characters, but only has %d characters.',
                $this->stringify($this->value),
                $minLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['min_length' => $minLength, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_MIN_LENGTH, $fieldName, $constraints);
        }
        if ( mb_strlen($this->value, $encoding) > $maxLength )
        {
            $message = $message ?: $this->overrideError;
            $message     = sprintf(
                $message ?: 'Value "%s" is too long, it should have no more than %d characters, but has %d characters.',
                $this->stringify($this->value),
                $maxLength,
                mb_strlen($this->value, $encoding)
            );
            $constraints = ['max_length' => $maxLength, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_MAX_LENGTH, $fieldName, $constraints);
        }

        return $this;
    }

    /**
     * Assert that value starts with a sequence of chars.
     *
     * @param string $needle
     * @param string $message
     * @param string $fieldName
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function startsWith(string $needle, string $message='', string $fieldName='', string $encoding='utf8') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( mb_strpos($this->value, $needle, 0, $encoding) !== 0 )
        {
            $message = $message ?: $this->overrideError;
            $message     = sprintf(
                $message ?: 'Value "%s" does not start with "%s".',
                $this->stringify($this->value),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_STRING_START, $fieldName, $constraints);
        }

        return $this;
    }

    /**
     * Assert that value ends with a sequence of chars.
     *
     * @param string $needle
     * @param string $message
     * @param string $fieldName
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function endsWith(string $needle, string $message='', string $fieldName='', string $encoding='utf8') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        $stringPosition = mb_strlen($this->value, $encoding) - mb_strlen($needle, $encoding);
        if ( mb_strripos($this->value, $needle, 0 , $encoding) !== $stringPosition )
        {
            $message = $message ?: $this->overrideError;
            $message     = sprintf(
                $message ?: 'Value "%s" does not end with "%s".',
                $this->stringify($this->value),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_STRING_END, $fieldName, $constraints);
        }

        return $this;
    }

    /**
     * Assert that value contains a sequence of chars.
     *
     * @param string $needle
     * @param string $message
     * @param string $fieldName
     * @param string $encoding
     * @return Assert
     * @throws AssertionFailedException
     */
    public function contains(string $needle, string $message='', string $fieldName='', string $encoding='utf8') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( mb_strpos($this->value, $needle, 0, $encoding) === false )
        {
            $message = $message ?: $this->overrideError;
            $message     = sprintf(
                $message ?: 'Value "%s" does not contain "%s".',
                $this->stringify($this->value),
                $this->stringify($needle)
            );
            $constraints = ['needle' => $needle, 'encoding' => $encoding];

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_STRING_CONTAINS, $fieldName, $constraints);
        }

        return $this;
    }

    /**
     * Assert that value is in an array of choices.
     *
     * @param array  $choices
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function choice(array $choices, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !in_array($this->value, $choices, true) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not an element of the valid values: %s',
                $this->stringify($this->value),
                implode(", ", array_map('Terah\Assert\Assert::stringify', $choices))
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_CHOICE, $fieldName, ['choices' => $choices]);
        }

        return $this;
    }

    /**
     * Alias of {@see choice()}
     *
     * @param array  $choices
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function inArray(array $choices, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->choice($choices, $message, $fieldName);

        return $this;
    }

    /**
     * Assert that value is numeric.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function numeric(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! is_numeric($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not numeric.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_NUMERIC, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a non-empty array.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function nonEmptyArray(string $message='', string $fieldName='') : Assert
    {
        $message = $message ?: 'Value "%s" is not a non-empty array.';

        return $this->isArray($message, $fieldName)->notEmpty($message, $fieldName);
    }

    /**
     * Assert that value is a non-empty int.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function nonEmptyInt(string $message='', string $fieldName='') : Assert
    {
        $message = $message ?: 'Value "%s" is not a non-empty integer.';

        return $this->integer($message, $fieldName)->notEmpty($message, $fieldName);
    }

    /**
     * Assert that value is a non-empty string.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function nonEmptyString(string $message='', string $fieldName='') : Assert
    {
        $message = $message ?: 'Value "%s" is not a non-empty string.';

        return $this->string($message, $fieldName)->notEmpty($message, $fieldName);
    }

    /**
     * Assert that value is an array.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isArray(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_array($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not an array.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_ARRAY, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is an array or a traversable object.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isTraversable(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_array($this->value) && !$this->value instanceof \Traversable )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not an array and does not implement Traversable.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_TRAVERSABLE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is an array or an array-accessible object.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isArrayAccessible(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_array($this->value) && !$this->value instanceof \ArrayAccess )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not an array and does not implement ArrayAccess.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_ARRAY_ACCESSIBLE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that key exists in the values array.
     *
     * @param string|integer $key
     * @param string         $message
     * @param string         $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keyExists($key, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isArray($message, $fieldName);
        if ( !array_key_exists($key, $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Array does not contain an element with key "%s"',
                $this->stringify($key)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_KEY_EXISTS, $fieldName, ['key' => $key]);
        }

        return $this;
    }

    /**
     * Assert that keys exist in the values array.
     *
     * @param array  $keys
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keysExist(array $keys, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isArray($message, $fieldName);
        foreach ( $keys as $key )
        {
            if ( !array_key_exists($key, $this->value) )
            {
                $message = $message
                    ?: sprintf(
                        'Array does not contain an element with key "%s"',
                        $this->stringify($key)
                    );
                throw $this->createException($message, $this->overrideCode ?: self::INVALID_KEYS_EXIST, $fieldName, ['key' => $key]);
            }
        }

        return $this;
    }

    /**
     * Assert that a property (key) exists in the values array.
     *
     * @param string|integer $key
     * @param string|null    $message
     * @param string|null    $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function propertyExists($key, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isObject($message, $fieldName);
        if ( !property_exists($this->value, $key) && !isset( $this->value->{$key} ) )
        {
            $message = $message
                ?: sprintf(
                    'Object does not contain a property with key "%s"',
                    $this->stringify($key)
                );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_PROPERTY_EXISTS, $fieldName, ['key' => $key]);
        }

        return $this;
    }

    /**
     * Assert that properties (keys) exist in the values array.
     *
     * @param array  $keys
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function propertiesExist(array $keys, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isObject($message, $fieldName);
        foreach ( $keys as $key )
        {
            // Using isset to allow resolution of magically defined properties
            if ( !property_exists($this->value, $key) && !isset( $this->value->{$key} ) )
            {
                $message = $message
                    ?: sprintf(
                        'Object does not contain a property with key "%s"',
                        $this->stringify($key)
                    );
                throw $this->createException($message, $this->overrideCode ?: self::INVALID_PROPERTIES_EXIST, $fieldName, ['key' => $key]);
            }
        }

        return $this;
    }

    /**
     * Assert that value is valid utf8.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function utf8(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( mb_detect_encoding($this->value, 'UTF-8', true) !== 'UTF-8' )
        {
            $message = $message
                ?: sprintf(
                    'Value "%s" was expected to be a valid UTF8 string',
                    $this->stringify($this->value)
                );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_UTF8, $fieldName);
        }

        return $this;
    }


    /**
     * Assert that value is valid ascii.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function ascii(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( ! preg_match('/^[ -~]+$/', $this->value) )
        {
            $message = $message
                ?: sprintf(
                    'Value "%s" was expected to be a valid ASCII string',
                    $this->stringify($this->value)
                );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_ASCII, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that key exists in an array/array-accessible object
     * (using isset()).
     *
     * @param string|integer $key
     * @param string|null    $message
     * @param string|null    $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function keyIsset($key, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->isArrayAccessible($message, $fieldName);
        if ( !isset( $this->value[$key] ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'The element with key "%s" was not found',
                $this->stringify($key)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_KEY_ISSET, $fieldName, ['key' => $key]);
        }

        return $this;
    }

    /**
     * Assert that key exists in an array/array-accessible object
     * and its value is not empty.
     *
     * @param string|integer $key
     * @param string|null    $message
     * @param string|null    $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notEmptyKey($key, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->keyIsset($key, $message, $fieldName);
        (new Assert($this->value[$key]))->setExceptionClass($this->exceptionClass)->notEmpty($message, $fieldName);

        return $this;
    }

    /**
     * Assert that value is not blank.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notBlank(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( false === $this->value || ( empty( $this->value ) && '0' != $this->value ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is blank, but was expected to contain a value.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_NOT_BLANK, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is an instance of a given class-name.
     *
     * @param string $className
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isInstanceOf(string $className, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !( $this->value instanceof $className ) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Class "%s" was expected to be instanceof of "%s" but is not.',
                $this->stringify($this->value),
                $className
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_INSTANCE_OF, $fieldName, ['class' => $className]);
        }

        return $this;
    }

    /**
     * Assert that value is not an instance of given class-name.
     *
     * @param string $className
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notIsInstanceOf(string $className, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value instanceof $className )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Class "%s" was not expected to be instanceof of "%s".',
                $this->stringify($this->value),
                $className
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_NOT_INSTANCE_OF, $fieldName, ['class' => $className]);
        }

        return $this;
    }

    /**
     * Assert that value is a subclass of given class-name.
     *
     * @param string $className
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function subclassOf(string $className, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_subclass_of($this->value, $className) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Class "%s" was expected to be subclass of "%s".',
                $this->stringify($this->value),
                $className
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_SUBCLASS_OF, $fieldName, ['class' => $className]);
        }

        return $this;
    }

    /**
     * Assert that value is within a range of numbers (inclusive).
     *
     * @param float    $minValue
     * @param float    $maxValue
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function range(float $minValue, float $maxValue, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->numeric($message, $fieldName);
        if ( $this->value < $minValue || $this->value > $maxValue )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at least "%d" and at most "%d".',
                $this->stringify($this->value),
                $this->stringify($minValue),
                $this->stringify($maxValue)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_RANGE, $fieldName, [
                'min' => $minValue,
                'max' => $maxValue
            ]);
        }

        return $this;
    }

    /**
     * Assert that value is larger or equal to a given lower limit.
     *
     * @param int    $minValue
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function min(int $minValue, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->numeric($message, $fieldName);
        if ( $this->value < $minValue )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at least "%d".',
                $this->stringify($this->value),
                $this->stringify($minValue)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_MIN, $fieldName, ['min' => $minValue]);
        }

        return $this;
    }

    /**
     * Assert that value is smaller than or equal to a given upper limit.
     *
     * @param int    $maxValue
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function max(int $maxValue, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->numeric($message, $fieldName);
        if ( $this->value > $maxValue )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Number "%s" was expected to be at most "%d".',
                $this->stringify($this->value),
                $this->stringify($maxValue)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_MAX, $fieldName, ['max' => $maxValue]);
        }

        return $this;
    }

    /**
     * Assert that value is a file that exists.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function file(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        $this->notEmpty($message, $fieldName);
        if ( !is_file($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'File "%s" was expected to exist.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_FILE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a file or directory that exists.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function fileOrDirectoryExists(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        $this->notEmpty($message, $fieldName);
        if ( ! file_exists($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'File or directory "%s" was expected to exist.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_FILE_OR_DIR, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a directory that exists.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function directory(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( !is_dir($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be a directory.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_DIRECTORY, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is something readable.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function readable(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( !is_readable($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be readable.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_READABLE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is something writeable.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function writeable(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( !is_writeable($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Path "%s" was expected to be writeable.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_WRITEABLE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a valid email address (using input_filter/FILTER_VALIDATE_EMAIL).
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function email(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        if ( ! filter_var($this->value, FILTER_VALIDATE_EMAIL) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid e-mail address.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_EMAIL, $fieldName);
        }
        else
        {
            $host = substr($this->value, strpos($this->value, '@') + 1);
            // Likely not a FQDN, bug in PHP FILTER_VALIDATE_EMAIL prior to PHP 5.3.3
            if ( version_compare(PHP_VERSION, '5.3.3', '<') && strpos($host, '.') === false )
            {
                $message = $message ?: $this->overrideError;
                $message = sprintf(
                    $message ?: 'Value "%s" was expected to be a valid e-mail address.',
                    $this->stringify($this->value)
                );
                throw $this->createException($message, $this->overrideCode ?: self::INVALID_EMAIL, $fieldName);
            }
        }

        return $this;
    }

    /**
     * Assert that value is a valid email prefix.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function emailPrefix(string $message='', string $fieldName='') : Assert
    {
        $this->value($this->value . '@example.com');

        return $this->email($message, $fieldName);
    }

    /**
     * Assert that value is a valid URL.
     *
     * This code snipped was taken from the Symfony project and modified to the special demands of this method.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     *
     *
     * @link https://github.com/symfony/Validator/blob/master/Constraints/UrlValidator.php
     * @link https://github.com/symfony/Validator/blob/master/Constraints/Url.php
     */
    public function url(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
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
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid URL starting with http or https',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_URL, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is domain name.
     *
     * This code snipped was taken from the Symfony project and modified to the special demands of this method.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     *
     */
    public function domainName(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->string($message, $fieldName);
        $pattern   = '/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}$/';
        if ( ! preg_match($pattern, $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" was expected to be a valid domain name',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_DOMAIN_NAME, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is alphanumeric.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function ausMobile(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        try
        {
            $this->regex('/^04([0-9]{8})$/', $message, $fieldName);
        }
        catch ( AssertionFailedException $e )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message
                    ?: 'Value "%s" is not an australian mobile number.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_AUS_MOBILE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is alphanumeric.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function alnum(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        try
        {
            $this->regex('(^([a-zA-Z]{1}[a-zA-Z0-9]*)$)', $message, $fieldName);
        }
        catch (AssertionFailedException $e)
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message
                    ?: 'Value "%s" is not alphanumeric, starting with letters and containing only letters and numbers.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_ALNUM, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is boolean True.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function true(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value !== true )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not TRUE.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_TRUE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is boolean True.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function truthy(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( ! $this->value )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not truthy.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_TRUE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is boolean False.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function false(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value !== false )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not FALSE.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_FALSE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is not boolean False.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function notFalse(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $this->value === false )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not FALSE.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_NOT_FALSE, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that the class exists.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function classExists(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !class_exists($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Class "%s" does not exist.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_CLASS, $fieldName);
        }

        return $this;
    }

    /**
     * @param string $interfaceName
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     * @throws \ReflectionException
     */
    public function implementsInterface(string $interfaceName, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $reflection = new \ReflectionClass($this->value);
        if ( !$reflection->implementsInterface($interfaceName) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Class "%s" does not implement interface "%s".',
                $this->stringify($this->value),
                $this->stringify($interfaceName)
            );

            throw $this->createException($message, self::INTERFACE_NOT_IMPLEMENTED, $fieldName, ['interface' => $interfaceName]);
        }

        return $this;
    }

    /**
     * Assert that value is a valid json string.
     *
     * NOTICE:
     * Since this does a json_decode to determine its validity
     * you probably should consider, when using the variable
     * content afterwards, just to decode and check for yourself instead
     * of using this assertion.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isJsonString(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( null === json_decode($this->value) && JSON_ERROR_NONE !== json_last_error() )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid JSON string.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_JSON_STRING, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a valid UUID.
     *
     * Uses code from {@link https://github.com/ramsey/uuid} that is MIT licensed.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function uuid(string $message='', string $fieldName='') : Assert
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
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid UUID.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_UUID, $fieldName);
        }

        return $this;
    }
    /**
     * Assert that value is a valid samAccountName (in line with Active
     * directory sAMAccountName restrictions for users).
     *
     * From: @link https://social.technet.microsoft.com/wiki/contents/articles/11216.active-directory-requirements-for-creating-objects.aspx#Objects_with_sAMAccountName_Attribute
     *      The schema allows 256 characters in sAMAccountName values. However, the system limits sAMAccountName to
     *      20 characters for user objects and 16 characters for computer objects. The following characters are not
     *      allowed in sAMAccountName values: " [ ] : ; | = + * ? < > / \ ,
     *      You cannot logon to a domain using a sAMAccountName that includes the "@" character. If a user has a
     *      sAMAccountName with this character, they must logon using their userPrincipalName (UPN).
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function samAccountName(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !preg_match('/^([a-z0-9]{4,20})$/', $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid samAccountName.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_SAMACCOUNTNAME, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is a valid userPrincipalName.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function userPrincipalName(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        try
        {
            $this->email($message, $fieldName);
        }
        catch (AssertionFailedException $e)
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message
                    ?: 'Value "%s" is not a valid userPrincipalName.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_USERPRINCIPALNAME, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that the given string is a valid UUID
     *
     * Uses code from {@link https://github.com/ramsey/uuid} that is MIT licensed.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isni(string $message='', string $fieldName='')
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !preg_match('/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]{1}$/', $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Value "%s" is not a valid ISNI.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_ISNI, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that the count of countable is equal to count.
     *
     * @param int    $count
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function count(int $count, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( $count !== count($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'List does not contain exactly "%d" elements.',
                $this->stringify($this->value),
                $this->stringify($count)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_COUNT, $fieldName, ['count' => $count]);
        }

        return $this;
    }

    /**
     * @param $func
     * @param $args
     * @return bool
     * @throws AssertionFailedException
     */
    protected function doAllOrNullOr($func, $args) : bool
    {
        if ( $this->nullOr && is_null($this->value) )
        {
            return true;
        }
        if ( $this->emptyOr && empty($this->value) )
        {
            return true;
        }
        if ( $this->all && (new Assert($this->value))->setExceptionClass($this->exceptionClass)->isTraversable() )
        {
            foreach ( $this->value as $idx => $value )
            {
                $object = (new Assert($value))->setExceptionClass($this->exceptionClass);
                call_user_func_array([$object, $func], $args);
            }
            return true;
        }

        return ( $this->nullOr && is_null($this->value) ) || ( $this->emptyOr && empty($this->value) ) ? true : false;
    }

    /**
     * Assert if values array has every choice as key and that this choice has content.
     *
     * @param array  $choices
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function choicesNotEmpty(array $choices, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        $this->notEmpty($message, $fieldName);
        foreach ( $choices as $choice )
        {
            $this->notEmptyKey($choice, $message, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that the named method is defined in the provided object.
     *
     * @param mixed $object
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function methodExists($object, string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        (new Assert($object))->setExceptionClass($this->exceptionClass)->isObject($message, $fieldName);
        if ( !method_exists($object, $this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Expected "%s" does not a exist in provided object.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_METHOD, $fieldName);
        }

        return $this;
    }

    /**
     * Assert that value is an object.
     *
     * @param string $message
     * @param string $fieldName
     * @return Assert
     * @throws AssertionFailedException
     */
    public function isObject(string $message='', string $fieldName='') : Assert
    {
        if ( $this->doAllOrNullOr(__FUNCTION__, func_get_args()) )
        {
            return $this;
        }
        if ( !is_object($this->value) )
        {
            $message = $message ?: $this->overrideError;
            $message = sprintf(
                $message ?: 'Provided "%s" is not a valid object.',
                $this->stringify($this->value)
            );

            throw $this->createException($message, $this->overrideCode ?: self::INVALID_OBJECT, $fieldName);
        }

        return $this;
    }

    /**
     * Make a string version of a value.
     *
     * @param $value
     * @return string
     */
    private function stringify($value) : string
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

