<?php
namespace PHPJava\Kernel\Mnemonics;

final class _fstore_3 extends AbstractOperationCode implements OperationCodeInterface
{
    public function getOperands(): ?Operands
    {
        parent::getOperands();
        if ($this->operands !== null) {
            return $this->operands;
        }
        return $this->operands = new Operands();
    }

    public function execute(): void
    {
        parent::execute();
        $this->setLocalStorage(3, $this->popFromOperandStack());
    }
}
