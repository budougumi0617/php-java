<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Core\JavaClass;
use PHPJava\Core\JavaClassInterface;
use PHPJava\Exceptions\NoSuchCodeAttributeException;
use PHPJava\Kernel\Filters\Normalizer;
use PHPJava\Kernel\Internal\Lambda;
use PHPJava\Kernel\Types\_Void;
use PHPJava\Packages\java\lang\NoSuchMethodException;
use PHPJava\Utilities\Formatter;

final class _invokeinterface extends AbstractOperationCode implements OperationCodeInterface
{
    protected $isStackingOperation = true;

    public function getOperands(): ?Operands
    {
        parent::getOperands();
        if ($this->operands !== null) {
            return $this->operands;
        }
        $indexbyte = $this->readUnsignedShort();
        $count = $this->readUnsignedByte();

        // NOTE: The value of the fourth operand byte must always be zero.
        $this->readByte();

        return $this->operands = new Operands(
            ['indexbyte', $indexbyte, ['indexbyte1', 'indexbyte2']],
            ['count', $count, ['count']]
        );
    }

    public function execute(): void
    {
        parent::execute();
        $cp = $this->getConstantPool();
        $index = $this->getOperands()['indexbyte'];
        $count = $this->getOperands()['count'];

        $interfaceMethodRef = $cp[$cp[$index]->getNameAndTypeIndex()];
        $className = $cp[$cp[$cp[$index]->getClassIndex()]->getClassIndex()]->getString();
        $name = $cp[$interfaceMethodRef->getNameIndex()]->getString();
        $descriptor = $cp[$interfaceMethodRef->getDescriptorIndex()]->getString();

        $signature = Formatter::parseSignature($descriptor);

        // POP with right-to-left (objectref + arguments)
        $arguments = array_fill(0, $signature['arguments_count'], null);
        for ($i = count($arguments) - 1; $i >= 0; $i--) {
            $arguments[$i] = $this->popFromOperandStack();
        }

        /**
         * @var JavaClassInterface|Lambda $objectref
         */
        $objectref = $this->popFromOperandStack();

        $this->getDebugTool()->getLogger()->debug(
            vsprintf(
                'Call a method: %s, parameters: %d',
                [
                    $name,
                    count($arguments),
                ]
            )
        );

        if ($objectref instanceof Lambda) {
            $result = $objectref($name, ...$arguments);
        } else {
            try {
                $result = $objectref->getInvoker()->getDynamic()->getMethods()->call(
                    $name,
                    ...$arguments
                );
            } catch (NoSuchMethodException | NoSuchCodeAttributeException $e) {
                // If targeted method is an abstract or method is undefined, then to find in InnerClass.
                // NOTE: Currently, nested InnerClass does not supported.

                $foundClass = false;
                foreach ($objectref->getDefinedInnerClasses() as [$class]) {
                    /**
                     * @var JavaClass $class
                     */
                    if ($class->getClassName() !== $className) {
                        continue;
                    }

                    $result = $class->getInvoker()->getDynamic()->getMethods()->call(
                        $name,
                        ...$arguments
                    );

                    $foundClass = true;
                    break;
                }

                try {
                    // NOTICE: This implementation is a trial.
                    // I don't know how to refer SuperClass from anonymous type InnerClass.
                    if (!$foundClass) {
                        $result = $this->javaClass->getInvoker()->getDynamic()->getMethods()->call(
                            $name,
                            ...$arguments
                        );
                    }
                } catch (NoSuchMethodException | NoSuchCodeAttributeException $e) {
                    throw $e;
                }
            }
        }

        if ($signature[0]['type'] !== _Void::class) {
            $this->pushToOperandStack(
                Normalizer::normalizeReturnValue(
                    $result,
                    $signature[0]
                )
            );
        }
    }
}
