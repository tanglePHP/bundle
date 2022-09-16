<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\checkTransaction;

  // create network connection
  $network = new Connect('shimmer:testnet');
  //
  echo $ret = (new checkTransaction($network->singleNode))->blockId("0x5c060723d699f0fdd4210b1f148fbe2ff5b0f2afc6b5dd7a275c778908513c5f")
                                                          ->run();