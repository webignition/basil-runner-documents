<?php

declare(strict_types=1);

namespace webignition\BasilRunnerDocuments\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\BasilRunnerDocuments\DocumentInterface;
use webignition\BasilRunnerDocuments\Step;

class StepTest extends TestCase
{
    /**
     * @dataProvider getDataDataProvider
     *
     * @param Step $step
     * @param array<mixed> $expectedData
     */
    public function testGetData(Step $step, array $expectedData): void
    {
        self::assertSame($expectedData, $step->getData());
    }

    /**
     * @return array[]
     */
    public function getDataDataProvider(): array
    {
        $statement1 = \Mockery::mock(DocumentInterface::class);
        $statement1
            ->shouldReceive('getData')
            ->andReturn([
                'content' => 'statement 1 mock content',
            ]);

        $statement2 = \Mockery::mock(DocumentInterface::class);
        $statement2
            ->shouldReceive('getData')
            ->andReturn([
                'content' => 'statement 2 mock content',
            ]);

        $statusPassed = 'passed';
        $statusFailed = 'failed';

        return [
            'passed, single statement' => [
                'step' => new Step(
                    'passed, single statement',
                    $statusPassed,
                    [
                        $statement1,
                    ]
                ),
                'expectedData' => [
                    'name' => 'passed, single statement',
                    'status' => $statusPassed,
                    'statements' => [
                        [
                            'content' => 'statement 1 mock content',
                        ]
                    ],
                ],
            ],
            'passed, multiple statements' => [
                'step' => new Step(
                    'passed, single action, single assertion',
                    $statusPassed,
                    [
                        $statement1,
                        $statement2,
                    ]
                ),
                'expectedData' => [
                    'name' => 'passed, single action, single assertion',
                    'status' => $statusPassed,
                    'statements' => [
                        [
                            'content' => 'statement 1 mock content',
                        ],
                        [
                            'content' => 'statement 2 mock content',
                        ],
                    ],
                ],
            ],
            'failed, single statement' => [
                'step' => new Step(
                    'failed, single assertion',
                    $statusFailed,
                    [
                        $statement1,
                    ]
                ),
                'expectedData' => [
                    'name' => 'failed, single assertion',
                    'status' => $statusFailed,
                    'statements' => [
                        [
                            'content' => 'statement 1 mock content',
                        ],
                    ],
                ],
            ],
            'passed, single statement with data' => [
                'step' => new Step(
                    'passed, single is assertion with data',
                    $statusPassed,
                    [
                        $statement1,
                    ],
                    [
                        'expected_value' => 'literal',
                    ]
                ),
                'expectedData' => [
                    'name' => 'passed, single is assertion with data',
                    'status' => $statusPassed,
                    'statements' => [
                        [
                            'content' => 'statement 1 mock content',
                        ],
                    ],
                    'data' => [
                        'expected_value' => 'literal',
                    ],
                ],
            ],
        ];
    }
}
