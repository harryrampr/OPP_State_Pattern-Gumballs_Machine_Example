<?php
declare(strict_types=1);

namespace App;


class SoldState implements State
{
    private GumBallMachine $gumBallMachine;

    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    public function insertQuarter(): void
    {
        echo '<p class="action">Please wait, we’re already giving you a gumball</p>', PHP_EOL;
    }

    public function ejectQuarter(): void
    {
        echo '<p class="action">Sorry, you already turned the crank</p>', PHP_EOL;
    }

    public function turnCrank(): void
    {
        echo '<p class="action">Turning twice doesn’t get you another gumball!</p>', PHP_EOL;
    }

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

    public function __toString(): string
    {
        return 'Gumball sold';
    }

    public function refill(int $refill): void
    {
        echo "<p class=\"action\"><p class=\"action\">Can't refill now</p>", PHP_EOL;
    }

}