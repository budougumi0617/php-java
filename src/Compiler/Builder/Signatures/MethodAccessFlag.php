<?php

namespace PHPJava\Compiler\Builder\Signatures;

use PHPJava\Kernel\Maps\MethodAccessFlag as Flag;

class MethodAccessFlag extends AbstractAccessFlag implements AccessFlagInterface
{
    public function enableStatic(): self
    {
        $this->flagValue |= Flag::ACC_STATIC;
        return $this;
    }

    public function enablePublic(): self
    {
        $this->flagValue |= Flag::ACC_PUBLIC;
        return $this;
    }

    public function enablePrivate(): self
    {
        $this->flagValue |= Flag::ACC_PRIVATE;
        return $this;
    }

    public function enableProtected(): self
    {
        $this->flagValue |= Flag::ACC_PROTECTED;
        return $this;
    }

    public function enableFinal(): self
    {
        $this->flagValue |= Flag::ACC_FINAL;
        return $this;
    }

    public function enableSynchronized(): self
    {
        $this->flagValue |= Flag::ACC_SYNCHRONIZED;
        return $this;
    }

    public function enableBridge(): self
    {
        $this->flagValue |= Flag::ACC_BRIDGE;
        return $this;
    }

    public function enableVarArgs(): self
    {
        $this->flagValue |= Flag::ACC_VARARGS;
        return $this;
    }

    public function enableNative(): self
    {
        $this->flagValue |= Flag::ACC_NATIVE;
        return $this;
    }

    public function enableAbstract(): self
    {
        $this->flagValue |= Flag::ACC_ABSTRACT;
        return $this;
    }

    public function enableStrict(): self
    {
        $this->flagValue |= Flag::ACC_STRICT;
        return $this;
    }

    public function enableSynthetic(): self
    {
        $this->flagValue |= Flag::ACC_SYNTHETIC;
        return $this;
    }
}
