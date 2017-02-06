<?php declare(strict_types=1);

namespace Terah\Assert;

/**
 * @param mixed      $value
 * @param bool|false $throwValidationError
 * @return Assert
 */
function Assert($value, $throwValidationError=false)
{
    $assert = new Assert($value);
    if ( ! $throwValidationError )
    {
        return $assert;
    }
    return $assert->setExceptionClass('Terah\Assert\AssertionFailedException');
}

/**
 * @param mixed $value
 * @param string $name
 * @param int    $code
 * @param string $error
 * @param string $level
 * @return Assert
 */
function Validate($value, $name='', $code=0, $error='', $level=Assert::WARNING)
{
    $assert = new Assert($value);
    $assert->setExceptionClass('Terah\Assert\ValidationFailedException');
    if ( $name )
    {
        $assert->name($name);
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