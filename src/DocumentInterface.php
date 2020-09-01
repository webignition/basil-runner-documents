<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

interface DocumentInterface
{
    public function getType(): string;

    /**
     * @return array<mixed>
     */
    public function getData(): array;
}
