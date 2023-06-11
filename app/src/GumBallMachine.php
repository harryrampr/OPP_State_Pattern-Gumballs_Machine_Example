<?php
declare(strict_types=1);

namespace App;

/**
 * Class GumBallMachine
 *
 * The GumBallMachine class represents a gumball machine with various states and operations.
 */
class GumBallMachine
{
    /** @var State The state when the gumball machine is sold out. */
    private State $soldOutState;

    /** @var State The state when the gumball machine has no quarter. */
    private State $noQuarterState;

    /** @var State The state when the gumball machine has a quarter. */
    private State $hasQuarterState;

    /** @var State The state when the gumball machine dispenses a gumball. */
    private State $soldState;

    /** @var State The state when the gumball machine dispenses a winning gumball. */
    private State $winnerState;

    /** @var State The current state of the gumball machine. */
    private State $state;

    /** @var int The count of gumballs in the machine. */
    private int $count = 0;

    /**
     * GumBallMachine constructor.
     *
     * Creates a new gumball machine with the specified count of gumballs.
     * Sets the initial state based on the count of gumballs.
     *
     * @param int $count The count of gumballs.
     */
    public function __construct(int $count)
    {
        $this->soldOutState = new SoldOutState($this);
        $this->noQuarterState = new NoQuarterState($this);
        $this->hasQuarterState = new HasQuarterState($this);
        $this->soldState = new SoldState($this);
        $this->winnerState = new WinnerState($this);

        if ($count > 0) {
            $this->count = $count;
            $this->state = $this->noQuarterState;
        } else {
            $this->state = $this->soldOutState;
        }
    }

    /**
     * Get the winner state of the gumball machine.
     *
     * @return State The winner state.
     */
    public function getWinnerState(): State
    {
        return $this->winnerState;
    }

    /**
     * Get the string representation of the gumball machine.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        $text = '<div class="monitor"><h1>Mighty Gumball, Inc.</h1>' . PHP_EOL;
        $text .= '<h2>Java-enabled Standing Gumball Model #2004</h2>' . PHP_EOL;
        $text .= "<p>Inventory: {$this->count} gumballs</p>" . PHP_EOL;
        $text .= "<p class=\"message\">{$this->state->__toString()}</p></div>" . PHP_EOL;
        return $text;
    }

    /**
     * Insert a quarter into the gumball machine.
     */
    public function insertQuarter(): void
    {
        $this->state->insertQuarter();
    }

    /**
     * Eject the quarter from the gumball machine.
     */
    public function ejectQuarter(): void
    {
        $this->state->ejectQuarter();
    }

    /**
     * Turn the crank of the gumball machine.
     */
    public function turnCrank(): void
    {
        $this->state->turnCrank();
        $this->state->dispense();
    }

    /**
     * Get the sold out state of the gumball machine.
     *
     * @return State The sold out state.
     */
    public function getSoldOutState(): State
    {
        return $this->soldOutState;
    }

    /**
     * Get the no quarter state of the gumball machine.
     *
     * @return State The no quarter state.
     */
    public function getNoQuarterState(): State
    {
        return $this->noQuarterState;
    }

    /**
     * Get the has quarter state of the gumball machine.
     *
     * @return State The has quarter state.
     */
    public function getHasQuarterState(): State
    {
        return $this->hasQuarterState;
    }

    /**
     * Get the sold state of the gumball machine.
     *
     * @return State The sold state.
     */
    public function getSoldState(): State
    {
        return $this->soldState;
    }

    /**
     * Get the current state of the gumball machine.
     *
     * @return State The current state.
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * Set the current state of the gumball machine.
     *
     * @param State $state The new state.
     */
    public function setState(State $state): void
    {
        $this->state = $state;
    }

    /**
     * Get the count of gumballs in the machine.
     *
     * @return int The count of gumballs.
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * Set the count of gumballs in the machine.
     *
     * @param int $count The new count of gumballs.
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * Release a gumball from the machine.
     */
    public function releaseBall(): void
    {
        echo '<p class="action">A gumball comes rolling out the slot</p>', PHP_EOL;
        if ($this->count > 0) {
            $this->count--;
        }
    }

    /**
     * Refill the gumball machine with a specified number of gumballs.
     *
     * @param int $refill The number of gumballs to refill.
     */
    public function refill(int $refill): void
    {
        if ($refill > 0) {
            $this->state->refill($refill);
        }
    }
}