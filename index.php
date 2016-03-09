<?php
require "vendor/autoload.php";

use Monero\Wallet;

$wallet = new Monero\Wallet();

$balance = $wallet->getBalance();
$address = $wallet->getAddress();
$height = $wallet->getHeight();
//$transfers = $wallet->incomingTransfers('all');
echo $wallet->store();

//$recipient = '47Vmj6BXSRPax69cVdqVP5APVLkcxxjjXdcP9fJWZdNc5mEpn3fXQY1CFmJDvyUXzj2Fy9XafvUgMbW91ZoqwqmQ6RjbVtp';
//$amount = 0.01;
//$destinations = [
//    'amount' => $amount,
//    'address' => $recipient
//];
//$payment_id = 'a936974e11d28211d24e2787a3b910f132992ba02856dffb2a74711956e2ad25';

//$options = [
//    'destinations' => $destinations
//];
//print_r($options);
//$tx_hash = $wallet->transfer($options);

echo $balance;
echo $address;
echo $height;
//echo $tx_hash;