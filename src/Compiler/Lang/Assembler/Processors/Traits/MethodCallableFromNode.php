<?php
namespace PHPJava\Compiler\Lang\Assembler\Processors\Traits;

use PHPJava\Compiler\Builder\Finder\ConstantPoolFinder;
use PHPJava\Compiler\Builder\Signatures\Descriptor;
use PHPJava\Compiler\Lang\Assembler\ClassAssemblerInterface;
use PHPJava\Compiler\Lang\Assembler\Enhancer\ConstantPoolEnhancer;
use PHPJava\Compiler\Lang\Assembler\Store\Store;
use PHPJava\Exceptions\AssembleStructureException;
use PHPJava\Kernel\Maps\OpCode;
use PHPJava\Kernel\Types\_Int;
use PHPJava\Kernel\Types\_Void;
use PHPJava\Utilities\ArrayTool;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\LNumber;

/**
 * @method Store getStore()
 * @method ConstantPoolEnhancer getEnhancedConstantPool()
 * @method ConstantPoolFinder getConstantPoolFinder()
 * @method ClassAssemblerInterface getClassAssembler()
 */
trait MethodCallableFromNode
{
    private function assembleDynamicMethodCallFromNode(MethodCall $expression): array
    {
        $var = $expression->var;
        $methodName = $expression->name;

        if (!($var instanceof Variable)) {
            throw new AssembleStructureException(
                'Unsupported callee type: ' . get_class($var)
            );
        }

        if (!($methodName instanceof Identifier)) {
            throw new AssembleStructureException(
                'Unsupported method name type: ' . get_class($methodName)
            );
        }

        [, $callFrom] = $this->getStore()->get($var->name);

        throw new AssembleStructureException(
            'The dynamic method call is not implemented.'
        );
    }

    private function assembleStaticMethodCallFromNode(StaticCall $expression): array
    {
        $targetClass = strtolower($expression->class->parts[0]);
        $methodName = $expression->name;

        if (!($methodName instanceof Identifier)) {
            throw new AssembleStructureException(
                'Unsupported method name type: ' . get_class($methodName)
            );
        }

        $callee = null;

        if ($targetClass === 'self') {
            $callee = $this->getClassAssembler()->getClassName();
        } elseif ($targetClass === 'static') {
            // TODO: Implement late static bindings.
            $callee = $this->getClassAssembler()->getClassName();
        } else {
            $callee = $targetClass;
        }

        $descriptorObject = (new Descriptor())
            ->setReturn(_Void::class);

        $operations = [];

        foreach ($expression->args as $index => $arg) {
            if (!($arg instanceof Arg)) {
                throw new AssembleStructureException(
                    'Does not support an argument type: ' . get_class($arg) . ' of #' . ($index + 1)
                );
            }
            $argValue = $arg->value;

            // A trial implementation
            if ($argValue instanceof LNumber) {
                $descriptorObject->addArgument(_Int::class);
                ArrayTool::concat(
                    $operations,
                    ...[
                        \PHPJava\Compiler\Builder\Generator\Operation\Operation::create(
                            OpCode::_iconst_1
                        ),
                    ]
                );
            }
            // End of Trial implementation.
        }

        ArrayTool::concat(
            $operations,
            ...$this->assembleStaticCallMethodOperations(
                $callee,
                $methodName->name,
                $descriptorObject->make()
            )
        );

        return $operations;
    }
}
