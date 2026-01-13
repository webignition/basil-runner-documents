<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\TestConfiguration;

class TestConfigurationTest extends TestCase
{
    /**
     * @dataProvider getDataDataProvider
     *
     * @param array<string, string> $expectedData
     */
    public function testGetData(TestConfiguration $configuration, array $expectedData): void
    {
        self::assertSame($expectedData, $configuration->getData());
    }

    /**
     * @return array<mixed>
     */
    public function getDataDataProvider(): array
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
