<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getSpendable;

  // create network connection
  $network = new Connect('iota:devnet');
  // get balance with addressbech32
  $ret = (new getSpendable($network->singleNode))->address('atoi1qrnhxtx78lg577jrffd5y6scv9lxj8maelmvrq2whsjnplr0llp3ucyd3rm')
                                                 ->run();

  print_r($ret);
