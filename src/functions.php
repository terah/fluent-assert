<?php

namespace Terah\Assert;

/**
 * @param mixed      $value
 * @param bool|false $throwValidationError
 * @return Assert
 */
function Assert($value, $throwValidationError=false)
{
    if ( ! $throwValidationError )
    {
        return new Assert($value);
    }
    return (new Assert($value))->setExceptionClass('Terah\Assert\AssertionFailedException');
}

/**
 * @param mixed $value
 * @return Assert
 */
function Validate($value)
{
    return (new Assert($value))->setExceptionClass('Terah\Assert\ValidationFailedException');
}