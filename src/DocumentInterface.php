<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

interface DocumentInterface
{
    /**
     * @return array{"type": string, "payload": array<mixed>}
     */
    public function getData(): array;
}
