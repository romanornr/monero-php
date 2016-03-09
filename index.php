<?php
require "vendor/autoload.php";

use Monero\Wallet;

$hostname = 'http://127.0.0.1';
$port = '18082';

$wallet = new Monero\Wallet($hostname, $port);

$balance = $wallet->getBalance();
$address = $wallet->getAddress();
$height = $wallet->getHeight();

echo $balance;
echo $address;
echo $height;