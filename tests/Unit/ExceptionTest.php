<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use Mockery\Exception\RuntimeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\Exception;

class ExceptionTest extends TestCase
{
    /**
     * @param array<string, int|string> $expectedDataWithoutTrace
     */
    #[DataProvider('getDataDataProvider')]
    public function testGetData(Exception $exception, array $expectedDataWithoutTrace): void
    {
        $data = $exception->getData();
        self::assertSame(Exception::TYPE, $data['type']);

        $payload = $data['payload'];
        $trace = $payload['trace'];
        self::assertIsArray($trace);
        self::assertEmpty($trace);

        unset($payload['trace']);

        self::assertSame($expectedDataWithoutTrace, $payload);
    }

    /**
     * @return array<mixed>
     */
    public static function getDataDataProvider(): array
    {
        $throwable = new RuntimeException('RuntimeException message', 123);

        return [
            'without step name, without trace' => [
                'exception' => new Exception(
                    $throwable::class,
                    $throwable->getMessage(),
                    $throwable->getCode(),
                    [],
                ),
                'expectedDataWithoutTrace' => [
                    'step' => null,
                    'class' => RuntimeException::class,
                    'message' => 'RuntimeException message',
                    'code' => 123,
                ],
            ],
            'with step name, without trace' => [
                'exception' => new Exception(
                    $throwable::class,
                    $throwable->getMessage(),
                    $throwable->getCode(),
                    [],
                    'step name present',
                ),
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

        $exception = new Exception(
            $throwable::class,
            $throwable->getMessage(),
            $throwable->getCode(),
            [],
        );

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
