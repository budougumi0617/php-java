<?php
namespace PHPJava\Compiler\Builder\Generator\Operation;

interface OperationGeneratorInterface
{
    public function getOpCode(): int;

    public function getOperandTypes(): array;
}
