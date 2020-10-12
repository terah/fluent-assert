<?php declare(strict_types=1);

namespace Terah\Assert\Test;

use Terah\Assert\Assert;
use Terah\Assert\AssertionFailedException;
use Terah\Assert\Tester;
use Terah\Assert\Suite;
use Terah\Assert\ValidationFailedException;

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
        '址'                                                    => 1,
        'ل'                                                     => 1,
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

    ->fixture('InvalidUncs', [
        '\\server\\someFolder',
        'server\\somePath',
        '\\\\\\server\\\\somePath',
    ])

    ->fixture('InvalidDriveLetters', [
        'A drive',
        'A:\\',
        'A',
    ])

    ->fixture('InvalidUuids', [
        'zf6f8cb0-c57d-11e1-9b21-0800200c9a66',
        'af6f8cb0c57d11e19b210800200c9a66',
        'ff6f8cb0-c57da-51e1-9b21-0800200c9a66',
        'af6f8cb-c57d-11e1-9b21-0800200c9a66',
        '3f6f8cb0-c57d-11e1-9b21-0800200c9a6',
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

        Assert::that(1.0)->float();
        Assert::that(0.1)->float();
        Assert::that(-1.1)->float();
    })

    ->test('testInvalidFloat', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidFloats') as $value )
        {
            Assert::that($value)->float();
        }

    }, '', Assert::INVALID_FLOAT, AssertionFailedException::class)

    ->test('testValidInteger', function(Suite $suite) {

        Assert::that(10)->integer();
        Assert::that(0)->integer();
    })

    ->test('testInvalidInteger', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidIntegers') as $value )
        {
            Assert::that($value)->integer();
        }

    }, '', Assert::INVALID_INTEGER, AssertionFailedException::class)

    ->test('testValidIntegerish', function(Suite $suite) {

        Assert::that(10)->integerish();
        Assert::that("10")->integerish();
    })

    ->test('testInvalidIntegerish', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidIntegerish') as $value )
        {
            Assert::that($value)->integerish();
        }

    }, '', Assert::INVALID_INTEGERISH, AssertionFailedException::class)

    ->test('testValidBoolean', function(Suite $suite) {

        Assert::that(true)->boolean();
        Assert::that(false)->boolean();
    })

    ->test('testInvalidBoolean', function(Suite $suite) {

        Assert::that(1)->boolean();

    }, '', Assert::INVALID_BOOLEAN, AssertionFailedException::class)

    ->test('testValidScalar', function(Suite $suite) {

        Assert::that("foo")->scalar();
        Assert::that(52)->scalar();
        Assert::that(12.34)->scalar();
        Assert::that(false)->scalar();
    })

    ->test('testInvalidScalar', function(Suite $suite) {

        Assert::that(new \stdClass)->scalar();

    }, '', Assert::INVALID_SCALAR, AssertionFailedException::class)

    ->test('testValidNotEmpty', function(Suite $suite) {

        Assert::that("test")->notEmpty();
        Assert::that(1)->notEmpty();
        Assert::that(true)->notEmpty();
        Assert::that(['foo'])->notEmpty();
    })

    ->test('testInvalidNotEmpty', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidNotEmpty') as $value )
        {
            Assert::that($value)->notEmpty();
        }

    }, '', Assert::VALUE_EMPTY, AssertionFailedException::class)

    ->test('testValidEmpty', function(Suite $suite) {

        Assert::that("")->noContent();
        Assert::that(0)->noContent();
        Assert::that(false)->noContent();
        Assert::that([])->noContent();
    })

    ->test('testInvalidEmpty', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidEmpty') as $value )
        {
            Assert::that($value)->noContent();
        }

    }, '', Assert::VALUE_NOT_EMPTY, AssertionFailedException::class)

    ->test('testValidNotNull', function(Suite $suite) {

        Assert::that("1")->notNull();
        Assert::that(1)->notNull();
        Assert::that(0)->notNull();
        Assert::that([])->notNull();
        Assert::that(false)->notNull();
    })

    ->test('testInvalidNotNull', function(Suite $suite) {

        Assert::that(null)->notNull();

    }, '', Assert::VALUE_NULL, AssertionFailedException::class)

    ->test('testValidString', function(Suite $suite) {

        Assert::that("test-string")->string();
        Assert::that("")->string();
    })

    ->test('testInvalidString', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidString') as $value )
        {
            Assert::that($value)->string();
        }

    }, '', Assert::INVALID_STRING, AssertionFailedException::class)

    ->test('testInvalidRegex', function(Suite $suite) {

        Assert::that("foo")->regex("(bar)");

    }, '', Assert::INVALID_REGEX, AssertionFailedException::class)

    ->test('testInvalidRegexValueNotString', function(Suite $suite) {

        Assert::that(['foo'])->regex("(bar)");

    }, '', Assert::INVALID_STRING, AssertionFailedException::class)

    ->test('testValidMinLength', function(Suite $suite) {

        Assert::that("foo")->minLength(3);
        Assert::that("foo")->minLength(1);
        Assert::that("foo")->minLength(0);
        Assert::that("")->minLength(0);
        Assert::that("址址")->minLength(2);
    })

    ->test('testInvalidMinLength', function(Suite $suite) {

        Assert::that("foo")->minLength(4);

    }, '', Assert::INVALID_MIN_LENGTH, AssertionFailedException::class)

    ->test('testValidMaxLength', function(Suite $suite) {

        Assert::that("foo")->maxLength(10);
        Assert::that("foo")->maxLength(3);
        Assert::that("")->maxLength(0);
        Assert::that("址址")->maxLength(2);
    })

    ->test('testInvalidMaxLength', function(Suite $suite) {

        Assert::that("foo")->maxLength(2);

    }, '', Assert::INVALID_MAX_LENGTH, AssertionFailedException::class)

    ->test('testValidBetweenLength', function(Suite $suite) {

        Assert::that("foo")->betweenLength(0, 3);
        Assert::that("址址")->betweenLength(2, 2);
    })

    ->test('testInvalidBetweenLengthMin', function(Suite $suite) {

        Assert::that("foo")->betweenLength(4, 100);

    }, '', Assert::INVALID_MIN_LENGTH, AssertionFailedException::class)

    ->test('testInvalidBetweenLengthMax', function(Suite $suite) {

        Assert::that("foo")->betweenLength(0, 2);

    }, '', Assert::INVALID_MAX_LENGTH, AssertionFailedException::class)

    ->test('testValidStartsWith', function(Suite $suite) {

        Assert::that("foo")->startsWith("foo");
        Assert::that("foo")->startsWith("fo");
        Assert::that("foo")->startsWith("f");
        Assert::that("址foo")->startsWith("址");
    })

    ->test('testInvalidStartsWith', function(Suite $suite) {

        Assert::that("foo")->startsWith("bar");

    }, '', Assert::INVALID_STRING_START, AssertionFailedException::class)

    ->test('testInvalidStartsWithDueToWrongEncoding', function(Suite $suite) {

        Assert::that("址")->startsWith("址址", '', '', 'ASCII');

    }, '', Assert::INVALID_STRING_START, AssertionFailedException::class)

    ->test('testValidEndsWith', function(Suite $suite) {

        Assert::that("foo")->endsWith("foo");
        Assert::that("sonderbar")->endsWith("bar");
        Assert::that("opp")->endsWith("p");
        Assert::that("foo址")->endsWith("址");
    })

    ->test('testInvalidEndsWith', function(Suite $suite) {

        Assert::that("foo")->endsWith("bar");

    }, '', Assert::INVALID_STRING_END, AssertionFailedException::class)

    ->test('testInvalidEndsWithDueToWrongEncoding', function(Suite $suite) {

        Assert::that("址")->endsWith("址址", '', '', 'ASCII');

    }, '', Assert::INVALID_STRING_END, AssertionFailedException::class)

    ->test('testValidContains', function(Suite $suite) {

        Assert::that("foo")->contains("foo");
        Assert::that("foo")->contains("oo");
    })

    ->test('testInvalidContains', function(Suite $suite) {

        Assert::that("foo")->contains("bar");

    }, '', Assert::INVALID_STRING_CONTAINS, AssertionFailedException::class)

    ->test('testValidChoice', function(Suite $suite) {

        Assert::that("foo")->choice(['foo']);
    })

    ->test('testInvalidChoice', function(Suite $suite) {

        Assert::that("foo")->choice(["bar", "baz"]);

    }, '', Assert::INVALID_CHOICE, AssertionFailedException::class)


    ->test('testValidInArray', function(Suite $suite) {

        Assert::that("foo")->inArray(['foo']);
    })

    ->test('testInvalidInArray', function(Suite $suite) {

        Assert::that("bar")->inArray(["baz"]);

    }, '', Assert::INVALID_CHOICE, AssertionFailedException::class)

    ->test('testValidNumeric', function(Suite $suite) {

        Assert::that("1")->numeric();
        Assert::that(1)->numeric();
        Assert::that(1.23)->numeric();
    })

    ->test('testInvalidNumeric', function(Suite $suite) {

        Assert::that("foo")->numeric();

    }, '', Assert::INVALID_NUMERIC, AssertionFailedException::class)

    ->test('testValidArray', function(Suite $suite) {

        Assert::that([])->isArray();
        Assert::that([1,2,3])->isArray();
        Assert::that([[],[]])->isArray();
    })

    ->test('testInvalidArray', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidArray') as $value )
        {
            Assert::that($value)->isArray();
        }

    }, '', Assert::INVALID_ARRAY, AssertionFailedException::class)

    ->test('testValidKeyExists', function(Suite $suite) {

        Assert::that(["foo" => "bar"])->keyExists("foo");
    })

    ->test('testInvalidKeyExists', function(Suite $suite) {

        Assert::that(["foo" => "bar"])->keyExists("baz");

    }, '', Assert::INVALID_KEY_EXISTS, AssertionFailedException::class)

    ->test('testValidNotBlank', function(Suite $suite) {

        Assert::that("foo")->notBlank();
    })

    ->test('testInvalidNotBlank', function(Suite $suite) {

        Assert::that("")->notBlank();

    }, '', Assert::INVALID_NOT_BLANK, AssertionFailedException::class)

    ->test('testValidNotIsInstanceOf', function(Suite $suite) {

        Assert::that(new \stdClass)->notIsInstanceOf('PDO');
    })

    ->test('testInvalidNotInstanceOf', function(Suite $suite) {

        Assert::that(new \stdClass)->notIsInstanceOf('stdClass');

    }, '', Assert::INVALID_NOT_INSTANCE_OF, AssertionFailedException::class)

    ->test('testValidInstanceOf', function(Suite $suite) {

        Assert::that(new \stdClass)->isInstanceOf('stdClass');
    })

    ->test('testInvalidInstanceOf', function(Suite $suite) {

        Assert::that(new \stdClass)->isInstanceOf('PDO');

    }, '', Assert::INVALID_INSTANCE_OF, AssertionFailedException::class)

    ->test('testValidSubclassOf', function(Suite $suite) {

        Assert::that(new class extends \stdClass{})->subclassOf('stdClass');
    })

    ->test('testInvalidSubclassOf', function(Suite $suite) {

        Assert::that(new \stdClass)->subclassOf('PDO');

    }, '', Assert::INVALID_SUBCLASS_OF, AssertionFailedException::class)

    ->test('testValidRange', function(Suite $suite) {

        Assert::that(1)->range(1, 2);
        Assert::that(2)->range(1, 2);
        Assert::that(2)->range(0, 100);
        Assert::that(2.5)->range(2.25, 2.75);
    })

    ->test('testInvalidRange', function(Suite $suite) {

        Assert::that(1)->range(2, 3);
        Assert::that(1.5)->range(2, 3);

    }, '', Assert::INVALID_RANGE, AssertionFailedException::class)

    ->test('testValidEmail', function(Suite $suite) {

        Assert::that("123hello+world@email.provider.com")->email();
    })

    ->test('testInvalidEmail', function(Suite $suite) {

        Assert::that("foo")->email();

    }, '', Assert::INVALID_EMAIL, AssertionFailedException::class)

    ->test('testValidUserPrincipalName', function(Suite $suite) {

        Assert::that("johncitizen@email.provider.com")->userPrincipalName();
    })

    ->test('testInvalidUserPrincipalName', function(Suite $suite) {

        Assert::that("johncitizen")->userPrincipalName();

    }, '', Assert::INVALID_USERPRINCIPALNAME, AssertionFailedException::class)

    ->test('testValidUrl', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidUrl') as $value )
        {
            Assert::that($value)->url();
        }
    })

    ->test('testInvalidUrl', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidUrl') as $value )
        {
            Assert::that($value)->url();
        }

    }, '', Assert::INVALID_URL, AssertionFailedException::class)

    ->test('testValidDigit', function(Suite $suite) {

        Assert::that(1)->digit();
        Assert::that(0)->digit();
        Assert::that("0")->digit();
    })

    ->test('testInvalidDigit', function(Suite $suite) {

        Assert::that(-1)->digit();

    }, '', Assert::INVALID_DIGIT, AssertionFailedException::class)

    ->test('testValidAlnum', function(Suite $suite) {

        Assert::that("a")->alnum();
        Assert::that("a1")->alnum();
        Assert::that("aasdf1234")->alnum();
        Assert::that("a1b2c3")->alnum();
    })

    ->test('testInvalidAlnum', function(Suite $suite) {

        Assert::that("1a")->alnum();

    }, '', Assert::INVALID_ALNUM, AssertionFailedException::class)

    ->test('testValidTrue', function(Suite $suite) {

        Assert::that(1 == 1)->true();
    })

    ->test('testInvalidTrue', function(Suite $suite) {

        Assert::that(false)->true();

    }, '', Assert::INVALID_TRUE, AssertionFailedException::class)

    ->test('testValidFalse', function(Suite $suite) {

        Assert::that(1 == 0)->false();
    })

    ->test('testInvalidFalse', function(Suite $suite) {

        Assert::that(true)->false();

    }, '', Assert::INVALID_FALSE, AssertionFailedException::class)

    ->test('testValidClass', function(Suite $suite) {

        Assert::that("\\Exception")->classExists();
    })

    ->test('testInvalidClass', function(Suite $suite) {

        Assert::that("Foo")->classExists();

    }, '', Assert::INVALID_CLASS, AssertionFailedException::class)

    ->test('testValidSame', function(Suite $suite) {

        Assert::that(1)->same(1);
        Assert::that("foo")->same("foo");
        Assert::that($obj = new \stdClass())->same($obj);
    })

    ->test('testInvalidSame', function(Suite $suite) {

        Assert::that(new \stdClass())->same(new \stdClass());

    }, '', Assert::INVALID_SAME, AssertionFailedException::class)

    ->test('testValidEq', function(Suite $suite) {

        Assert::that(1)->eq("1");
        Assert::that("foo")->eq(true);
        Assert::that($obj = new \stdClass())->eq($obj);
    })

    ->test('testInvalidEq', function(Suite $suite) {

        Assert::that("2")->eq(1);

    }, '', Assert::INVALID_EQ, AssertionFailedException::class)

    ->test('testValidNotEq', function(Suite $suite) {

        Assert::that("1")->notEq(false);
        Assert::that(new \stdClass())->notEq([]);
    })

    ->test('testInvalidNotEq', function(Suite $suite) {

        Assert::that("1")->notEq(1);

    }, '', Assert::INVALID_NOT_EQ, AssertionFailedException::class)

    ->test('testValidNotSame', function(Suite $suite) {

        Assert::that("1")->notSame(2);
        Assert::that(new \stdClass())->notSame([]);
    })

    ->test('testInvalidNotSame', function(Suite $suite) {

        Assert::that(1)->notSame(1);

    }, '', Assert::INVALID_NOT_SAME, AssertionFailedException::class)

    ->test('testValidMin', function(Suite $suite) {

        Assert::that(1)->min(1);
        Assert::that(2)->min(1);
        Assert::that(2.5)->min(1);
    })

    ->test('testInvalidMin', function(Suite $suite) {

        Assert::that(0)->min(1);

    }, '', Assert::INVALID_MIN, AssertionFailedException::class)

    ->test('testValidMax', function(Suite $suite) {

        Assert::that(1)->max(1);
        Assert::that(0.5)->max(1);
        Assert::that(0)->max(1);
    })

    ->test('testInvalidMax', function(Suite $suite) {

        Assert::that(2)->max(1);

    }, '', Assert::INVALID_MAX, AssertionFailedException::class)

    ->test('testNullOr', function(Suite $suite) {

        Assert::that(null)->nullOr()->max(1);
        Assert::that(null)->nullOr()->max(2);
    })

    ->test('testValidLength', function(Suite $suite) {

        Assert::that("asdf")->length(4);
        Assert::that("")->length(0);
    })

    ->test('testInvalidLength', function(Suite $suite) {

        Assert::that("asdf")->length(3);

    }, '', Assert::INVALID_LENGTH, AssertionFailedException::class)

    ->test('testValidLengthUtf8Characters', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidLengthUtf8Characters') as $value => $expected )
        {
            Assert::that($value)->length($expected);
        }
    })

    ->test('testInvalidLengthForWrongEncoding', function(Suite $suite) {

        Assert::that("址")->length(1, '', '', 'ASCII');

    }, '', Assert::INVALID_LENGTH, AssertionFailedException::class)

    ->test('testValidLengthForGivenEncoding', function(Suite $suite) {

        Assert::that("址")->length(1, '', '', 'utf8');
    })

    ->test('testValidFile', function(Suite $suite) {

        Assert::that(__FILE__)->file();
    })

    ->test('testInvalidFileForEmptyFilename', function(Suite $suite) {

        Assert::that("")->file();

    }, '', Assert::VALUE_EMPTY, AssertionFailedException::class)

    ->test('testInvalidFileForDoesNotExist', function(Suite $suite) {

        Assert::that(__DIR__ . '/does-not-exists')->file();

    }, '', Assert::INVALID_FILE, AssertionFailedException::class)

    ->test('testValidDirectory', function(Suite $suite) {

        Assert::that(__DIR__)->directory();
    })

    ->test('testInvalidDirectory', function(Suite $suite) {

        Assert::that(__DIR__ . '/does-not-exist')->directory();

    }, '', Assert::INVALID_DIRECTORY, AssertionFailedException::class)

    ->test('testValidReadable', function(Suite $suite) {

        Assert::that(__FILE__)->readable();
    })

    ->test('testInvalidReadable', function(Suite $suite) {

        Assert::that(__DIR__ . '/does-not-exist')->readable();

    }, '', Assert::INVALID_READABLE, AssertionFailedException::class)

    ->test('testValidWriteable', function(Suite $suite) {

        Assert::that(sys_get_temp_dir())->writeable();
    })

    ->test('testInvalidWriteable', function(Suite $suite) {

        Assert::that(__DIR__ . '/does-not-exist')->writeable();

    }, '', Assert::INVALID_WRITEABLE, AssertionFailedException::class)

    ->test('testValidImplementsInterface', function(Suite $suite) {

        Assert::that('\ArrayIterator')->implementsInterface('\Traversable');
    })

    ->test('testInvalidImplementsInterface', function(Suite $suite) {

        Assert::that('\Exception')->implementsInterface('\Traversable');

    }, '', Assert::INTERFACE_NOT_IMPLEMENTED, AssertionFailedException::class)

    ->test('testValidImplementsInterfaceWithClassObject', function(Suite $suite) {

        $class = new \ArrayObject();

        Assert::that($class)->implementsInterface('\Traversable');
    })

    ->test('testInvalidImplementsInterfaceWithClassObject', function(Suite $suite) {

        $class = new \ArrayObject();

        Assert::that($class)->implementsInterface('\SplObserver');

    }, '', Assert::INTERFACE_NOT_IMPLEMENTED, AssertionFailedException::class)

    ->test('testValidIsJsonString', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidIsJsonString') as $value )
        {
            Assert::that($value)->isJsonString();
        }
    })

    ->test('testInvalidIsJsonString', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidIsJsonString') as $value )
        {
            Assert::that($value)->isJsonString();
        }

    }, '', Assert::INVALID_JSON_STRING, AssertionFailedException::class)

    ->test('testValidSamAccountName', function(Suite $suite) {

        Assert::that('johncitizen')->samAccountName();
        Assert::that('jcitiz')->samAccountName();
        Assert::that('jcitiz123')->samAccountName();
    })

    ->test('testInvalidSamAccountName', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidSamAccountName') as $value )
        {
            Assert::that($value)->samAccountName();
        }

    }, '', Assert::INVALID_SAMACCOUNTNAME, AssertionFailedException::class)

    ->test('testValidUnc', function(Suite $suite) {

        Assert::that('\\\\some.server\\folderName')->unc();
        Assert::that('\\\\some.server\\folderName\\someOtherFolderName')->unc();
    })

    ->test('testInvalidUnc', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidUncs') as $value )
        {
            Assert::that($value)->unc();
        }

    }, '', Assert::INVALID_UNC_PATH, AssertionFailedException::class)

    ->test('testValidDriveLetter', function(Suite $suite) {

        Assert::that('A:')->driveLetter();
        Assert::that('h:')->driveLetter();
    })

    ->test('testInvalidDriveLetter', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidDriveLetters') as $value )
        {
            Assert::that($value)->driveLetter();
        }

    }, '', Assert::INVALID_DRIVE_LETTER, AssertionFailedException::class)


    ->test('testValidUuids', function(Suite $suite) {

        foreach ( $suite->getFixture('ValidUuids') as $value )
        {
            Assert::that($value)->uuid();
        }
    })

    ->test('testInvalidUuids', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidUuids') as $value )
        {
            Assert::that($value)->uuid();
        }

    }, '', Assert::INVALID_UUID, AssertionFailedException::class)

    ->test('testValidNotEmptyKey', function(Suite $suite) {

        Assert::that(['keyExists' => 'notEmpty'])->notEmptyKey('keyExists');
    })

    ->test('testInvalidNotEmptyKey', function(Suite $suite) {

        $tests                  = [
            'testKey'               => ['testKey'   => 'I am not empty'],
            'testKey2'              => ['testKey2'  => ['I am not empty', 'I am not empty']],
        ];
        foreach ( $tests as $key => $value )
        {
            Assert::that($value)->notEmptyKey($key);
        }
    })

    ->test('testAllWithSimpleAssertion', function(Suite $suite) {

        Assert::that([true, true])->all()->true();
    })

    ->test('testAllWithSimpleAssertionThrowsExceptionOnElementThatFailsAssertion', function(Suite $suite) {

        Assert::that([true, false])->all()->true();

    }, '', Assert::INVALID_TRUE, AssertionFailedException::class)

    ->test('testAllWithComplexAssertion', function(Suite $suite) {

        Assert::that([new \stdClass, new \stdClass])->all()->isInstanceOf('stdClass');
    })

    ->test('testAllWithComplexAssertionThrowsExceptionOnElementThatFailsAssertion', function(Suite $suite) {

        Assert::that([new \stdClass, new \stdClass])->all()->isInstanceOf('PDO', 'Assertion failed', 'foos');

    }, '', Assert::INVALID_INSTANCE_OF, AssertionFailedException::class)

    ->test('testAllWithNoValueThrows', function(Suite $suite) {

        Assert::that(null)->all()->true();

    }, '', Assert::INVALID_TRAVERSABLE, AssertionFailedException::class)

    ->test('testValidCount', function(Suite $suite) {

        Assert::that(['Hi'])->count(1);
        Assert::that(new class implements \Countable {public function count(){return 1;}})->count(1);
    })

    ->test('testInvalidCount', function(Suite $suite) {

        foreach ( $suite->getFixture('InvalidCount') as $key => $value )
        {
            Assert::that($value)->count($key);
        }

    }, '', Assert::INVALID_COUNT, AssertionFailedException::class)

    ->test('testChoicesNotEmpty', function(Suite $suite) {

        Assert::that(['tux' => 'linux', 'Gnu' => 'dolphin'])->choicesNotEmpty(['tux']);
    })

    ->test('testInvalidChoicesNotEmptyForValueEmpty', function(Suite $suite) {

        $tests = [
            'choice not found in values' => [['tux' => ''], ['invalidChoice'], Assert::INVALID_KEY_ISSET]
        ];
        foreach ( $tests as $key => $value )
        {
            Assert::that($key)->choicesNotEmpty($value);
        }

    }, '', Assert::INVALID_ARRAY_ACCESSIBLE, AssertionFailedException::class)

    ->test('testInvalidChoicesNotEmptyForInvalidKeySet', function(Suite $suite) {

        $test =  [
            'empty values' => [[], ['tux']],
            'empty recodes in $values' => [['tux' => ''], ['tux']]
        ];
        foreach ( $test as $key => $value )
        {
            Assert::that($key)->choicesNotEmpty($value);
        }

    }, '', Assert::INVALID_ARRAY_ACCESSIBLE, AssertionFailedException::class)

    ->test('testValidIsObject', function(Suite $suite) {

        Assert::that(new \stdClass)->isObject();
    })

    ->test('testInvalidIsObject', function(Suite $suite) {

        Assert::that('notAnObject')->isObject();

    }, '', Assert::INVALID_OBJECT, AssertionFailedException::class)

    ->test('testValidMethodExists', function(Suite $suite) {

        Assert::that('methodExists')->methodExistsAssert::that(null);
    })

    ->test('testValidChaining', function(Suite $suite) {

        Assert::that(1)->integer()->integerish()->numeric()->notNull()->eq(1);
        Assert::that([1,1,1,1,1,1,])->allIds()->integerish()->numeric()->notNull()->eq(1);
    })

    ->test('testChainingFails', function(Suite $suite) {

        Assert::that(1)->integer()->integerish()->numeric()->notNull()->eq(2);

    }, '', Assert::INVALID_EQ, AssertionFailedException::class)

    ->test('testAllChainingFails', function(Suite $suite) {

        Assert::that([1,1,1,1,1,2,])->all()->id()->integerish()->numeric()->notNull()->eq(1);

    }, '', Assert::INVALID_EQ, AssertionFailedException::class)


    ->test('testDifferentExceptionError', function(Suite $suite) {

        Assert::that(1)->setExceptionClass(ValidationFailedException::class)->eq(2);

    }, '', Assert::INVALID_EQ, ValidationFailedException::class)

;