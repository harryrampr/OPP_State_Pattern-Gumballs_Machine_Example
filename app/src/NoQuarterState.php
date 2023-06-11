<?php
declare(strict_types=1);

namespace App;

/**
 * Class NoQuarterState
 *
 * The NoQuarterState class represents the state of a gumball machine when no quarter is inserted.
 */
class NoQuarterState implements State
{
    private GumBallMachine $gumBallMachine;

    /**
     * NoQuarterState constructor.
     *
     * @param GumBallMachine $gumBallMachine The gumball machine associated with the state.
     */
    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    /**
     * Insert a quarter and transition to the HasQuarterState.
     */
    public function insertQuarter(): void
    {
        echo '<p class="action">You inserted a quarter</p>', PHP_EOL;
        $this->gumBallMachine->setState($this->gumBallMachine->getHasQuarterState());
    }

    /**
     * Ejecting a quarter is not allowed when no quarter is inserted.
     */
    public function ejectQuarter(): void
    {
        echo '<p class="action">You haven’t inserted a quarter</p>', PHP_EOL;
    }

    /**
     * Turning the crank is not allowed when no quarter is inserted.
     */
    public function turnCrank(): void
    {
        echo '<p class="action">You turned, but there’s no quarter</p>', PHP_EOL;
    }

    /**
     * Dispensing a gumball is not allowed when no quarter is inserted.
     */
    public function dispense(): void
    {
        echo '<p class="action">You need to pay first</p>', PHP_EOL;
    }

    /**
     * Get the string representation of the state.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        return 'Machine is waiting for quarter';
    }

    /**
     * Refill the gumball machine with the specified number of gumballs.
     *
     * @param int $refill The number of gumballs to refill.
     */
    public function refill(int $refill): void
    {
        $this->gumBallMachine->setCount($this->gumBallMachine->getCount() + $refill);
        echo "<p class=\"action\"><p class=\"action\">A $refill gumballs refill was done</p>", PHP_EOL;
    }
}