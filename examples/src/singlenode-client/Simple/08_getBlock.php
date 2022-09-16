<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result
  echo $ret = $network->singleNode->block("0xa9236d3c77cf6dbcc8eb2e60e7ea1fd13736adfc833a45358d89b99e0336e950");