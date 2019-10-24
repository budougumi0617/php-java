<?php
namespace PHPJava\Compiler\Emulator\Mnemonics;

class _iload_1 extends AbstractOperationCode implements OperationCodeInterface
{
    use \PHPJava\Compiler\Emulator\Traits\GeneralProcessor;

    public function execute(): void
    {
        $this->accumulator->pushToOperandStack(
            $this->accumulator
                ->getFromLocal(1)
        );
    }
}
