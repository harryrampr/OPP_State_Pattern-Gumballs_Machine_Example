<?php
declare(strict_types=1);

namespace App;

class HasQuarterState implements State
{
    private GumBallMachine $gumBallMachine;

    public function __construct(GumBallMachine $gumBallMachine)
    {
        $this->gumBallMachine = $gumBallMachine;
    }

    public function insertQuarter(): void
    {
        echo '<p class="action">You can’t insert another quarter</p>', PHP_EOL;
    }

    public function ejectQuarter(): void
    {
        echo '<p class="action">Quarter returned</p>', PHP_EOL;
        $this->gumBallMachine->setState($this->gumBallMachine->getNoQuarterState());
    }

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

    public function dispense(): void
    {
        echo '<p class="action">No gumball dispensed</p>', PHP_EOL;
    }

    public function __toString(): string
    {
        return 'Machine has a quarter';
    }

    public function refill(int $refill): void
    {
        echo "<p class=\"action\"><p class=\"action\">Can't refill now</p>", PHP_EOL;
    }
}