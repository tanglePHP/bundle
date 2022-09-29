<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');
  // Faucet only works on devnet / testnet
  if(!$network->hasFaucetServer()) {
    die('no FaucetServer on this network!');
  }
  // loading mnemonic
  $mnemonic = require_once("../../.assets/createMnemonic.php");
  // print result
  echo $ret = $network->faucetServer->sendFundsBack(1000000000, $mnemonic, 0, 0);
  #echo PHP_EOL;
  #echo $ret->blockId;