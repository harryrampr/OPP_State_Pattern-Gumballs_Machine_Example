<?php
declare(strict_types=1);

namespace App;

/**
 * Class SoldOutState
 *
 * The SoldOutState class represents the state of a gumball machine when it is sold out.
 */
class SoldOutState implements State
{
    private GumBallMachine $gumBallMachine;

    /**
     * SoldOutState constructor.
     *
     * @param GumBallMachine $gumBallMachine The gumball machine associated with the state.
     */
    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    /**
     * Inserting a quarter is not allowed when the machine is sold out.
     */
    public function insertQuarter(): void
    {
        echo '<p class="action">You can’t insert a quarter, the machine is sold out</p>', PHP_EOL;
    }

    /**
     * Ejecting a quarter is not allowed when no quarter is inserted.
     */
    public function ejectQuarter(): void
    {
        echo '<p class="action">You can’t eject, you haven’t inserted a quarter yet</p>', PHP_EOL;
    }

    /**
     * Turning the crank is not allowed when there are no gumballs.
     */
    public function turnCrank(): void
    {
        echo '<p class="action">You turned, but there are no gumballs</p>', PHP_EOL;
    }

    /**
     * Dispensing a gumball is not allowed when the machine is sold out.
     */
    public function dispense(): void
    {
        echo '<p class="action">No gumball dispensed</p>', PHP_EOL;
    }

    /**
     * Get the string representation of the state.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        return 'Machine is sold out';
    }

    /**
     * Refill the gumball machine with the specified number of gumballs.
     *
     * @param int $refill The number of gumballs to refill.
     */
    public function refill(int $refill): void
    {
        $this->gumBallMachine->setCount($refill);
        echo "<p class=\"action\">A $refill gumballs refill was done</p>", PHP_EOL;
        $this->gumBallMachine->setState($this->gumBallMachine->getNoQuarterState());
    }
}