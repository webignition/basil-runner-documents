<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class TestConfiguration implements DocumentInterface
{
    private const TYPE = 'test-configuration';

    public function __construct(
        private string $browser,
        private string $url
    ) {
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getData(): array
    {
        return [
            'browser' => $this->browser,
            'url' => $this->url,
        ];
    }
}
