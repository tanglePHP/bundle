<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('iota:mainnet');

  // print result of node information
  echo $ret = $network->marketServer->coinMarketChart(1, 'usd');

  //
  #echo PHP_EOL;
  #echo $ret->prices . PHP_EOL;