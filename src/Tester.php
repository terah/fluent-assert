<?php declare(strict_types=1);

namespace Terah\Assert;

use Closure;

class Tester
{
    const DEFAULT_SUITE             = 'default';

    /** @var string  */
    protected static $currentSuite  = self::DEFAULT_SUITE;

    /** @var Suite[]  */
    protected static $suites        = [];

    /** @var Logger $logger */
    public static $logger           = null;

    /**
     * @return bool
     */
    public static function init() : bool
    {
        return true;
    }

    /**
     * @param string $suiteName
     * @return Suite
     */
    public static function suite(string $suiteName='') : Suite
    {
        $suiteName                  = $suiteName ?: static::$currentSuite;
        static::$suites[$suiteName] = new Suite();

        return static::$suites[$suiteName];
    }

    /**
     * @param string   $testName
     * @param Closure  $test
     * @param string   $suiteName
     * @param string   $successMessage
     * @param int|null $exceptionCode
     * @param string   $exceptionClass
     * @return Suite
     * @throws AssertionFailedException
     */
    public static function test(string $testName, Closure $test, string $suiteName='', string $successMessage='', int $exceptionCode=0, string $exceptionClass='') : Suite
    {
        Assert::that($successMessage)->notEmpty();
        Assert::that($test)->isCallable();
        Assert::that($suiteName)->notEmpty();

        return static::suite($suiteName)->test($testName, $test, $successMessage, $exceptionCode, $exceptionClass);
    }

    /**
     * @param string $suiteName
     * @param string $testName
     * @return array
     */
    public static function run(string $suiteName='', string $testName='') : array
    {
        $totalFailed    = 0;
        $totalTests     = 0;
        $suites         = static::$suites;
        if ( ! empty($suiteName) )
        {
            Assert::that($suites)->keyExists($suiteName, "The test suite ({$suiteName}) has not been loaded");
            $suites         = [$suites[$suiteName]];
        }
        foreach ( $suites as $suite )
        {
            $totalFailed    += $suite->run($testName);
            $totalTests     += $suite->totalTestsCount();
        }
        
        return compact('totalFailed', 'totalTests');
    }

    /**
     * @return Logger
     */
    public static function getLogger() : Logger
    {
        if ( ! static::$logger )
        {
            static::$logger = new Logger();
        }

        return static::$logger;
    }

    /**
     * @param string $suiteName
     * @return Suite
     */
    protected static function getSuite(string $suiteName='') : Suite
    {
        $suiteName                  = $suiteName ?: static::$currentSuite;
        if ( ! array_key_exists($suiteName, static::$suites) )
        {
            return static::suite($suiteName);
        }

        return static::$suites[$suiteName];
    }


