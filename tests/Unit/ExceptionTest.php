<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use Mockery\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\Exception;

class ExceptionTest extends TestCase
{
    /**
     * @dataProvider getDataDataProvider
     *
     * @param Exception $exception
     * @param array<string, string|int> $expectedDataWithoutTrace
     */
    public function testGetData(Exception $exception, array $expectedDataWithoutTrace)
    {
        $data = $exception->getData();

        $trace = $data['trace'];
        self::assertIsArray($trace);
        self::assertNotEmpty($trace);

        unset($data['trace']);

        self::assertSame($expectedDataWithoutTrace, $data);
    }

    public function getDataDataProvider(): array
    {
        $throwable = new RuntimeException('RuntimeException message', 123);

        return [
            'without step name' => [
                'exception' => Exception::createFromThrowable($throwable),
                'expectedDataWithoutTrace' => [
                    'step' => null,
                    'class' => RuntimeException::class,
                    'message' => 'RuntimeException message',
                    'code' => 123,
                ],
            ],
            'with step name' => [
                'exception' => Exception::createFromThrowable($throwable, 'step name present'),
                'expectedDataWithoutTrace' => [
                    'step' => 'step name present',
                    'class' => RuntimeException::class,
                    'message' => 'RuntimeException message',
                    'code' => 123,
                ],
            ],
        ];
    }
}
