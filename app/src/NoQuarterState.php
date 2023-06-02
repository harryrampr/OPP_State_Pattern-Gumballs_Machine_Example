<?php
declare(strict_types=1);

namespace App;

class NoQuarterState implements State
{
    private GumBallMachine $gumBallMachine;

    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    public function insertQuarter(): void
    {
        echo '<p class="action">You inserted a quarter</p>', PHP_EOL;
        $this->gumBallMachine->setState($this->gumBallMachine->getHasQuarterState());
    }

    public function ejectQuarter(): void
    {
        echo '<p class="action">You haven’t inserted a quarter</p>', PHP_EOL;
    }

    public function turnCrank(): void
    {
        echo '<p class="action">You turned, but there’s no quarter</p>', PHP_EOL;
    }

    public function dispense(): void
    {
        echo '<p class="action">You need to pay first</p>', PHP_EOL;
    }

    public function __toString(): string
    {
        return 'Machine is waiting for quarter';
    }

    public function refill(int $refill): void
    {
        $this->gumBallMachine->setCount($this->gumBallMachine->getCount() + $refill);
        echo "<p class=\"action\"><p class=\"action\">A $refill gumballs refill was done</p>", PHP_EOL;
    }
}