    /**
     * @param string $inputFile
     * @param string $outputPath
     * @return bool
     */
    public static function generateTest(string $inputFile, string $outputPath) : bool
    {
        //Assert::that($inputFile)->classExists();
        $declaredClasses    = get_declared_classes();
        require $inputFile; //one or more classes in file, contains class class1, class2, etc...

        $className          = array_values(array_diff_key(get_declared_classes(), $declaredClasses));

        $reflectionClass    = new \ReflectionClass($className[0]);
        $publicMethods      = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
        $fullClassName      = $reflectionClass->getName();
        $className          = $reflectionClass->getShortName();
        $namespace          = $reflectionClass->getNamespaceName();
        $constructorParams  = '';
        foreach ( $publicMethods as $method )
        {
            if ( $method->isConstructor() )
            {
                $constructorParams  = static::getMethodParams($method);
            }
        }
        $objectInit         = "new {$fullClassName}({$constructorParams})";
        $output             = [];
        $output[]           = <<<PHP
<?php declare(strict_types=1);

namespace {$namespace}\Test;

use Terah\Assert\Assert;
use Terah\Assert\Tester;
use Terah\Assert\Suite;

Tester::suite('AssertSuite')

    ->fixture('testSubject', {$objectInit})
PHP;

        foreach ( $publicMethods as $method )
        {
            $methodName         = $method->getName();
            $methodParams       = static::getMethodParams($method);
            $testName           = 'test' . ucfirst($methodName);
            $successArgs        = static::getMethodArgs($method);
            $failArgs           = static::getMethodArgs($method, '    ');
            $returnVal          = static::getReturnVal($method);
            $methodSignature    = "\$suite->getFixture('testSubject')->{$methodName}({$methodParams})";

            if ( $method->isStatic() )
            {
                $methodSignature = "{$className}::{$methodName}({$methodParams})";
            }

            $output[] = <<<PHP
            
    ->test('{$testName}Success', function(Suite \$suite) {

        {$successArgs}
        \$actual                         = {$methodSignature};
        \$expected                       = {$returnVal};

        Assert::that(\$actual))->eq(\$expected, 'The method ({$methodName}) did not produce the correct output');
    })
    
    ->test('{$testName}Failure', function(Suite \$suite) {

        {$failArgs}
        \$actual                         = {$methodSignature};
        \$expected                       = {$returnVal};

        Assert::that(\$actual))->eq(\$expected, 'The method ({$methodName}) did not produce the correct output');
        
    }, '', Assert::INVALID_INTEGER, AssertionFailedException::class)
PHP;

        }

        $output[] = "    ;";

        return static::createDirectoriesAndSaveFile($outputPath, implode("\n", $output));
    }


    /**
     * @param string    $filePath
     * @param string    $data
     * @param int $flags
     * @param int $dirMode
     * @return bool
     */
    protected static function createDirectoriesAndSaveFile(string $filePath, $data, $flags=0, $dirMode=0755) : bool
    {
        static::createParentDirectories($filePath, $dirMode);
        Assert::that(file_put_contents($filePath, $data, $flags))->notFalse("Failed to put contents in file ({$filePath})");

        return true;
    }

    /**
     * @param string $filePath
     * @param int $mode
     * @return bool
     */
    protected static function createParentDirectories(string $filePath, $mode=0755) : bool
    {
        $directoryPath  = preg_match('/.*\//', $filePath);
        Assert::that($filePath)
            ->notEmpty("Failed to identify path ({$directoryPath}) to create")
            ->notEq(DIRECTORY_SEPARATOR, "Failed to identify path ({$directoryPath}) to create");
        if ( file_exists($directoryPath) )
        {
            Assert::that(is_dir($directoryPath))->notFalse("Failed to create parent directories.. files exists and is not a directory({$directoryPath})");

            return true;
        }
        Assert::that(mkdir($directoryPath, $mode, true))->notFalse("Failed to create parent directories ({$directoryPath})");
        Assert::that($directoryPath)->directory();

        return true;
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    protected static function getMethodParams(\ReflectionMethod $method) : string
    {
        $output = [];
        foreach ( $method->getParameters() as $param )
        {
            $output[] = '$' . $param->getName();
        }

        return implode(', ', $output);
    }

    /**
     * @param \ReflectionMethod $method
     * @param string $extraPadding
     * @return string
     */
    protected static function getMethodArgs(\ReflectionMethod $method, string $extraPadding='') : string
    {
        $output     = [];
        $params     = $method->getParameters();
        foreach ( $params as $param )
        {
            $type       = $param->hasType() ? $param->getType()->_toString() : '';
            $paramDef   = str_pad('$' . $param->getName(), 32, ' ') . '= ';
            $paramDef   .= static::getDefaultValue($type);
            $output[]   = $paramDef . ';';
        }

        return implode("\n        {$extraPadding}", $output);
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    protected static function getReturnVal(\ReflectionMethod $method) : string
    {

        $returnType = $method->hasReturnType() ? $method->getReturnType()->_toString() : '';

        return static::getDefaultValue($returnType);
    }

    /**
     * @param string $type
     * @param string $default
     * @return string
     */
    protected static function getDefaultValue(string $type='', string $default='null') : string
    {
        $typeMap    = [
            'int'           => "0",
            'float'         => "0.0",
            'string'        => "''",
            'bool'          => "false",
            'stdClass'      => "new stdClass",
            'array'         => "[]",
        ];

        return $typeMap[$type] ?? $default;
    }
}


class Suite
{
    /** @var Test[] */
    protected $tests        = [];

    /** @var mixed[] */
    protected $fixtures     = [];

    /** @var Logger */
    protected $logger       = null;
    
    /** @var int **/
    protected $failedCount  = 0;
    
    /**
     * @param string $filter
     * @return int
     */
    public function run(string $filter='') : int
    {
        foreach ( $this->tests as $test => $testCase )
        {
            $testName   = $testCase->getTestName();
            if ( $filter && $test !== $filter )
            {
                continue;
            }
            try
            {
                $this->getLogger()->info("[{$testName}] - Starting...");
                $testCase->runTest($this);
                $this->getLogger()->info("[{$testName}] - " . $testCase->getSuccessMessage());
            }
            catch ( \Exception $e )
            {
                $expectedCode       = $testCase->getExceptionCode();
                $expectedClass      = $testCase->getExceptionType();
                $code               = $e->getCode();
                $exception          = get_class($e);
                if ( ! $expectedClass &&  ! $expectedCode )
                {
                    $this->getLogger()->error($e->getMessage(), [compact('testName'), $e]);
                    $this->failedCount++;

                    continue;
                }
                if ( $expectedCode && $expectedCode !== $code )
                {
                    $this->getLogger()->error("Exception code({$code}) was expected to be ({$expectedCode})", [compact('testName'), $e]);
                    $this->failedCount++;
                    
                    continue;
                }
                if ( $expectedClass && $expectedClass !== $exception )
                {
                    $this->getLogger()->error("Exception class({$exception}) was expected to be ({$expectedClass})", [compact('testName'), $e]);
                    $this->failedCount++;
                    
                    continue;
                }
                $this->getLogger()->info("[{$test}] - " . $testCase->getSuccessMessage());
            }
        }
        
        return $this->failedTestsCount();
    }
    
    /**
     * @return int
     */  
    public function totalTestsCount() : int
    {
        return count($this->tests);
    }
        
    /**
     * @return int
     */  
    public function failedTestsCount() : int
    {
        return $this->failedCount;
    }

    /**
     * @param string   $testName
     * @param Closure  $test
     * @param string   $successMessage
     * @param int|null $exceptionCode
     * @param string   $exceptionClass
     * @return Suite
     * @throws AssertionFailedException
     */
    public function test(string $testName, Closure $test, string $successMessage='', int $exceptionCode=0, string $exceptionClass='') : Suite
    {
        $this->tests[]  = new Test($testName, $test, $successMessage, $exceptionCode, $exceptionClass);

        return $this;
    }

    /**
     * @param string $fixtureName
     * @param        $value
     * @return Suite
     */
    public function fixture(string $fixtureName, $value) : Suite
    {
        $this->fixtures[$fixtureName]  = $value;

        return $this;
    }

    /**
     * @param string $fixtureName
     * @return mixed
     * @throws AssertionFailedException
     */
    public function getFixture(string $fixtureName)
    {
        Assert::that($this->fixtures)->keyExists($fixtureName, "The fixture ({$fixtureName}) does not exist.");

        return $this->fixtures[$fixtureName];
    }


    /**
     * @param Logger $logger
     * @return $this
     */
    public function setLogger(Logger $logger) : Suite
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return Logger
     */
    public function getLogger() : Logger
    {
        if ( ! $this->logger )
        {
            $this->logger = new Logger();
        }

        return $this->logger;
    }

}

class Test
{
    /** @var string  */
    public $testName        = '';

    /** @var string  */
    public $successMessage  = '';

    /** @var Closure  */
    public $test            = null;

    /** @var string */
    public $exceptionType   = null;

    /** @var int */
    public $exceptionCode   = null;

    /**
     * Test constructor.
     *
     * @param string   $testName
     * @param Closure  $test
     * @param string   $successMessage
     * @param int|null $exceptionCode
     * @param string   $exceptionClass
     * @throws AssertionFailedException
     */
    public function __construct(string $testName, Closure $test, string $successMessage='', int $exceptionCode=0, string $exceptionClass='')
    {
        $this->setTestName($testName);
        $this->setTest($test);
        $this->setSuccessMessage($successMessage);
        $this->setExceptionCode($exceptionCode);
        $this->setExceptionType($exceptionClass);
    }

    /**
     * @return string
     */
    public function getTestName() : string
    {
        return $this->testName;
    }

    /**
     * @param string $testName
     * @return Test
     */
    public function setTestName(string $testName) : Test
    {
        Assert::that($testName)->notEmpty();

        $this->testName = $testName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuccessMessage() : string
    {
        if ( ! $this->successMessage )
        {
            return "Successfully run {$this->testName}";
        }

        return $this->successMessage;
    }

    /**
     * @param string $successMessage
     * @return Test
     * @throws AssertionFailedException
     */
    public function setSuccessMessage(string $successMessage) : Test
    {
        $this->successMessage = $successMessage;

        return $this;
    }

    /**
     * @return Closure
     */
    public function getTest() : Closure
    {
        return $this->test;
    }

    /**
     * @param Closure $test
     * @return Test
     */
    public function setTest(Closure $test) : Test
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return string
     */
    public function getExceptionType() : string
    {
        return $this->exceptionType;
    }

    /**
     * @param string $exceptionType
     * @return Test
     */
    public function setExceptionType(string $exceptionType) : Test
    {
        $this->exceptionType = $exceptionType;

        return $this;
    }

    /**
     * @return int
     */
    public function getExceptionCode() : int
    {
        return $this->exceptionCode;
    }

    /**
     * @param int $exceptionCode
     * @return Test
     */
    public function setExceptionCode(int $exceptionCode) : Test
    {
        $this->exceptionCode = $exceptionCode;

        return $this;
    }

    /**
     * @param Suite $suite
     * @return mixed
     */
    public function runTest(Suite $suite)
    {
        return $this->getTest()->__invoke($suite);
    }
}

/**
 * Class Logger
 *
 * @package Terah\Assert
 */
class Logger
{
    const EMERGENCY     = 'emergency';
    const ALERT         = 'alert';
    const CRITICAL      = 'critical';
    const ERROR         = 'error';
    const WARNING       = 'warning';
    const NOTICE        = 'notice';
    const INFO          = 'info';
    const DEBUG         = 'debug';

    const BLACK         = 'black';
    const DARK_GRAY     = 'dark_gray';
    const BLUE          = 'blue';
    const LIGHT_BLUE    = 'light_blue';
    const GREEN         = 'green';
    const LIGHT_GREEN   = 'light_green';
    const CYAN          = 'cyan';
    const LIGHT_CYAN    = 'light_cyan';
    const RED           = 'red';
    const LIGHT_RED     = 'light_red';
    const PURPLE        = 'purple';
    const LIGHT_PURPLE  = 'light_purple';
    const BROWN         = 'brown';
    const YELLOW        = 'yellow';
    const MAGENTA       = 'magenta';
    const LIGHT_GRAY    = 'light_gray';
    const WHITE         = 'white';
    const DEFAULT       = 'default';
    const BOLD          = 'bold';

    /**  @var resource $resource The file handle */
    protected $resource         = null;

    /** @var string $level */
    protected $level            = self::INFO;

    /** @var bool $closeLocally */
    protected $closeLocally     = false;

    /** @var bool */
    protected $addDate          = true;

    /** @var string  */
    protected $separator        = ' | ';

    /** @var \Closure */
    protected $formatter        = null;

    /** @var string  */
    protected $lastLogEntry     = '';

    /** @var bool|null  */
    protected $gzipFile         = null;

    /** @var bool  */
    protected $useLocking       = false;

    /**
     * @var array $logLevels List of supported levels
     */
    static protected $logLevels       = [
        self::EMERGENCY => [1, self::WHITE,       self::RED,      self::DEFAULT,  'EMERG'],
        self::ALERT     => [2, self::WHITE,       self::YELLOW,   self::DEFAULT,  'ALERT'],
        self::CRITICAL  => [3, self::RED,         self::DEFAULT,  self::BOLD ,    'CRIT'],
        self::ERROR     => [4, self::RED,         self::DEFAULT,  self::DEFAULT,  'ERROR'],
        self::WARNING   => [5, self::YELLOW,      self::DEFAULT,  self::DEFAULT,  'WARN'],
        self::NOTICE    => [6, self::CYAN,        self::DEFAULT,  self::DEFAULT,  'NOTE'],
        self::INFO      => [7, self::GREEN,       self::DEFAULT,  self::DEFAULT,  'INFO'],
        self::DEBUG     => [8, self::LIGHT_GRAY,  self::DEFAULT,  self::DEFAULT,  'DEBUG'],
    ];

    /**
     * @var array
     */
    static protected $colours   = [
        'fore' => [
            self::BLACK         => '0;30',
            self::DARK_GRAY     => '1;30',
            self::BLUE          => '0;34',
            self::LIGHT_BLUE    => '1;34',
            self::GREEN         => '0;32',
            self::LIGHT_GREEN   => '1;32',
            self::CYAN          => '0;36',
            self::LIGHT_CYAN    => '1;36',
            self::RED           => '0;31',
            self::LIGHT_RED     => '1;31',
            self::PURPLE        => '0;35',
            self::LIGHT_PURPLE  => '1;35',
            self::BROWN         => '0;33',
            self::YELLOW        => '1;33',
            self::MAGENTA       => '0;35',
            self::LIGHT_GRAY    => '0;37',
            self::WHITE         => '1;37',
        ],
        'back'  => [
            self::DEFAULT       => '49',
            self::BLACK         => '40',
            self::RED           => '41',
            self::GREEN         => '42',
            self::YELLOW        => '43',
            self::BLUE          => '44',
            self::MAGENTA       => '45',
            self::CYAN          => '46',
            self::LIGHT_GRAY    => '47',
        ],
        self::BOLD => [],
    ];

    /**
     * @param mixed  $resource
     * @param string $level
     * @param bool   $useLocking
     * @param bool   $gzipFile
     * @param bool   $addDate
     */
    public function __construct($resource=STDOUT, string $level=self::INFO, bool $useLocking=false, bool $gzipFile=false, bool $addDate=true)
    {
        $this->resource     = $resource;
        $this->setLogLevel($level);
        $this->useLocking   = $useLocking;
        $this->gzipFile     = $gzipFile;
        $this->addDate      = $addDate;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     */
    public function emergency(string $message, array $context=[])
    {
        $this->log(self::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     */
    public function alert(string $message, array $context=[])
    {
        $this->log(self::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     */
    public function critical(string $message, array $context=[])
    {
        $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     */
    public function error(string $message, array $context=[])
    {
        $this->log(self::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     */
    public function warning(string $message, array $context=[])
    {
        $this->log(self::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     */
    public function notice(string $message, array $context=[])
    {
        $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     */
    public function info(string $message, array $context=[])
    {
        $this->log(self::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     */
    public function debug(string $message, array $context=[])
    {
        $this->log(self::DEBUG, $message, $context);
    }

    /**
     * @param $resource
     * @return Logger
     */
    public function setLogFile($resource) : Logger
    {
        $this->resource     = $resource;

        return $this;
    }

    /**
     * @param string $string
     * @param string $foregroundColor
     * @param string $backgroundColor
     * @param bool $bold
     * @return string
     */
    public static function addColour(string $string, string $foregroundColor='', string $backgroundColor='', bool $bold=false) : string
    {
        // todo: support bold
        unset($bold);
        $coloredString = '';
        // Check if given foreground color found
        if ( isset(static::$colours['fore'][$foregroundColor]) )
        {
            $coloredString .= "\033[" . static::$colours['fore'][$foregroundColor] . "m";
        }
        // Check if given background color found
        if ( isset(static::$colours['back'][$backgroundColor]) )
        {
            $coloredString .= "\033[" . static::$colours['back'][$backgroundColor] . "m";
        }
        // Add string and end coloring
        $coloredString .=  $string . "\033[0m";

        return $coloredString;
    }

    /**
     * @param string    $string
     * @param string    $foregroundColor
     * @param string    $backgroundColor
     * @param bool      $bold
     * @return string
     */
    public function colourize(string $string, string $foregroundColor='', string $backgroundColor='', bool $bold=false) : string
    {
        return static::addColour($string, $foregroundColor, $backgroundColor, $bold);
    }

    /**
     * @param string $level Ignore logging attempts at a level less the $level
     * @return Logger
     */
    public function setLogLevel(string $level) : Logger
    {
        if ( ! isset(static::$logLevels[$level]) )
        {
            throw new \InvalidArgumentException("Log level is invalid");
        }
        $this->level = static::$logLevels[$level][0];

        return $this;
    }

    /**
     * @return Logger
     */
    public function lock() : Logger
    {
        $this->useLocking = true;

        return $this;
    }

    /**
     * @return Logger
     */
    public function gzipped() : Logger
    {
        $this->gzipFile = true;

        return $this;
    }

    /**
     * @param callable $fnFormatter
     *
     * @return Logger
     */
    public function formatter(callable $fnFormatter) : Logger
    {
        $this->formatter = $fnFormatter;

        return $this;
    }

    /**
     * Log messages to resource
     *
     * @param mixed          $level    The level of the log message
     * @param string|object  $message  If an object is passed it must implement __toString()
     * @param array          $context  Placeholders to be substituted in the message
     */
    public function log($level, $message, array $context=[])
    {
        $level = isset(static::$logLevels[$level]) ? $level : self::INFO;
        list($logLevel, $fore, $back, $style) = static::$logLevels[$level];
        unset($style);
        if ( $logLevel > $this->level )
        {
            return ;
        }
        if ( is_callable($this->formatter) )
        {
            $message = $this->formatter->__invoke(static::$logLevels[$level][4], $message, $context);
        }
        else
        {
            $message = $this->formatMessage($level, $message, $context);
        }
        $this->lastLogEntry = $message;
        $this->write($this->colourize($message, $fore, $back) . PHP_EOL);
    }

    /**
     * @param string $style
     * @param string $message
     * @return string
     */
    public static function style(string $style, string $message) : string
    {
        $style = isset(static::$logLevels[$style]) ? $style : self::INFO;
        list($logLevel, $fore, $back, $style) = static::$logLevels[$style];
        unset($logLevel, $style);

        return static::addColour($message, $fore, $back);
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     * @return string
     */
    protected function formatMessage(string $level, string $message, array $context=[]) : string
    {
        # Handle objects implementing __toString
        $message            = (string) $message;
        $message            .= empty($context) ? '' : PHP_EOL . json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $data               = $this->addDate ? ['date' => date('Y-m-d H:i:s')] : [];
        $data['level']      = strtoupper(str_pad(static::$logLevels[$level][4], 5, ' ', STR_PAD_RIGHT));
        $data['message']    = $message;

        return implode($this->separator, $data);
    }

    /**
     * Write the content to the stream
     *
     * @param  string $content
     */
    public function write(string $content)
    {
        $resource = $this->getResource();
        if ( $this->useLocking )
        {
            flock($resource, LOCK_EX);
        }
        gzwrite($resource, $content);
        if ( $this->useLocking )
        {
            flock($resource, LOCK_UN);
        }
    }

    /**
     * @return mixed|resource
     * @throws \Exception
     */
    protected function getResource()
    {
        if ( is_resource($this->resource) )
        {
            return $this->resource;
        }
        $fileName               = $this->resource;
        $this->closeLocally     = true;
        $this->resource         = $this->openResource();
        if ( ! is_resource($this->resource) )
        {
            throw new \Exception("The resource ({$fileName}) could not be opened");
        }

        return $this->resource;
    }

    /**
     * @return string
     */
    public function getLastLogEntry() : string
    {
        return $this->lastLogEntry;
    }

    /**
     * @return resource
     */
    protected function openResource()
    {
        if ( $this->gzipFile )
        {
            return gzopen($this->resource, 'a');
        }

        return fopen($this->resource, 'a');
    }

    public function __destruct()
    {
        if ($this->closeLocally)
        {
            gzclose($this->getResource());
        }
    }
}
