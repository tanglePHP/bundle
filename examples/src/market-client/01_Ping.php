<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result of node information
  echo $ret = $network->marketServer->ping();

  // print single informations
  echo $ret->gecko_says . PHP_EOL;