<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result of node routes
  echo $ret = $network->singleNode->routes();
  // print single informations
  echo PHP_EOL;
  echo $ret->routes . PHP_EOL;