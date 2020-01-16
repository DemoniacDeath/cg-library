<?php

namespace CG\Tests\Core;

use CG\Core\ReflectionUtils;
use CG\Generator\Writer;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ReflectionUtilsTest extends TestCase
{
    public function testGetOverridableMethods(): void
    {
        $ref = new ReflectionClass(OverridableReflectionTest::class);
        $methods = ReflectionUtils::getOverrideableMethods($ref);

        $this->assertEquals(4, count($methods));

        $methods = array_map(function ($v) {
            return $v->name;
        }, $methods);
        sort($methods);
    }

    public function testGetUnIndentedDocComment(): void
    {
        $writer = new Writer();
        $comment = $writer
            ->writeln('/**')
            ->indent()
            ->writeln(' * Foo.')
            ->write(' */')
            ->getContent();

        $this->assertEquals("/**\n * Foo.\n */", ReflectionUtils::getUnindentedDocComment($comment));
    }
}

abstract class OverridableReflectionTest
{
    public function a()
    {
    }

    final public function b()
    {
    }

    public static function c()
    {
    }

    abstract public function d();

    protected function e()
    {
    }

    final protected function f()
    {
    }

    protected static function g()
    {
    }

    abstract protected function h();

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private function i()
    {
    }
}