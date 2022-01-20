<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class Exception implements DocumentInterface
{
    public const TYPE = 'exception';

    /**
     * @param array<mixed> $trace
     */
    private function __construct(
        private string $class,
        private string $message,
        private int $code,
        private array $trace,
        private ?string $stepName = null
    ) {
    }

    public static function createFromThrowable(\Throwable $throwable, ?string $stepName = null): self
    {
        return new Exception(
            get_class($throwable),
            $throwable->getMessage(),
            $throwable->getCode(),
            $throwable->getTrace(),
            $stepName
        );
    }

    public function withoutTrace(): self
    {
        $new = clone $this;
        $new->trace = [];

        return $new;
    }

    public function getData(): array
    {
        return [
            'type' => self::TYPE,
            'payload' => [
                'step' => $this->stepName,
                'class' => $this->class,
                'message' => $this->message,
                'code' => $this->code,
                'trace' => $this->trace,
            ],
        ];
    }
}
