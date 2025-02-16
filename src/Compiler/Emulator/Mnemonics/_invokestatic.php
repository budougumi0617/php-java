<?php
namespace PHPJava\Compiler\Emulator\Mnemonics;

class _invokestatic extends AbstractOperationCode implements OperationCodeInterface
{
    use \PHPJava\Compiler\Emulator\Traits\GeneralProcessor;

    public function execute(): void
    {
        $signature = $this->getSignature(2);

        for ($i = 0; $i < $signature['arguments_count']; $i++) {
            $this->accumulator->popFromOperandStack();
        }

        $this->pushToOperandStackByType(
            $this->getReturnType(),
            $this->getClassName()
        );
    }
}
