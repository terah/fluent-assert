<?php declare(strict_types=1);

namespace Terah\Assert\Test;

use Terah\Assert\Assert;
use Terah\Assert\AssertionFailedException;
use Terah\Assert\Tester;
use Terah\Assert\Suite;

Tester::suite('AssertSuite')

    ->fixture('InvalidFloats', [1, false, 'test', null, '1.23', '10'])

    ->fixture('InvalidIntegers', [1.23, false, 'test', null, '1.23', '10', new \DateTime()])

    ->fixture('InvalidIntegerish', [1.23, false, 'test', null, '1.23'])

    ->fixture('InvalidEmpty', ['foo', true, 12, ['foo'], new \stdClass()])

    ->fixture('InvalidNotEmpty', ['', false, 0, null, [] ])

    ->fixture('InvalidString', [1.23, false, new \ArrayObject, null, 10, true])

    ->fixture('ValidUrl', [
        'straight with Http'                                    => 'http://example.org',
        'Http with path'                                        => 'http://example.org/do/something',
        'Http with query'                                       => 'http://example.org/index.php?do=something',
        'Http with port'                                        => 'http://example.org:8080',
        'Http with all possibilities'                           => 'http://example.org:8080/do/something/index.php?do=something',
        'straight with Https'                                   => 'https://example.org',
    ])

    ->fixture('InvalidUrl', [
        'null value'                                            => '',
        'empty string'                                          => ' ',
        'no scheme'                                             => 'url.de',
        'unsupported scheme'                                    => 'git://url.de',
        'Http with query (no / between tld und ?)'              => 'http://example.org?do=something',
        'Http with query and port (no / between port und ?)'    => 'http://example.org:8080?do=something',
    ])

    ->fixture('InvalidChoicesForValueEmpty', [
        'empty values'                                          => [[], ['tux']],
        'empty recodes in $values'                              => [['tux' => ''], ['tux']]
    ])
    ->fixture('ValidLengthUtf8Characters', [
        ['址', 1],
        ['ل', 1],
    ])

    ->fixture('InvalidArray', [null, false, "test", 1, 1.23, new \stdClass, fopen('php://memory', 'r'), 0])

    ->fixture('ValidIsJsonString', [
        '»null« value'                                          => json_encode(null),
        '»false« value'                                         => json_encode(false),
        'array value'                                           => '["false"]',
        'object value'                                          => '{"tux":"false"}',
    ])

    ->fixture('InvalidIsJsonString', [
        'no json string'                                        => 'invalid json encoded string',
        'error in json string'                                  => '{invalid json encoded string}',

    ])

    ->fixture('ValidUuids', [
        'ff6f8cb0-c57d-11e1-9b21-0800200c9a66',
        'ff6f8cb0-c57d-21e1-9b21-0800200c9a66',
        'ff6f8cb0-c57d-31e1-9b21-0800200c9a66',
        'ff6f8cb0-c57d-41e1-9b21-0800200c9a66',
        'ff6f8cb0-c57d-51e1-9b21-0800200c9a66',
        'FF6F8CB0-C57D-11E1-9B21-0800200C9A66',
    ])

    ->fixture('InvalidSamAccountName', [
        'johncitizen12345678999999999999',
        'johncitizen@something.com',
        'john.citizen',
        'citizen,john',
    ])

    ->fixture('InvalidUuids', [
        'zf6f8cb0-c57d-11e1-9b21-0800200c9a66',
        'af6f8cb0c57d11e19b210800200c9a66',
        'ff6f8cb0-c57da-51e1-9b21-0800200c9a66',
        'af6f8cb-c57d-11e1-9b21-0800200c9a66',
        '3f6f8cb0-c57d-11e1-9b21-0800200c9a6',
    ])

    ->fixture('InvalidNotEmptyKey', [
        'empty'                                                 => [['keyExists' => ''], 'keyExists'],
        'key not exists'                                        => [['key' => 'notEmpty'], 'keyNotExists']
    ])

    ->fixture('InvalidCount', [
        [['Hi', 'There'], 3],
        [new class implements \Countable {public function count(){return 1;}}, 2],
    ])

    ->fixture('InvalidChoicesForInvalidKeySet', [
        'choice not found in values' => [
            ['tux' => ''],
            ['invalidChoice'],
            Assert::INVALID_KEY_ISSET
        ]
    ])

    ->test('testValidFloat', function(Suite $suite) {

        (new Assert(1.0))->float();
        (new Assert(0.1))->float();
        (new Assert(-1.1))->float();
    })

    ->test('testInvalidFloat', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidFloats') as $value )
        {
            (new Assert($value))->float();
        }

    }, '', Assert::INVALID_FLOAT, AssertionFailedException::class)

    ->test('testValidInteger', function(Suite $suite) {

        (new Assert(10))->integer();
        (new Assert(0))->integer();
    })

    ->test('testInvalidInteger', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidIntegers') as $value )
        {
            (new Assert($value))->integer();
        }

    }, '', Assert::INVALID_INTEGER, AssertionFailedException::class)

    ->test('testValidIntegerish', function(Suite $suite) {

        (new Assert(10))->integerish();
        (new Assert("10"))->integerish();
    })

    ->test('testInvalidIntegerish', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidIntegerish') as $value )
        {
            (new Assert($value))->integerish();
        }

    }, '', Assert::INVALID_INTEGERISH, AssertionFailedException::class)

    ->test('testValidBoolean', function(Suite $suite) {

        (new Assert(true))->boolean();
        (new Assert(false))->boolean();
    })

    ->test('testInvalidBoolean', function(Suite $suite) {

        (new Assert(1))->boolean();

    }, '', Assert::INVALID_BOOLEAN, AssertionFailedException::class)

    ->test('testValidScalar', function(Suite $suite) {

        (new Assert("foo"))->scalar();
        (new Assert(52))->scalar();
        (new Assert(12.34))->scalar();
        (new Assert(false))->scalar();
    })

    ->test('testInvalidScalar', function(Suite $suite) {

        (new Assert(new \stdClass))->scalar();

    }, '', Assert::INVALID_SCALAR, AssertionFailedException::class)

    ->test('testValidNotEmpty', function(Suite $suite) {

        (new Assert("test"))->notEmpty();
        (new Assert(1))->notEmpty();
        (new Assert(true))->notEmpty();
        (new Assert(array("foo")))->notEmpty();
    })

    ->test('testInvalidNotEmpty', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidNotEmpty') as $value )
        {
            (new Assert($value))->notEmpty();
        }

    }, '', Assert::VALUE_EMPTY, AssertionFailedException::class)

    ->test('testValidEmpty', function(Suite $suite) {

        (new Assert(""))->noContent();
        (new Assert(0))->noContent();
        (new Assert(false))->noContent();
        (new Assert([]))->noContent();
    })

    ->test('testInvalidEmpty', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidEmpty') as $value )
        {
            (new Assert($value))->noContent();
        }

    }, '', Assert::VALUE_NOT_EMPTY, AssertionFailedException::class)

    ->test('testValidNotNull', function(Suite $suite) {

        (new Assert("1"))->notNull();
        (new Assert(1))->notNull();
        (new Assert(0))->notNull();
        (new Assert([]))->notNull();
        (new Assert(false))->notNull();
    })

    ->test('testInvalidNotNull', function(Suite $suite) {

        (new Assert(null))->notNull();

    }, '', Assert::VALUE_NULL, AssertionFailedException::class)

    ->test('testValidString', function(Suite $suite) {

        (new Assert("test-string"))->string();
        (new Assert(""))->string();
    })

    ->test('testInvalidString', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidString') as $value )
        {
            (new Assert($value))->string();
        }

    }, '', Assert::INVALID_STRING, AssertionFailedException::class)

    ->test('testInvalidRegex', function(Suite $suite) {

        (new Assert("foo"))->regex("(bar)");

    }, '', Assert::INVALID_REGEX, AssertionFailedException::class)

    ->test('testInvalidRegexValueNotString', function(Suite $suite) {

        (new Assert(array("foo")))->regex("(bar)");

    }, '', Assert::INVALID_STRING, AssertionFailedException::class)

    ->test('testValidMinLength', function(Suite $suite) {

        (new Assert("foo"))->minLength(3);
        (new Assert("foo"))->minLength(1);
        (new Assert("foo"))->minLength(0);
        (new Assert(""))->minLength(0);
        (new Assert("址址"))->minLength(2);
    })

    ->test('testInvalidMinLength', function(Suite $suite) {

        (new Assert("foo"))->minLength(4);

    }, '', Assert::INVALID_MIN_LENGTH, AssertionFailedException::class)

    ->test('testValidMaxLength', function(Suite $suite) {

        (new Assert("foo"))->maxLength(10);
        (new Assert("foo"))->maxLength(3);
        (new Assert(""))->maxLength(0);
        (new Assert("址址"))->maxLength(2);
    })

    ->test('testInvalidMaxLength', function(Suite $suite) {

        (new Assert("foo"))->maxLength(2);

    }, '', Assert::INVALID_MAX_LENGTH, AssertionFailedException::class)

    ->test('testValidBetweenLength', function(Suite $suite) {

        (new Assert("foo"))->betweenLength(0, 3);
        (new Assert("址址"))->betweenLength(2, 2);
    })

    ->test('testInvalidBetweenLengthMin', function(Suite $suite) {

        (new Assert("foo"))->betweenLength(4, 100);

    }, '', Assert::INVALID_MIN_LENGTH, AssertionFailedException::class)

    ->test('testInvalidBetweenLengthMax', function(Suite $suite) {

        (new Assert("foo"))->betweenLength(0, 2);

    }, '', Assert::INVALID_MAX_LENGTH, AssertionFailedException::class)

    ->test('testValidStartsWith', function(Suite $suite) {

        (new Assert("foo"))->startsWith("foo");
        (new Assert("foo"))->startsWith("fo");
        (new Assert("foo"))->startsWith("f");
        (new Assert("址foo"))->startsWith("址");
    })

    ->test('testInvalidStartsWith', function(Suite $suite) {

        (new Assert("foo"))->startsWith("bar");

    }, '', Assert::INVALID_STRING_START, AssertionFailedException::class)

    ->test('testInvalidStartsWithDueToWrongEncoding', function(Suite $suite) {

        (new Assert("址"))->startsWith("址址", '', '', 'ASCII');

    }, '', Assert::INVALID_STRING_START, AssertionFailedException::class)

    ->test('testValidEndsWith', function(Suite $suite) {

        (new Assert("foo"))->endsWith("foo");
        (new Assert("sonderbar"))->endsWith("bar");
        (new Assert("opp"))->endsWith("p");
        (new Assert("foo址"))->endsWith("址");
    })

    ->test('testInvalidEndsWith', function(Suite $suite) {

        (new Assert("foo"))->endsWith("bar");

    }, '', Assert::INVALID_STRING_END, AssertionFailedException::class)

    ->test('testInvalidEndsWithDueToWrongEncoding', function(Suite $suite) {

        (new Assert("址"))->endsWith("址址", '', '', 'ASCII');

    }, '', Assert::INVALID_STRING_END, AssertionFailedException::class)

    ->test('testValidContains', function(Suite $suite) {

        (new Assert("foo"))->contains("foo");
        (new Assert("foo"))->contains("oo");
    })

    ->test('testInvalidContains', function(Suite $suite) {

        (new Assert("foo"))->contains("bar");
    
    }, '', Assert::INVALID_STRING_CONTAINS, AssertionFailedException::class)
    
    ->test('testValidChoice', function(Suite $suite) {

        (new Assert("foo"))->choice(array("foo"));
    })

    ->test('testInvalidChoice', function(Suite $suite) {

        (new Assert("foo"))->choice(array("bar", "baz"));
    
    }, '', Assert::INVALID_CHOICE, AssertionFailedException::class)


    ->test('testValidInArray', function(Suite $suite) {

        (new Assert("foo"))->inArray(array("foo"));
    })

    ->test('testInvalidInArray', function(Suite $suite) {

        (new Assert("bar"))->inArray(array("baz"));
    
    }, '', Assert::INVALID_CHOICE, AssertionFailedException::class)

    ->test('testValidNumeric', function(Suite $suite) {

        (new Assert("1"))->numeric();
        (new Assert(1))->numeric();
        (new Assert(1.23))->numeric();
    })

    ->test('testInvalidNumeric', function(Suite $suite) {

        (new Assert("foo"))->numeric();
    
    }, '', Assert::INVALID_NUMERIC, AssertionFailedException::class)

    ->test('testValidArray', function(Suite $suite) {

        (new Assert([]))->isArray();
        (new Assert(array(1,2,3)))->isArray();
        (new Assert(array([],[])))->isArray();
    })

    ->test('testInvalidArray', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidArray') as $value )
        {
            (new Assert($value))->isArray();
        }
    
    }, '', Assert::INVALID_ARRAY, AssertionFailedException::class)

    ->test('testValidKeyExists', function(Suite $suite) {

        (new Assert(array("foo" => "bar")))->keyExists("foo");
    })

    ->test('testInvalidKeyExists', function(Suite $suite) {

        (new Assert(array("foo" => "bar")))->keyExists("baz");
    
    }, '', Assert::INVALID_KEY_EXISTS, AssertionFailedException::class)

    ->test('testValidNotBlank', function(Suite $suite) {

        (new Assert("foo"))->notBlank();
    })

    ->test('testInvalidNotBlank', function(Suite $suite) {

        (new Assert(""))->notBlank();
    
    }, '', Assert::INVALID_NOT_BLANK, AssertionFailedException::class)

    ->test('testValidNotIsInstanceOf', function(Suite $suite) {

        (new Assert(new \stdClass))->notIsInstanceOf('PDO');
    })

    ->test('testInvalidNotInstanceOf', function(Suite $suite) {

        (new Assert(new \stdClass))->notIsInstanceOf('stdClass');
    
    }, '', Assert::INVALID_NOT_INSTANCE_OF, AssertionFailedException::class)

    ->test('testValidInstanceOf', function(Suite $suite) {

        (new Assert(new \stdClass))->isInstanceOf('stdClass');
    })

    ->test('testInvalidInstanceOf', function(Suite $suite) {

        (new Assert(new \stdClass))->isInstanceOf('PDO');
    
    }, '', Assert::INVALID_INSTANCE_OF, AssertionFailedException::class)

    ->test('testValidSubclassOf', function(Suite $suite) {

        (new Assert(new ChildStdClass))->subclassOf('stdClass');
    })

    ->test('testInvalidSubclassOf', function(Suite $suite) {

        (new Assert(new \stdClass))->subclassOf('PDO');
    
    }, '', Assert::INVALID_SUBCLASS_OF, AssertionFailedException::class)

    ->test('testValidRange', function(Suite $suite) {

        (new Assert(1))->range(1, 2);
        (new Assert(2))->range(1, 2);
        (new Assert(2))->range(0, 100);
        (new Assert(2.5))->range(2.25, 2.75);
    })

    ->test('testInvalidRange', function(Suite $suite) {

        (new Assert(1))->range(2, 3);
        (new Assert(1.5))->range(2, 3);
    
    }, '', Assert::INVALID_RANGE, AssertionFailedException::class)

    ->test('testValidEmail', function(Suite $suite) {

        (new Assert("123hello+world@email.provider.com"))->email();
    })

    ->test('testInvalidEmail', function(Suite $suite) {

        (new Assert("foo"))->email();
    
    }, '', Assert::INVALID_EMAIL, AssertionFailedException::class)

    ->test('testValidUserPrincipalName', function(Suite $suite) {

        (new Assert("johncitizen@email.provider.com"))->userPrincipalName();
    })

    ->test('testInvalidUserPrincipalName', function(Suite $suite) {

        (new Assert("johncitizen"))->userPrincipalName();
    
    }, '', Assert::INVALID_USERPRINCIPALNAME, AssertionFailedException::class)

    ->test('testValidUrl', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidUrl') as $value )
        {
            (new Assert($value))->url();
        }
    })

    ->test('testInvalidUrl', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidUrl') as $value )
        {
            (new Assert($value))->url();
        }

    }, '', Assert::INVALID_URL, AssertionFailedException::class)

    ->test('testValidDigit', function(Suite $suite) {

        (new Assert(1))->digit();
        (new Assert(0))->digit();
        (new Assert("0"))->digit();
    })

    ->test('testInvalidDigit', function(Suite $suite) {

        (new Assert(-1))->digit();
    
    }, '', Assert::INVALID_DIGIT, AssertionFailedException::class)

    ->test('testValidAlnum', function(Suite $suite) {

        (new Assert("a"))->alnum();
        (new Assert("a1"))->alnum();
        (new Assert("aasdf1234"))->alnum();
        (new Assert("a1b2c3"))->alnum();
    })

    ->test('testInvalidAlnum', function(Suite $suite) {

        (new Assert("1a"))->alnum();
    
    }, '', Assert::INVALID_ALNUM, AssertionFailedException::class)

    ->test('testValidTrue', function(Suite $suite) {

        (new Assert(1 == 1))->true();
    })

    ->test('testInvalidTrue', function(Suite $suite) {

        (new Assert(false))->true();
    
    }, '', Assert::INVALID_TRUE, AssertionFailedException::class)

    ->test('testValidFalse', function(Suite $suite) {

        (new Assert(1 == 0))->false();
    })

    ->test('testInvalidFalse', function(Suite $suite) {

        (new Assert(true))->false();
    
    }, '', Assert::INVALID_FALSE, AssertionFailedException::class)

    ->test('testValidClass', function(Suite $suite) {

        (new Assert("\\Exception"))->classExists();
    })

    ->test('testInvalidClass', function(Suite $suite) {

        (new Assert("Foo"))->classExists();
    
    }, '', Assert::INVALID_CLASS, AssertionFailedException::class)

    ->test('testValidSame', function(Suite $suite) {

        (new Assert(1))->same(1);
        (new Assert("foo"))->same("foo");
        (new Assert($obj = new \stdClass()))->same($obj);
    })

    ->test('testInvalidSame', function(Suite $suite) {

        (new Assert(new \stdClass()))->same(new \stdClass());
    
    }, '', Assert::INVALID_SAME, AssertionFailedException::class)

    ->test('testValidEq', function(Suite $suite) {

        (new Assert(1))->eq("1");
        (new Assert("foo"))->eq(true);
        (new Assert($obj = new \stdClass()))->eq($obj);
    })

    ->test('testInvalidEq', function(Suite $suite) {

        (new Assert("2"))->eq(1);
    
    }, '', Assert::INVALID_EQ, AssertionFailedException::class)

    ->test('testValidNotEq', function(Suite $suite) {

        (new Assert("1"))->notEq(false);
        (new Assert(new \stdClass()))->notEq([]);
    })

    ->test('testInvalidNotEq', function(Suite $suite) {

        (new Assert("1"))->notEq(1);
    
    }, '', Assert::INVALID_NOT_EQ, AssertionFailedException::class)

    ->test('testValidNotSame', function(Suite $suite) {

        (new Assert("1"))->notSame(2);
        (new Assert(new \stdClass()))->notSame([]);
    })

    ->test('testInvalidNotSame', function(Suite $suite) {

        (new Assert(1))->notSame(1);
    
    }, '', Assert::INVALID_NOT_SAME, AssertionFailedException::class)

    ->test('testValidMin', function(Suite $suite) {

        (new Assert(1))->min(1);
        (new Assert(2))->min(1);
        (new Assert(2.5))->min(1);
    })

    ->test('testInvalidMin', function(Suite $suite) {

        (new Assert(0))->min(1);
    
    }, '', Assert::INVALID_MIN, AssertionFailedException::class)

    ->test('testValidMax', function(Suite $suite) {

        (new Assert(1))->max(1);
        (new Assert(0.5))->max(1);
        (new Assert(0))->max(1);
    })

    ->test('testInvalidMax', function(Suite $suite) {

        (new Assert(2))->max(1);
    
    }, '', Assert::INVALID_MAX, AssertionFailedException::class)

    ->test('testNullOr', function(Suite $suite) {

        (new Assert(null))->nullOr()->max(1);
        (new Assert(null))->nullOr()->max(2);
    })

    ->test('testValidLength', function(Suite $suite) {

        (new Assert("asdf"))->length(4);
        (new Assert(""))->length(0);
    })

    ->test('testInvalidLength', function(Suite $suite) {

        (new Assert("asdf"))->length(3);
    
    }, '', Assert::INVALID_LENGTH, AssertionFailedException::class)

    ->test('testValidLengthUtf8Characters', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidLengthUtf8Characters') as $value => $expected )
        {
            (new Assert($value))->length($expected);
        }
    })

    ->test('testInvalidLengthForWrongEncoding', function(Suite $suite) {

        (new Assert("址"))->length(1, '', '', 'ASCII');
    
    }, '', Assert::INVALID_LENGTH, AssertionFailedException::class)

    ->test('testValidLengthForGivenEncoding', function(Suite $suite) {

        (new Assert("址"))->length(1, '', '', 'utf8');
    })

    ->test('testValidFile', function(Suite $suite) {

        (new Assert(__FILE__))->file();
    })

    ->test('testInvalidFileForEmptyFilename', function(Suite $suite) {

        (new Assert(""))->file();

    }, '', Assert::VALUE_EMPTY, AssertionFailedException::class)

    ->test('testInvalidFileForDoesNotExist', function(Suite $suite) {

        (new Assert(__DIR__ . '/does-not-exists'))->file();

    }, '', Assert::INVALID_FILE, AssertionFailedException::class)

    ->test('testValidDirectory', function(Suite $suite) {

        (new Assert(__DIR__))->directory();
    })

    ->test('testInvalidDirectory', function(Suite $suite) {

        (new Assert(__DIR__ . '/does-not-exist'))->directory();

    }, '', Assert::INVALID_DIRECTORY, AssertionFailedException::class)

    ->test('testValidReadable', function(Suite $suite) {

        (new Assert(__FILE__))->readable();
    })

    ->test('testInvalidReadable', function(Suite $suite) {

        (new Assert(__DIR__ . '/does-not-exist'))->readable();

    }, '', Assert::INVALID_READABLE, AssertionFailedException::class)

    ->test('testValidWriteable', function(Suite $suite) {

        (new Assert(sys_get_temp_dir()))->writeable();
    })

    ->test('testInvalidWriteable', function(Suite $suite) {

        (new Assert(__DIR__ . '/does-not-exist'))->writeable();

    }, '', Assert::INVALID_WRITEABLE, AssertionFailedException::class)

    ->test('testValidImplementsInterface', function(Suite $suite) {

        (new Assert('\ArrayIterator'))->implementsInterface('\Traversable');
    })

    ->test('testInvalidImplementsInterface', function(Suite $suite) {

        (new Assert('\Exception'))->implementsInterface('\Traversable');

    }, '', Assert::INTERFACE_NOT_IMPLEMENTED, AssertionFailedException::class)

    ->test('testValidImplementsInterfaceWithClassObject', function(Suite $suite) {

        $class = new \ArrayObject();

        (new Assert($class))->implementsInterface('\Traversable');
    })

    ->test('testInvalidImplementsInterfaceWithClassObject', function(Suite $suite) {

        $class = new \ArrayObject();

        (new Assert($class))->implementsInterface('\SplObserver');

    }, '', Assert::INTERFACE_NOT_IMPLEMENTED, AssertionFailedException::class)

    ->test('testValidIsJsonString', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidIsJsonString') as $value )
        {
            (new Assert($value))->isJsonString();
        }
    })

    ->test('testInvalidIsJsonString', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidIsJsonString') as $value )
        {
            (new Assert($value))->isJsonString();
        }

    }, '', Assert::INVALID_JSON_STRING, AssertionFailedException::class)

    ->test('testValidSamAccountName', function(Suite $suite) {

        (new Assert('johncitizen'))->samAccountName();
        (new Assert('jcitiz'))->samAccountName();
        (new Assert('jcitiz123'))->samAccountName();
    })

    ->test('testInvalidSamAccountName', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidSamAccountName') as $value )
        {
            (new Assert($value))->samAccountName();
        }

    }, '', Assert::INVALID_SAMACCOUNTNAME, AssertionFailedException::class)

    ->test('testValidUuids', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidUuids') as $value )
        {
            (new Assert($value))->uuid();
        }
    })

    ->test('testInvalidUuids', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidUuids') as $value )
        {
            (new Assert($value))->uuid();
        }

    }, '', Assert::INVALID_UUID, AssertionFailedException::class)

    ->test('testValidNotEmptyKey', function(Suite $suite) {

        (new Assert(array('keyExists' => 'notEmpty')))->notEmptyKey('keyExists');
    })

    ->test('testInvalidNotEmptyKey', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidNotEmptyKey') as $key => $value )
        {
            (new Assert($value))->notEmptyKey($key);
        }
    })

    ->test('testAllWithSimpleAssertion', function(Suite $suite) {

        (new Assert(array(true, true)))->all()->true();
    })

    ->test('testAllWithSimpleAssertionThrowsExceptionOnElementThatFailsAssertion', function(Suite $suite) {

        (new Assert([true, false]))->all()->true();

    }, '', Assert::INVALID_TRUE, AssertionFailedException::class)

    ->test('testAllWithComplexAssertion', function(Suite $suite) {

        (new Assert([new \stdClass, new \stdClass]))->all()->isInstanceOf('stdClass');
    })

    ->test('testAllWithComplexAssertionThrowsExceptionOnElementThatFailsAssertion', function(Suite $suite) {

        (new Assert([new \stdClass, new \stdClass]))->all()->isInstanceOf('PDO', 'Assertion failed', 'foos');

    }, '', Assert::INVALID_INSTANCE_OF, AssertionFailedException::class)
    /**

     */
    ->test('testAllWithNoValueThrows', function(Suite $suite) {

        (new Assert(null))->all()->true();
    })

    ->test('testValidCount', function(Suite $suite) {

        (new Assert(array('Hi')))->count(1);
        (new Assert(new OneCountable()))->count(1);
    })

    ->test('testInvalidCount', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidCount') as $key => $value )
        {
            (new Assert($key))->count($value);
        }

    }, '', Assert::INVALID_COUNT, AssertionFailedException::class)

    ->test('testChoicesNotEmpty', function(Suite $suite) {

        (new Assert(array('tux' => 'linux', 'Gnu' => 'dolphin')))->choicesNotEmpty(array('tux'));
    })

    ->test('testInvalidChoicesNotEmptyForValueEmpty', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidChoicesForValueEmpty') as $key => $value )
        {
            (new Assert($key))->choicesNotEmpty($value);
        }

    }, '', Assert::VALUE_EMPTY, AssertionFailedException::class)

    ->test('testInvalidChoicesNotEmptyForInvalidKeySet', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidChoicesForValueEmpty') as $key => $value )
        {
            (new Assert($key))->choicesNotEmpty($value);
        }

    }, '', Assert::INVALID_KEY_ISSET, AssertionFailedException::class)

    ->test('testValidIsObject', function(Suite $suite) {

        (new Assert(new \stdClass))->isObject();
    })

    ->test('testInvalidIsObject', function(Suite $suite) {

        (new Assert('notAnObject'))->isObject();

    }, '', Assert::INVALID_OBJECT, AssertionFailedException::class)

    ->test('testValidMethodExists', function(Suite $suite) {

        (new Assert('methodExists'))->methodExists(new Assert(null));
    })

    ->test('testValidChaining', function(Suite $suite) {

        (new Assert(1))->integer()->integerish()->numeric()->notNull()->eq(1);
        (new Assert(array(1,1,1,1,1,1,)))->allIds()->integerish()->numeric()->notNull()->eq(1);
    })

    ->test('testChainingFails', function(Suite $suite) {

        (new Assert(1))->integer()->integerish()->numeric()->notNull()->eq(2);

    }, '', Assert::INVALID_EQ, AssertionFailedException::class)

    ->test('testAllChainingFails', function(Suite $suite) {

        (new Assert(array(1,1,1,1,1,2,)))->all()->id()->integerish()->numeric()->notNull()->eq(1);

    }, '', Assert::INVALID_EQ, AssertionFailedException::class)

//    ->test('it_passes_values_and_constraints_to_exception', function(Suite $suite) {
//
//        try {
//            (new Assert(0))->range(10, 20);
//
//            static::fail('Exception expected');
//        } catch (AssertionFailedException $e) {
//            $this->assertEquals(0, $e->getValue());
//            $this->assertEquals(array('min' => 10, 'max' => 20), $e->getConstraints());
//        })    })}
;