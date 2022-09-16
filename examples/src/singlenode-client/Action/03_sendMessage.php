<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\sendMessage;

  // create network connection
  $network = new Connect('shimmer:testnet');
  //
  echo $ret = (new sendMessage($network->singleNode))->message('#tanglePHP', 'tanglePHP sendMessage test! follow me on Twitter @tanglePHP')
                                                     ->setting('checkTransaction', false)
                                                     ->run();
  // print single information
  echo PHP_EOL;
  echo $ret->explorerUrl . PHP_EOL;
  echo $ret->blockId . PHP_EOL;
  echo $ret->check . PHP_EOL;
  // print network informations
  echo $ret->networkInfo;