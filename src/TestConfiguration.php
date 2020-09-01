<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class TestConfiguration implements DocumentInterface
{
    private const TYPE = 'test-configuration';

    private string $browser;
    private string $url;

    public function __construct(string $browser, string $url)
    {
        $this->browser = $browser;
        $this->url = $url;
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
