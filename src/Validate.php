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
 * Validate
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Terry Cullen <terry@terah.com.au>
 *
 */

class Validate extends Assert
{
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected $exceptionClass           = 'Terah\Assert\ValidationFailedException';
}