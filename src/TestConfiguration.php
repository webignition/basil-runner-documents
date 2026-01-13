<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class TestConfiguration implements DocumentInterface
{
    public const TYPE = 'test-configuration';

    public function __construct(
        private string $browser,
        private string $url
    ) {}

    public function getData(): array
    {
        return [
            'type' => self::TYPE,
            'payload' => $this->createPayload(),
        ];
    }

    /**
     * @return array<mixed>
     */
    public function createPayload(): array
    {
        return [
            'browser' => $this->browser,
            'url' => $this->url,
        ];
    }
}
