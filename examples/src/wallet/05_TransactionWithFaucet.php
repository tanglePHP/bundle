<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');
  // create mnemonic
  $mnemonic = require_once("../../.assets/createMnemonic.php");
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, $network->singleNode);



  // Open first address in wallet accountIndex 0, addressIndex0
  $address_0 = $wallet->address(0, 0);
  echo "Address0 opend: " . $address_0->getAddressBech32() . PHP_EOL;
  echo "Address0 Balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "#####################################################" . PHP_EOL;
  // Check Balance and get Funds from Faucet (only testnets)
  if($address_0->getBalance()->balance < 1000000000) {
    // Get Funds from Faucet (only testnets)
    $ret = $address_0->getFundsFromFaucet();
    echo "Faucet Message: " . $ret . PHP_EOL;
    echo "#####################################################" . PHP_EOL;
  }
  // wait until fund is received
  do {
    $check = $address_0->getBalance()->balance;
    sleep(1);
  } while($check < 1000000);
  //
  // Open next address in wallet accountIndex 0, addressIndex1
  $address_1 = $wallet->address(0, 1);
  echo "Address1 opend: " . $address_1->getAddressBech32() . PHP_EOL;
  echo "Address1 Balance: " . $address_1->getBalance()->balance . PHP_EOL;
  echo "#####################################################" . PHP_EOL;
  // Send 1000000 to the next address
  $ret = $address_0->send($address_1->getAddressBech32(), 1000000);
  echo " SendMessage: " . $ret . PHP_EOL;
  echo "#####################################################" . PHP_EOL;
  echo "---> new Address0 Balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "---> new Address1 Balance: " . $address_1->getBalance()->balance . PHP_EOL;
  echo "#####################################################" . PHP_EOL;
  // Send Funds back to Faucet (only testnets)
  $ret = $address_0->sendFundsToFaucet($address_0->getBalance()->balance);
  echo "Address0 send Faucet back Message: " . $ret . PHP_EOL;
  $ret = $address_1->sendFundsToFaucet($address_1->getBalance()->balance);
  echo "Address1 send Faucet back Message: " . $ret . PHP_EOL;
  echo "#####################################################" . PHP_EOL;
  echo "Address0 Balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "Address1 Balance: " . $address_1->getBalance()->balance . PHP_EOL;