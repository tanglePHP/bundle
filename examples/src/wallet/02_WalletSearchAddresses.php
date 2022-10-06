<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');
  // create mnemonic
  $mnemonic = require_once("../../.assets/createMnemonic.php");
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, $network->singleNode);
  $found = $wallet->searchAddresses(1,1, false);

  print_r($found);