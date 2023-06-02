<?php
declare(strict_types=1);

namespace App;

interface State
{
    public function insertQuarter(): void;

    public function ejectQuarter(): void;

    public function turnCrank(): void;

    public function dispense(): void;

    public function refill(int $refill): void;

    public function __toString(): string;

}