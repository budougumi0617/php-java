<?php
namespace PHPJava\Compiler\Emulator\Mnemonics;

use PHPJava\Exceptions\NotImplementedException;

class _dstore_0 extends AbstractOperationCode implements OperationCodeInterface
{
    use \PHPJava\Compiler\Emulator\Traits\GeneralProcessor;

    public function execute(): void
    {
        throw new NotImplementedException(__CLASS__);
    }
}
