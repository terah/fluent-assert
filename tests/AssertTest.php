<?php declare(strict_types=1);

namespace Terah\Assert\Test;

use Terah\Assert\Assert;
use Terah\Assert\AssertionFailedException;

class AssertTest extends \PHPUnit_Framework_TestCase
{
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
     * @dataProvider dataInvalidFloat
     */
    public function testInvalidFloat($nonFloat)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_FLOAT);
        (new Assert($nonFloat))->float();
    }

    public function testValidFloat()
    {
        (new Assert(1.0))->float();
        (new Assert(0.1))->float();
        (new Assert(-1.1))->float();
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
     * @dataProvider dataInvalidInteger
     */
    public function testInvalidInteger($nonInteger)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_INTEGER);
        (new Assert($nonInteger))->integer();
    }

    public function testValidInteger()
    {
        (new Assert(10))->integer();
        (new Assert(0))->integer();
    }

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
     * @dataProvider dataInvalidIntegerish
     */
    public function testInvalidIntegerish($nonInteger)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_INTEGERISH);
        (new Assert($nonInteger))->integerish();
    }

    public function testValidBoolean()
    {
        (new Assert(true))->boolean();
        (new Assert(false))->boolean();
    }

    public function testInvalidBoolean()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_BOOLEAN);
        (new Assert(1))->boolean();
    }

    public function testInvalidScalar()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_SCALAR);
        (new Assert(new \stdClass))->scalar();
    }

    public function testValidScalar()
    {
        (new Assert("foo"))->scalar();
        (new Assert(52))->scalar();
        (new Assert(12.34))->scalar();
        (new Assert(false))->scalar();
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
     * @dataProvider dataInvalidNotEmpty
     */
    public function testInvalidNotEmpty($value)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::VALUE_EMPTY);
        (new Assert($value))->notEmpty();
    }

    public function testNotEmpty()
    {
        (new Assert("test"))->notEmpty();
        (new Assert(1))->notEmpty();
        (new Assert(true))->notEmpty();
        (new Assert(array("foo")))->notEmpty();
    }

    public function testEmpty()
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
     * @dataProvider dataInvalidEmpty
     */
    public function testInvalidEmpty($value)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::VALUE_NOT_EMPTY);
        (new Assert($value))->noContent();
    }

    public function testNotNull()
    {
        (new Assert("1"))->notNull();
        (new Assert(1))->notNull();
        (new Assert(0))->notNull();
        (new Assert(array()))->notNull();
        (new Assert(false))->notNull();
    }

    public function testInvalidNotNull()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::VALUE_NULL);
        (new Assert(null))->notNull();
    }

    public function testString()
    {
        (new Assert("test-string"))->string();
        (new Assert(""))->string();
    }

    /**
     * @dataProvider dataInvalidString
     */
    public function testInvalidString($invalidString)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_STRING);
        (new Assert($invalidString))->string();
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

    public function testInvalidRegex()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_REGEX);
        (new Assert("foo"))->regex("(bar)");
    }

    public function testInvalidRegexValueNotString()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_STRING);
        (new Assert(array("foo")))->regex("(bar)");
    }

    public function testInvalidMinLength()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_MIN_LENGTH);
        (new Assert("foo"))->minLength(4);
    }

    public function testValidMinLength()
    {
        (new Assert("foo"))->minLength(3);
        (new Assert("foo"))->minLength(1);
        (new Assert("foo"))->minLength(0);
        (new Assert(""))->minLength(0);
        (new Assert("址址"))->minLength(2);
    }

    public function testInvalidMaxLength()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_MAX_LENGTH);
        (new Assert("foo"))->maxLength(2);
    }

    public function testValidMaxLength()
    {
        (new Assert("foo"))->maxLength(10);
        (new Assert("foo"))->maxLength(3);
        (new Assert(""))->maxLength(0);
        (new Assert("址址"))->maxLength(2);
    }

    public function testInvalidBetweenLengthMin()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_MIN_LENGTH);
        (new Assert("foo"))->betweenLength(4, 100);
    }

    public function testInvalidBetweenLengthMax()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_MAX_LENGTH);
        (new Assert("foo"))->betweenLength(0, 2);
    }

    public function testValidBetweenLength()
    {
        (new Assert("foo"))->betweenLength(0, 3);
        (new Assert("址址"))->betweenLength(2, 2);
    }

    public function testInvalidStartsWith()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_STRING_START);
        (new Assert("foo"))->startsWith("bar");
    }

    public function testInvalidStartsWithDueToWrongEncoding()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_STRING_START);
        (new Assert("址"))->startsWith("址址", null, null, 'ASCII');
    }

    public function testValidStartsWith()
    {
        (new Assert("foo"))->startsWith("foo");
        (new Assert("foo"))->startsWith("fo");
        (new Assert("foo"))->startsWith("f");
        (new Assert("址foo"))->startsWith("址");
    }

    public function testInvalidEndsWith()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_STRING_END);
        (new Assert("foo"))->endsWith("bar");
    }

    public function testInvalidEndsWithDueToWrongEncoding()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_STRING_END);
        (new Assert("址"))->endsWith("址址", null, null, 'ASCII');
    }

    public function testValidEndsWith()
    {
        (new Assert("foo"))->endsWith("foo");
        (new Assert("sonderbar"))->endsWith("bar");
        (new Assert("opp"))->endsWith("p");
        (new Assert("foo址"))->endsWith("址");
    }

    public function testInvalidContains()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_STRING_CONTAINS);
        (new Assert("foo"))->contains("bar");
    }

    public function testValidContains()
    {
        (new Assert("foo"))->contains("foo");
        (new Assert("foo"))->contains("oo");
    }

    public function testInvalidChoice()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_CHOICE);
        (new Assert("foo"))->choice(array("bar", "baz"));
    }

    public function testValidChoice()
    {
        (new Assert("foo"))->choice(array("foo"));
    }

    public function testInvalidInArray()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_CHOICE);
        (new Assert("bar"))->inArray(array("baz"));
    }

    public function testValidInArray()
    {
        (new Assert("foo"))->inArray(array("foo"));
    }

    public function testInvalidNumeric()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_NUMERIC);
        (new Assert("foo"))->numeric();
    }

    public function testValidNumeric()
    {
        (new Assert("1"))->numeric();
        (new Assert(1))->numeric();
        (new Assert(1.23))->numeric();
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
     * @dataProvider dataInvalidArray
     */
    public function testInvalidArray($value)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_ARRAY);
        (new Assert($value))->isArray();
    }

    public function testValidArray()
    {
        (new Assert(array()))->isArray();
        (new Assert(array(1,2,3)))->isArray();
        (new Assert(array(array(),array())))->isArray();
    }

    public function testInvalidKeyExists()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_KEY_EXISTS);
        (new Assert(array("foo" => "bar")))->keyExists("baz");
    }

    public function testValidKeyExists()
    {
        (new Assert(array("foo" => "bar")))->keyExists("foo");
    }

    public function testInvalidNotBlank()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_NOT_BLANK);
        (new Assert(""))->notBlank();
    }

    public function testValidNotBlank()
    {
        (new Assert("foo"))->notBlank();
    }

    public function testInvalidNotInstanceOf()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_NOT_INSTANCE_OF);
        (new Assert(new \stdClass))->notIsInstanceOf('stdClass');
    }

    public function testValidNotIsInstanceOf()
    {
        (new Assert(new \stdClass))->notIsInstanceOf('PDO');
    }

    public function testInvalidInstanceOf()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_INSTANCE_OF);
        (new Assert(new \stdClass))->isInstanceOf('PDO');
    }

    public function testValidInstanceOf()
    {
        (new Assert(new \stdClass))->isInstanceOf('stdClass');
    }

    public function testInvalidSubclassOf()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_SUBCLASS_OF);
        (new Assert(new \stdClass))->subclassOf('PDO');
    }

    public function testValidSubclassOf()
    {
        (new Assert(new ChildStdClass))->subclassOf('stdClass');
    }

    public function testInvalidRange()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_RANGE);
        (new Assert(1))->range(2, 3);
        (new Assert(1.5))->range(2, 3);
    }

    public function testValidRange()
    {
        (new Assert(1))->range(1, 2);
        (new Assert(2))->range(1, 2);
        (new Assert(2))->range(0, 100);
        (new Assert(2.5))->range(2.25, 2.75);
    }

    public function testInvalidEmail()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_EMAIL);
        (new Assert("foo"))->email();
    }

    public function testValidEmail()
    {
        (new Assert("123hello+world@email.provider.com"))->email();
    }

    /**
     * @dataProvider dataInvalidUrl
     */
    public function testInvalidUrl($url)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_URL);
        (new Assert('foo'))->url($url);
    }

    public static function dataInvalidUrl()
    {
        return array(
            'null value' => array(""),
            'empty string' => array(" "),
            'no scheme' => array("url.de"),
            'unsupported scheme' => array("git://url.de"),
            'Http with query (no / between tld und ?)' => array("http://example.org?do=something"),
            'Http with query and port (no / between port und ?)' => array("http://example.org:8080?do=something"),
        );
    }

    /**
     * @dataProvider dataValidUrl
     */
    public function testValidUrl($url)
    {
        (new Assert($url))->url();
    }

    public static function dataValidUrl()
    {
        return array(
            'straight with Http' => array("http://example.org"),
            'Http with path' => array("http://example.org/do/something"),
            'Http with query' => array("http://example.org/index.php?do=something"),
            'Http with port' => array("http://example.org:8080"),
            'Http with all possibilities' => array("http://example.org:8080/do/something/index.php?do=something"),
            'straight with Https' => array("https://example.org"),
        );
    }

    public function testInvalidDigit()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_DIGIT);
        (new Assert(-1))->digit();
    }

    public function testValidDigit()
    {
        (new Assert(1))->digit();
        (new Assert(0))->digit();
        (new Assert("0"))->digit();
    }

    public function testValidAlnum()
    {
        (new Assert("a"))->alnum();
        (new Assert("a1"))->alnum();
        (new Assert("aasdf1234"))->alnum();
        (new Assert("a1b2c3"))->alnum();
    }

    public function testInvalidAlnum()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_ALNUM);
        (new Assert("1a"))->alnum();
    }

    public function testValidTrue()
    {
        (new Assert(1 == 1))->true();
    }

    public function testInvalidTrue()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_TRUE);
        (new Assert(false))->true();
    }

    public function testValidFalse()
    {
        (new Assert(1 == 0))->false();
    }

    public function testInvalidFalse()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_FALSE);
        (new Assert(true))->false();
    }

    public function testInvalidClass()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_CLASS);
        (new Assert("Foo"))->classExists();
    }

    public function testValidClass()
    {
        (new Assert("\\Exception"))->classExists();
    }

    public function testSame()
    {
        (new Assert(1))->same(1);
        (new Assert("foo"))->same("foo");
        (new Assert($obj = new \stdClass()))->same($obj);
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_SAME);
        (new Assert(new \stdClass()))->same(new \stdClass());
    }

    public function testEq()
    {
        (new Assert(1))->eq("1");
        (new Assert("foo"))->eq(true);
        (new Assert($obj = new \stdClass()))->eq($obj);
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_EQ);
        (new Assert("2"))->eq(1);
    }

    public function testNotEq()
    {
        (new Assert("1"))->notEq(false);
        (new Assert(new \stdClass()))->notEq(array());
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_NOT_EQ);
        (new Assert("1"))->notEq(1);
    }

    public function testNotSame()
    {
        (new Assert("1"))->notSame(2);
        (new Assert(new \stdClass()))->notSame(array());
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_NOT_SAME);
        (new Assert(1))->notSame(1);
    }

    public function testMin()
    {
        (new Assert(1))->min(1);
        (new Assert(2))->min(1);
        (new Assert(2.5))->min(1);

        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_MIN);
        (new Assert(0))->min(1);
    }

    public function testMax()
    {
        (new Assert(1))->max(1);
        (new Assert(0.5))->max(1);
        (new Assert(0))->max(1);

        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_MAX);
        (new Assert(2))->max(1);
    }

    public function testNullOr()
    {
        (new Assert(null))->nullOr()->max(1);
        (new Assert(null))->nullOr()->max(2);
    }

    public function testLength()
    {
        (new Assert("asdf"))->length(4);
        (new Assert(""))->length(0);
    }

    public static function dataLengthUtf8Characters()
    {
        return array(
            array("址", 1),
            array("ل", 1),
        );
    }

    /**
     * @dataProvider dataLengthUtf8Characters
     */
    public function testLenghtUtf8Characters($value, $expected)
    {
        (new Assert($value))->length($expected);
    }

    public function testLengthFailed()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_LENGTH);
        (new Assert("asdf"))->length(3);
    }

    public function testLengthFailedForWrongEncoding()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_LENGTH);
        (new Assert("址"))->length(1, null, null, 'ASCII');
    }

    public function testLengthValidForGivenEncoding()
    {
        (new Assert("址"))->length(1, null, null, 'utf8');
    }

    public function testFile()
    {
        (new Assert(__FILE__))->file();
    }

    public function testFileWithEmptyFilename()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::VALUE_EMPTY);
        (new Assert(""))->file();
    }

    public function testFileDoesNotExists()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_FILE);
        (new Assert(__DIR__ . '/does-not-exists'))->file();
    }

    public function testDirectory()
    {
        (new Assert(__DIR__))->directory();

        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_DIRECTORY);
        (new Assert(__DIR__ . '/does-not-exist'))->directory();
    }

    public function testReadable()
    {
        (new Assert(__FILE__))->readable();

        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_READABLE);
        (new Assert(__DIR__ . '/does-not-exist'))->readable();
    }

    public function testWriteable()
    {
        (new Assert(sys_get_temp_dir()))->writeable();

        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_WRITEABLE);
        (new Assert(__DIR__ . '/does-not-exist'))->writeable();
    }

    public function testImplementsInterface()
    {
        (new Assert('\ArrayIterator'))->implementsInterface('\Traversable');

        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INTERFACE_NOT_IMPLEMENTED);
        (new Assert('\Exception'))->implementsInterface('\Traversable');
    }

    public function testImplementsInterfaceWithClassObject()
    {
        $class = new \ArrayObject();

        (new Assert($class))->implementsInterface('\Traversable');

        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INTERFACE_NOT_IMPLEMENTED);
        (new Assert($class))->implementsInterface('\SplObserver');
    }

    /**
     * @dataProvider isJsonStringDataprovider
     */
    public function testIsJsonString($content)
    {
        (new Assert($content))->isJsonString();
    }

    public static function isJsonStringDataprovider()
    {
        return array(
            '»null« value' => array(json_encode(null)),
            '»false« value' => array(json_encode(false)),
            'array value' => array('["false"]'),
            'object value' => array('{"tux":"false"}'),
        );
    }

    /**
     * @dataProvider isJsonStringInvalidStringDataprovider
     */
    public function testIsJsonStringExpectingException($invalidString)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_JSON_STRING);
        (new Assert($invalidString))->isJsonString();
    }

    public static function isJsonStringInvalidStringDataprovider()
    {
        return array(
            'no json string' => array('invalid json encoded string'),
            'error in json string' => array('{invalid json encoded string}'),
        );
    }

    /**
     * @dataProvider providesValidUuids
     */
    public function testValidUuids($uuid)
    {
        (new Assert($uuid))->uuid();
    }

    /**
     * @dataProvider providesInvalidUuids
     */
    public function testInvalidUuids($uuid)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException');
        (new Assert($uuid))->uuid();
    }

    public static function providesValidUuids()
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

    public static function providesInvalidUuids()
    {
        return array(
            array('zf6f8cb0-c57d-11e1-9b21-0800200c9a66'),
            array('af6f8cb0c57d11e19b210800200c9a66'),
            array('ff6f8cb0-c57da-51e1-9b21-0800200c9a66'),
            array('af6f8cb-c57d-11e1-9b21-0800200c9a66'),
            array('3f6f8cb0-c57d-11e1-9b21-0800200c9a6'),
        );
    }

    public function testValidNotEmptyKey()
    {
        (new Assert(array('keyExists' => 'notEmpty')))->notEmptyKey('keyExists');
    }

    /**
     * @dataProvider invalidNotEmptyKeyDataprovider
     */
    public function testInvalidNotEmptyKey($invalidArray, $key)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException');
        (new Assert($invalidArray))->notEmptyKey($key);
    }

    public static function invalidNotEmptyKeyDataprovider()
    {
        return array(
            'empty'          => array(array('keyExists' => ''), 'keyExists'),
            'key not exists' => array(array('key' => 'notEmpty'), 'keyNotExists')
        );
    }

    public function testAllWithSimpleAssertion()
    {
        (new Assert(array(true, true)))->all()->true();
    }

    public function testAllWithSimpleAssertionThrowsExceptionOnElementThatFailsAssertion()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_TRUE);
        (new Assert(array(true, false)))->all()->true();
    }

    public function testAllWithComplexAssertion()
    {
        (new Assert(array(new \stdClass, new \stdClass)))->all()->isInstanceOf('stdClass');
    }

    public function testAllWithComplexAssertionThrowsExceptionOnElementThatFailsAssertion()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', 'Assertion failed', Assert::INVALID_INSTANCE_OF);

        (new Assert(array(new \stdClass, new \stdClass)))->all()->isInstanceOf('PDO', 'Assertion failed', 'foos');
    }

    public function testAllWithNoValueThrows()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException');
        (new Assert(null))->all()->true();
    }

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
     * @dataProvider dataInvalidCount
     */
    public function testInvalidCount($countable, $count)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_COUNT);
        (new Assert($countable))->count($count);
    }

    public function testChoicesNotEmpty()
    {
        (new Assert(array('tux' => 'linux', 'Gnu' => 'dolphin')))->choicesNotEmpty(array('tux'));
    }

    /**
     * @dataProvider invalidChoicesProvider
     */
    public function testChoicesNotEmptyExpectingException($values, $choices, $exceptionCode)
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, $exceptionCode);
        (new Assert($values))->choicesNotEmpty($choices);
    }

    public function invalidChoicesProvider()
    {
        return array(
            'empty values' => array(array(), array('tux'), Assert::VALUE_EMPTY),
            'empty recodes in $values' => array(array('tux' => ''), array('tux'), Assert::VALUE_EMPTY),
            'choice not found in values' => array(array('tux' => ''), array('invalidChoice'), Assert::INVALID_KEY_ISSET),
        );
    }

    public function testIsObject()
    {
        (new Assert(new \stdClass))->isObject();
    }

    public function testIsObjectExpectingException()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_OBJECT);
        (new Assert('notAnObject'))->isObject();
    }

    public function testMethodExists()
    {
        (new Assert('methodExists'))->methodExists(new Assert(null));
    }

    public function testChaining()
    {
        (new Assert(1))->integer()->integerish()->numeric()->notNull()->eq(1);
        (new Assert(array(1,1,1,1,1,1,)))->allIds()->integerish()->numeric()->notNull()->eq(1);
    }

    public function testChainingFails()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_EQ);
        (new Assert(1))->integer()->integerish()->numeric()->notNull()->eq(2);
    }

    public function testAllChainingFails()
    {
        $this->setExpectedException('Terah\Assert\AssertionFailedException', null, Assert::INVALID_EQ);
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
