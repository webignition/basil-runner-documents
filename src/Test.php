<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class Test implements DocumentInterface
{
    private const TYPE = 'test';

    public function __construct(
        private string $path,
        private TestConfiguration $configuration
    ) {
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getData(): array
    {
        return [
            'path' => $this->path,
            'config' => $this->configuration->getData(),
        ];
    }
}
