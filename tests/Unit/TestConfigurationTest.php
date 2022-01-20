<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\TestConfiguration;

class TestConfigurationTest extends TestCase
{
    public function testGetType(): void
    {
        $configuration = new TestConfiguration('chrome', 'http://example.com');
        self::assertSame('test-configuration', $configuration->getType());
    }

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
     * @return array[]
     */
    public function getDataDataProvider(): array
    {
        return [
            'chrome, http://example.com' => [
                'configuration' => new TestConfiguration('chrome', 'http://example.com'),
                'expectedData' => [
                    'browser' => 'chrome',
                    'url' => 'http://example.com'
                ],
            ],
            'firefox, http://example.org' => [
                'configuration' => new TestConfiguration('firefox', 'http://example.org'),
                'expectedData' => [
                    'browser' => 'firefox',
                    'url' => 'http://example.org'
                ],
            ],
        ];
    }
}
