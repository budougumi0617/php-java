<?php
namespace PHPJava\Kernel\Mnemonics;

use Brick\Math\BigInteger;
use PHPJava\Kernel\Filters\Normalizer;
use PHPJava\Kernel\Types\_Int;

final class _lcmp extends AbstractOperationCode implements OperationCodeInterface
{
    protected $isStackingOperation = true;

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
        $value2 = (string) Normalizer::getPrimitiveValue($this->popFromOperandStack());
        $value1 = (string) Normalizer::getPrimitiveValue($this->popFromOperandStack());

        $compare = BigInteger::of($value1)->compareTo($value2);

        if ($compare == 1) {
            $this->pushToOperandStack(_Int::get(1));
            return;
        }

        if ($compare == -1) {
            $this->pushToOperandStack(_Int::get(-1));
            return;
        }

        $this->pushToOperandStack(_Int::get(0));
    }
}
