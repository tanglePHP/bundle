<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result
  echo $ret = $network->singleNode->blockMetadata("0x946fc66b2b12c3fee47b1e3e863cc02ab4ea0362d935667f87940d2d6c4d6343");