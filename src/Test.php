<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class Test implements DocumentInterface
{
    public const TYPE = 'test';

    public function __construct(
        private string $path,
        private TestConfiguration $configuration
    ) {}

    public function getData(): array
    {
        return [
            'type' => self::TYPE,
            'payload' => [
                'path' => $this->path,
                'config' => $this->configuration->createPayload(),
            ],
        ];
    }
}
