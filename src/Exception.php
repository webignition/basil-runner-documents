<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class Exception implements DocumentInterface
{
    private const TYPE = 'exception';

    private ?string $stepName;
    private string $class;
    private string $message;
    private int $code;

    /**
     * @var array<int, array<string, string|int>>
     */
    private array $trace;

    /**
     * @param string $class
     * @param string $message
     * @param int $code
     * @param array<int, array<string, string|int>> $trace
     * @param string|null $stepName
     */
    private function __construct(string $class, string $message, int $code, array $trace, ?string $stepName = null)
    {
        $this->class = $class;
        $this->message = $message;
        $this->code = $code;
        $this->trace = $trace;
        $this->stepName = $stepName;
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

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getData(): array
    {
        return [
            'step' => $this->stepName,
            'class' => $this->class,
            'message' => $this->message,
            'code' => $this->code,
            'trace' => $this->trace,
        ];
    }
}
