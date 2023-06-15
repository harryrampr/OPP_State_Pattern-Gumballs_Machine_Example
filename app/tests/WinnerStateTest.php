<?php

namespace Tests;

use App\GumBallMachine;
use App\NoQuarterState;
use App\SoldOutState;
use App\State;
use App\WinnerState;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class WinnerStateTest
 *
 * This class contains unit tests for the WinnerState class.
 */
class WinnerStateTest extends TestCase
{
    /**
     * Test that WinnerState implements the State interface using reflection.
     */
    public function testWinnerStateImplementsState(): void
    {
        $reflection = new ReflectionClass(WinnerState::class);
        $this->assertTrue($reflection->implementsInterface(State::class));
    }

    /**
     * Test that WinnerState properties exist, have expected access, and expected types.
     */
    public function testWinnerStatePropertiesExist(): void
    {
        $reflection = new ReflectionClass(WinnerState::class);
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

            // Match access type
            match ($expected[$name]['access']) {
                'public' => $this->assertTrue($property->isPublic()),
                'protected' => $this->assertTrue($property->isProtected()),
                'private' => $this->assertTrue($property->isPrivate()),
                default => $this->fail('Unexpected access type'),
            };

            $this->assertSame($expected[$name]['type'], $property->getType()->getName());
        }
    }

    /**
     * Test that WinnerState methods exist, have expected access, and expected return types.
     */
    public function testWinnerStateMethodsExist(): void
    {
        $reflection = new ReflectionClass(WinnerState::class);
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

            // Match access type
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
     * Test that the WinnerState constructor sets the correct GumBallMachine instance.
     */
    public function testWinnerStateConstructor(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $reflection = new ReflectionClass(WinnerState::class);
        $property = $reflection->getProperty('gumBallMachine');
        $property->setAccessible(true);

        $winnerState = new WinnerState($gumBallMachine);

        $this->assertSame($gumBallMachine, $property->getValue($winnerState));
    }

    /**
     * Test the behavior of the insertQuarter method in WinnerState.
     */
    public function testWinnerStateInsertQuarter(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $winnerState = new WinnerState($gumBallMachine);

        $this->expectOutputString(
            '<p class="action">Please wait, we’re already giving you a gumball</p>' . PHP_EOL);
        $winnerState->insertQuarter();
    }

    /**
     * Test the behavior of the ejectQuarter method in WinnerState.
     */
    public function testWinnerStateEjectQuarter(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $winnerState = new WinnerState($gumBallMachine);

        $this->expectOutputString(
            '<p class="action">Sorry, you already turned the crank</p>' . PHP_EOL);
        $winnerState->ejectQuarter();
    }

    /**
     * Test the behavior of the turnCrank method in WinnerState.
     */
    public function testWinnerStateTurnCrank(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $winnerState = new WinnerState($gumBallMachine);

        $this->expectOutputString(
            '<p class="action">Turning twice doesn’t get you another gumball!</p>' . PHP_EOL);
        $winnerState->turnCrank();
    }

    /**
     * Test the behavior of the dispense method in WinnerState.
     */
    public function testWinnerStateDispense(): void
    {
        // Test that the state is set to NoQuarterState when count is 2 and then 1
        $initialCount = 2;
        $expectedOutput = '<p class="action">YOU’RE A WINNER! You get two gumballs for your quarter</p>' .
            PHP_EOL;
        $NoQuarterState = $this->createMock(NoQuarterState::class);
        $gumBallMachine1 = $this->createMock(GumBallMachine::class);
        $gumBallMachine1->expects($this->exactly(2))->method('releaseBall');
        $gumBallMachine1->expects($this->exactly(2))->method('getCount')
            ->will($this->onConsecutiveCalls($initialCount, $initialCount - 1));
        $gumBallMachine1->expects($this->once())->method('getNoQuarterState')->willReturn($NoQuarterState);
        $gumBallMachine1->expects($this->once())->method('setState')->with($NoQuarterState);
        $gumBallMachine1->expects($this->never())->method('getSoldOutState');

        $winnerState = new WinnerState($gumBallMachine1);
        ob_start();
        $winnerState->dispense();
        $output = ob_get_clean();
        $this->assertSame($expectedOutput, $output);

        // Test that the state is set to SoldOutState when the count is 0
        $initialCount = 0;
        $SoldOutState = $this->createMock(SoldOutState::class);
        $gumBallMachine2 = $this->createMock(GumBallMachine::class);
        $gumBallMachine2->expects($this->exactly(1))->method('releaseBall');
        $gumBallMachine2->expects($this->exactly(1))->method('getCount')
            ->will($this->onConsecutiveCalls($initialCount, $initialCount - 1));
        $gumBallMachine2->expects($this->once())->method('getSoldOutState')->willReturn($SoldOutState);
        $gumBallMachine2->expects($this->once())->method('setState')->with($SoldOutState);
        $gumBallMachine2->expects($this->never())->method('getNoQuarterState');

        $winnerState = new WinnerState($gumBallMachine2);
        ob_start();
        $winnerState->dispense();
        $output = ob_get_clean();
        $this->assertSame($expectedOutput, $output);

        // Test that the state is set to SoldOutState when count is 1 and then 0
        $expectedOutput .= '<p class="action">Oops, out of gumballs!</p>' . PHP_EOL;

        $initialCount = 1;
        $gumBallMachine3 = $this->createMock(GumBallMachine::class);
        $gumBallMachine3->expects($this->exactly(2))->method('releaseBall');
        $gumBallMachine3->expects($this->exactly(2))->method('getCount')
            ->will($this->onConsecutiveCalls($initialCount, $initialCount - 1));
        $gumBallMachine3->expects($this->once())->method('getSoldOutState')->willReturn($SoldOutState);
        $gumBallMachine3->expects($this->once())->method('setState')->with($SoldOutState);
        $gumBallMachine3->expects($this->never())->method('getNoQuarterState');

        $winnerState = new WinnerState($gumBallMachine3);
        ob_start();
        $winnerState->dispense();
        $output = ob_get_clean();
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * Test the behavior of the __toString method in WinnerState.
     */
    public function testWinnerStateToString(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $winnerState = new WinnerState($gumBallMachine);

        $this->assertSame('There is a winner!', $winnerState->__toString());
    }

    /**
     * Test the behavior of the refill method in WinnerState.
     */
    public function testWinnerStateRefill(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $winnerState = new WinnerState($gumBallMachine);

        $this->expectOutputString(
            "<p class=\"action\">Can't refill now</p>" . PHP_EOL);
        $winnerState->refill(1);
    }
}