<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class Exception implements DocumentInterface
{
    public const TYPE = 'exception';

    private ?StackTrace $trace = null;

    private ?string $stepName = null;

    public function __construct(
        private readonly string $class,
        private readonly string $message,
        private readonly int $code,
    ) {}

    public static function createFromThrowable(\Throwable $throwable, ?string $stepName = null): self
    {
        $exception = new Exception(
            get_class($throwable),
            $throwable->getMessage(),
            $throwable->getCode(),
        );

        $exception = $exception->withTrace(StackTrace::fromPhpTrace($throwable->getTrace()));

        if (is_string($stepName)) {
            $exception = $exception->withStepName($stepName);
        }

        return $exception;
    }

    public function withTrace(StackTrace $trace): self
    {
        $new = clone $this;
        $new->trace = $trace;

        return $new;
    }

    public function withoutTrace(): self
    {
        $new = clone $this;
        $new->trace = null;

        return $new;
    }

    public function withStepName(string $stepName): self
    {
        $new = clone $this;
        $new->stepName = $stepName;

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
