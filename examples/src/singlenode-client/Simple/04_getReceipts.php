<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result
  echo $ret = $network->singleNode->receipts();