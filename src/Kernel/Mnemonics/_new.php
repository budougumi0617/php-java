<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Core\JavaClass;

final class _new extends AbstractOperationCode implements OperationInterface
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
        $cpInfo = $this->getConstantPool();
        $class = $cpInfo[$this->readUnsignedShort()];
        $className = $cpInfo[$class->getClassIndex()]->getString();

        $javaClass = JavaClass::load(
            $className,
            $this->javaClass->getOptions()
        );

        $this->pushToOperandStackByReference($javaClass);
    }
}
