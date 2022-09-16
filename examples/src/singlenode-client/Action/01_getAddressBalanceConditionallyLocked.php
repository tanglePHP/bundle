<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;

  // create network connection
  $network = new Connect('shimmer:testnet');


  // get balance with addressbech32
  // These funds reside within outputs with additional unlock conditions which might be potentially un-lockable
  echo $ret = (new getBalance($network->singleNode))->address('d4686d71647240aa5d3bdcd54007319e987f29d991c4f970b8b2210e8086162c')
                                                    ->filter(['hasExpiration' => true])
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
  echo $ret->networkInfo;