<?php

namespace Tests;

use App\NoQuarterState;
use PHPUnit\Framework\TestCase;

/**
 * Class NoQuarterStateTest
 * Test cases for the NoQuarterState class.
 */
class NoQuarterStateTest extends TestCase
{
    /**
     * Test that NoQuarterState implements State interface using reflection.
     */
    public function testNoQuarterStateImplementsStateInterface(): void
    {
        $noQuarterStateReflection = new \ReflectionClass(NoQuarterState::class);
        $this->assertTrue($noQuarterStateReflection->implementsInterface('App\State'));
    }

    /**
     * Test that NoQuarterState properties exist, have the correct access type, and correct type.
     */
    public function testNoQuarterStatePropertiesExist(): void
    {
        $reflection = new \ReflectionClass(NoQuarterState::class);
        $properties = $reflection->getProperties();
        $expected = [
            'gumBallMachine' => [
                'access' => 'private',
                'type' => 'App\GumBallMachine',
            ],
        ];

        $this->assertSame(count($expected), count($properties));
        foreach ($properties as $property) {
            $name = $property->getName();
            $this->assertArrayHasKey($name, $expected);

            // Match access type, but not return type
            match ($expected[$name]['access']) {
                'public' => $this->assertTrue($property->isPublic()),
                'protected' => $this->assertTrue($property->isProtected()),
                'private' => $this->assertTrue($property->isPrivate()),
                default => $this->fail('Unexpected access type'),
            };

            $this->assertSame($expected[$name]['type'], $property->hasType() ? $property->getType()->getName() : '');
        }
    }

    /**
     * Test that the gumBallMachine methods exist, have the correct access type, and correct return type.
     */
    public function testNoQuarterStateMethodsExist(): void
    {
        $reflection = new \ReflectionClass(NoQuarterState::class);
        $methods = $reflection->getMethods();
        $expected = [
            '__construct' => [
                'access' => 'public',
                'return' => '',
            ],
            'insertQuarter' => [
                'access' => 'public',
                'return' => 'void',
            ],
            'ejectQuarter' => [
                'access' => 'public',
                'return' => 'void',
            ],
            'turnCrank' => [
                'access' => 'public',
                'return' => 'void',
            ],
            'dispense' => [
                'access' => 'public',
                'return' => 'void',
            ],
            '__toString' => [
                'access' => 'public',
                'return' => 'string',
            ],
            'refill' => [
                'access' => 'public',
                'return' => 'void',
            ],
        ];

        $this->assertSame(count($expected), count($methods));
        foreach ($methods as $method) {
            $name = $method->getName();
            $this->assertArrayHasKey($name, $expected);

            // Match access type, but not return type
            match ($expected[$name]['access']) {
                'public' => $this->assertTrue($method->isPublic()),
                'protected' => $this->assertTrue($method->isProtected()),
                'private' => $this->assertTrue($method->isPrivate()),
                default => $this->fail('Unexpected access type'),
            };

            $this->assertSame($expected[$name]['return'], $method->hasReturnType() ? $method->getReturnType()->getName() : '');
        }
    }

    /**
     * Test that the constructor sets the gumBallMachine property.
     */
    public function testNoQuarterStateConstruct(): void
    {
        $reflection = new \ReflectionClass(NoQuarterState::class);
        $property = $reflection->getProperty('gumBallMachine');
        $property->setAccessible(true);

        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $noQuarterState = new NoQuarterState($gumBallMachine);
        $this->assertSame($gumBallMachine, $property->getValue($noQuarterState));
    }

    /**
     * Test the insertQuarter method of NoQuarterState.
     */
    public function testNoQuarterStateInsertQuarter(): void
    {
        $hasQuarterState = $this->createMock('App\HasQuarterState');
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $gumBallMachine->expects($this->once())
            ->method('getHasQuarterState')
            ->willReturn($hasQuarterState);
        $gumBallMachine->expects($this->once())
            ->method('setState')
            ->with($hasQuarterState);

        $noQuarterState = new NoQuarterState($gumBallMachine);
        $this->expectOutputString('<p class="action">You inserted a quarter</p>' . PHP_EOL);
        $noQuarterState->insertQuarter();
    }

    /**
     * Test the ejectQuarter method of NoQuarterState.
     */
    public function testNoQuarterStateEjectQuarter(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $noQuarterState = new NoQuarterState($gumBallMachine);

        $this->expectOutputString("<p class=\"action\">You haven’t inserted a quarter</p>" . PHP_EOL);
        $noQuarterState->ejectQuarter();
    }

    /**
     * Test the turnCrank method of NoQuarterState.
     */
    public function testNoQuarterStateTurnCrank(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $noQuarterState = new NoQuarterState($gumBallMachine);

        $this->expectOutputString("<p class=\"action\">You turned, but there’s no quarter</p>" . PHP_EOL);
        $noQuarterState->turnCrank();
    }

    /**
     * Test the dispense method of NoQuarterState.
     */
    public function testNoQuarterStateDispense(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $noQuarterState = new NoQuarterState($gumBallMachine);

        $this->expectOutputString("<p class=\"action\">You need to pay first</p>" . PHP_EOL);
        $noQuarterState->dispense();
    }

    /**
     * Test the __toString method of NoQuarterState.
     */
    public function testNoQuarterStateToString(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $noQuarterState = new NoQuarterState($gumBallMachine);

        $this->assertSame('Machine is waiting for quarter', $noQuarterState->__toString());
    }

    /**
     * Test the refill method of NoQuarterState.
     */
    public function testNoQuarterStateRefill(): void
    {
        $refill = 10;
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $gumBallMachine->expects($this->once())
            ->method('setCount')
            ->with($refill);

        $noQuarterState = new NoQuarterState($gumBallMachine);

        $this->expectOutputString("<p class=\"action\">A $refill gumballs refill was done</p>" . PHP_EOL);
        $noQuarterState->refill($refill);
    }
}