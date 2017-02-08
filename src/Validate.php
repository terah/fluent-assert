<?php

namespace Terah\Assert;


class Validate extends Assert
{
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected $exceptionClass           = 'Terah\Assert\ValidationFailedException';
}