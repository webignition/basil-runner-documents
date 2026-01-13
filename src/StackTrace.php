<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

/**
 * @phpstan-import-type SerializedStackTraceLine from StackTraceLine
 */
readonly class StackTrace
{
    /**
     * @param StackTraceLine[] $lines
     */
    public function __construct(
        public array $lines,
    ) {}

    /**
     * @param array{'file'?: string, 'line'?: int, 'function': string, 'class'?: string, 'type'?: string}[] $trace
     */
    public static function fromPhpTrace(array $trace): self
    {
        $lines = [];

        foreach ($trace as $entry) {
            $path = $entry['file'] ?? '';
            if ('' === $path) {
                continue;
            }

            $line = $entry['line'] ?? 0;
            if ($line < 1) {
                continue;
            }

            $lines[] = new StackTraceLine($path, $line);
        }

        return new StackTrace($lines);
    }

    /**
     * @return SerializedStackTraceLine[]
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->lines as $line) {
            $data[] = $line->getData();
        }

        return $data;
    }
}
