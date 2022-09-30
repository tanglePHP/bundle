<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result of node information
  echo $ret = $network->marketServer->price();
  //
  #echo PHP_EOL;
  #echo $ret->iota . PHP_EOL;
  #echo $ret->iota->usd . PHP_EOL;