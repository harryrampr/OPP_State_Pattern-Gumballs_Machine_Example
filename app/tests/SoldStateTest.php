<?php

namespace Tests;

use App\GumBallMachine;
use App\SoldState;
use App\State;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class SoldStateTest
 *
 * @package App\Tests
 */
class SoldStateTest extends TestCase
{
    /**
     * Test that SoldState implements the State interface.
     */
    public function testSoldStateImplementsState(): void
    {
        $reflection = new ReflectionClass(SoldState::class);
        $this->assertTrue($reflection->implementsInterface(State::class));
    }

    /**
     * Test that the properties of SoldState exist, have the correct types, and access types.
     */
    public function testSoldStatePropertiesExist(): void
    {
        $reflection = new ReflectionClass(SoldState::class);
        $properties = $reflection->getProperties();
        $expectedValues = [
            'gumBallMachine' => [
                'type' => 'App\GumBallMachine',
                'access' => 'private',
            ],
        ];

        $this->assertSame(count($expectedValues), count($properties));
        foreach ($properties as $property) {
            $this->assertArrayHasKey($property->getName(), $expectedValues);
            match ($expectedValues[$property->getName()]['access']) {
                'private' => $this->assertTrue($property->isPrivate()),
                'protected' => $this->assertTrue($property->isProtected()),
                'public' => $this->assertTrue($property->isPublic()),
            };

            $this->assertEquals($expectedValues[$property->getName()]['type'], $property->getType()->getName());
        }
    }

    /**
     * Test that the methods of SoldState exist, have the correct return types, and access types.
     */
    public function testSoldStateMethodsExist(): void
    {
        $reflection = new ReflectionClass(SoldState::class);
        $methods = $reflection->getMethods();
        $expectedValues = [
            '__construct' => [
                'returnType' => '',
                'access' => 'public',
            ],
            'insertQuarter' => [
                'returnType' => 'void',
                'access' => 'public',
            ],
            'ejectQuarter' => [
                'returnType' => 'void',
                'access' => 'public',
            ],
            'turnCrank' => [
                'returnType' => 'void',
                'access' => 'public',
            ],
            'dispense' => [
                'returnType' => 'void',
                'access' => 'public',
            ],
            '__toString' => [
                'returnType' => 'string',
                'access' => 'public',
            ],
            'refill' => [
                'returnType' => 'void',
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

            $this->assertEquals($expectedValues[$method->getName()]['returnType'],
                $method->hasReturnType() ? $method->getReturnType()->getName() : '');
        }
    }

    /**
     * Test that the SoldState constructor sets the GumBallMachine property.
     */
    public function testSoldStateConstructorSetsGumBallMachineProperty(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $soldState = new SoldState($gumBallMachine);
        $reflection = new ReflectionClass(SoldState::class);
        $gumBallMachineProperty = $reflection->getProperty('gumBallMachine');
        $gumBallMachineProperty->setAccessible(true);
        $this->assertEquals($gumBallMachine, $gumBallMachineProperty->getValue($soldState));
    }

    /**
     * Test that the SoldState insertQuarter method echoes the correct string.
     */
    public function testSoldStateInsertQuarterMethodEchoesCorrectString(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $soldState = new SoldState($gumBallMachine);
        $expectedString = '<p class="action">Please wait, we’re already giving you a gumball</p>' . PHP_EOL;
        $this->expectOutputString($expectedString);
        $soldState->insertQuarter();
    }

    /**
     * Test that the SoldState ejectQuarter method echoes the correct string.
     */
    public function testSoldStateEjectQuarterMethodEchoesCorrectString(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $soldState = new SoldState($gumBallMachine);
        $expectedString = '<p class="action">Sorry, you already turned the crank</p>' . PHP_EOL;
        $this->expectOutputString($expectedString);
        $soldState->ejectQuarter();
    }

    /**
     * Test that the SoldState turnCrank method echoes the correct string.
     */
    public function testSoldStateTurnCrankMethodEchoesCorrectString(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $soldState = new SoldState($gumBallMachine);
        $expectedString = '<p class="action">Turning twice doesn’t get you another gumball!</p>' . PHP_EOL;
        $this->expectOutputString($expectedString);
        $soldState->turnCrank();
    }

    /**
     * Test that the SoldState dispense method echoes the correct string.
     */
    public function testSoldStateDispenseMethodEchoesCorrectString(): void
    {
        // Test with count > 0
        $gumBallMachine1 = $this->createMock(GumBallMachine::class);
        $gumBallMachine1->expects($this->once())->method('releaseBall');
        $gumBallMachine1->expects($this->once())->method('getCount')->willReturn(1);
        $gumBallMachine1->expects($this->once())->method('setState');
        $gumBallMachine1->expects($this->once())->method('getNoQuarterState');
        $gumBallMachine1->expects($this->never())->method('getSoldOutState');
        $soldState = new SoldState($gumBallMachine1);
        $soldState->dispense();

        // Test with count = 0
        $gumBallMachine2 = $this->createMock(GumBallMachine::class);
        $gumBallMachine2->expects($this->once())->method('releaseBall');
        $gumBallMachine2->expects($this->once())->method('getCount')->willReturn(0);
        $gumBallMachine2->expects($this->once())->method('setState');
        $gumBallMachine2->expects($this->never())->method('getNoQuarterState');
        $gumBallMachine2->expects($this->once())->method('getSoldOutState');

        $soldState = new SoldState($gumBallMachine2);
        $expectedString = '<p class="action">Oops, out of gumballs!</p>' . PHP_EOL;
        $this->expectOutputString($expectedString);
        $soldState->dispense();
    }

    /**
     * Test that the SoldState __toString method echoes the correct string.
     */
    public function testSoldStateToStringMethod(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $soldState = new SoldState($gumBallMachine);
        $this->assertEquals('Gumball sold', $soldState->__toString());
    }

    /**
     * Test that the SoldState refill method echoes the correct string.
     */
    public function testSoldStateRefillMethodEchoesCorrectString(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $soldState = new SoldState($gumBallMachine);
        $expectedString = "<p class=\"action\"><p class=\"action\">Can't refill now</p>" . PHP_EOL;
        $this->expectOutputString($expectedString);
        $soldState->refill(1);
    }
}