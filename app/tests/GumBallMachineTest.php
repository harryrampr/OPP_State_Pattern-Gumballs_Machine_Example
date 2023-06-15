<?php /** @noinspection PhpExpressionResultUnusedInspection */

namespace Tests;

use App\GumBallMachine;
use App\HasQuarterState;
use App\NoQuarterState;
use App\SoldOutState;
use App\SoldState;
use App\WinnerState;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GumBallMachineTest extends TestCase
{
    /**
     * Test that properties exist, have correct access, correct type, and correct default value.
     */
    public function testGumBallMachinePropertiesExist(): void
    {
        define('NO_DEFAULT_VALUE', 'NO_DEFAULT_VALUE');
        $testObject = $this->createMock(GumBallMachine::class);
        $reflection = new ReflectionClass(GumBallMachine::class);
        $properties = $reflection->getProperties();

        $expected = [
            'soldOutState' => [
                'access' => 'private',
                'type' => 'App\State',
                'default' => NO_DEFAULT_VALUE,
            ],
            'noQuarterState' => [
                'access' => 'private',
                'type' => 'App\State',
                'default' => NO_DEFAULT_VALUE,
            ],
            'hasQuarterState' => [
                'access' => 'private',
                'type' => 'App\State',
                'default' => NO_DEFAULT_VALUE,
            ],
            'soldState' => [
                'access' => 'private',
                'type' => 'App\State',
                'default' => NO_DEFAULT_VALUE,
            ],
            'winnerState' => [
                'access' => 'private',
                'type' => 'App\State',
                'default' => NO_DEFAULT_VALUE,
            ],
            'state' => [
                'access' => 'private',
                'type' => 'App\State',
                'default' => NO_DEFAULT_VALUE,
            ],
            'count' => [
                'access' => 'private',
                'type' => 'int',
                'default' => 0,
            ],
        ];

        $this->assertSame(count($expected), count($properties));
        foreach ($properties as $property) {
            $name = $property->getName();
            $this->assertArrayHasKey($name, $expected);

            // Test access type
            match ($expected[$name]['access']) {
                'public' => $this->assertTrue($property->isPublic()),
                'protected' => $this->assertTrue($property->isProtected()),
                'private' => $this->assertTrue($property->isPrivate()),
                default => $this->fail('Unexpected access type'),
            };

            // Test type
            $this->assertSame($expected[$name]['type'],
                $property->getType()->getName());

            // Test default value
            $property->setAccessible(true);
            $this->assertSame($expected[$name]['default'],
                $property->hasDefaultValue() ? $property->getValue($testObject) : NO_DEFAULT_VALUE);
        }
    }

    /**
     * Test that methods exist, have correct access, and correct return type.
     */
    public function testGumBallMachineMethodsExist(): void
    {
        $reflection = new ReflectionClass(GumBallMachine::class);
        $methods = $reflection->getMethods();
        $expected = [
            '__construct' => [
                'access' => 'public',
                'return' => '',
            ],
            'getWinnerState' => [
                'access' => 'public',
                'return' => 'App\State',
            ],
            '__toString' => [
                'access' => 'public',
                'return' => 'string',
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
            'getSoldOutState' => [
                'access' => 'public',
                'return' => 'App\State',
            ],
            'getNoQuarterState' => [
                'access' => 'public',
                'return' => 'App\State',
            ],
            'getHasQuarterState' => [
                'access' => 'public',
                'return' => 'App\State',
            ],
            'getSoldState' => [
                'access' => 'public',
                'return' => 'App\State',
            ],
            'getState' => [
                'access' => 'public',
                'return' => 'App\State',
            ],
            'setState' => [
                'access' => 'public',
                'return' => 'void',
            ],
            'getCount' => [
                'access' => 'public',
                'return' => 'int',
            ],
            'setCount' => [
                'access' => 'public',
                'return' => 'void',
            ],
            'refill' => [
                'access' => 'public',
                'return' => 'void',
            ],
            'releaseBall' => [
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
     * Test the GumBallMachine constructor.
     */
    public function testGumBallMachineConstruct(): void
    {
        // Test that the constructor sets the state to NoQuarterState if the count > 0
        $gumBallMachine1 = new GumBallMachine(5);
        $this->assertSame(5, $gumBallMachine1->getCount());
        $this->assertInstanceOf(NoQuarterState::class, $gumBallMachine1->getState());

        // Test that the constructor sets other states and getters work
        $this->assertInstanceOf(SoldOutState::class, $gumBallMachine1->getSoldOutState());
        $this->assertInstanceOf(HasQuarterState::class, $gumBallMachine1->getHasQuarterState());
        $this->assertInstanceOf(SoldState::class, $gumBallMachine1->getSoldState());
        $this->assertInstanceOf(WinnerState::class, $gumBallMachine1->getWinnerState());

        // Test that the constructor sets the state to SoldOutState if the count is 0
        $gumBallMachine2 = new GumBallMachine(0);
        $this->assertSame(0, $gumBallMachine2->getCount());
        $this->assertInstanceOf(SoldOutState::class, $gumBallMachine2->getState());
    }

    /**
     * Test the __toString method of GumBallMachine.
     */
    public function testGumBallMachineToString(): void
    {
        $testCount = 5;
        $gumBallMachine = new GumBallMachine($testCount);
        $expected = '<div class="monitor"><h1>Mighty Gumball, Inc.</h1>' . PHP_EOL;
        $expected .= '<h2>Java-enabled Standing Gumball Model #2004</h2>' . PHP_EOL;
        $expected .= "<p>Inventory: $testCount gumballs</p>" . PHP_EOL;
        $expected .= '<p class="message">Machine is waiting for quarter</p></div>' . PHP_EOL;

        $this->assertSame($expected, $gumBallMachine->__toString());
    }

    /**
     * Test the insertQuarter method of GumBallMachine.
     */
    public function testGumBallMachineInsertQuarter(): void
    {
        $gumBallMachine = new GumBallMachine(5);
        $gumBallMachine->insertQuarter();
        $this->assertInstanceOf(HasQuarterState::class, $gumBallMachine->getState());
    }

    /**
     * Test the ejectQuarter method of GumBallMachine.
     */
    public function testGumBallMachineEjectQuarter(): void
    {
        $gumBallMachine = new GumBallMachine(5);
        $gumBallMachine->insertQuarter();
        $gumBallMachine->ejectQuarter();
        $this->assertInstanceOf(NoQuarterState::class, $gumBallMachine->getState());
    }

    /**
     * Test the turnCrank method of GumBallMachine.
     */
    public function testGumBallMachineTurnCrank(): void
    {
        // Test that the state is an instance of NoQuarterState
        $gumBallMachine1 = new GumBallMachine(5);
        $gumBallMachine1->insertQuarter();
        $gumBallMachine1->turnCrank();
        $this->assertInstanceOf(NoQuarterState::class, $gumBallMachine1->getState());

        // Test that the state is an instance of SoldOutState
        $gumBallMachine2 = new GumBallMachine(1);
        $gumBallMachine2->insertQuarter();
        $gumBallMachine2->turnCrank();
        $this->assertInstanceOf(SoldOutState::class, $gumBallMachine2->getState());
    }

    /**
     * Test the setState method of GumBallMachine.
     */
    public function testGumBallMachineSetState(): void
    {
        $gumBallMachine = new GumBallMachine(5);
        $gumBallMachine->setState(new SoldOutState($gumBallMachine));
        $this->assertInstanceOf(SoldOutState::class, $gumBallMachine->getState());
    }

    /**
     * Test the setCount method of GumBallMachine.
     */
    public function testGumBallMachineSetCount(): void
    {
        $gumBallMachine = new GumBallMachine(5);
        $gumBallMachine->setCount(10);
        $this->assertSame(10, $gumBallMachine->getCount());
    }

    /**
     * Test the releaseBall method of GumBallMachine.
     */
    public function testGumBallMachineReleaseBall(): void
    {
        $gumBallMachine = new GumBallMachine(5);
        $this->expectOutputString('<p class="action">A gumball comes rolling out the slot</p>' .
            PHP_EOL);
        $gumBallMachine->releaseBall();
        $this->assertSame(4, $gumBallMachine->getCount());
    }

    /**
     * Test the getCount method of GumBallMachine.
     */
    public function testGumBallMachineGetCount(): void
    {
        $testCount = 5;
        $gumBallMachine = new GumBallMachine($testCount);
        $this->assertSame($testCount, $gumBallMachine->getCount());
    }

    /**
     * Test the refill method of GumBallMachine.
     */
    public function testGumBallMachineRefill(): void
    {
        $gumBallMachine = new GumBallMachine(5);
        $this->assertSame(5, $gumBallMachine->getCount());

        $gumBallMachine->refill(10);
        $this->assertSame(15, $gumBallMachine->getCount());
        $this->assertInstanceOf(NoQuarterState::class, $gumBallMachine->getState());
    }

}