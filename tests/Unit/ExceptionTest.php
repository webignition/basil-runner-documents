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
     * @param array<string, int|string> $expectedDataWithoutTrace
     */
    public function testGetData(Exception $exception, array $expectedDataWithoutTrace): void
    {
        $data = $exception->getData();
        self::assertSame(Exception::TYPE, $data['type']);

        $payload = $data['payload'];
        $trace = $payload['trace'];
        self::assertIsArray($trace);
        self::assertNotEmpty($trace);

        unset($payload['trace']);

        self::assertSame($expectedDataWithoutTrace, $payload);
    }

    /**
     * @return array<mixed>
     */
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

    public function testWithoutTrace(): void
    {
        $throwable = new RuntimeException('RuntimeException message', 123);

        $exception = Exception::createFromThrowable($throwable);
        $exception = $exception->withoutTrace();

        self::assertSame(
            [
                'type' => Exception::TYPE,
                'payload' => [
                    'step' => null,
                    'class' => RuntimeException::class,
                    'message' => 'RuntimeException message',
                    'code' => 123,
                    'trace' => [],
                ],
            ],
            $exception->getData()
        );
    }
}
