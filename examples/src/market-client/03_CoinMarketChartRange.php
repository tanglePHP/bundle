<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('iota:mainnet');

  // print result of node information
  echo $ret = $network->marketServer->coinMarketChartRange(time()-3600, time(), 'usd');

  //
  #echo PHP_EOL;
  #echo $ret->prices . PHP_EOL;
  #echo $ret->market_caps . PHP_EOL;
  #echo $ret->total_volumes . PHP_EOL;