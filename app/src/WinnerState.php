<?php
declare(strict_types=1);

namespace App;

/**
 * Class WinnerState
 *
 * The WinnerState class represents the state of a gumball machine when the customer is a winner.
 */
class WinnerState implements State
{
    private GumBallMachine $gumBallMachine;

    /**
     * WinnerState constructor.
     *
     * @param GumBallMachine $gumBallMachine The gumball machine associated with the state.
     */
    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    /**
     * Inserting a quarter is not allowed when the machine is already giving a gumball to the winner.
     */
    public function insertQuarter(): void
    {
        echo '<p class="action">Please wait, we’re already giving you a gumball</p>', PHP_EOL;
    }

    /**
     * Ejecting a quarter is not allowed after turning the crank as the customer is already a winner.
     */
    public function ejectQuarter(): void
    {
        echo '<p class="action">Sorry, you already turned the crank</p>', PHP_EOL;
    }

    /**
     * Turning the crank again doesn't result in another gumball for the winner.
     */
    public function turnCrank(): void
    {
        echo '<p class="action">Turning twice doesn’t get you another gumball!</p>', PHP_EOL;
    }

    /**
     * Dispensing gumballs to the winner and transitioning to the appropriate state.
     */
    public function dispense(): void
    {
        echo '<p class="action">YOU’RE A WINNER! You get two gumballs for your quarter</p>', PHP_EOL;
        $this->gumBallMachine->releaseBall();
        if ($this->gumBallMachine->getCount() < 1) {
            $this->gumBallMachine->setState($this->gumBallMachine->getSoldOutState());
        } else {
            $this->gumBallMachine->releaseBall();
            if ($this->gumBallMachine->getCount() > 0) {
                $this->gumBallMachine->setState($this->gumBallMachine->getNoQuarterState());
            } else {
                echo '<p class="action">Oops, out of gumballs!</p>', PHP_EOL;
                $this->gumBallMachine->setState($this->gumBallMachine->getSoldOutState());
            }
        }
    }

    /**
     * Get the string representation of the state.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        return 'There is a winner!';
    }

    /**
     * Refilling the gumball machine is not allowed when the customer is a winner.
     *
     * @param int $refill The number of gumballs to refill.
     */
    public function refill(int $refill): void
    {
        echo "<p class=\"action\">Can't refill now</p>", PHP_EOL;
    }
}