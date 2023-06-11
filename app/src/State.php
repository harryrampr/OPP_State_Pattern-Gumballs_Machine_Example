<?php
declare(strict_types=1);

namespace App;

/**
 * Interface State
 *
 * The State interface represents the various states of a gumball machine.
 */
interface State
{
    /**
     * Insert a quarter into the gumball machine.
     */
    public function insertQuarter(): void;

    /**
     * Eject the quarter from the gumball machine.
     */
    public function ejectQuarter(): void;

    /**
     * Turn the crank of the gumball machine.
     */
    public function turnCrank(): void;

    /**
     * Dispense a gumball from the gumball machine.
     */
    public function dispense(): void;

    /**
     * Refill the gumball machine with a specified number of gumballs.
     *
     * @param int $refill The number of gumballs to refill.
     */
    public function refill(int $refill): void;

    /**
     * Get the string representation of the state.
     *
     * @return string The string representation.
     */
    public function __toString(): string;
}