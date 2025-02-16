<?php
namespace PHPJava\Tests\Cases;

use PHPJava\IO\Standard\Output;

class AccessDynamicMethodTest extends Base
{
    protected $fixtures = [
        'AccessDynamicMethodTest',
    ];

    public function testCallMainHavingStringArguments()
    {
        // call main
        static::$initiatedJavaClasses['AccessDynamicMethodTest']
            ->getInvoker()
            ->construct()
            ->getDynamic()
            ->getMethods()
            ->call(
                'main',
                ['Hello', 'World']
            );
        $result = Output::getHeapspace();

        $this->assertEquals('HelloWorld', $result);
    }

    public function testCallMainHavingIntegerArguments()
    {
        // call main
        static::$initiatedJavaClasses['AccessDynamicMethodTest']
            ->getInvoker()
            ->construct()
            ->getDynamic()
            ->getMethods()
            ->call(
                'main',
                [1234, 5678]
            );
        $result = Output::getHeapspace();

        $this->assertEquals(246811356, $result);
    }

    public function testCallReturnTest()
    {
        // call main
        $result = static::$initiatedJavaClasses['AccessDynamicMethodTest']
            ->getInvoker()
            ->construct()
            ->getDynamic()
            ->getMethods()
            ->call('returnTest');

        $this->assertEquals('Return Test.', $result);
    }
}
