<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('iota:mainnet');

  // print result of node information
  echo $ret = $network->marketServer->coin();