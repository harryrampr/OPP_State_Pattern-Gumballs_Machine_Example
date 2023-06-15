<?php /** @noinspection PhpExpressionResultUnusedInspection */

namespace Tests;

use App\GumBallMachine;
use App\HasQuarterState;
use App\SoldState;
use App\State;
use App\WinnerState;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class HasQuarterStateTest
 *
 * @package Your\Namespace
 */
class HasQuarterStateTest extends TestCase
{
    /**
     * Tests that HasQuarterState implements State using reflection.
     */
    public function testHasQuarterStateImplementsState(): void
    {
        $hasQuarterStateReflection = new ReflectionClass(HasQuarterState::class);
        $this->assertTrue($hasQuarterStateReflection->implementsInterface(State::class));
    }

    /**
     * Tests that properties exist, have the correct access modifiers and types.
     */
    public function testHasQuarterStatePropertiesExist(): void
    {
        $reflection = new ReflectionClass(HasQuarterState::class);
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

            $this->assertSame($expected[$name]['type'], $property->hasType() ?
                $property->getType()->getName() : '');

        }
    }

    /**
     * Tests that the insertQuarter method exists and has the correct access modifier and return type.
     */
    public function testHasQuarterStateMethodsExists(): void
    {
        $reflection = new ReflectionClass(HasQuarterState::class);
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

            // Test access type
            match ($expected[$name]['access']) {
                'public' => $this->assertTrue($method->isPublic()),
                'protected' => $this->assertTrue($method->isProtected()),
                'private' => $this->assertTrue($method->isPrivate()),
                default => $this->fail('Unexpected access type'),
            };

            // Test return type
            $this->assertSame($expected[$name]['return'], $method->hasReturnType() ?
                $method->getReturnType()->getName() : '');
        }
    }

    /**
     * Tests that the constructor sets the gumBallMachine property.
     */
    public function testHasQuarterStateConstructSetsGumBallMachine(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $hasQuarterState = new HasQuarterState($gumBallMachine);

        $reflection = new ReflectionClass(HasQuarterState::class);
        $property = $reflection->getProperty('gumBallMachine');
        $property->setAccessible(true);

        $this->assertSame($gumBallMachine, $property->getValue($hasQuarterState));
    }

    /**
     * Tests that the insertQuarter method outputs the expected message.
     */
    public function testHasQuarterStateInsertQuarterOutputsInsertQuarterMessage(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $hasQuarterState = new HasQuarterState($gumBallMachine);

        $this->expectOutputString('<p class="action">You can’t insert another quarter</p>' . PHP_EOL);
        $hasQuarterState->insertQuarter();
    }

    /**
     * Tests that the ejectQuarter method outputs the expected message.
     */
    public function testHasQuarterStateEjectQuarterOutputsEjectQuarterMessage(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $hasQuarterState = new HasQuarterState($gumBallMachine);

        $this->expectOutputString('<p class="action">Quarter returned</p>' . PHP_EOL);
        $hasQuarterState->ejectQuarter();
    }

    /**
     * Tests that the turnCrank method outputs the expected message and sets the state.
     */
    public function testHasQuarterStateTurnCrankOutputsTurnCrankMessageAndSetsState(): void
    {
        $testTimes = 100;
        $expectedOutput = '<p class="action">You turned</p>' . PHP_EOL;

        $gumBallMachineMock = $this->createMock(GumBallMachine::class);
        $gumBallMachineMock->expects($this->atLeast(1))->method('getCount')->willReturn($testTimes * 2);
        // SoldState must be called at least 75% of the time
        $gumBallMachineMock->expects($this->atLeast(ceil($testTimes * .75)))->method('getSoldState');

        // getSoldState must be called at least 4% of the time
        $gumBallMachineMock->expects($this->atLeast(ceil($testTimes * .04)))->method('getWinnerState');

        $hasQuarterState = new HasQuarterState($gumBallMachineMock);

        for ($i = 0; $i < $testTimes; $i++) {
            ob_start();
            $hasQuarterState->turnCrank();
            $output = ob_get_clean();
            $this->assertSame($expectedOutput, $output);
        }
    }

    /**
     * Tests that the dispense method outputs the expected message.
     */
    public function testHasQuarterStateDispenseOutputsDispenseMessage(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $hasQuarterState = new HasQuarterState($gumBallMachine);

        $this->expectOutputString('<p class="action">No gumball dispensed</p>' . PHP_EOL);
        $hasQuarterState->dispense();
    }

    /**
     * Tests that the __toString method returns the expected output.
     */
    public function testHasQuarterStateToStringOutput(): void
    {
        $expectedOutput = 'Machine has a quarter';

        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $hasQuarterState = new HasQuarterState($gumBallMachine);

        $this->assertSame($expectedOutput, (string)$hasQuarterState);
    }

    /**
     * Tests that the refill method outputs the expected message.
     */
    public function testHasQuarterStateRefill(): void
    {
        $gumBallMachine = $this->createMock(GumBallMachine::class);
        $hasQuarterState = new HasQuarterState($gumBallMachine);

        $this->expectOutputString("<p class=\"action\">Can't refill now</p>" . PHP_EOL);
        $hasQuarterState->refill(10);
    }

}