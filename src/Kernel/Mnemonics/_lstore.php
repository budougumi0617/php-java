<?php
namespace PHPJava\Kernel\Mnemonics;

final class _lstore extends AbstractOperationCode implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    public function getOperands(): ?Operands
    {
        parent::getOperands();
        return $this->operands ?? new Operands();
    }

    public function execute(): void
    {
        parent::execute();
        $index = $this->readUnsignedByte();
        $this->setLocalStorage($index, $this->popFromOperandStack());
    }
}
