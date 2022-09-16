<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // getLatestMilestone
  $latestMilestone = $network->singleNode->getLatestMilestone();


  // print result
  echo $ret = $network->singleNode->milestoneUtxoChanges($latestMilestone->milestoneId).  PHP_EOL;
  // get milestone by milestoneIndex
  echo $ret = $network->singleNode->milestoneUtxoChangesByIndex($latestMilestone->index);