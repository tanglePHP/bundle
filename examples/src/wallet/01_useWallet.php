<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");
  // create mnemonic
  $mnemonic = require_once("../../.assets/createMnemonic.php");
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, 'shimmer:testnet');
  // alternative: Open wallet
  # $wallet = tanglePHP\Wallet\Run::open($mnemonic, 'shimmer:testnet');

  $address_0 = $wallet->address();
  $address_1 = $wallet->address(0, 1);
  // outputs
  echo "CoinType: " . $wallet->getCoinType() . PHP_EOL;
  echo "WalletSeed: " . $wallet->getSeed() . PHP_EOL;
  echo "WalletMnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;
  echo "Address 0" . PHP_EOL;
  echo "AddressPath: " . $address_0->getPathString() . PHP_EOL;
  echo "Address: 0x" . $address_0->getAddress() . PHP_EOL;
  echo "AddressBech32: " . $address_0->getAddressBech32() . PHP_EOL;
  echo "Balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "Balance MarketData: " . $address_0->getBalance()->marketData_balance . PHP_EOL;
  echo "Balance Spendable: " . $address_0->getBalanceSpendable()->balance . PHP_EOL;
  echo PHP_EOL;
  echo "###################################################################################" . PHP_EOL;
  echo "Address 1" . PHP_EOL;
  $address_1_fullInfo = $address_1->getFullInfo();
  print_r($address_1_fullInfo);
  echo "###################################################################################" . PHP_EOL;