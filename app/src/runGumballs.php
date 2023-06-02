<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\GumBallMachine;

$gumballMachine = new GumballMachine(5);

echo $gumballMachine, PHP_EOL;

$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();

echo $gumballMachine, PHP_EOL;

$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();
$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();

echo $gumballMachine, PHP_EOL;

$gumballMachine->refill(100);

echo $gumballMachine, PHP_EOL;