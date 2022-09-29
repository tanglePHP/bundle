<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\sendTransaction;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // loading mnemonic
  $mnemonic = require_once("../../../.assets/createMnemonic.php");

  //
  echo $ret = (new sendTransaction($network->singleNode))->amount(1000000)
                                                         ->seedInput($mnemonic)
                                                         ->toAddress('ba4ca851e2674f87bd795f0f398e2e8886f5bfa62c5b97007bbe4504683a66a1')
                                                         //->message("#tanglePHP", "transaction test! follow me on Twitter @tanglePHP")
                                                         ->message("#tanglePHP", [
                                                           'key1' => "transaction test!",
                                                           'key2' => "follow me on Twitter @tanglePHP",
                                                         ])
                                                       ->setting(['checkTransaction' => true])
                                                         ->run();
  // print single information
  echo PHP_EOL;
  echo $ret->explorerUrl . PHP_EOL;
  echo $ret->blockId . PHP_EOL;
  echo $ret->check . PHP_EOL;
  // print network informations
  echo $ret->networkInfo . PHP_EOL;
  // print market informations
  echo $ret->marketData . PHP_EOL;
  echo $ret->marketData_balance . PHP_EOL;