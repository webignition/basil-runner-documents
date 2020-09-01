<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\Test;
use webignition\BasilRunnerDocuments\TestConfiguration;

class TestTest extends TestCase
{
    public function testGetType()
    {
        $test = new Test(
            'test.yml',
            new TestConfiguration('chrome', 'http://example.com')
        );
        self::assertSame('test', $test->getType());
    }

    /**
     * @dataProvider getDataDataProvider
     *
     * @param Test $test
     * @param array<mixed> $expectedData
     */
    public function testGetData(Test $test, array $expectedData)
    {
        self::assertSame($expectedData, $test->getData());
    }

    public function getDataDataProvider(): array
    {
        return [
            'test1.yml, chrome, http://example.com' => [
                'test' => new Test(
                    'test1.yml',
                    new TestConfiguration('chrome', 'http://example.com')
                ),
                'expectedData' => [
                    'path' => 'test1.yml',
                    'config' => [
                        'browser' => 'chrome',
                        'url' => 'http://example.com'
                    ],
                ],
            ],
            'test2.yml, firefox, http://example.org' => [
                'test' => new Test(
                    'test2.yml',
                    new TestConfiguration('firefox', 'http://example.org')
                ),
                'expectedData' => [
                    'path' => 'test2.yml',
                    'config' => [
                        'browser' => 'firefox',
                        'url' => 'http://example.org'
                    ],
                ],
            ],
        ];
    }
}
