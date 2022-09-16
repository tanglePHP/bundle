<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('iota:mainnet');

  // print result of node information
  echo $ret = $network->marketServer->coinHistory('30-12-2021');

  //
  #echo PHP_EOL;
  #echo $ret->id . PHP_EOL;
  #echo $ret->symbol . PHP_EOL;
  #echo $ret->name . PHP_EOL;
  #echo $ret->localization . PHP_EOL;
  #echo $ret->image . PHP_EOL;