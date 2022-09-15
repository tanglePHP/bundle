<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection to shimmer:testnet
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // check has faucet server
  $ret = $network->hasFaucetServer();
  var_dump($ret);

  // check has chronicle node
  $ret = $network->hasChronicleNode();
  var_dump($ret);