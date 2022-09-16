<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection to shimmer:testnet
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // create mnemonic random
  $mnemonic = tanglePHP\Core\Helper\Simplifier::createMnemonic();
  echo "Random Mnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;

  // create Address via TransactionHelper
  // second Address is addressIndex = 1
  // second wallet is accountIndex = 1
  $addressBech32 = \tanglePHP\SingleNodeClient\Helper\TransactionHelper::createAddressBech32($mnemonic, $network, 0,0);
  echo "addressBech32 0: " . $addressBech32 . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;

