<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection to shimmer:testnet
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // return ExplorerUrl
  $ret = $network->getExplorerUrl();
  echo $ret;

  // other ExplorerUrls
  echo $network->getExplorerUrlBlock($blockId); // only v2
  echo $network->getExplorerUrlNFT($nftId); // only v2
  echo $network->getExplorerUrlMessage($messageId); // only v1

