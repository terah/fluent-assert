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
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */
class AssertionFailedException extends \Exception
{
    private $propertyPath;
    private $value;
    private $constraints;
    private $level;
    private $location;

    /**
     * AssertionFailedException constructor.
     * @param string $message
     * @param int $code
     * @param string $propertyPath
     * @param $value
     * @param array $constraints
     * @param string $level
     */
    public function __construct(string $message, int $code, string $propertyPath = null, $value, array $constraints=[], string $level='critical')
    {
        parent::__construct($message, $code);
        $this->propertyPath     = $propertyPath;
        $this->value            = $value;
        $this->constraints      = $constraints;
        $this->level            = $level;
        foreach ( $this->getTrace() as $point )
        {
            if ( $this->location )
            {
                continue;
            }
            $class = $point['class'] ?: '';
            if ( $class !== 'Terah\\Assert\\Assert' )
            {
                $this->location = (object)$point;
            }
        }
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
        $calling_location = $this->getCallingFileAndLine();

        return $this->propertyPath . ' in ' .$calling_location;
    }

    /**
     * @return null|string
     */
    public function getProperty() : string
    {
        return $this->propertyPath ? $this->propertyPath : 'General Error';
    }

    /**
     * @return string
     */
    public function getLevel() : string
    {
        return $this->level ? $this->level : 'critical';
    }

    /**
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
     * @return object
     */
    public function getLocation()
    {
        return $this->location;
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
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param string $needle
     * @param string $haystack
     * @param bool $return_original
     * @return string
     */
    public static function afterLast(string $needle, string $haystack, bool $return_original=false) : string
    {
        if ( static::strrevpos($haystack, $needle) !== -1 )
        {
            return mb_substr($haystack, static::strrevpos($haystack, $needle) + mb_strlen($needle));
        }

        return $return_original ? $haystack : '';
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
