<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;

  // create network connection
  $network = new Connect('iota:devnet');


  // get balance with addressbech32
  echo $ret = (new getBalance($network->singleNode))->address('atoi1qqghchyvvegq3jt0a4jg5392t63zmfhk0pkqj8czpelr7ey67ekgsat9sky')
                                                    ->run();
  // print single information
  echo PHP_EOL;
  echo $ret->balance . PHP_EOL;
  echo $ret->addressBech32 . PHP_EOL;
  echo $ret->nativeTokens . PHP_EOL;
  echo $ret->ledgerIndex . PHP_EOL;
  // print filter informations
  echo $ret->filter . PHP_EOL;
  // print network informations
  echo $ret->networkInfo . PHP_EOL;
  // print market informations
  echo $ret->marketData . PHP_EOL;
