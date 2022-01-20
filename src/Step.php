<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class Step implements DocumentInterface
{
    private const TYPE = 'step';

    /**
     * @var DocumentInterface[]
     */
    private array $statements;

    /**
     * @param DocumentInterface[] $statements
     * @param null|array<mixed>   $data
     */
    public function __construct(
        private string $name,
        private string $status,
        array $statements,
        private ?array $data = null
    ) {
        $this->statements = array_filter($statements, function ($item) {
            return $item instanceof DocumentInterface;
        });
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getData(): array
    {
        $data = [
            'name' => $this->name,
            'status' => $this->status,
        ];

        if (count($this->statements)) {
            $statementData = [];

            foreach ($this->statements as $statement) {
                $statementData[] = $statement->getData();
            }

            $data['statements'] = $statementData;
        }

        if (null !== $this->data) {
            $data['data'] = $this->data;
        }

        return $data;
    }
}
