#!/usr/bin/env php
<?php declare(strict_types=1);

use Terah\Assert\Tester;

require_once __DIR__ . '/../vendor/autoload.php';

class TestRunner
{
    public static function run()
    {
        $fileName       = (string)static::getArg(1, getcwd());
        $suite          = (string)static::getArg('suite', '');
        $test           = (string)static::getArg('test', '');
        $recursive      = (bool)static::getArg('recursive', true);
        $generate       = (string)static::getArg('generate', '');
        $output         = (string)static::getArg('output', '');
        if ( $generate )
        {
            static::generate($generate, $output);
        }

        static::runTests($fileName, $suite, $test, $recursive);
    }

    public static function generate(string $generate, string $output)
    {
        Tester::generateTest($generate, $output);

        exit(0);
    }

    public static function runTests(string $fileName, string $suite, string $test, bool $recursive)
    {
        $tests          = static::getTestFiles($fileName, $recursive);
        if ( empty($tests) )
        {
            Tester::getLogger()->error("No test files found/specified");

            exit(1);
        }
        foreach ( $tests as $fileName )
        {
            Tester::getLogger()->debug("Loading test file {$fileName}");
            require($fileName);
            Tester::run($suite, $test);
        }

        exit(0);
    }

    /**
     * @param string $fileName
     * @param bool   $recursive
     * @return array
     */
    protected static function getTestFiles(string $fileName='', bool $recursive=false) : array
    {
        if ( empty($fileName) )
        {
            return [];
        }
        if ( ! file_exists($fileName) )
        {
            Tester::getLogger()->error("{$fileName} does not exist; exiting");

            exit(1);
        }
        $fileName   = realpath($fileName);
        if ( is_dir($fileName) )
        {
            $iterator       = new \DirectoryIterator($fileName);
            if ( $recursive )
            {
                $iterator       = new \RecursiveDirectoryIterator($fileName);
                $iterator       = $recursive ? new RecursiveIteratorIterator($iterator) : $iterator;
            }
            $testFiles      = [];
            foreach ( $iterator as $fileInfo )
            {
                if ( preg_match('/Suite.php$/', $fileInfo->getBasename()) )
                {
                    $testFiles[] = $fileInfo->getPathname();
                }
            }

            return $testFiles;
        }
        if ( ! is_file($fileName) )
        {
            Tester::getLogger()->error("{$fileName} is not a file; exiting");

            exit(1);
        }

        return [$fileName];
    }

    /**
     * PARSE ARGUMENTS
     *
     * This command line option parser supports any combination of three types of options
     * [single character options (`-a -b` or `-ab` or `-c -d=dog` or `-cd dog`),
     * long options (`--foo` or `--bar=baz` or `--bar baz`)
     * and arguments (`arg1 arg2`)] and returns a simple array.
     *
     * [pfisher ~]$ php test.php --foo --bar=baz --spam eggs
     *   ["foo"]   => true
     *   ["bar"]   => "baz"
     *   ["spam"]  => "eggs"
     *
     * [pfisher ~]$ php test.php -abc foo
     *   ["a"]     => true
     *   ["b"]     => true
     *   ["c"]     => "foo"
     *
     * [pfisher ~]$ php test.php arg1 arg2 arg3
     *   [0]       => "arg1"
     *   [1]       => "arg2"
     *   [2]       => "arg3"
     *
     * [pfisher ~]$ php test.php plain-arg --foo --bar=baz --funny="spam=eggs" --also-funny=spam=eggs \
     * > 'plain arg 2' -abc -k=value "plain arg 3" --s="original" --s='overwrite' --s
     *   [0]       => "plain-arg"
     *   ["foo"]   => true
     *   ["bar"]   => "baz"
     *   ["funny"] => "spam=eggs"
     *   ["also-funny"]=> "spam=eggs"
     *   [1]       => "plain arg 2"
     *   ["a"]     => true
     *   ["b"]     => true
     *   ["c"]     => true
     *   ["k"]     => "value"
     *   [2]       => "plain arg 3"
     *   ["s"]     => "overwrite"
     *
     * Not supported: `-cd=dog`.
     *
     * @author              Patrick Fisher <patrick@pwfisher.com>
     * @since               August 21, 2009
     * @see                 https://github.com/pwfisher/CommandLine.php
     * @see                 http://www.php.net/manual/en/features.commandline.php
     *                      #81042 function arguments($argv) by technorati at gmail dot com, 12-Feb-2008
     *                      #78651 function getArgs($args) by B Crawford, 22-Oct-2007
     * @usage               $args = CommandLine::parseArgs($_SERVER['argv']);
     * @param array $argv
     * @return array
     */
    protected static function parseArgs(array $argv=[]) : array
    {
        $argv = $argv ?: ! empty($_SERVER['argv']) ? $_SERVER['argv'] : [];
        array_shift($argv);
        $out = [];
        for ( $i = 0, $j = count($argv); $i < $j; $i++ )
        {
            $arg = $argv[$i];
            // --foo --bar=baz
            if ( mb_substr($arg, 0, 2) === '--' )
            {
                $eqPos = mb_strpos($arg, '=');
                // --foo
                if ($eqPos === false)
                {
                    $key = mb_substr($arg, 2);
                    // --foo value
                    if ($i + 1 < $j && $argv[$i + 1][0] !== '-')
                    {
                        $value = $argv[$i + 1];
                        $i++;
                    }
                    else
                    {
                        $value = isset($out[$key]) ? $out[$key] : true;
                    }
                    $out[$key] = $value;
                }
                // --bar=baz
                else
                {
                    $key        = mb_substr($arg, 2, $eqPos - 2);
                    $value      = mb_substr($arg, $eqPos + 1);
                    $out[$key]  = $value;
                }
            }
            // -k=value -abc
            else if (mb_substr($arg, 0, 1) === '-')
            {
                // -k=value
                if (mb_substr($arg, 2, 1) === '=')
                {
                    $key       = mb_substr($arg, 1, 1);
                    $value     = mb_substr($arg, 3);
                    $out[$key] = $value;
                }
                // -abc
                else
                {
                    $chars = str_split(mb_substr($arg, 1));
                    $key = '';
                    foreach ( $chars as $char )
                    {
                        $key       = $char;
                        $value     = isset($out[$key]) ? $out[$key] : true;
                        $out[$key] = $value;
                    }
                    // -a value1 -abc value2
                    if ($i + 1 < $j && $argv[$i + 1][0] !== '-')
                    {
                        $out[$key] = $argv[$i + 1];
                        $i++;
                    }
                }
            }
            // plain-arg
            else
            {
                $value = $arg;
                $out[] = $value;
            }
        }
        foreach ( $out as $idx => $val )
        {
            if ( is_string($val) && strpos($val, '|') !== false )
            {
                $out[$idx] = explode('|', $val);
            }
        }

        return $out;
    }

    /**
     * @param $name
     * @param mixed $default
     * @return string
     */
    protected static function getArg($name, $default=null)
    {
        $args = static::parseArgs();

        return isset($args[$name]) && $args[$name] ? $args[$name] : $default;
    }

}

TestRunner::run();