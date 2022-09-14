<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');
  // Faucet only works on devnet / testnet
  if(!$network->hasFaucetServer()) {
    die('no FaucetServer on this network!');
  }
  // print result
  echo $ret = $network->faucetServer->getFunds('ba4ca851e2674f87bd795f0f398e2e8886f5bfa62c5b97007bbe4504683a66a1');
  #echo PHP_EOL;
  #echo $ret->address . PHP_EOL;
  #echo $ret->waitingRequests . PHP_EOL;