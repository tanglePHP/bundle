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
  echo $ret = $network->faucetServer->info();