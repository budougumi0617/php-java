<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Filters\Normalizer;
use PHPJava\Kernel\Types\_Char;
use PHPJava\Kernel\Types\Type;

final class _castore extends AbstractOperationCode implements OperationCodeInterface
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
        $value = Normalizer::getPrimitiveValue($this->popFromOperandStack());
        $index = Normalizer::getPrimitiveValue($this->popFromOperandStack());

        /**
         * @var Type $arrayref
         */
        $arrayref = $this->popFromOperandStack();

        // The value is a ref.
        $arrayref[$index] = _Char::get($value);
    }
}
