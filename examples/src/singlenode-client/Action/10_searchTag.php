<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\search;

  // create network connection
  $network = new Connect('shimmer:testnet');
  //
  echo $ret = (new search($network->singleNode))->tag('#tanglePHP')
                                                ->parseItemList(true)
                                                ->run();
  // print single information
  echo PHP_EOL;
  echo "Found: " . $ret->count . PHP_EOL;
  print_r($ret->items);
  echo PHP_EOL;
  print_r($ret->first);
  echo PHP_EOL;
  print_r($ret->last);