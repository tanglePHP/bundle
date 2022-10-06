<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');
  // create mnemonic
  $mnemonic = require_once("../../.assets/createMnemonic.php");
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, $network->singleNode);
  // get address 0/0
  $address_0 = $wallet->address(0, 0);
  // current balance
  echo "Balance address_0: " . $address_0->getBalance()->balance . PHP_EOL;
  // send Tokens
  echo $address_0->send('rms1qqdfq7k49zs77q0sk03wagjsrz4qsaqulpl0qw87cjc6z9mn6kzwkk8kzgh', 1000000) . PHP_EOL;
  // balance
  echo "Balance address_0: " . $address_0->getBalance()->balance . PHP_EOL;
