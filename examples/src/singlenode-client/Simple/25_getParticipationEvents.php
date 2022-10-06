<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('https://chrysalis-nodes.iota.cafe/');


  // print result
  $ret = $network->singleNode->v1->eventsParticipation();

  print_r($ret->eventIds);