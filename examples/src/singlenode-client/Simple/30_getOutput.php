<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result
  echo $ret = $network->singleNode->output("0x7d76372fadaab95f8d14e5f9acc797a21257a0482567ac4ed8aaba25de68cf5d0000");
