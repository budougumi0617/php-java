<?php
namespace PHPJava\Kernel\Mnemonics;

final class _if_icmpne extends AbstractOperationCode implements OperationCodeInterface
{
    public function getOperands(): ?Operands
    {
        parent::getOperands();
        if ($this->operands !== null) {
            return $this->operands;
        }
        $branchbyte = $this->readShort();

        return $this->operands = new Operands(
            ['branchbyte', $branchbyte, ['branchbyte1', 'branchbyte2']]
        );
    }

    public function execute(): void
    {
        parent::execute();
        $offset = $this->getOperands()['branchbyte'];

        $rightOperand = $this->popFromOperandStack();
        $leftOperand = $this->popFromOperandStack();

        if ($leftOperand != $rightOperand) {
            $this->setOffset($this->getProgramCounter() + $offset);
        }
    }
}
