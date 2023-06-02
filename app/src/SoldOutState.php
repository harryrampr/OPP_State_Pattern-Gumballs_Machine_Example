<?php
declare(strict_types=1);

namespace App;

class SoldOutState implements State
{
    private GumBallMachine $gumBallMachine;

    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    public function insertQuarter(): void
    {
        echo '<p class="action">You can’t insert a quarter, the machine is sold out</p>', PHP_EOL;
    }

    public function ejectQuarter(): void
    {
        echo '<p class="action">You can’t eject, you haven’t inserted a quarter yet</p>', PHP_EOL;
    }

    public function turnCrank(): void
    {
        echo '<p class="action">You turned, but there are no gumballs</p>', PHP_EOL;
    }

    public function dispense(): void
    {
        echo '<p class="action">No gumball dispensed</p>', PHP_EOL;
    }

    public function __toString(): string
    {
        return 'Machine is sold out';
    }

    public function refill(int $refill): void
    {
        $this->gumBallMachine->setCount($refill);
        echo "<p class=\"action\"><p class=\"action\">A $refill gumballs refill was done</p>", PHP_EOL;
        $this->gumBallMachine->setState($this->gumBallMachine->getNoQuarterState());
    }
}