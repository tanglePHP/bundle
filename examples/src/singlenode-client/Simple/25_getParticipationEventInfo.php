<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('https://chrysalis-nodes.iota.cafe/');
  // get all events
  $ret = $network->singleNode->v1->eventsParticipation();

  // get eventId info & status
  foreach($ret->eventIds as $eventId) {
    $info   = $network->singleNode->v1->eventParticipation($eventId);
    $status = $network->singleNode->v1->eventStatusParticipation($eventId);
    echo PHP_EOL;
    echo $eventId . PHP_EOL;
    echo $info . PHP_EOL;
    echo $status . PHP_EOL;
  }