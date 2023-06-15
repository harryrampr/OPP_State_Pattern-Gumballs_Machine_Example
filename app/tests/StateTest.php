<?php

namespace Tests;

use App\State;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class StateTest
 *
 * This class contains unit tests for the State interface.
 */
class StateTest extends TestCase
{
    /**
     * Test that State is an interface using reflection.
     */
    public function testStateIsAnInterface(): void
    {
        $reflection = new ReflectionClass(State::class);
        $this->assertTrue($reflection->isInterface());
    }

    /**
     * Test that the methods of State exist, have the correct return types, and access types.
     */
    public function testStateMethodsExist(): void
    {
        $reflection = new ReflectionClass(State::class);
        $methods = $reflection->getMethods();
        $expectedValues = [
            'insertQuarter' => [
                'return' => 'void',
                'access' => 'public',
            ],
            'ejectQuarter' => [
                'return' => 'void',
                'access' => 'public',
            ],
            'turnCrank' => [
                'return' => 'void',
                'access' => 'public',
            ],
            'dispense' => [
                'return' => 'void',
                'access' => 'public',
            ],
            'refill' => [
                'return' => 'void',
                'access' => 'public',
            ],
            '__toString' => [
                'return' => 'string',
                'access' => 'public',
            ],
        ];

        $this->assertSame(count($expectedValues), count($methods));
        foreach ($methods as $method) {
            $this->assertArrayHasKey($method->getName(), $expectedValues);
            match ($expectedValues[$method->getName()]['access']) {
                'private' => $this->assertTrue($method->isPrivate()),
                'protected' => $this->assertTrue($method->isProtected()),
                'public' => $this->assertTrue($method->isPublic()),
            };
            $this->assertEquals($expectedValues[$method->getName()]['return'],
                $method->hasReturnType() ? $method->getReturnType()->getName() : '');
        }
    }
}