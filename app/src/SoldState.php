<?php
declare(strict_types=1);

namespace App;

/**
 * Class SoldState
 *
 * The SoldState class represents the state of a gumball machine when a gumball is being sold.
 */
class SoldState implements State
{
    private GumBallMachine $gumBallMachine;

    /**
     * SoldState constructor.
     *
     * @param GumBallMachine $gumBallMachine The gumball machine associated with the state.
     */
    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    /**
     * Inserting a quarter is not allowed when a gumball is being sold.
     */
    public function insertQuarter(): void
    {
        echo '<p class="action">Please wait, we’re already giving you a gumball</p>', PHP_EOL;
    }

    /**
     * Ejecting a quarter is not allowed after turning the crank.
     */
    public function ejectQuarter(): void
    {
        echo '<p class="action">Sorry, you already turned the crank</p>', PHP_EOL;
    }

    /**
     * Turning the crank multiple times doesn't result in another gumball.
     */
    public function turnCrank(): void
    {
        echo '<p class="action">Turning twice doesn’t get you another gumball!</p>', PHP_EOL;
    }

    /**
     * Dispense a gumball and transition to the appropriate state based on the gumball count.
     */
    public function dispense(): void
    {
        $this->gumBallMachine->releaseBall();
        if ($this->gumBallMachine->getCount() > 0) {
            $this->gumBallMachine->setState($this->gumBallMachine->getNoQuarterState());
        } else {
            echo '<p class="action">Oops, out of gumballs!</p>', PHP_EOL;
            $this->gumBallMachine->setState($this->gumBallMachine->getSoldOutState());
        }
    }

    /**
     * Get the string representation of the state.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        return 'Gumball sold';
    }

    /**
     * Refilling is not allowed when a gumball is being sold.
     *
     * @param int $refill The number of gumballs to refill.
     */
    public function refill(int $refill): void
    {
        echo "<p class=\"action\"><p class=\"action\">Can't refill now</p>", PHP_EOL;
    }
}