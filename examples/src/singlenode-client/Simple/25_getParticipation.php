<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('https://chrysalis-nodes.iota.cafe/');
  // print result
  $ret = $network->singleNode->v1->addressParticipation("iota1qzedfjw5tzrk74kvf04cfhjkf5m3379d3v77g2xkc4um94c9qvsnqjp33kv");

  foreach($ret->rewards as $eventId => $reward) {

    $info   = $network->singleNode->v1->eventParticipation($eventId);
    $status = $network->singleNode->v1->eventStatusParticipation($eventId);

    echo PHP_EOL;
    echo $eventId . PHP_EOL;
    echo $info . PHP_EOL;
    echo $status . PHP_EOL;
    echo "amount: " . $reward->amount . PHP_EOL;
    echo "symbol: " . $reward->symbol . PHP_EOL;
    echo "minimumReached: " . $reward->minimumReached . PHP_EOL;
  }