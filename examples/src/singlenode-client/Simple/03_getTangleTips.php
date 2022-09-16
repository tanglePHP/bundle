<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result of tangle tips
  echo $ret = $network->singleNode->tips();

  // print single informations
  if($network->singleNode->getProtocolVersion() == '2') {
    echo PHP_EOL;
    var_dump($ret->tips);
    echo $ret->tips->{0};
  }
  else {
    echo PHP_EOL;
    var_dump($ret->tipMessageIds);
    echo $ret->tipMessageIds->{0};
  }