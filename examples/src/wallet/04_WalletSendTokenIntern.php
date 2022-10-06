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
  // get address 0/1
  $address_1 = $wallet->address(0, 1);
  $amount    = 1000000;
  // send Tokens
  echo "#--- send '$amount'" . PHP_EOL;
  echo "#    from: " . $address_0->getAddressBech32() . " | balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "#    to:   " . $address_1->getAddressBech32() . " | balance: " . $address_1->getBalance()->balance . PHP_EOL;
  echo "#    result: " . $address_0->send($address_1->getAddressBech32(), $amount) . PHP_EOL;
  // send Tokens back ;-)
  echo "#--- send Tokens back" . PHP_EOL;
  echo "#    from:   " . $address_0->getAddressBech32() . " | balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "#    to:     " . $address_1->getAddressBech32() . " | balance: " . $address_1->getBalance()->balance . PHP_EOL;
  echo "#    result: " . $address_1->send($address_0->getAddressBech32(), $amount) . PHP_EOL;
  // check balance
  echo "#--- check" . PHP_EOL;
  echo "#    Address 0: " . $address_0->getAddressBech32() . " | balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "#    Address 1: " . $address_1->getAddressBech32() . " | balance: " . $address_1->getBalance()->balance . PHP_EOL;