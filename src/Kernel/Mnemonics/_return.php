<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Types\_Void;

final class _return extends AbstractOperationCode implements OperationCodeInterface
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
        $this->returnValue = new _Void();
    }
}
