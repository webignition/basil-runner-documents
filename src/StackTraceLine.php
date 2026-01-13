<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

/**
 * @phpstan-type SerializedStackTraceLine array{'path': non-empty-string, 'line_number': positive-int}
 */
readonly class StackTraceLine
{
    /**
     * @param non-empty-string $path
     * @param positive-int     $lineNumber
     */
    public function __construct(
        public string $path,
        public int $lineNumber,
    ) {}

    /**
     * @return SerializedStackTraceLine
     */
    public function getData(): array
    {
        return [
            'path' => $this->path,
            'line_number' => $this->lineNumber,
        ];
    }
}
