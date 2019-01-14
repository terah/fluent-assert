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
 * AssertionFailedException
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Terry Cullen <terry@terah.com.au>
 *
 */
class AssertionFailedException extends \Exception
{
    private $fieldName;
    private $value;
    private $constraints;
    private $level;
    private $propertyPath;
    private $location;

    /**
     * AssertionFailedException constructor.
     *
     * @param string $message
     * @param int    $code
     * @param string $fieldName
     * @param        $value
     * @param array  $constraints
     * @param string $level
     * @param string $propertyPath
     */
    public function __construct(string $message, int $code, string $fieldName='', $value='', array $constraints=[], string $level='critical', string $propertyPath='')
    {
        parent::__construct($message, $code);
        $this->fieldName        = $fieldName;
        $this->value            = $value;
        $this->constraints      = $constraints;
        $this->level            = $level;
        $this->propertyPath     = $propertyPath;

        $trace                  = $this->getTrace();
        foreach ( $trace as $idx => $point )
        {
            $class                  = $point['class'] ??0?: '';
            if ( $class !== Assert::class )
            {
                $this->location         = isset($trace[$idx - 1]) ? (object)$trace[$idx - 1] : (object)$point;

                break;
            }
        }
    }

    /**
     * Get the field name that was set for the assertion object.
     *
     * @return string
     */
    public function getFieldName() : string
    {
        return $this->fieldName;
    }

    /**
     * Get the value that caused the assertion to fail.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the constraints that applied to the failed assertion.
     *
     * @return array
     */
    public function getConstraints() : array
    {
        return $this->constraints;
    }

    /**
     * Get the error level.
     *
     * @return string
     */
    public function getLevel() : string
    {
        return $this->level ? $this->level : 'critical';
    }

    /**
     * User controlled way to define a sub-property causing
     * the failure of a currently asserted objects.
     *
     * Useful to transport information about the nature of the error
     * back to higher layers.
     *
     * @return string
     */
    public function getPropertyPath() : string
    {
        return $this->propertyPath ? $this->propertyPath : 'General Error';
    }

    /**
     * Get the propertyPath, combined with the calling file and line location.
     *
     * @return string
     */
    public function getPropertyPathAndCallingLocation() : string
    {
        return $this->getPropertyPath() . ' in ' . $this->getCallingFileAndLine();
    }

    /**
     * Get the calling file and line from where the failing assertion
     * was called.
     *
     * @return string
     */
    protected function getCallingFileAndLine() : string
    {
        foreach ( $this->getTrace() as $trace )
        {
            $trace = (object)$trace;
            if ( empty($trace->file) )
            {
                continue;
            }
            $file = static::beforeLast('.php', static::afterLast('/', $trace->file));
            if ( in_array($file, ['AssertionChain', 'Assertion']) )
            {
                continue;
            }
            return "{$trace->file}:{$trace->line}";
        }

        return '';
    }

    /**
     * Get the trace location of where the failing assertion
     * was called.
     *
     * @return object
     */
    public function getLocation() : \stdClass
    {
        if ( ! $this->location )
        {
            return new \stdClass();
        }

        return $this->location;
    }

    /**
     * @param string $needle
     * @param string $haystack
     * @param bool $returnOriginal
     * @return string
     */
    public static function afterLast(string $needle, string $haystack, bool $returnOriginal=false) : string
    {
        if ( static::strrevpos($haystack, $needle) !== -1 )
        {
            return mb_substr($haystack, static::strrevpos($haystack, $needle) + mb_strlen($needle));
        }

        return $returnOriginal ? $haystack : '';
    }

    /**
     * @param string $string
     * @param string $needle
     * @return int
     */
    public static function strrevpos(string $string, string $needle) : int
    {
        $revStr = mb_strpos(strrev($string), strrev($needle));

        return $revStr === false ? -1 : mb_strlen($string) - $revStr - mb_strlen($needle);
    }

    /**
     * @param string $needle
     * @param string $haystack
     * @return string
     */
    public static function beforeLast(string $needle, string $haystack) : string
    {
        $position   = static::strrevpos($haystack, $needle);

        return $position === -1 ? '' : mb_substr($haystack, 0, static::strrevpos($haystack, $needle));
    }
}