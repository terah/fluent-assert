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
 * Assert and Validate functions
 *
 * @author Terry Cullen <terry@terah.com.au>
 *
 */

/**
 * Instantiate and return an Assert object, set to @throw AssertionFailedException.
 *
 * @param mixed  $value
 * @param string $fieldName
 * @param int    $code
 * @param string $error
 * @param string $level
 * @return Assert
 */
function Assert($value, $fieldName='', $code=0, $error='', $level=Assert::WARNING)
{
    $assert = new Assert($value);
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
 * Instantiate and return an Assert object, set to @throw ValidationFailedException.
 *
 * @param mixed  $value
 * @param string $fieldName
 * @param int    $code
 * @param string $error
 * @param string $level
 * @return Assert
 */
function Validate($value, $fieldName='', $code=0, $error='', $level=Assert::WARNING)
{
    $assert = new Assert($value);
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

    $assert->setExceptionClass('Terah\Assert\ValidationFailedException');
    return $assert;
}