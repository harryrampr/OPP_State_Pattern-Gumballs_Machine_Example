<?php
declare(strict_types=1);

namespace App;

/**
 * Class HasQuarterState
 *
 * The HasQuarterState class represents the state of a gumball machine when it has a quarter inserted.
 */
class HasQuarterState implements State
{
    private GumBallMachine $gumBallMachine;

    /**
     * HasQuarterState constructor.
     *
     * @param GumBallMachine $gumBallMachine The gumball machine associated with the state.
     */
    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    /**
     * Inserting another quarter is not allowed when a quarter is already inserted.
     */
    public function insertQuarter(): void
    {
        echo '<p class="action">You can’t insert another quarter</p>', PHP_EOL;
    }

    /**
     * Eject the quarter and transition to the NoQuarterState.
     */
    public function ejectQuarter(): void
    {
        echo '<p class="action">Quarter returned</p>', PHP_EOL;
        $this->gumBallMachine->setState($this->gumBallMachine->getNoQuarterState());
    }

    /**
     * Turn the crank and transition to the appropriate state based on the outcome.
     */
    public function turnCrank(): void
    {
        echo '<p class="action">You turned</p>', PHP_EOL;
        $winner = random_int(0, 9);
        if ($winner == 0 && $this->gumBallMachine->getCount() > 1) {
            $this->gumBallMachine->setState($this->gumBallMachine->getWinnerState());
        } else {
            $this->gumBallMachine->setState($this->gumBallMachine->getSoldState());
        }
    }

    /**
     * Dispensing a gumball is not allowed when in the HasQuarterState.
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
        return 'Machine has a quarter';
    }

    /**
     * Refilling is not allowed when a quarter is already inserted.
     *
     * @param int $refill The number of gumballs to refill.
     */
    public function refill(int $refill): void
    {
        echo "<p class=\"action\">Can't refill now</p>", PHP_EOL;
    }
}