<?php declare(strict_types=1);

namespace Terah\Assert\Test;

use PHPUnit\Framework\TestCase;
use Terah\Assert\Assert;
use Terah\Assert\AssertionFailedException;


class AssertTest extends TestCase
{

    /**
     * @doesNotPerformAssertions
     */
    public function testValidFloat()
    {
        (new Assert(1.0))->float();
        (new Assert(0.1))->float();
        (new Assert(-1.1))->float();
    }

    public static function dataInvalidFloat()
    {
        return array(
            array(1),
            array(false),
            array("test"),
            array(null),
            array("1.23"),
            array("10"),
        );
    }

    /**
     * @dataProvider                dataInvalidFloat
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_FLOAT
     */
    public function testInvalidFloat($nonFloat)
    {
        (new Assert($nonFloat))->float();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidInteger()
    {
        (new Assert(10))->integer();
        (new Assert(0))->integer();
    }

    public static function dataInvalidInteger()
    {
        return array(
            array(1.23),
            array(false),
            array("test"),
            array(null),
            array("1.23"),
            array("10"),
            array(new \DateTime()),
        );
    }

    /**
     * @dataProvider                dataInvalidInteger
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_INTEGER
     */
    public function testInvalidInteger($nonInteger)
    {
        (new Assert($nonInteger))->integer();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidIntegerish()
    {
        (new Assert(10))->integerish();
        (new Assert("10"))->integerish();
    }

    public static function dataInvalidIntegerish()
    {
        return array(
            array(1.23),
            array(false),
            array("test"),
            array(null),
            array("1.23"),
        );
    }

    /**
     * @dataProvider                dataInvalidIntegerish
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_INTEGERISH
     */
    public function testInvalidIntegerish($nonInteger)
    {
        (new Assert($nonInteger))->integerish();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidBoolean()
    {
        (new Assert(true))->boolean();
        (new Assert(false))->boolean();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_BOOLEAN
     */
    public function testInvalidBoolean()
    {
        (new Assert(1))->boolean();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidScalar()
    {
        (new Assert("foo"))->scalar();
        (new Assert(52))->scalar();
        (new Assert(12.34))->scalar();
        (new Assert(false))->scalar();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_SCALAR
     */
    public function testInvalidScalar()
    {
        (new Assert(new \stdClass))->scalar();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNotEmpty()
    {
        (new Assert("test"))->notEmpty();
        (new Assert(1))->notEmpty();
        (new Assert(true))->notEmpty();
        (new Assert(array("foo")))->notEmpty();
    }

    public static function dataInvalidNotEmpty()
    {
        return array(
            array(""),
            array(false),
            array(0),
            array(null),
            array( array() ),
        );
    }

    /**
     * @dataProvider                dataInvalidNotEmpty
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::VALUE_EMPTY
     */
    public function testInvalidNotEmpty($value)
    {
        (new Assert($value))->notEmpty();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidEmpty()
    {
        (new Assert(""))->noContent();
        (new Assert(0))->noContent();
        (new Assert(false))->noContent();
        (new Assert( array() ))->noContent();
    }

    public static function dataInvalidEmpty()
    {
        return array(
            array("foo"),
            array(true),
            array(12),
            array( array('foo') ),
            array( new \stdClass() ),
        );
    }

    /**
     * @dataProvider                dataInvalidEmpty
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::VALUE_NOT_EMPTY
     */
    public function testInvalidEmpty($value)
    {
        (new Assert($value))->noContent();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNotNull()
    {
        (new Assert("1"))->notNull();
        (new Assert(1))->notNull();
        (new Assert(0))->notNull();
        (new Assert(array()))->notNull();
        (new Assert(false))->notNull();
    }

    /**
    * @expectedException           Terah\Assert\AssertionFailedException
    * @expectedExceptionCode       Terah\Assert\Assert::VALUE_NULL
    */
    public function testInvalidNotNull()
    {
        (new Assert(null))->notNull();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidString()
    {
        (new Assert("test-string"))->string();
        (new Assert(""))->string();
    }

    public static function dataInvalidString()
    {
        return array(
            array(1.23),
            array(false),
            array(new \ArrayObject),
            array(null),
            array(10),
            array(true),
        );
    }

    /**
     * @dataProvider                dataInvalidString
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_STRING
     */
    public function testInvalidString($invalidString)
    {
        (new Assert($invalidString))->string();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_REGEX
     */
    public function testInvalidRegex()
    {
        (new Assert("foo"))->regex("(bar)");
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_STRING
     */
    public function testInvalidRegexValueNotString()
    {
        (new Assert(array("foo")))->regex("(bar)");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidMinLength()
    {
        (new Assert("foo"))->minLength(3);
        (new Assert("foo"))->minLength(1);
        (new Assert("foo"))->minLength(0);
        (new Assert(""))->minLength(0);
        (new Assert("址址"))->minLength(2);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_MIN_LENGTH
     */
    public function testInvalidMinLength()
    {
        (new Assert("foo"))->minLength(4);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidMaxLength()
    {
        (new Assert("foo"))->maxLength(10);
        (new Assert("foo"))->maxLength(3);
        (new Assert(""))->maxLength(0);
        (new Assert("址址"))->maxLength(2);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_MAX_LENGTH
     */
    public function testInvalidMaxLength()
    {
        (new Assert("foo"))->maxLength(2);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidBetweenLength()
    {
        (new Assert("foo"))->betweenLength(0, 3);
        (new Assert("址址"))->betweenLength(2, 2);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_MIN_LENGTH
     */
    public function testInvalidBetweenLengthMin()
    {
        (new Assert("foo"))->betweenLength(4, 100);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_MAX_LENGTH
     */
    public function testInvalidBetweenLengthMax()
    {
        (new Assert("foo"))->betweenLength(0, 2);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidStartsWith()
    {
        (new Assert("foo"))->startsWith("foo");
        (new Assert("foo"))->startsWith("fo");
        (new Assert("foo"))->startsWith("f");
        (new Assert("址foo"))->startsWith("址");
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_STRING_START
     */
    public function testInvalidStartsWith()
    {
        (new Assert("foo"))->startsWith("bar");
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_STRING_START
     */
    public function testInvalidStartsWithDueToWrongEncoding()
    {
        (new Assert("址"))->startsWith("址址", null, null, 'ASCII');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidEndsWith()
    {
        (new Assert("foo"))->endsWith("foo");
        (new Assert("sonderbar"))->endsWith("bar");
        (new Assert("opp"))->endsWith("p");
        (new Assert("foo址"))->endsWith("址");
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_STRING_END
     */
    public function testInvalidEndsWith()
    {
        (new Assert("foo"))->endsWith("bar");
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_STRING_END
     */
    public function testInvalidEndsWithDueToWrongEncoding()
    {
        (new Assert("址"))->endsWith("址址", null, null, 'ASCII');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidContains()
    {
        (new Assert("foo"))->contains("foo");
        (new Assert("foo"))->contains("oo");
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_STRING_CONTAINS
     */
    public function testInvalidContains()
    {
        (new Assert("foo"))->contains("bar");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidChoice()
    {
        (new Assert("foo"))->choice(array("foo"));
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_CHOICE
     */
    public function testInvalidChoice()
    {
        (new Assert("foo"))->choice(array("bar", "baz"));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidInArray()
    {
        (new Assert("foo"))->inArray(array("foo"));
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_CHOICE
     */
    public function testInvalidInArray()
    {
        (new Assert("bar"))->inArray(array("baz"));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNumeric()
    {
        (new Assert("1"))->numeric();
        (new Assert(1))->numeric();
        (new Assert(1.23))->numeric();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_NUMERIC
     */
    public function testInvalidNumeric()
    {
        (new Assert("foo"))->numeric();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidArray()
    {
        (new Assert(array()))->isArray();
        (new Assert(array(1,2,3)))->isArray();
        (new Assert(array(array(),array())))->isArray();
    }

    public static function dataInvalidArray()
    {
        return array(
            array(null),
            array(false),
            array("test"),
            array(1),
            array(1.23),
            array(new \stdClass),
            array(fopen('php://memory', 'r')),
        );
    }

    /**
     * @dataProvider                dataInvalidArray
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_ARRAY
     */
    public function testInvalidArray($value)
    {
        (new Assert($value))->isArray();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidKeyExists()
    {
        (new Assert(array("foo" => "bar")))->keyExists("foo");
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_KEY_EXISTS
     */
    public function testInvalidKeyExists()
    {
        (new Assert(array("foo" => "bar")))->keyExists("baz");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNotBlank()
    {
        (new Assert("foo"))->notBlank();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_NOT_BLANK
     */
    public function testInvalidNotBlank()
    {
        (new Assert(""))->notBlank();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNotIsInstanceOf()
    {
        (new Assert(new \stdClass))->notIsInstanceOf('PDO');
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_NOT_INSTANCE_OF
     */
    public function testInvalidNotInstanceOf()
    {
        (new Assert(new \stdClass))->notIsInstanceOf('stdClass');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidInstanceOf()
    {
        (new Assert(new \stdClass))->isInstanceOf('stdClass');
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_INSTANCE_OF
     */
    public function testInvalidInstanceOf()
    {
        (new Assert(new \stdClass))->isInstanceOf('PDO');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidSubclassOf()
    {
        (new Assert(new ChildStdClass))->subclassOf('stdClass');
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_SUBCLASS_OF
     */
    public function testInvalidSubclassOf()
    {
        (new Assert(new \stdClass))->subclassOf('PDO');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidRange()
    {
        (new Assert(1))->range(1, 2);
        (new Assert(2))->range(1, 2);
        (new Assert(2))->range(0, 100);
        (new Assert(2.5))->range(2.25, 2.75);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_RANGE
     */
    public function testInvalidRange()
    {
        (new Assert(1))->range(2, 3);
        (new Assert(1.5))->range(2, 3);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidEmail()
    {
        (new Assert("123hello+world@email.provider.com"))->email();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_EMAIL
     */
    public function testInvalidEmail()
    {
        (new Assert("foo"))->email();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidUserPrincipalName()
    {
        (new Assert("johncitizen@email.provider.com"))->userPrincipalName();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_USERPRINCIPALNAME
     */
    public function testInvalidUserPrincipalName()
    {
        (new Assert("johncitizen"))->userPrincipalName();
    }

    public static function dataValidUrl()
    {
        return array(
            'straight with Http'            => array("http://example.org"),
            'Http with path'                => array("http://example.org/do/something"),
            'Http with query'               => array("http://example.org/index.php?do=something"),
            'Http with port'                => array("http://example.org:8080"),
            'Http with all possibilities'   => array("http://example.org:8080/do/something/index.php?do=something"),
            'straight with Https'           => array("https://example.org"),
        );
    }

    /**
     * @dataProvider                dataValidUrl
     * @doesNotPerformAssertions
     */
    public function testValidUrl($url)
    {
        (new Assert($url))->url();
    }

    public static function dataInvalidUrl()
    {
        return array(
            'null value'                    => array(""),
            'empty string'                  => array(" "),
            'no scheme'                     => array("url.de"),
            'unsupported scheme'            => array("git://url.de"),
            'Http with query (no / between tld und ?)'              => array("http://example.org?do=something"),
            'Http with query and port (no / between port und ?)'    => array("http://example.org:8080?do=something"),
        );
    }

    /**
     * @dataProvider                dataInvalidUrl
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_URL
     */
    public function testInvalidUrl($url)
    {
        (new Assert('foo'))->url($url);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidDigit()
    {
        (new Assert(1))->digit();
        (new Assert(0))->digit();
        (new Assert("0"))->digit();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_DIGIT
     */
    public function testInvalidDigit()
    {
        (new Assert(-1))->digit();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidAlnum()
    {
        (new Assert("a"))->alnum();
        (new Assert("a1"))->alnum();
        (new Assert("aasdf1234"))->alnum();
        (new Assert("a1b2c3"))->alnum();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_ALNUM
     */
    public function testInvalidAlnum()
    {
        (new Assert("1a"))->alnum();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidTrue()
    {
        (new Assert(1 == 1))->true();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_TRUE
     */
    public function testInvalidTrue()
    {
        (new Assert(false))->true();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidFalse()
    {
        (new Assert(1 == 0))->false();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_FALSE
     */
    public function testInvalidFalse()
    {
        (new Assert(true))->false();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidClass()
    {
        (new Assert("\\Exception"))->classExists();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_CLASS
     */
    public function testInvalidClass()
    {
        (new Assert("Foo"))->classExists();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidSame()
    {
        (new Assert(1))->same(1);
        (new Assert("foo"))->same("foo");
        (new Assert($obj = new \stdClass()))->same($obj);

    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_SAME
     */
    public function testInvalidSame()
    {
        (new Assert(new \stdClass()))->same(new \stdClass());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidEq()
    {
        (new Assert(1))->eq("1");
        (new Assert("foo"))->eq(true);
        (new Assert($obj = new \stdClass()))->eq($obj);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_EQ
     */
    public function testInvalidEq()
    {
        (new Assert("2"))->eq(1);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNotEq()
    {
        (new Assert("1"))->notEq(false);
        (new Assert(new \stdClass()))->notEq(array());
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_NOT_EQ
     */
    public function testInvalidNotEq()
    {
        (new Assert("1"))->notEq(1);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNotSame()
    {
        (new Assert("1"))->notSame(2);
        (new Assert(new \stdClass()))->notSame(array());

    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_NOT_SAME
     */
    public function testInvalidNotSame()
    {
        (new Assert(1))->notSame(1);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidMin()
    {
        (new Assert(1))->min(1);
        (new Assert(2))->min(1);
        (new Assert(2.5))->min(1);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_MIN
     */
    public function testInvalidMin()
    {
        (new Assert(0))->min(1);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidMax()
    {
        (new Assert(1))->max(1);
        (new Assert(0.5))->max(1);
        (new Assert(0))->max(1);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_MAX
     */
    public function testInvalidMax()
    {
        (new Assert(2))->max(1);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNullOr()
    {
        (new Assert(null))->nullOr()->max(1);
        (new Assert(null))->nullOr()->max(2);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidLength()
    {
        (new Assert("asdf"))->length(4);
        (new Assert(""))->length(0);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_LENGTH
     */
    public function testInvalidLength()
    {
        (new Assert("asdf"))->length(3);
    }

    public static function dataValidLengthUtf8Characters()
    {
        return array(
            array("址", 1),
            array("ل", 1),
        );
    }

    /**
     * @dataProvider dataValidLengthUtf8Characters
     * @doesNotPerformAssertions
     */
    public function testValidLengthUtf8Characters($value, $expected)
    {
        (new Assert($value))->length($expected);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_LENGTH
     */
    public function testInvalidLengthForWrongEncoding()
    {
        (new Assert("址"))->length(1, null, null, 'ASCII');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidLengthForGivenEncoding()
    {
        (new Assert("址"))->length(1, null, null, 'utf8');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidFile()
    {
        (new Assert(__FILE__))->file();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::VALUE_EMPTY
     */
    public function testInvalidFileForEmptyFilename()
    {
        (new Assert(""))->file();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_FILE
     */
    public function testInvalidFileForDoesNotExist()
    {
        (new Assert(__DIR__ . '/does-not-exists'))->file();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidDirectory()
    {
        (new Assert(__DIR__))->directory();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_DIRECTORY
     */
    public function testInvalidDirectory()
    {
        (new Assert(__DIR__ . '/does-not-exist'))->directory();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidReadable()
    {
        (new Assert(__FILE__))->readable();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_READABLE
     */
    public function testInvalidReadable()
    {
        (new Assert(__DIR__ . '/does-not-exist'))->readable();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidWriteable()
    {
        (new Assert(sys_get_temp_dir()))->writeable();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_WRITEABLE
     */
    public function testInvalidWriteable()
    {
        (new Assert(__DIR__ . '/does-not-exist'))->writeable();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidImplementsInterface()
    {
        (new Assert('\ArrayIterator'))->implementsInterface('\Traversable');
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INTERFACE_NOT_IMPLEMENTED
     */
    public function testInvalidImplementsInterface()
    {
        (new Assert('\Exception'))->implementsInterface('\Traversable');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidImplementsInterfaceWithClassObject()
    {
        $class = new \ArrayObject();

        (new Assert($class))->implementsInterface('\Traversable');
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INTERFACE_NOT_IMPLEMENTED
     */
    public function testInvalidImplementsInterfaceWithClassObject()
    {
        $class = new \ArrayObject();

        (new Assert($class))->implementsInterface('\SplObserver');
    }

    public static function dataValidIsJsonString()
    {
        return array(
            '»null« value' => array(json_encode(null)),
            '»false« value' => array(json_encode(false)),
            'array value' => array('["false"]'),
            'object value' => array('{"tux":"false"}'),
        );
    }

    /**
     * @dataProvider                dataValidIsJsonString
     * @doesNotPerformAssertions
     */
    public function testValidIsJsonString($content)
    {
        (new Assert($content))->isJsonString();
    }

    public static function dataInvalidIsJsonString()
    {
        return array(
            'no json string' => array('invalid json encoded string'),
            'error in json string' => array('{invalid json encoded string}'),
        );
    }

    /**
     * @dataProvider                dataInvalidIsJsonString
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_JSON_STRING
     */
    public function testInvalidIsJsonString($invalidString)
    {
        (new Assert($invalidString))->isJsonString();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidSamAccountName()
    {
        (new Assert('johncitizen'))->samAccountName();
        (new Assert('jcitiz'))->samAccountName();
        (new Assert('jcitiz123'))->samAccountName();
    }

    public static function dataInvalidSamAccountName()
    {
        return array(
            array('johncitizen12345678999999999999'),
            array('johncitizen@something.com'),
            array('john.citizen'),
            array('citizen,john')
        );
    }

    /**
     * @dataProvider                dataInvalidSamAccountName
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_SAMACCOUNTNAME
     */
    public function testInvalidSamAccountName($nonSamAccountName)
    {
        (new Assert($nonSamAccountName))->samAccountName();
    }

    public static function dataValidUuids()
    {
        return array(
            array('ff6f8cb0-c57d-11e1-9b21-0800200c9a66'),
            array('ff6f8cb0-c57d-21e1-9b21-0800200c9a66'),
            array('ff6f8cb0-c57d-31e1-9b21-0800200c9a66'),
            array('ff6f8cb0-c57d-41e1-9b21-0800200c9a66'),
            array('ff6f8cb0-c57d-51e1-9b21-0800200c9a66'),
            array('FF6F8CB0-C57D-11E1-9B21-0800200C9A66'),
        );
    }

    /**
     * @dataProvider                dataValidUuids
     * @doesNotPerformAssertions
     */
    public function testValidUuids($uuid)
    {
        (new Assert($uuid))->uuid();
    }

    public static function dataInvalidUuids()
    {
        return array(
            array('zf6f8cb0-c57d-11e1-9b21-0800200c9a66'),
            array('af6f8cb0c57d11e19b210800200c9a66'),
            array('ff6f8cb0-c57da-51e1-9b21-0800200c9a66'),
            array('af6f8cb-c57d-11e1-9b21-0800200c9a66'),
            array('3f6f8cb0-c57d-11e1-9b21-0800200c9a6'),
        );
    }

    /**
     * @dataProvider                dataInvalidUuids
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_UUID
     */
    public function testInvalidUuids($uuid)
    {
        (new Assert($uuid))->uuid();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidNotEmptyKey()
    {
        (new Assert(array('keyExists' => 'notEmpty')))->notEmptyKey('keyExists');
    }

    public static function dataInvalidNotEmptyKey()
    {
        return array(
            'empty'          => array(array('keyExists' => ''), 'keyExists'),
            'key not exists' => array(array('key' => 'notEmpty'), 'keyNotExists')
        );
    }

    /**
     * @dataProvider                dataInvalidNotEmptyKey
     * @expectedException           Terah\Assert\AssertionFailedException
     */
    public function testInvalidNotEmptyKey($invalidArray, $key)
    {
        (new Assert($invalidArray))->notEmptyKey($key);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAllWithSimpleAssertion()
    {
        (new Assert(array(true, true)))->all()->true();
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_TRUE
     */
    public function testAllWithSimpleAssertionThrowsExceptionOnElementThatFailsAssertion()
    {
        (new Assert(array(true, false)))->all()->true();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAllWithComplexAssertion()
    {
        (new Assert(array(new \stdClass, new \stdClass)))->all()->isInstanceOf('stdClass');
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_INSTANCE_OF
     */
    public function testAllWithComplexAssertionThrowsExceptionOnElementThatFailsAssertion()
    {
        (new Assert(array(new \stdClass, new \stdClass)))->all()->isInstanceOf('PDO', 'Assertion failed', 'foos');
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     */
    public function testAllWithNoValueThrows()
    {
        (new Assert(null))->all()->true();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidCount()
    {
        (new Assert(array('Hi')))->count(1);
        (new Assert(new OneCountable()))->count(1);
    }

    public static function dataInvalidCount()
    {
        return array(
            array(array('Hi', 'There'), 3),
            array(new OneCountable(), 2),
        );
    }

    /**
     * @dataProvider                dataInvalidCount
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_COUNT
     */
    public function testInvalidCount($countable, $count)
    {
        (new Assert($countable))->count($count);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testChoicesNotEmpty()
    {
        (new Assert(array('tux' => 'linux', 'Gnu' => 'dolphin')))->choicesNotEmpty(array('tux'));
    }

    public function dataInvalidChoicesForValueEmpty()
    {
        return array(
            'empty values' => array(array(), array('tux')),
            'empty recodes in $values' => array(array('tux' => ''), array('tux'))
        );
    }

    /**
     * @dataProvider                dataInvalidChoicesForValueEmpty
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::VALUE_EMPTY
     */
    public function testInvalidChoicesNotEmptyForValueEmpty($values, $choices)
    {
        (new Assert($values))->choicesNotEmpty($choices);
    }


    public function dataInvalidChoicesForInvalidKeySet()
    {
        return array(
            'choice not found in values' => array(array('tux' => ''), array('invalidChoice'), Assert::INVALID_KEY_ISSET)
        );
    }

    /**
     * @dataProvider                dataInvalidChoicesForInvalidKeySet
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_KEY_ISSET
     */
    public function testInvalidChoicesNotEmptyForInvalidKeySet($values, $choices)
    {
        (new Assert($values))->choicesNotEmpty($choices);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidIsObject()
    {
        (new Assert(new \stdClass))->isObject();
    }
    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_OBJECT
     */
    public function testInvalidIsObject()
    {
        (new Assert('notAnObject'))->isObject();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidMethodExists()
    {
        (new Assert('methodExists'))->methodExists(new Assert(null));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidChaining()
    {
        (new Assert(1))->integer()->integerish()->numeric()->notNull()->eq(1);
        (new Assert(array(1,1,1,1,1,1,)))->allIds()->integerish()->numeric()->notNull()->eq(1);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_EQ
     */
    public function testChainingFails()
    {
        (new Assert(1))->integer()->integerish()->numeric()->notNull()->eq(2);
    }

    /**
     * @expectedException           Terah\Assert\AssertionFailedException
     * @expectedExceptionCode       Terah\Assert\Assert::INVALID_EQ
     */
    public function testAllChainingFails()
    {
        (new Assert(array(1,1,1,1,1,2,)))->all()->id()->integerish()->numeric()->notNull()->eq(1);
    }
    /**
     * @test
     */
    public function it_passes_values_and_constraints_to_exception()
    {
        try {
            (new Assert(0))->range(10, 20);

            static::fail('Exception expected');
        } catch (AssertionFailedException $e) {
            $this->assertEquals(0, $e->getValue());
            $this->assertEquals(array('min' => 10, 'max' => 20), $e->getConstraints());
        }
    }
}

class ChildStdClass extends \stdClass
{

}

class OneCountable implements \Countable
{
    public function count()
    {
        return 1;
    }
}
