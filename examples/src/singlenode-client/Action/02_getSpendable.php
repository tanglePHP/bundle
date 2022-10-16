<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getSpendable;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // get balance with addressbech32
  $ret = (new getSpendable($network->singleNode))->address('rms1qrl3rcymcz0tc8exktv95fyx760yrmgpwgt3wxh2j9uf06ml6th0urcdcag')
                                                 ->run();

  print_r($ret);
