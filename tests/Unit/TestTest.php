<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\Test;
use webignition\BasilRunnerDocuments\TestConfiguration;

class TestTest extends TestCase
{
    /**
     * @dataProvider getDataDataProvider
     *
     * @param array<mixed> $expectedData
     */
    public function testGetData(Test $test, array $expectedData): void
    {
        self::assertSame($expectedData, $test->getData());
    }

    /**
     * @return array<mixed>
     */
    public function getDataDataProvider(): array
    {
        return [
            'test1.yml, chrome, http://example.com' => [
                'test' => new Test(
                    'test1.yml',
                    new TestConfiguration('chrome', 'http://example.com')
                ),
                'expectedData' => [
                    'type' => Test::TYPE,
                    'payload' => [
                        'path' => 'test1.yml',
                        'config' => [
                            'browser' => 'chrome',
                            'url' => 'http://example.com'
                        ],
                    ],
                ],
            ],
            'test2.yml, firefox, http://example.org' => [
                'test' => new Test(
                    'test2.yml',
                    new TestConfiguration('firefox', 'http://example.org')
                ),
                'expectedData' => [
                    'type' => Test::TYPE,
                    'payload' => [
                        'path' => 'test2.yml',
                        'config' => [
                            'browser' => 'firefox',
                            'url' => 'http://example.org'
                        ],
                    ],
                ],
            ],
        ];
    }
}
