<?php
namespace PHPJava\Tests\Cases;

class AccessStaticFieldTest extends Base
{
    protected $fixtures = [
        'AccessStaticFieldTest',
    ];

    public function testGetPuttedField()
    {
        $this->assertEquals(5, static::$initiatedJavaClasses['AccessStaticFieldTest']->getInvoker()->getStatic()->getFields()->get('number')->getValue());
        $this->assertEquals('Hello World', static::$initiatedJavaClasses['AccessStaticFieldTest']->getInvoker()->getStatic()->getFields()->get('string'));
    }

    public function testOverwriteField()
    {
        $static = static::$initiatedJavaClasses['AccessStaticFieldTest']->getInvoker()->getStatic();
        $static->getFields()->set('number', 1000);
        $static->getFields()->set('string', 'New String!');
        $this->assertEquals(1000, $static->getFields()->get('number'));
        $this->assertEquals('New String!', $static->getFields()->get('string'));
    }
}
