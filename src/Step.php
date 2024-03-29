<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments;

class Step implements DocumentInterface
{
    public const TYPE = 'step';

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
    private function createPayload(): array
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
