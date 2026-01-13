<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use Mockery\Exception\RuntimeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\Exception;
use webignition\BasilRunnerDocuments\StackTrace;

class ExceptionTest extends TestCase
{
    /**
     * @param array<string, int|string> $expectedData
     */
    #[DataProvider('getDataDataProvider')]
    public function testGetData(
        Exception $exception,
        array $expectedData,
    ): void {
        $data = $exception->getData();
        self::assertSame(Exception::TYPE, $data['type']);

        $payload = $data['payload'];
        self::assertSame($expectedData, $payload);
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
                ),
                'expectedData' => [
                    'step' => null,
                    'class' => RuntimeException::class,
                    'message' => 'RuntimeException message',
                    'code' => 123,
                    'trace' => null,
                ],
            ],
            'with step name, without trace' => [
                'exception' => new Exception(
                    $throwable::class,
                    $throwable->getMessage(),
                    $throwable->getCode(),
                )->withStepName('step name present'),
                'expectedData' => [
                    'step' => 'step name present',
                    'class' => RuntimeException::class,
                    'message' => 'RuntimeException message',
                    'code' => 123,
                    'trace' => null,
                ],
            ],
            'from throwable, without step name' => [
                'exception' => Exception::createFromThrowable($throwable),
                'expectedData' => [
                    'step' => null,
                    'class' => RuntimeException::class,
                    'message' => 'RuntimeException message',
                    'code' => 123,
                    'trace' => StackTrace::fromPhpTrace($throwable->getTrace())->getData(),
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
                    'trace' => null,
                ],
            ],
            $exception->getData()
        );
    }
}
