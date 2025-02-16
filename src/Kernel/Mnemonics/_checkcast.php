<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Kernel\Resolvers\TypeResolver;
use PHPJava\Packages\java\lang\ClassCastException;
use PHPJava\Utilities\Formatter;

final class _checkcast extends AbstractOperationCode implements OperationCodeInterface
{
    public function getOperands(): ?Operands
    {
        parent::getOperands();
        if ($this->operands !== null) {
            return $this->operands;
        }
        $indexbyte = $this->readUnsignedShort();

        return $this->operands = new Operands(
            ['indexbyte', $indexbyte, ['indexbyte1', 'indexbyte2']]
        );
    }

    /**
     * @throws ClassCastException
     */
    public function execute(): void
    {
        parent::execute();
        $cp = $this->getConstantPool();
        $index = $this->getOperands()['indexbyte'];
        $objectref = $this->popFromOperandStack();

        if ($objectref === null) {
            return;
        }

        $castTo = $cp[$cp[$index]->getClassIndex()]->getString();

        $fromObjectClass = Formatter::convertPHPNamespacesToJava(get_class($objectref));

        [$classes, $interfaces] = TypeResolver::getExtendedClasses(
            'L' . str_replace('/', '.', $castTo)
        )[0] ?? [[], []];

        if (in_array($fromObjectClass, $classes, true)) {
            return;
        }

        throw new ClassCastException(
            'class \\' . get_class($objectref) . ' cannot be cast to class ' . Formatter::convertJavaNamespaceToPHP($castTo)[1]
        );
    }
}
