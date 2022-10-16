<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result
  echo $ret = $network->singleNode->block("0x59bf5bbcdedf675bc48ccf25bda04bcb2e608e4f6b933b9714320e0e79b10b03");