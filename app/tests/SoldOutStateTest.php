<?php

namespace Tests;

use App\SoldOutState;
use App\State;
use PHPUnit\Framework\TestCase;

class SoldOutStateTest extends TestCase
{
    /**
     * Test SoldOutState implements State interface using reflection.
     */
    public function testSoldOutStateImplementsStateInterface(): void
    {
        $soldOutStateReflection = new \ReflectionClass(SoldOutState::class);
        $this->assertTrue($soldOutStateReflection->implementsInterface('App\State'));
    }

    /**
     * Test that SoldOutState properties exist, have the correct access type, and correct type.
     */
    public function testSoldOutStatePropertiesExist(): void
    {
        $reflection = new \ReflectionClass(SoldOutState::class);
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
    public function testSoldOutStateMethodsExist(): void
    {
        $reflection = new \ReflectionClass(SoldOutState::class);
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
            'refill' => [
                'access' => 'public',
                'return' => 'void',
            ],
            '__toString' => [
                'access' => 'public',
                'return' => 'string',
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
     * Test the __construct method of SoldOutState.
     */
    public function testSoldOutStateConstruct(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $reflection = new \ReflectionClass(SoldOutState::class);
        $property = $reflection->getProperty('gumBallMachine');
        $property->setAccessible(true);

        $soldOutState = new SoldOutState($gumBallMachine);
        $this->assertSame($gumBallMachine, $property->getValue($soldOutState));
    }

    /**
     * Test that insertQuarter() outputs the correct string.
     */
    public function testSoldOutStateInsertQuarter(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $this->expectOutputString('<p class="action">You can’t insert a quarter, the machine is sold out</p>' . PHP_EOL);
        $soldOutState = new SoldOutState($gumBallMachine);
        $soldOutState->insertQuarter();
    }

    /**
     * Test that ejectQuarter() outputs the correct string.
     */
    public function testSoldOutStateEjectQuarter(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $this->expectOutputString('<p class="action">You can’t eject, you haven’t inserted a quarter yet</p>' . PHP_EOL);
        $soldOutState = new SoldOutState($gumBallMachine);
        $soldOutState->ejectQuarter();
    }

    /**
     * Test that turnCrank() outputs the correct string.
     */
    public function testSoldOutStateTurnCrank(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $this->expectOutputString('<p class="action">You turned, but there are no gumballs</p>' . PHP_EOL);
        $soldOutState = new SoldOutState($gumBallMachine);
        $soldOutState->turnCrank();
    }

    /**
     * Test that dispense() outputs the correct string.
     */
    public function testSoldOutStateDispense(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $this->expectOutputString('<p class="action">No gumball dispensed</p>' . PHP_EOL);
        $soldOutState = new SoldOutState($gumBallMachine);
        $soldOutState->dispense();
    }

    /**
     * Test that __toString() returns the correct string.
     */
    public function testSoldOutStateToString(): void
    {
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $soldOutState = new SoldOutState($gumBallMachine);
        $this->assertSame('Machine is sold out', $soldOutState->__toString());
    }

    /**
     * Test that refill() outputs the correct string and performs the expected actions.
     */
    public function testSoldOutStateRefill(): void
    {
        $refill = 10;
        $noQuarterState = $this->createMock('App\NoQuarterState');
        $gumBallMachine = $this->createMock('App\GumBallMachine');
        $gumBallMachine->expects($this->once())
            ->method('setCount')
            ->with($refill);
        $gumBallMachine->expects($this->once())
            ->method('getNoQuarterState')
            ->willReturn($noQuarterState);
        $gumBallMachine->expects($this->once())
            ->method('setState')
            ->with($noQuarterState);
        $this->expectOutputString("<p class=\"action\">A $refill gumballs refill was done</p>" . PHP_EOL);
        $soldOutState = new SoldOutState($gumBallMachine);
        $soldOutState->refill($refill);
    }
}