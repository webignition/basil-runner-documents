<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\TestConfiguration;

class TestConfigurationTest extends TestCase
{
    /**
     * @param array<string, string> $expectedData
     */
    #[DataProvider('getDataDataProvider')]
    public function testGetData(TestConfiguration $configuration, array $expectedData): void
    {
        self::assertSame($expectedData, $configuration->getData());
    }

    /**
     * @return array<mixed>
     */
    public static function getDataDataProvider(): array
    {
        return [
            'chrome, http://example.com' => [
                'configuration' => new TestConfiguration('chrome', 'http://example.com'),
                'expectedData' => [
                    'type' => TestConfiguration::TYPE,
                    'payload' => [
                        'browser' => 'chrome',
                        'url' => 'http://example.com',
                    ],
                ],
            ],
            'firefox, http://example.org' => [
                'configuration' => new TestConfiguration('firefox', 'http://example.org'),
                'expectedData' => [
                    'type' => TestConfiguration::TYPE,
                    'payload' => [
                        'browser' => 'firefox',
                        'url' => 'http://example.org',
                    ],
                ],
            ],
        ];
    }
}
