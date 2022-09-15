<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection to shimmer:testnet
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // get protocol version
  $ret = $network->getENDPOINTUrls();
  var_dump($ret);