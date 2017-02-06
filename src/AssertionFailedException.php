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

    public function __construct($message, $code, $propertyPath = null, $value, array $constraints = [], $level='critical')
    {
        parent::__construct($message, $code);
        $this->propertyPath     = $propertyPath;
        $this->value            = $value;
        $this->constraints      = $constraints;
        $this->level            = $level;
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
    public function getPropertyPath()
    {
        $calling_location = $this->getCallingFileAndLine();
        return $this->propertyPath . ' in ' .$calling_location;
    }

    /**
     * @return null|string
     */
    public function getProperty()
    {
        return $this->propertyPath ? $this->propertyPath : 'General Error';
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level ? $this->level : 'critical';
    }

    /**
     * @return string
     */
    protected function getCallingFileAndLine()
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

    public static function afterLast($needle, $haystack, $return_original=false)
    {
        if ( ! is_bool(static::strrevpos($haystack, $needle)) )
        {
            return mb_substr($haystack, static::strrevpos($haystack, $needle) + mb_strlen($needle));
        }
        return $return_original ? $haystack : '';
    }

    public static function strrevpos($string, $needle)
    {
        $revStr = mb_strpos(strrev($string), strrev($needle));
        return $revStr === false ? false : mb_strlen($string) - $revStr - mb_strlen($needle);
    }

    public static function beforeLast($needle, $haystack)
    {
        return mb_substr($haystack, 0, static::strrevpos($haystack, $needle));
    }
}
