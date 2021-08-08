<?php
declare(strict_types=1);

namespace App\PHPStan\Rules;

use PHPStan\Rules\Rule;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PhpParser\Node\Stmt\Class_;

class CheckClassIsFinalRule implements Rule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Class should be final';

    /**
     * @phpstan-return class-string<TNodeType>
     * @return string
     */
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @phpstan-param TNodeType $node
     * @param \PhpParser\Node $node
     * @param \PHPStan\Analyser\Scope $scope
     * @return (string|RuleError)[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->extends === null) {
            return [];
        }

        if ($node->extends->getLast() !== 'AppController') {
            return [];
        }

        if ($node->isFinal()) {
            return [];
        }

        return [self::ERROR_MESSAGE];
    }
}