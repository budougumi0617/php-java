<?php
namespace PHPJava\Compiler\Emulator\Mnemonics;

class _istore_0 extends AbstractOperationCode implements OperationCodeInterface
{
    use \PHPJava\Compiler\Emulator\Traits\GeneralProcessor;

    public function execute(): void
    {
        $this->accumulator
            ->setToLocal(
                0,
                $this->accumulator
                    ->popFromOperandStack()
            );
    }
}
