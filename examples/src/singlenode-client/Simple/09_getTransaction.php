<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result
  echo $ret = $network->singleNode->transaction("0x8b047e5f7c2af65f2cccccb904faadcd493c733bb5ed81ee55e45360015de0e5");