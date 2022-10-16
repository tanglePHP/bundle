<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result of node information
  echo $ret = $network->singleNode->info();
  echo PHP_EOL;

  // print single informations
  if($network->singleNode->getProtocolVersion() == '2') {
    echo $ret->name . PHP_EOL;
    echo $ret->version . PHP_EOL;
    //
    echo $ret->status . PHP_EOL;
    echo $ret->metrics . PHP_EOL;
    echo $ret->supportedProtocolVersions . PHP_EOL;
    echo $ret->protocol . PHP_EOL;
    echo $ret->pendingProtocolParameters . PHP_EOL;
    echo $ret->baseToken . PHP_EOL;
    echo $ret->features . PHP_EOL;
  }
  elseif($network->singleNode->getProtocolVersion() == '1') {
    echo $ret->name . PHP_EOL;
    echo $ret->version . PHP_EOL;
    //
    echo $ret->isHealthy . PHP_EOL;
    echo $ret->networkId . PHP_EOL;
    echo $ret->bech32HRP . PHP_EOL;
    echo $ret->minPoWScore . PHP_EOL;
    echo $ret->messagesPerSecond . PHP_EOL;
    echo $ret->referencedMessagesPerSecond . PHP_EOL;
    echo $ret->referencedRate . PHP_EOL;
    echo $ret->latestMilestoneTimestamp . PHP_EOL;
    echo $ret->latestMilestoneIndex . PHP_EOL;
    echo $ret->confirmedMilestoneIndex . PHP_EOL;
    echo $ret->pruningIndex . PHP_EOL;
    echo $ret->features;
  }